<?php

namespace Martin\Subscriptions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\Products\Meal;

class MealReplacement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'removed_meal_id',
        'added_meal_id',
        'plan_id',
    ];

    /**
     * @param Meal $meal
     * @return $this
     */
    public function withMeal(Meal $meal) {
        $this->added_meal_id = $meal->id;
        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function addedMeal() {
        return $this->belongsTo(Meal::class, 'added_meal_id');
    }
}
