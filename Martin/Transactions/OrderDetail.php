<?php

namespace Martin\Transactions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'label',
        'quantity',
        'unit_cost',
        'extended_cost',
        'tax',
        'orderable_type',
        'orderable_id',
    ];

    /*
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order() {
        return $this->belongsTo(Order::class);
    }
}
