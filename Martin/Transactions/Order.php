<?php

namespace Martin\Transactions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\ACL\User;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'delivery_address_id',
        'subtotal',
        'tax',
        'total_cost',
    ];

    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer() {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
