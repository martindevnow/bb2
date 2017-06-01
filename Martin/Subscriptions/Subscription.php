<?php

namespace Martin\Subscriptions;

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
        'package_id',
        'activity_level_id',
        'delivery_frequency_id',
        'payment_frequency_id',

        // Details of the  at the time the sub was made (in case of price changes, etc)
        'package_external_lb_cost',
        'activity_level_multiplier',
        'frequency_multiplier',
        'frequency_discount_percent',

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
     * Get the label for this specific subSubscription
     *
     * @return string
     */
    public function getLabel() {
        return $this->package->label . ' - '
            . $this->activityLevel->label . ' - '
            . $this->paymentFrequency->label;
    }

    /**
     * Build a new Subscription for this Pet/User
     *
     * @param Package $package
     * @param ActivityLevel $activityLevel
     * @param Frequency $paymentFrequency
     * @param Frequency $deliveryFrequency
     * @param PickupLocation $location
     * @param PickupAppointment $appointment
     * @param User $user
     * @param Pet $pet
     */
    public static function makeNew(Package $package,
                                    ActivityLevel $activityLevel,
                                    Frequency $paymentFrequency,
                                    Frequency $deliveryFrequency,
                                    PickupLocation $location,
                                    PickupAppointment $appointment,
                                    User $user,
                                    Pet $pet) {
        $cost = static::calculateCost($package, $activityLevel, $paymentFrequency, $pet->weight);
        $plan = Plan::where('subSubscription_package_id', $package->id)
            ->where('subSubscription_activity_level_id', $activityLevel->id)
            ->where('subSubscription_frequency_id', $paymentFrequency->id)
            ->firstOrFail();

        $sub = new static([
            'plan_id'                           => $plan->id,
            'plan_quantity'                     => $pet->getPlanQuantity(),
            'package_id'                    => $package->id,
            'package_external_lb_cost'      => $package->external_lb_cost,
            'activity_level_id'             => $activityLevel->id,
            'activity_level_multiplier'     => $activityLevel->multiplier,
            'payment_frequency_id'                  => $paymentFrequency->id,
            'delivery_frequency_id'                 => $deliveryFrequency->id,
            'payment_frequency_multiplier'          => $paymentFrequency->multiplier,
            'payment_frequency_discount_percent'    => $paymentFrequency->discount_percent,
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
     * Deactivate this subSubscription
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
     * @param Package $package
     * @param ActivityLevel $activityLevel
     * @param Frequency $frequency
     * @return mixed
     */
    public static function calculateCost(Package $package, ActivityLevel $activityLevel, Frequency $frequency, $weight) {
        return $package->external_lb_cost
            * $activityLevel->multiplier * $weight * 7
            * $frequency->multiplier * (1 - $frequency->discount_percent);
    }

    /**
     * Calculate the internal cost of purchasing the meat/materials
     *
     * @param Package $package
     * @param ActivityLevel $activityLevel
     * @param Frequency $frequency
     * @param int $weight
     * @return mixed
     */
    public static function calculateInternalCost(Package $package, ActivityLevel $activityLevel, Frequency $frequency, $weight = 5)
    {
        return $package->lb_cost // using internal cost
            * $activityLevel->multiplier * $weight * 7
            * $frequency->multiplier; // no discount
    }

    /**
     * @return mixed
     */
    public function getCalculatedCost() {
        return $this->package->external_lb_cost
            * $this->activityLevel->multiplier * 7
            * $this->paymentFrequency->multiplier * (1 - $this->paymentFrequency->discount_percent);
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
    public function getPackageExternalLbCostAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setPackageExternalLbCostAttribute($value) {
        $this->attributes['package_external_lb_cost'] = round($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getActivityLevelMultiplierAttribute($value) {
        return $value / 1000;
    }

    /**
     * @param $value
     */
    public function setActivityLevelMultiplierAttribute($value) {
        $this->attributes['activity_level_multiplier'] = round($value * 1000);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getFrequencyDiscountPercentAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setFrequencyDiscountPercentAttribute($value) {
        $this->attributes['frequency_discount_percent'] = round($value * 100);
    }


    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function package() {
        return $this->belongsTo(Package::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activityLevel() {
        return $this->belongsTo(ActivityLevel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentFrequency() {
        return $this->belongsTo(Frequency::class, 'payment_frequency_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deliveryFrequency() {
        return $this->belongsTo(Frequency::class, 'delivery_frequency_id');
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
