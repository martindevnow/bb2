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
        'payer_id',
        'collector_id',
        'paymentable_id',
        'paymentable_type',
        'received_at',
        'format',
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
    public function payer() {
        return $this->belongsTo(User::class, 'payer_id');
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
