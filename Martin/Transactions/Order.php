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
use Martin\Subscriptions\Plan;
use Stripe\Collection;

class Order extends Model
{
    use SoftDeletes;
    use CoreRelations;

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
     * Scopes
     */

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeNeedsPacking(Builder $query) {
        return $query->where('packed', '=', 0);
    }
    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeNeedsPicking(Builder $query) {
        return $query->where('picked', '=', 0);
    }


    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer() {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deliveryAddress() {
        return $this->belongsTo(Address::class, 'delivery_address_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan() {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payments() {
        return $this->morphMany(Payment::class, 'paymentable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function inventoryChanges() {
        return $this->morphMany(Inventory::class, 'changeable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function delivery() {
        return $this->hasOne(Delivery::class, 'order_id');
    }
}
