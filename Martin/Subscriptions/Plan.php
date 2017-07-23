<?php

namespace Martin\Subscriptions;

use App\Http\Controllers\PackagesController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'delivery_id',
        'shipping_cost',    // cents

        'pet_id',
        'pet_weight',       // lbs
        'pet_activity_level',

        'package_id',
        'package_stripe_code',
        'package_base',     // cents

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
    public function package() {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
