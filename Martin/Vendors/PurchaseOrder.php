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
     * @param Model $model
     * @param $quantity
     * @return Model
     */
    public function addItem(Model $model, $quantity) {
        $details = PurchaseOrderDetail::byPurchasable($model, $quantity);
        return $this->details()->save($details);
    }

    /**
     * @param PurchaseOrderDetail $detail
     * @return bool
     */
    public function removeDetail(PurchaseOrderDetail $detail) {
        if ($detail->purchase_order_id == $this->id) {
            $detail->delete();
        }

        // TODO: Throw error here
        // This detail doesn't belong to this Purchase Order
        return false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details() {
        return $this->hasMany(PurchaseOrderDetail::class, 'purchase_order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }

}
