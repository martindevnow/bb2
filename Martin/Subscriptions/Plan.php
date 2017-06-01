<?php

namespace Martin\Subscriptions;

use App\Http\Controllers\PackagesController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'plan_name',
        'package_id',
        'activity_level_id',
        'frequency_id',
        'internal_cost',
        'external_cost',
        'active',
    ];


    /**
     * Static Constructor to fetch a Plan to use with Stripe
     *
     * @param Package $package
     * @param ActivityLevel $activityLevel
     * @param Frequency $frequency
     * @return mixed
     */
    public static function fetchFromSubData(Package $package, ActivityLevel $activityLevel, Frequency $frequency) {
        return static::where('package_id', $package->id)
            ->where('activity_level_id', $activityLevel->id)
            ->where('frequency_id', $frequency->id)
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
        return $this->belongsTo(Package::class, 'package_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subActivityLevel() {
        return $this->belongsTo(ActivityLevel::class, 'activity_level_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subFrequency() {
        return $this->belongsTo(Frequency::class, 'frequency_id');
    }


}
