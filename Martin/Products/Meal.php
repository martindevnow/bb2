<?php

namespace Martin\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meal extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code', 'label', 'meal_value',
    ];

    /**
     * Mutators
     */


    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function meats() {
        return $this->belongsToMany(Meat::class);
    }

}
