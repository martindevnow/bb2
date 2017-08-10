<?php

namespace Martin\Subscriptions\Traits;

use Martin\Products\Meal;
use Martin\Subscriptions\MealPackage;

trait HasMeals {

    /**
     * @param $meal
     * @param $calendar_code
     * @return
     */
    public function addMeal($meal, string $calendar_code) {
        if ($this->hasMeal($calendar_code)) {
            $this->removeMeal($calendar_code);
        }

        if (is_string($meal))
            return $this->meals()->attach(
                Meal::whereCode($meal)->firstOrFail(),
                compact('calendar_code')
            );

        if ($meal instanceof Meal) {
            $attach = $this->meals()->save(
                $meal,
                compact('calendar_code')
            );
            return $attach;
        }

        return $this->meals()->attach(
            Meal::findOrFail($meal),
            compact('calendar_code')
        );
    }

    public function hasMeal($meal) {
        if ($this->meals->count() == 0)
            return false;

        if ($meal instanceof Meal)
            return !! $this->meals->filter(function($val, $key) use ($meal) {
                return $val->id === $meal->id;
            })->count();

        if (is_integer($meal))
            return !! $this->meals->filter(function($val, $key) use ($meal) {
                return $val->id === $meal;
            })->count();

        if (is_string($meal))
            return !! $this->meals->filter(function($val, $key) use ($meal) {
                return $val->pivot->calendar_code == $meal;
            })->count();

        // TODO: Throw an error here.
        return false;
    }

    public function removeMeal($meal) {
        if (is_string($meal)) {
            $meals = $this->meals->filter(function($val, $key) use ($meal) {
                return $val->pivot->calendar_code == $meal;
            });

            if ( $meals->count() !== 1)
                return false;   // TODO: Throw an error here

            $mealToRemove = $meals->first();
            $pivot = MealPackage::where('package_id', $mealToRemove->pivot->package_id)
                ->where('meal_id', $mealToRemove->pivot->meal_id)
                ->where('calendar_code', $meal)
                ->first();
            return $pivot->delete();
        }

        return false;
    }

    public function getMeal($meal) {
        if (is_string($meal))
            return $this->meals->filter(function($val, $key) use ($meal) {
                return $val->pivot->calendar_code == $meal;
            })->first();

        // TODO: Throw an error here...
        return false;
    }

}