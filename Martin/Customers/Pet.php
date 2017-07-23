<?php

namespace Martin\Customers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\ACL\User;
use Martin\Subscriptions\Subscription;

class Pet extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'species',
        'breed',
        'weight',
        'birthday',
        'activity_level'
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

    public function mealSize() {
        return $this->weight * $this->activity_level / 100 / 2;
    }

    public function mealSizeInGrams() {
        return $this->mealSize() * 454;
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




    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions() {
        return $this->hasMany(Subscription::class);
    }
}
