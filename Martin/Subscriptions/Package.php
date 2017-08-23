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
        'customization',
        'level',
    ];

    /**
     * Get the average cost per pound of food for this package
     *
     * @return float|int
     */
    public function costPerLb() {
        if (! $this->meals()->count())
            return 0;

        return $this->meals->reduce(function($carry, Meal $meal) {
                return $carry + $meal->costPerLb();
            }) / $this->meals()->count();
    }

    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plans() {
        return $this->hasMany(Plan::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function meals() {
        return $this->belongsToMany(Meal::class)
            ->withPivot('calendar_code');
    }

    /**
     * Other
     */

    /**
     * Get the cost per meal for the pet on this plan
     *
     * @param Pet $pet
     * @return float
     */
    public function costPerMeal(Pet $pet) {
        return $pet->mealSize() * $this->costPerLb() ;
    }

    /**
     * @param Pet $pet
     * @return float
     */
    public function costPerWeek(Pet $pet) {
        return $this->costPerMeal($pet) * 14;
    }

    /**
     * @return $this
     */
    public function mealCounts($meal = null) {
        $grouped =  $this->meals->groupBy('id')
            ->map(function($group, $key) {
                $item = $group->first();
                $item->count = $group->count();
                return $item;
            });

        if (! $meal)
            return $grouped;

        return $grouped->where('label', $meal->label)
            ->first()
            ->count;
    }
}
