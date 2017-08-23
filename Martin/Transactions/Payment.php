<?php

namespace Martin\Transactions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\ACL\User;

class Payment extends Model
{
    use SoftDeletes;

    /**
     * Mass-assignable Fields
     * 
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'collector_id',
        'paymentable_id',
        'paymentable_type',
        'received_at',
        'format',               // CASH, STRIPE, etc...
        'amount_paid',
    ];

    /**
     * Cast these fields as Carbon/Carbon
     * 
     * @var array
     */
    protected $dates = [
        'received_at'
    ];


    /**
     * Mutators
     */

    /**
     * @param $value
     * @return float|int
     */
    public function getAmountPaidAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setAmountPaidAttribute($value) {
        $this->attributes['amount_paid'] = round($value * 100);
    }


    /**
     * Relationships
     */

    /**
     * Return the person who collected the money
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function collector() {
        return $this->belongsTo(User::class, 'collector_id');
    }

    /**
     * Return the person who made the payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer() {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Return what this payment was applied to (subscription, purchase, etc)
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function paymentable() {
        return $this->morphTo();
    }
}
