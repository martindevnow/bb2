<?php

namespace Martin\Customers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\ACL\User;
use Martin\Subscriptions\Plan;

class Pet extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'species',
        'breed',
        'weight',
        'birthday',
        'activity_level',
        'owner_id',
        'daily_meals',
    ];

    protected $dates = [
        'birthday',
    ];

//    protected $appends = [
//        'owner_name'
//    ];
//
//    public function getOwnerNameAttribute() {
//        return $this->owner->name;
//    }

    /**
     * All Plans are priced at intervals of 5lbs
     *
     * @return float
     */
    public function getPlanQuantity() {
        return round($this->weight / 5);
    }

    /**
     * Meal weight in LBs for this pet
     *
     * @return float
     */
    public function mealSize() {
        return $this->dailyConsumption()
            / $this->daily_meals;
    }

    /**
     * Individual meal weight in Grams for this pet
     *
     * @return float
     */
    public function mealSizeInGrams() {
        return $this->mealSize() * 454;
    }

    /**
     * Weight in LBs of total food eaten daily by this pet
     *
     * @return float|int
     */
    public function dailyConsumption() {
        return $this->weight
            * $this->activity_level / 100;
    }

    /**
     * Weight in LBs of total food eaten weekly by this pet
     *
     * @return float|int
     */
    public function weeklyConsumption() {
        return $this->dailyConsumption() * 7;
    }

    public function makePuppy() {
        $this->daily_meals = 3;
        $this->save();
        return $this;
    }

    /**
     * Mutators
     */

    /**
     * @param $activity_level
     * @return float|int
     */
    public function getActivityLevelAttribute($activity_level) {
        return $activity_level / 100;
    }

    /**
     * @param $activity_level
     */
    public function setActivityLevelAttribute($activity_level) {
        $this->attributes['activity_level'] = round($activity_level * 100);
    }

    // TODO: Add a mutator for birthday so it removes the time portion of carbon... ?
    // I can use the Trait I made to remove the time from the Carbon instance..
    // It makes life easier as I can assume that it is coming as a date string in a
    // predictable format....
    // OR
    // Is a Carbon instance easier....?



    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plans() {
        return $this->hasMany(Plan::class);
    }
}
