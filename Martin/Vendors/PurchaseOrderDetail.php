<?php

namespace Martin\Vendors;

use function GuzzleHttp\Psr7\_parse_request_uri;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\Core\Traits\CoreRelations;

class PurchaseOrderDetail extends Model
{
    use CoreRelations;
    use SoftDeletes;

    protected $fillable = [
        'purchase_order_id',
        'purchasable_id',
        'purchasable_type',
        'quantity',
    ];

    /**
     * Static constructor.. does NOT persist to DB
     *
     * @param $model
     * @param $quantity
     * @return Model
     */
    public static function byPurchasable($model, $quantity) {
        return PurchaseOrderDetail::make([
            'purchasable_type'  => get_class($model),
            'purchasable_id'    => $model->id,
            'quantity'          => $quantity,
        ]);
    }

    /**
     * @param $quantity
     */
    public function updateQuantity($quantity) {
        $this->quantity = $quantity;
        $this->save();
    }

    /**
     * @param $quantity
     * @return float|int
     */
    public function getQuantityAttribute($quantity) {
        return $quantity / 100;
    }

    /**
     * @param $quantity
     */
    public function setQuantityAttribute($quantity) {
        $this->attributes['quantity'] = round($quantity * 100);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function purchasable() {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchaseOrder() {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }
}
