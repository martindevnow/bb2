<?php

namespace Martin\Transactions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\ACL\User;
use Martin\Core\Address;
use Martin\Core\CoreModel;
use Martin\Products\Inventory;
use Martin\Products\Meal;
use Martin\Subscriptions\Plan;

class Order extends CoreModel
{
    use SoftDeletes;

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
        $plan = $this->plan;
        $grouped =  $this->plan->package->meals->groupBy('id')
            ->map(function($group, $key) use ($plan) {
                $item = $group->first();
                $item->count = $group->count() * $plan->weeks_at_a_time;
                return $item;
            });

        if (! $meal)
            return $grouped;

        return $grouped->where('label', $meal->label)
            ->first()
            ->count;
    }

    /**
     * Order Packing etc Workflow
     */

    public function markAsPacked() {

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
