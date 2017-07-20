<?php

namespace Martin\Subscriptions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
