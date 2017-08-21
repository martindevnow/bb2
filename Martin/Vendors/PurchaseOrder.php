<?php

namespace Martin\Vendors;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\Core\Traits\CoreRelations;

class PurchaseOrder extends Model
{
    use CoreRelations;
    use SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'total',
        'ordered',
        'ordered_at',
        'received',
        'received_at',
    ];


    /**
     * @param $total
     * @return float|int
     */
    public function getTotalAttribute($total) {
        return $total / 100;
    }

    /**
     * @param $total
     */
    public function setTotalAttribute($total) {
        $this->attributes['total'] = round($total * 100);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function details() {
        return $this->morphMany(PurchaseOrderDetail::class, 'purchasable');
    }

}
