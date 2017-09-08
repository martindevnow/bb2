<?php

namespace Martin\Subscriptions;

use Illuminate\Database\Eloquent\Model;

class CostModel extends Model
{
    protected $fillable = [
        'size',
        'min_weight',
        'max_weight',
        'base_cost',
        'incremental_cost',
        'upgrade_cost',
        'customization_cost',
    ];

    /**
     * @param $value
     * @return float|int
     */
    public function getBaseCostAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setBaseCostAttribute($value) {
        $this->attributes['base_cost'] = round($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getIncrementalCostAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setIncrementalCostAttribute($value) {
        $this->attributes['incremental_cost'] = round($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getUpgradeCostAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setUpgradeCostAttribute($value) {
        $this->attributes['upgrade_cost'] = round($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getCustomizationCostAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setCustomizationCostAttribute($value) {
        $this->attributes['customization_cost'] = round($value * 100);
    }

}
