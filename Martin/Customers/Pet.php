<?php

namespace Martin\Customers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\ACL\User;
use Martin\Products\Subscription;

class Pet extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'species',
        'breed',
        'weight',
        'birthday',
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
