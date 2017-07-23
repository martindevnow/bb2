<?php

namespace Martin\Subscriptions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\Customers\Pet;
use Martin\Products\Meal;
use Martin\Subscriptions\Traits\HasMeals;

class Package extends Model
{
    use SoftDeletes;

    use HasMeals;

    protected $fillable = [
        'label',
        'code',
        'public',
        'active',
    ];

    /**
     * Mutators
     */


    /**
     * Get the average cost per pound of food for this package
     *
     * @param Pet $pet
     * @return float|int
     */
    public function costPerLb(Pet $pet = null) {
        $costPerLb = $this->meals->reduce(function($carry, Meal $meal) {
                return $carry + $meal->costPerLb();
            }) / $this->meals()->count();

        if ( ! $pet)
            return $costPerLb;

        return $costPerLb * $pet->mealSize();

    }

    public function costPerMeal(Pet $pet) {
        return $pet->mealSize() * $this->costPerLb() ;
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
    public function meals() {
        return $this->belongsToMany(Meal::class)
            ->withPivot('calendar_code');
    }
}
