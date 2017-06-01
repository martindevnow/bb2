<?php

namespace Martin\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meat extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'label',
        'code',
        'internal_cost',
        'external_cost',
    ];


    /**
     * Mutators
     */

    /**
     * @param $value
     * @return float|int
     */
    public function getInternalLbCostAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setInternalLbCostAttribute($value) {
        $this->attributes['internal_lb_cost'] = round($value * 100);
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
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subPackages() {
        return $this->belongsToMany(SubPackage::class)->withPivot('meat_percentage');
    }
}

