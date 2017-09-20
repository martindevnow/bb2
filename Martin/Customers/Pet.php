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
    ];

    protected $dates = [
        'birthday',
    ];

    /**
     * All Plans are priced at intervals of 5lbs
     *
     * @return float
     */
    public function getPlanQuantity() {
        return round($this->weight / 5);
    }

    /**
     * Meal Size in LBs
     *
     * @return float
     */
    public function mealSize() {
        return $this->weight * $this->activity_level / 100 / 2;
    }

    public function mealSizeInGrams() {
        return $this->mealSize() * 454;
    }

    public function weeklyConsumption() {
        return $this->mealSize() * 14;
    }

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

    /**
     * Mutators
     */
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
