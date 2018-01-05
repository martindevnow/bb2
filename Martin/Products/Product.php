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

    /*
     * Scopes
     */


    /**
     * @param Builder $query
     * @return $this
     */
     public function scopeActive(Builder $query) {
        return $query->where('active', '=', 1);
     }

    /*
     * Mutators
     */

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


    /*
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
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
