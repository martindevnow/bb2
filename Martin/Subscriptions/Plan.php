<?php

namespace Martin\Subscriptions;

use App\Http\Controllers\PackagesController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\ACL\User;
use Martin\Core\Address;
use Martin\Customers\Pet;
use Martin\Products\Container;
use Martin\Transactions\Order;
use Martin\Transactions\Payment;

class Plan extends Model
{
    const HOURLY_RATE_FOR_PACKING_ORDERS = 25;
    const MINUTES_REQUIRED_TO_PACK_A_WEEK = 20;

    use SoftDeletes;

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

        'weeks_at_a_time',
        'active',
    ];


    public function costPerWeek() {
        return $this->package
            ->costPerWeek($this->pet);
    }

    public function costPerPoundOfDog() {
        return $this->weekly_cost / $this->pet_weight;
    }

    public function profit() {
        return $this->weekly_cost -
            ($this->totalPackingCost() + $this->costPerWeek());
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
     * Generators
     */

    /**
     * TOD: Make the deliveryData 'smarter'
     *
     * @return Order
     */
    public function generateOrder(): Order {
        if (! $this->orders()->count()) {
            $delivery_date = $this->getFirstDeliveryDate();
        } else {
            $delivery_date = $this->getLatestOrder()
                ->deliver_by
                ->addDays(7)
            ;
        }

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
        return $this->weeks_at_a_time *
            ($this->package->costPerWeek($this->pet)
                + $this->packagingCost());
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

}
