<?php

namespace Martin\Delivery;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\ACL\User;

class Delivery extends Model
{
    use SoftDeletes;

    /**
     * Mass-assignable fields
     *
     * @var array
     */
    protected $fillable = [
        'deliverer_id',
        'recipient_id',

        'deliverable_id',
        'deliverable_type',

        'delivered_at',
        'days_of_food_delivered',
    ];

    /**
     * Cast these fields as Carbon/Carbon
     *
     * @var array
     */
    protected $dates = [
        'delivered_at',
    ];


    /**
     * Relationships
     */

    /**
     * Return the person who made the delivery
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deliverer() {
        return $this->belongsTo(User::class, 'deliverer_id');
    }

    /**
     * Return the person who received the delivery
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient() {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    /**
     * Return what the delivery is applied to (ie. subscription, purchase, etc)
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function deliverable() {
        return $this->morphTo();
    }
}
