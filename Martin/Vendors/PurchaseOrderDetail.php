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
        'purchasable_id',
        'purchasable_type',
        'quantity',
    ];

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
}
