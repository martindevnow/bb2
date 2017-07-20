<?php

namespace Martin\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\Products\Traits\HasMeats;
use Martin\Products\Traits\HasToppings;

class Meal extends Model
{
    use SoftDeletes;

    use HasMeats, HasToppings;

    protected $fillable = [
        'code', 'label', 'meal_value',
    ];

    /**
     * @return float|int
     */
    public function costPerLb() {
        if ( ! $this->meats()->count() )
            return 0;

        return $this->meats()->sum('cost_per_lb') / $this->meats()->count() / 100;
    }



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
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function toppings() {
        return $this->belongsToMany(Topping::class);
    }

}
