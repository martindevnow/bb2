<?php

namespace Martin\Subscriptions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityLevel extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'label',
        'code',
        'multiplier',
        'active',
    ];

    /**
     * Mutators
     */

    /**
     * @param $value
     * @return float|int
     */
    public function getMultiplierAttribute($value) {
        return $value / 1000;
    }

    /**
     * @param $value
     */
    public function setMultiplierAttribute($value) {
        $this->attributes['multiplier'] = round($value * 1000);
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
}
