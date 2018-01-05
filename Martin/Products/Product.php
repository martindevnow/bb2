<?php

namespace Martin\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\Core\Traits\CoreRelations;
use Martin\Subscriptions\Plan;

class Product extends Model
{
    use SoftDeletes;
    use CoreRelations;

    public function getBuyableIdentifier($options = null) {
        return $this->id;
    }

    public function getBuyableDescription($options = null) {
        return $this->description;
    }
    
    public function getBuyablePrice($options = null) {
        return $this->price;
    }

    protected $fillable = [
        'name',
        'description',
        'description_long',
        'size',
        'sku',
        'ingredients',
        'price',
        'active',
    ];

    protected $casts = [
        'price' => 'integer',
    ];

    /**
     * Scopes
     */

     public function scopeActive(Builder $query) {
        return $query->where('active', '=', 1);
     }

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

    public function plans() {
        return $this->belongsToMany(Plan::class)
            ->withPivot('quantity');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function inventories() {
        return $this->morphMany(Inventory::class, 'inventoryable');
    }
}
