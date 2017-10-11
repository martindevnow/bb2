<?php

namespace Martin\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\Subscriptions\Package;

class Meat extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'variety',
        'code',
        'cost_per_lb',
    ];

    protected $appends = [
        'cost_per_quantity',
    ];

    public function getCostPerQuantityAttribute() {
        return $this->costPerQuantity();
    }

    /**
     * Mutators
     */

    /**
     * @param $value
     * @return float|int
     */
    public function getCostPerLbAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setCostPerLbAttribute($value) {
        $this->attributes['cost_per_lb'] = round($value * 100);
    }

    public function costPerQuantity() {
        return $this->cost_per_lb / 454;
    }

    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function meals() {
        return $this->belongsToMany(Meal::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function inventories() {
        return $this->morphMany(Inventory::class, 'inventoryable');
    }
}

