<?php

namespace Martin\Subscriptions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Frequency extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'label',
        'code',
        'multiplier',
        'discount_percent',
        'active',
    ];

    protected $casts = [
        'multiplier' => 'integer',
    ];

    /**
     * Mutators
     */

    /**
     * @param $value
     * @return float|int
     */
    public function getDiscountPercentAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setDiscountPercentAttribute($value) {
        $this->attributes['discount_percent'] = round($value * 100);
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
