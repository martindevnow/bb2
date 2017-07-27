<?php

namespace Martin\Delivery;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\ACL\User;
use Martin\Transactions\Order;

class Delivery extends Model
{
    use SoftDeletes;

    /**
     * Mass-assignable fields
     *
     * @var array
     */
    protected $fillable = [
        'recipient_id',
        'order_id',
        'courier_id',

        'shipped_at',
        'delivered_at',

        'tracking_number',
        'instructions',
    ];

    /**
     * Cast these fields as Carbon/Carbon
     *
     * @var array
     */
    protected $dates = [
        'shipped_at',
        'delivered_at',
    ];

    /**
     * Return whether or not this delivery has been delivered
     *
     * @return bool
     */
    public function delivered() {
        return ! $this->delivered_at == null;
    }


    /**
     * Relationships
     */

    /**
     * Return the person who made the delivery
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courier() {
        return $this->belongsTo(Courier::class, 'courier_id');
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
     * Return the order that is being delivered
     */
    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
