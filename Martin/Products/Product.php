<?php

namespace Martin\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\Core\CoreModel;

class Product extends CoreModel
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'description_long',
        'size',
        'sku',
        'ingredients',
        'price'
    ];

    protected $casts = [
        'price' => 'integer',
    ];

    /**
     * @param $value
     * @return float|int
     */
    public function getPriceAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setPriceAttribute($value) {
        $this->attributes['price'] = round($value * 100);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function inventories() {
        return $this->morphMany(Inventory::class, 'inventoryable');
    }
}
