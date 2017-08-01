<?php

namespace Martin\Subscriptions;

use App\Http\Controllers\PackagesController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\ACL\User;
use Martin\Core\Address;
use Martin\Customers\Pet;
use Martin\Transactions\Order;
use Martin\Transactions\Payment;

class Plan extends Model
{
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
    public function getLatestOrder(): mixed
    {
        return $this->orders()
            ->orderBy('deliver_by', 'DESC')
            ->first();
    }

    /**
     * Generators
     */

    /**
     * TOD: Make the deliveryData 'smarter'
     *
     * @return Model
     */
    public function generateOrder() {
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
            'subtotal'  => $subtotal,
            'tax'   => $tax,
            'total_cost' => $tax + $subtotal,
            'deliver_by'   => $delivery_date,
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

    public function calculateSubtotal() {
        return $this->weeks_at_a_time *
            ($this->package->costPetWeek($this->pet)
                + $this->getPackagingCost());
    }

    /**
     * TODO: Make this 'smarter'
     *
     * @return float
     */
    public function getPackagingCost() {
        return 4.50;
    }


}
