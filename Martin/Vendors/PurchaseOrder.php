<?php

namespace Martin\Vendors;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\Core\Traits\CoreRelations;
use Martin\Products\Meat;
use Martin\Subscriptions\Plan;

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


    public function addPlanToOrder(Plan $plan, $number_of_weeks = 1) {
        $meatWeights = $plan->getMeatWeightsByCode();

        foreach($meatWeights as $code => $weightInGrams) {
            $item = Meat::where('code', $code)->first();

            if ($detail = $this->hasItem($item)) {
                $detail->addToQuantity($weightInGrams);
            } else {
                $this->addItem($item, $weightInGrams * $number_of_weeks);
            }
        }
    }

    public function hasItem($item) {
        $items = $this->details()->where('purchasable_type', get_class($item))
            ->where('purchasable_id', $item->id);

        if (! $items->count())
            return false;

        return $items->first();
    }

//    public function totalsByItem() {
//        $keyed = $this->details->map(function($detail) {
//            $detail->uniqueKey = $detail->purchasable_id . "---". $detail->purchasable_type;
//            return $detail;
//        });
//
//        $items = $keyed->unique('uniqueKey')->pluck('uniqueKey');
//
//
//        return $items;
//    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details() {
        return $this->hasMany(
            PurchaseOrderDetail::class,
            'purchase_order_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }

}
