<?php

namespace Martin\Subscriptions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'label',
        'code',
        'lb_cost',
        'external_lb_cost',
        'profit_margin',
        'active',
    ];


    /**
     * Mutators
     */

    /**
     * @param $value
     * @return float|int
     */
    public function getLbCostAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setLbCostAttribute($value) {
        $this->attributes['lb_cost'] = round($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getExternalLbCostAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setExternalLbCostAttribute($value) {
        $this->attributes['external_lb_cost'] = round($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getProfitMarginAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setProfitMarginAttribute($value) {
        $this->attributes['profit_margin'] = round($value * 100);
    }


    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions() {
        return $this->hasMany(Subscription::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function meats() {
        return $this->belongsToMany(Meat::class)->withPivot('meat_percentage');
    }
}
