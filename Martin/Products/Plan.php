<?php

namespace Martin\Products;

use App\Http\Controllers\PackagesController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'plan_name',
        'subscription_package_id',
        'subscription_activity_level_id',
        'subscription_frequency_id',
        'internal_cost',
        'external_cost',
        'active',
    ];


    /**
     * Static Constructor to fetch a Plan to use with Stripe
     *
     * @param SubPackage $package
     * @param SubActivityLevel $activityLevel
     * @param SubFrequency $frequency
     * @return mixed
     */
    public static function fetchFromSubData(SubPackage $package, SubActivityLevel $activityLevel, SubFrequency $frequency) {
        return static::where('subscription_package_id', $package->id)
            ->where('subscription_activity_level_id', $activityLevel->id)
            ->where('subscription_frequency_id', $frequency->id)
            ->first();
    }


    /**
     * Mutators
     */

    /**
     * @param $value
     * @return float|int
     */
    public function getInternalCostAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setInternalCostAttribute($value) {
        $this->attributes['internal_cost'] = round($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getExternalCostAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setExternalCostAttribute($value) {
        $this->attributes['external_cost'] = round($value * 100);
    }



    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subPackage() {
        return $this->belongsTo(SubPackage::class, 'subscription_package_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subActivityLevel() {
        return $this->belongsTo(SubActivityLevel::class, 'subscription_activity_level_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subFrequency() {
        return $this->belongsTo(SubFrequency::class, 'subscription_frequency_id');
    }


}
