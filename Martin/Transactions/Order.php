<?php

namespace Martin\Transactions;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\ACL\User;
use Martin\Core\Address;
use Martin\Core\Traits\CoreRelations;
use Martin\Delivery\Delivery;
use Martin\Products\Inventory;
use Martin\Products\Meal;
use Martin\Products\Product;
use Martin\Subscriptions\Plan;
use Spatie\Activitylog\Traits\LogsActivity;
use Stripe\Collection;

class Order extends Model
{
    use SoftDeletes;
    use CoreRelations;

    use LogsActivity;
    static $logFillable = true;

    protected $fillable = [
        'plan_id',
        'customer_id',
        'delivery_address_id',
        'subtotal',
        'tax',
        'total_cost',

        'include_meals',

        'paid',
        'packed',
        'picked',
        'shipped',
        'delivered',

        'deliver_by',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'deliver_by'
    ];

    /**
     * @param $crudAction
     * @return string
     */
    public function adminUrl($crudAction) {
        switch ($crudAction) {
            case 'index':
            case 'store':
                return "/admin/orders";
            case 'show':
            case 'update':
            case 'destroy':
                return "/admin/orders/$this->id";
            case 'create':
                return "/admin/orders/create";
            case 'edit':
                return "/admin/orders/$this->id/edit";
        }
    }

    public static function createFromCart(CartRepository $cart, Address $address) {
        $addressable = $address->addressable;
        if ($addressable instanceof User)
            $customer_id = $addressable->id;
        else
            $customer_id = 0;

        $subtotal = $cart->getSubTotal();
        $tax = $cart->getCondition('HST 13%')->getCalculatedValue($subtotal);
        $total = $cart->getTotal();

        $order = Order::create([
            'plan_id'               => 0,
            'customer_id'           => $customer_id,
            'delivery_address_id'   => $address->id,
            'deliver_by'    => Carbon::now()->addDays(2),
            'subtotal'      => $subtotal,
            // TODO: Change to using the tax on the cart
            'tax'           => $tax,
            // TODO: Change to using the tax on the cart
            'total_cost'    => $total,
            'plan_order'    => false,
        ]);

        foreach ($cart->getContent()->toArray() as $item) {
            $order->addProduct($item['attributes'], $item['quantity']);
        }
        return $order->fresh(['details', 'deliveryAddress']);
    }

    /**
     * Mutators
     */

    /**
     * @param $value
     * @return float|int
     */
    public function getSubtotalAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setSubtotalAttribute($value) {
        $this->attributes['subtotal'] = round($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getTaxAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setTaxAttribute($value) {
        $this->attributes['tax'] = round($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getTotalCostAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setTotalCostAttribute($value) {
        $this->attributes['total_cost'] = round($value * 100);
    }


    /**
     * Order Packing etc Workflow
     */

    /**
     * Mark this order as "paid"
     *
     * @param Payment $payment
     * @return $this
     */
    public function markAsPaid(Payment $payment) {
        $this->paid = true;
        $this->payments()->save($payment);
        $this->save();
        return $this;
    }

    /**
     * Marks this Order as "packed" and adjusts inventory as appropriate..
     *
     * @return $this
     */
    public function markAsPacked($data = null) {
        $numberOfWeeks = isset($data['weeks_packed']) ? $data['weeks_packed'] : $this->plan->weeks_of_food_per_shipment;
        $packageId = isset($data['packed_package_id']) ? $data['packed_package_id'] : $this->plan->package_id;

        $this->reduceMeatInventory($numberOfWeeks, $packageId);
        $this->increaseMealInventory();

        $this->packed = true;

        $this->weeks_packed = $numberOfWeeks;
        $this->packed_package_id = $packageId;

        $this->save();

        return $this;
    }

    /**
     * Mark this order as picked...
     *
     * @return $this
     */
    public function markAsPicked() {
        $this->reduceMealInventory();

        $this->picked = true;
        $this->save();

        return $this;
    }

    /**
     * @param Delivery $delivery
     * @return $this
     */
    public function markAsShipped(Delivery $delivery) {
        $delivery->recipient_id = $this->customer_id;
        $this->delivery()->save($delivery);

        $this->shipped_at = $delivery->shipped_at;
        $this->weeks_shipped = $delivery->weeks_shipped;
        $this->shipped_package_id = $delivery->shipped_package_id;

        $this->shipped = true;
        $this->save();

        $this->plan->updateForShipped($this);

        return $this;
    }

    /**
     * Mark this order as "delivered"
     *
     * @return $this
     */
    public function markAsDelivered() {
        $this->delivered = true;

        $this->save();
        return $this;
    }

    public function delayShipmentDays($daysToDelay, $affectOnlyThisOrder = false) {
        if ($daysToDelay < 1)
            return false; // TODO: Throw error;

        $this->deliver_by = $this->deliver_by->addDays($daysToDelay);
        $this->save();

        if ($affectOnlyThisOrder)
            return $this;

        return $this->plan->delayOrdersAfter($this, $daysToDelay);
    }

    /**
     * @param Meal|null $meal
     * @return mixed
     */
    public function mealCounts(Meal $meal = null, $number_of_weeks = null) {
        return $this->plan->mealCounts($meal, $number_of_weeks);
    }

    /**
     * TODO: Move to Plan
     */
    private function reduceMeatInventory($number_of_weeks, $package_id) {
        $pet_meal_size = $this->plan->pet->mealSize();

        // TODO: This should be on the Plan model too.. no reason for it to be here....
        $meals = $this->mealCounts()->map(function($meal, $key) use ($pet_meal_size){
            $meal->total_weight = $meal->count * $pet_meal_size;
            return $meal;
        });

        foreach($meals as $meal) {
            foreach ($meal->meats as $meat) {
                $this->inventoryChanges()->create([
                    'inventoryable_id'      => $meat->id,
                    'inventoryable_type'    => get_class($meat),
                    'change'    => -1 * $meal->total_weight / $meal->meats()->count(),
                ]);
            }
        }
    }

    /**
     * TODO: Make it public and simply reference the plan.. these methods should be on Plan
     * @param null $number_of_weeks
     */
    private function increaseMealInventory($number_of_weeks = null) {
        $meals = $this->mealCounts(null, $number_of_weeks);

        foreach($meals as $meal) {
            $this->inventoryChanges()->create([
                'inventoryable_id'  => $meal->id,
                'inventoryable_type'=> get_class($meal),
                'size'      => $this->plan->pet->mealSize(),
                'change'    => $meal->count,
            ]);
        }
    }

    /**
     * TODO: Make it public and simply reference the plan.. these methods should be on Plan
     */
    private function reduceMealInventory() {
        $meals = $this->mealCounts();

        foreach($meals as $meal) {
            $this->inventoryChanges()->create([
                'inventoryable_id'  => $meal->id,
                'inventoryable_type'=> get_class($meal),
                'size'      => $this->plan->pet->mealSize(),
                'change'    => -1 * $meal->count,
            ]);
        }
    }

    /**
     * Cancels an order
     */
    public function cancel() {
        $this->cancelled = true;
        $this->save();
    }

    /**
     * @param $newDate
     * @param bool $applyToFutureOrders
     * @return bool
     */
    public function updateDeliverBy($newDate, $applyToFutureOrders = false) {
        $oldDeliverBy = clone $this->deliver_by;
        $this->deliver_by = Carbon::createFromFormat('Y-m-d', $newDate);

        $this->save();
        if (!$applyToFutureOrders) {
            return true;
        }

        /** @var Carbon $oldDeliverBy */
        if ($oldDeliverBy->lt($this->deliver_by)) {
            $oldDeliverBy->subSecond();
        } else {
            $oldDeliverBy->addSecond();
        }

        /** @var Carbon $oldDeliverBy */
        $daysToDelay = $oldDeliverBy->diff($this->deliver_by);
        $daysToDelay = ($daysToDelay->days) * ($daysToDelay->invert ? -1 : 1);

        $this->plan->delayOrdersAfter($this, $daysToDelay);
    }

    /**
     * Scopes
     */

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeNeedsPacking(Builder $query) {
        return $query->where('packed', '=', 0)
            ->where('cancelled', 0);
    }
    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeNeedsPicking(Builder $query) {
        return $query->where('picked', '=', 0)
            ->where('cancelled', 0);
    }


    /*
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer() {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function delivery() {
        return $this->hasOne(Delivery::class, 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deliveryAddress() {
        return $this->belongsTo(Address::class, 'delivery_address_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details() {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function inventoryChanges() {
        return $this->morphMany(Inventory::class, 'changeable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payments() {
        return $this->morphMany(Payment::class, 'paymentable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan() {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    /**
     * @param Product $product
     * @param int $quantity
     */
    public function addProduct($product, $quantity = 1) {
        if (is_array($product)) {
            $product = Product::findOrFail($product['id']);
        }
        
        $this->details()->create([
            'label'             => $product->name,
            'quantity'          => $quantity,
            'unit_cost'         => $product->price,
            'extended_cost'     => $product->price * $quantity,
            'tax'               => 0,
            'orderable_type'    => get_class($product),
            'orderable_id'      => $product->id,
        ]);
    }

    public function hasProduct(Product $product) {
        return !! $this->details()
            ->where('orderable_type', get_class($product))
            ->where('orderable_id', $product->id)
            ->count();
    }

    /**
     * @param Product $product
     */
    public function removeProduct(Product $product) {
        $this->details()
            ->where('orderable_type', get_class($product))
            ->where('orderable_id', $product->id)
            ->delete();
    }
}
