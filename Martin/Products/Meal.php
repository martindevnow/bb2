<?php

namespace Martin\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\Products\Traits\HasMeats;
use Martin\Products\Traits\HasToppings;
use Martin\Subscriptions\Package;

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

        return $this->meats()->sum('cost_per_lb')
            / $this->meats()->count()
            / 100;
    }

    /**
     * @return string
     */
    public function toppingsToString() {
        if (! $this->hasToppings())
            return "Plain";

        $toppings = $this->toppings->pluck('label');
        return implode(', ', $toppings->all());
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function packages() {
        return $this->belongsToMany(Package::class)
            ->withPivot('calendar_code');
    }

    /**
     * @return bool
     */
    public function hasToppings() {
        return !! $this->toppings()->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function inventories() {
        return $this->morphMany(Inventory::class, 'inventoryable');
    }


    // TODO: Maybe include a method here to get the meals of this type,
    // but group by 'size' and sum the 'current'
    // so we know exactly how many of this type for each size...
    // or something....
}
