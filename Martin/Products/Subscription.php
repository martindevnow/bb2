<?php

namespace Martin\Products;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\ACL\User;
use Martin\Customers\Pet;
use Martin\Delivery\Delivery;
use Martin\Delivery\PickupAppointment;
use Martin\Delivery\PickupLocation;

class Subscription extends Model
{
    use SoftDeletes;

    /**
     * Mass-assignable fields
     *
     * @var array
     */
    protected $fillable = [
        // Only really apply to Stripe
        'plan_id',
        'plan_quantity',
        'stripe_customer_id',

        // User/Pet Info
        'user_id',
        'pet_id',
        'pet_weight_lbs',

        // Package/Activity/Frequency Data
        'sub_package_id',
        'sub_activity_level_id',
        'sub_delivery_frequency_id',
        'sub_payment_frequency_id',

        // Details of the Sub at the time the sub was made (in case of price changes, etc)
        'sub_package_external_lb_cost',
        'sub_activity_level_multiplier',
        'sub_frequency_multiplier',
        'sub_frequency_discount_percent',

        // Delivery Info
        'pickup_location_id',
        'pickup_appointment_id',
        'first_delivery_at',

        // Cost at the time the sub was made
        'cost',

        // Whether it is active or not
        'active',
        'expires_on',
    ];

    /**
     * Cast these fields as Carbon/Carbon
     *
     * @var array
     */
    protected $dates = [
        'first_delivery_at',
        'expires_on',
    ];

    /**
     * Get the label for this specific subscription
     *
     * @return string
     */
    public function getLabel() {
        return $this->subPackage->label . ' - '
            . $this->subActivityLevel->label . ' - '
            . $this->subPaymentFrequency->label;
    }

    /**
     * Build a new Subscription for this Pet/User
     *
     * @param SubPackage $package
     * @param SubActivityLevel $activityLevel
     * @param SubFrequency $frequency
     * @param User $user
     * @return
     */
    public static function makeNew(SubPackage $package,
                                    SubActivityLevel $activityLevel,
                                    SubFrequency $paymentFrequency,
                                    SubFrequency $deliveryFrequency,
                                    PickupLocation $location,
                                    PickupAppointment $appointment,
                                    User $user,
                                    Pet $pet) {
        $cost = static::calculateCost($package, $activityLevel, $paymentFrequency, $pet->weight);
        $plan = Plan::where('subscription_package_id', $package->id)
            ->where('subscription_activity_level_id', $activityLevel->id)
            ->where('subscription_frequency_id', $paymentFrequency->id)
            ->firstOrFail();

        $sub = new static([
            'plan_id'                           => $plan->id,
            'plan_quantity'                     => $pet->getPlanQuantity(),
            'sub_package_id'                    => $package->id,
            'sub_package_external_lb_cost'      => $package->external_lb_cost,
            'sub_activity_level_id'             => $activityLevel->id,
            'sub_activity_level_multiplier'     => $activityLevel->multiplier,
            'sub_payment_frequency_id'                  => $paymentFrequency->id,
            'sub_delivery_frequency_id'                 => $deliveryFrequency->id,
            'sub_payment_frequency_multiplier'          => $paymentFrequency->multiplier,
            'sub_payment_frequency_discount_percent'    => $paymentFrequency->discount_percent,
            'pickup_location_id'                => $location->id,
            'pickup_appointment_id'             => $appointment->id,
            'user_id'                           => $user->id,
            'pet_id'                            => $pet->id,
            'pet_weight_lbs'                    => $pet->weight,
            'cost'                              => $cost,
        ]);

        return $sub->save();
    }

    /**
     * Activate this Subscription
     *
     * @param $customerId
     * @return bool
     */
    public function activate($customerId) {
        return $this->update([
            'stripe_customer_id'    => $customerId,
            'active'                => true,
        ]);
    }

    /**
     * Deactivate this subscription
     *
     * @return bool
     */
    public function deactivate() {
        return $this->update([
            'active'        => false,
            'expires_on'    => Carbon::now(),
        ]);
    }

    /**
     * Calculate the external cost of the plan for the customer
     *
     * @param SubPackage $package
     * @param SubActivityLevel $activityLevel
     * @param SubFrequency $frequency
     * @return mixed
     */
    public static function calculateCost(SubPackage $package, SubActivityLevel $activityLevel, SubFrequency $frequency, $weight) {
        return $package->external_lb_cost
            * $activityLevel->multiplier * $weight * 7
            * $frequency->multiplier * (1 - $frequency->discount_percent);
    }

    /**
     * Calculate the internal cost of purchasing the meat/materials
     *
     * @param SubPackage $package
     * @param SubActivityLevel $activityLevel
     * @param SubFrequency $frequency
     * @param int $weight
     * @return mixed
     */
    public static function calculateInternalCost(SubPackage $package, SubActivityLevel $activityLevel, SubFrequency $frequency, $weight = 5)
    {
        return $package->lb_cost // using internal cost
            * $activityLevel->multiplier * $weight * 7
            * $frequency->multiplier; // no discount
    }

    /**
     * @return mixed
     */
    public function getCalculatedCost() {
        return $this->subPackage->external_lb_cost
            * $this->subActivityLevel->multiplier * 7
            * $this->subPaymentFrequency->multiplier * (1 - $this->subPaymentFrequency->discount_percent);
    }

    /**
     * @return bool
     */
    public function validateCost() {
        return $this->getCalculatedCost() == $this->cost;
    }


    /**
     * Mutators
     */

    /**
     * @param $value
     * @return float|int
     */
    public function getCostAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setCostAttribute($value) {
        $this->attributes['cost'] = round($value * 100);
    }
    /**
     * @param $value
     * @return float|int
     */
    public function getSubPackageExternalLbCostAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setSubPackageExternalLbCostAttribute($value) {
        $this->attributes['sub_package_external_lb_cost'] = round($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getSubActivityLevelMultiplierAttribute($value) {
        return $value / 1000;
    }

    /**
     * @param $value
     */
    public function setSubActivityLevelMultiplierAttribute($value) {
        $this->attributes['sub_activity_level_multiplier'] = round($value * 1000);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getSubFrequyencyDiscountPercentAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setSubFrequyencyDiscountPercentAttribute($value) {
        $this->attributes['sub_frequency_discount_percent'] = round($value * 100);
    }


    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subPackage() {
        return $this->belongsTo(SubPackage::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subActivityLevel() {
        return $this->belongsTo(SubActivityLevel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subPaymentFrequency() {
        return $this->belongsTo(SubFrequency::class, 'sub_payment_frequency_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subDeliveryFrequency() {
        return $this->belongsTo(SubFrequency::class, 'sub_delivery_frequency_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pet() {
        return $this->belongsTo(Pet::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan() {
        return $this->belongsTo(Plan::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function deliveries() {
        return $this->morphMany(Delivery::class, 'deliverable');
    }

}
