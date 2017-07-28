<?php

namespace Martin\Transactions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\ACL\User;
use Martin\Core\Address;
use Martin\Subscriptions\Plan;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'plan_id',
        'delivery_address_id',
        'subtotal',
        'tax',
        'total_cost',
        'deliver_by',
    ];

    protected $dates = [
        'deliver_by'
    ];

    /**
     * Mutators
     */

    /**
     * @param $value
     * @return float|int
     */
    public function getSubtotalAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setSubtotalAttribute($value) {
        $this->attributes['subtotal'] = round($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getTaxAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setTaxAttribute($value) {
        $this->attributes['tax'] = round($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getTotalCostAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setTotalCostAttribute($value) {
        $this->attributes['total_cost'] = round($value * 100);
    }


    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer() {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deliveryAddress() {
        return $this->belongsTo(Address::class, 'delivery_address_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan() {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payments() {
        return $this->morphMany(Payment::class, 'paymentable');
    }

}
