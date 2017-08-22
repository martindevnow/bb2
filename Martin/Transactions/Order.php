<?php

namespace Martin\Transactions;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\ACL\User;
use Martin\Core\Address;
use Martin\Core\Traits\CoreRelations;
use Martin\Products\Inventory;
use Martin\Products\Meal;
use Martin\Subscriptions\Plan;

class Order extends Model
{
    use SoftDeletes;
    use CoreRelations;

    protected $fillable = [
        'plan_id',
        'customer_id',
        'delivery_address_id',
        'subtotal',
        'tax',
        'total_cost',

        'include_meals',

        'paid',
        'packed',
        'picked',
        'shipped',
        'delivered',

        'deliver_by',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'deliver_by'
    ];

    /**
     * Mutators
     */

    /**
     * @param $value
     * @return float|int
     */
    public function getSubtotalAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setSubtotalAttribute($value) {
        $this->attributes['subtotal'] = round($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getTaxAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setTaxAttribute($value) {
        $this->attributes['tax'] = round($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getTotalCostAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setTotalCostAttribute($value) {
        $this->attributes['total_cost'] = round($value * 100);
    }

    /**
     * @param Meal|null $meal
     * @return mixed
     */
    public function mealCounts(Meal $meal = null) {
        return $this->plan->mealCounts($meal);
    }

    /**
     * Order Packing etc Workflow
     */

    /**
     * Marks this Order as packed and adjusts inventory as appropriate..
     *
     * @return $this
     */
    public function markAsPacked() {
        $this->reduceMeatInventory();
        $this->increaseMealInventory();

        $this->packed = true;
        $this->save();

        return $this;
    }

    /**
     * @return $this
     */
    public function markAsPicked() {
        $this->reduceMealInventory();

        $this->picked = true;
        $this->save();

        return $this;
    }

    /**
     * TODO: Move to Plan
     */
    private function reduceMeatInventory() {
        $pet_meal_size = $this->plan->pet->mealSize();

        // TODO: This should be on the Plan model too.. no reason for it to be here....
        $meals = $this->mealCounts()->map(function($meal, $key) use ($pet_meal_size){
            $meal->total_weight = $meal->count * $pet_meal_size;
            return $meal;
        });

        foreach($meals as $meal) {
            foreach ($meal->meats as $meat) {
                $this->inventoryChange()->create([
                    'inventoryable_id'      => $meat->id,
                    'inventoryable_type'    => get_class($meat),
                    'change'    => -1 * $meal->total_weight / $meal->meats()->count(),
                ]);
            }
        }
    }

    /**
     * TODO: Make it public and simply reference the plan.. these methods should be on Plan
     */
    private function increaseMealInventory() {
        $meals = $this->mealCounts();

        foreach($meals as $meal) {
            $this->inventoryChange()->create([
                'inventoryable_id'  => $meal->id,
                'inventoryable_type'=> get_class($meal),
                'size'      => $this->plan->pet->mealSize(),
                'change'    => $meal->count,
            ]);
        }
    }

    /**
     * TODO: Make it public and simply reference the plan.. these methods should be on Plan
     */
    private function reduceMealInventory() {
        $meals = $this->mealCounts();

        foreach($meals as $meal) {
            $this->inventoryChange()->create([
                'inventoryable_id'  => $meal->id,
                'inventoryable_type'=> get_class($meal),
                'size'      => $this->plan->pet->mealSize(),
                'change'    => -1 * $meal->count,
            ]);
        }
    }


    /**
     * Scopes
     */

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeNeedsPacking(Builder $query) {
        return $query->where('packed', '=', 0);
    }


    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer() {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deliveryAddress() {
        return $this->belongsTo(Address::class, 'delivery_address_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan() {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payments() {
        return $this->morphMany(Payment::class, 'paymentable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function inventoryChange() {
        return $this->morphMany(Inventory::class, 'changeable');
    }
}
