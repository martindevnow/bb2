<?php

namespace Martin\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topping extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code', 'label', 'cost_per_kg',
    ];

    /**
     * Mutators
     */

    /**
     * @param $value
     * @return float|int
     */
    public function getCostPerKgAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setCostPerKgAttribute($value) {
        $this->attributes['cost_per_kg'] = round($value * 100);
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
}
