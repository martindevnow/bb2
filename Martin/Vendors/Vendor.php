<?php

namespace Martin\Vendors;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\Core\Traits\CoreRelations;

class Vendor extends Model
{
    use CoreRelations;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'label',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseOrders() {
        return $this->hasMany(PurchaseOrder::class);
    }
}
