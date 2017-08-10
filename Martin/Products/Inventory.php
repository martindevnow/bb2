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
