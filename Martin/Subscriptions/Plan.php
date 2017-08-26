<?php

namespace Martin\Subscriptions;

use App\Http\Controllers\PackagesController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Martin\ACL\User;
use Martin\Core\Address;
use Martin\Core\Traits\CoreRelations;
use Martin\Customers\Pet;
use Martin\Products\Container;
use Martin\Products\Meal;
use Martin\Transactions\Order;
use Martin\Transactions\Payment;

class Plan extends Model
{
    const HOURLY_RATE_FOR_PACKING_ORDERS = 25;
    const MINUTES_REQUIRED_TO_PACK_A_WEEK = 20;

    const PRICING_BY_SIZE = [
        ['label' => 'S', 'min' => 5, 'max' => 14, 'base' => 39, 'inc' => 1.95],
        ['label' => 'M', 'min' => 15, 'max' => 49, 'base' => 44.85, 'inc' => 1.625],
        ['label' => 'L', 'min' => 50, 'max' => 94, 'base' => 65, 'inc' => 1.755],
        ['label' => 'XL', 'min' => 95, 'max' => 139, 'base' => 87.1, 'inc' => 1.95],
        ['label' => 'XXL', 'min' => 140, 'max' => 220, 'base' => 104, 'inc' => 2.145],
    ];

    const SHIPPING_COST = 20;

    use SoftDeletes;
    use CoreRelations;

    /**
     * Fields which are "mass-assignable"
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'delivery_address_id',
        'shipping_cost',    // cents

        'pet_id',
        'pet_weight',       // lbs
        'pet_activity_level',

        'package_id',
        'package_stripe_code',
        'package_base',     // cents

        'weekly_cost',

        'last_delivery_at',
        'weeks_at_a_time',
        'active',
        'payment_method',
        'hash',
    ];

    /**
     * Fields which are cast to type of Carbon/Carbon
     *
     * @var array
     */
    protected $dates = [
        'last_delivery_at',
    ];

    public static function byHash($hash) {
        return Plan::where('hash', $hash)->firstOrFail();
    }

    public static function getPrice($pet_weight, Package $package, $shipping_modifier) {
        /** @var Collection $sizes */
        $sizes = collect(self::PRICING_BY_SIZE);

        $size = $sizes->filter(function($size) use ($pet_weight) {
            return $pet_weight >= $size['min'] && $pet_weight <= $size['max'];
        });
        if (! $size->count()) {
            // TODO: Throw error here
            return false;
        }
        $size = $size->first();

        $weight = round($pet_weight / 5, 0) * 5;
        return $size['base']
            + ($weight - $size['min']) / 5 * $size['inc']
            + $package->level * 5
            + $package->customization * 3
            + 5 * ($shipping_modifier) ;
    }

    /**
     * Scopes
     */

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNeedsOrder(Builder $query) {
        // 1 week at a time, will be all orders
        //      as long as there are no orders with....
        //          deliver_by is within the next two weeks
        // 2 weeks at a time, will be all orders, as long as there isn't an order already made for that day
        // 3 weeks at a time will be if the last_delivery_at is older than 1 week
        // 4 weeks at a time will be if the last delivery_at is older than 2 weeks
        return $query->where(function (Builder $sQ) {
            $sQ->where('last_delivery_at', '<=', Carbon::now())
                ->where('weeks_at_a_time', '<=', 2)
                ->whereDoesntHave('orders', function (Builder $ssQ) {
                    $ssQ->where('deliver_by', '<=', Carbon::now()->addDays(14));
                });
            ;
        })->orWhere(function (Builder $sQ) {
            $sQ->where('last_delivery_at', '<=', Carbon::now()->subDays(7))
                ->where('weeks_at_a_time', '=', 3)
                ->whereDoesntHave('orders', function (Builder $ssQ) {
                    $ssQ->where('deliver_by', '<=', Carbon::now()->addDays(14));
                });
        })->orWhere(function (Builder $sQ) {
            $sQ->where('last_delivery_at', '<=', Carbon::now()->subDays(14))
                ->where('weeks_at_a_time', '=', 4)
                ->whereDoesntHave('orders', function (Builder $ssQ) {
                    $ssQ->where('deliver_by', '<=', Carbon::now()->addDays(14));
                });
        });
    }


    /**
     * Mutators
     */

    /**
     * @param $value
     * @return float|int
     */
    public function getPackageBaseAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setPackageBaseAttribute($value) {
        $this->attributes['package_base'] = round($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getShippingCostAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setShippingCostAttribute($value) {
        $this->attributes['shipping_cost'] = round($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getWeeklyCostAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setWeeklyCostAttribute($value) {
        $this->attributes['weekly_cost'] = round($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getPetActivityLevelAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setPetActivityLevelAttribute($value) {
        $this->attributes['pet_activity_level'] = round($value * 100);
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
    public function package() {
        return $this->belongsTo(Package::class, 'package_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payments() {
        return $this->morphMany(Payment::class, 'paymentable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders() {
        return $this->hasMany(Order::class, 'plan_id');
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
    public function pet() {
        return $this->belongsTo(Pet::class, 'pet_id');
    }

    /**
     * Orders
     */

    /**
     * @return mixed
     */
    public function getLatestOrder() {
        return $this->orders()
            ->orderBy('deliver_by', 'DESC')
            ->first();
    }

    /**
     * @return bool
     */
    public function hasOrders() {
        return !! $this->orders()->count();
    }

    /**
     * @return Carbon
     */
    public function getNextOrderDate() {
        if (! $this->hasOrders())
            return Carbon::now();

        return $this->getLatestOrder()
            ->created_at
            ->addDays(7 * $this->weeks_at_a_time);
    }

    /**
     * @param Meal|null $meal
     * @return mixed
     */
    public function mealCounts(Meal $meal = null) {
        $weeks_at_a_time = $this->weeks_at_a_time;
        $grouped =  $this->package->meals->groupBy('id')
            ->map(function($group, $key) use ($weeks_at_a_time) {
                $item = $group->first();
                $item->count = $group->count() * $weeks_at_a_time;
                return $item;
            });

        if (! $meal)
            return $grouped;

        return $grouped->where('label', $meal->label)
            ->first()
            ->count;
    }

    /**
     * Generators
     */

    /**
     * TOD: Make the deliveryDate 'smarter'
     *
     * @return Order
     */
    public function generateOrder(): Order {
        $delivery_date = $this->getNextDeliveryDate();

        $subtotal = $this->calculateSubtotal();
        $tax = $this->deliveryAddress->getTax();

        return $this->orders()->create([
            'customer_id'   => $this->customer_id,
            'delivery_address_id'   => $this->delivery_address_id,
//            'shipping_cost' => $this->deliveryAddress
//                ->getShippingCostByMealSize($this->pet->mealSizeInGrams()),
            'subtotal'      => $subtotal,
            'tax'           => $tax,
            'total_cost'    => $tax + $subtotal,
            'deliver_by'    => $delivery_date,
            'plan_order'    => true,
        ]);
    }



    /**
     * Other
     */

    /**
     * @return mixed
     */
    public function getNextDeliveryDate() {
        if (! $this->last_delivery_at)
            return $this->created_at
                ->addDays(4);

        return $this->last_delivery_at
            ->addDays($this->weeks_at_a_time * 7);

        if (! $this->orders()->count())
            return $this->getFirstDeliveryDate();

        return $this->getLatestOrder()
            ->deliver_by
            ->addDays($this->weeks_at_a_time * 7);
    }

    /**
     * TODO: Make this 'smarter'
     *
     * @return mixed
     */
    public function getFirstDeliveryDate() {
        return $this->created_at;
    }

    /**
     * @return mixed
     */
    public function calculateSubtotal() {
        return self::getPrice($this->pet_weight, $this->package, $this->weeks_at_a_time === 4 ? 0 : 1);
    }

    /**
     * TODO: Make this 'smarter'
     *
     * @return float
     */
    public function packagingCost() {
        return Container::selectContainer($this->pet->mealSizeInGrams())
            ->costPerWeek();
    }

    /**
     * TODO: Make this 'smarter'
     *
     * @return float
     */
    public function packingCost() {
        return self::HOURLY_RATE_FOR_PACKING_ORDERS
            * (self::MINUTES_REQUIRED_TO_PACK_A_WEEK / 60);
    }

    /**
     * @return float
     */
    public function totalPackingCost() {
        return $this->packingCost() + $this->packagingCost();
    }


    /**
     * Return the internal cost per week for this Pet
     *
     * @return mixed
     */
    public function costPerWeek() {
        return $this->package
            ->costPerWeek($this->pet);
    }

    /**
     * Return the Cost as a function of the weight of the Pet for this plan
     *
     * @return float|int
     */
    public function costPerPoundOfDog() {
        return $this->weekly_cost / $this->pet_weight;
    }

    /**
     * Return the profit earned for this Plan
     *
     * @return mixed
     */
    public function profit() {
        return $this->weekly_cost -
            ($this->totalPackingCost() + $this->costPerWeek());
    }

}
