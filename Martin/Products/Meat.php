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

    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subPackages() {
        return $this->belongsToMany(Package::class)
            ->withPivot('number_of_meals');
    }
}

