<?php

namespace Martin\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'inventoryable_id',
        'inventoryable_type',
        'size',
        'change',
        'changeable_id',
        'changeable_type',
        'current',
    ];


    /**
     * @param $change
     * @return float|int
     */
    public function getChangeAttribute($change) {
        return $change / 100;
    }

    /**
     * @param $change
     */
    public function setChangeAttribute($change) {
        $this->attributes['change'] = round($change * 100);
    }

    /**
     * @param $current
     * @return float|int
     */
    public function getCurrentAttribute($current) {
        return $current / 100;
    }

    /**
     * @param $current
     */
    public function setCurrentAttribute($current) {
        $this->attributes['current'] = round($current * 100);
    }





    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function changeable() {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function inventoryable() {
        return $this->morphTo();
    }

}
