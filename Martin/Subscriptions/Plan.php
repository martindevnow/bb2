<?php

namespace Martin\Subscriptions;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Martin\ACL\User;
use Martin\Core\Address;
use Martin\Core\Traits\CoreRelations;
use Martin\Customers\Pet;
use Martin\Products\Container;
use Martin\Products\Meal;
use Martin\Transactions\Order;
use Martin\Transactions\Payment;
use Spatie\Activitylog\Traits\LogsActivity;

class Plan extends Model
{
    const HOURLY_RATE_FOR_PACKING_ORDERS = 25;
    const MINUTES_REQUIRED_TO_PACK_A_WEEK = 20;
    const SHIPPING_COST = 20;

    use SoftDeletes;
    use CoreRelations;

    use LogsActivity;
    static $logFillable = true;

    /**
     * Fields which are "mass-assignable"
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'delivery_address_id',
        'shipping_cost',    // cents

        'pet_id',
        'pet_weight',       // lbs
        'pet_activity_level',

        'package_id',
        'internal_cost',     // cents
        'weekly_cost',

        'latest_delivery_at',
        'weeks_of_food_per_shipment',
        'ships_every_x_weeks',
        'active',
        'payment_method',
        'hash',
    ];

    /**
     * Fields which are cast to type of Carbon/Carbon
     *
     * @var array
     */
    protected $dates = [
        'latest_delivery_at',
        'first_delivery_at'
    ];

    public static function byHash($hash) {
        return Plan::where('hash', $hash)->firstOrFail();
    }

    public function updateForShipped(Order $order) {
        $this->latest_delivery_at = $order->shipped_at;
        if ($order->weeks_shipped > $this->ships_every_x_weeks) {
            $futureOrders = $this->orders()
                ->where('deliver_by', '>', $order->deliver_by)
                ->get();
            foreach ($futureOrders as $fOrder) {
                $fOrder->deliver_by = $fOrder->deliver_by->addWeeks($order->weeks_shipped - $this->ships_every_x_weeks);
                $fOrder->save();
            }
        }
    }

    public function delayOrdersAfter(Order $order, $daysToDelay) {
        $futureOrders = $this->orders()
            ->where('id', '>', $order->id)
            ->get();
        foreach ($futureOrders as $fOrder) {
            $fOrder->deliver_by = $fOrder->deliver_by->addDays($daysToDelay);
            $fOrder->save();
        }
        return true;
    }

    public static function getPrice($pet_weight, Package $package, $shipping_modifier) {
        /** @var Collection $costModels */
        $costModels = CostModel::all();

        $costModel = $costModels->filter(function($costModel) use ($pet_weight) {
            return $pet_weight >= $costModel['min_weight'] && $pet_weight <= $costModel['max_weight'];
        });
        if (! $costModel->count()) {
            // TODO: Throw error here
            return false;
        }
        /** @var CostModel $costModel */
        $costModel = $costModel->first();

        $weight = round($pet_weight / 5, 0) * 5;
        return $costModel->base_cost
            + ($weight - $costModel->min_weight) / 5 * $costModel->incremental_cost
            + $package->level * $costModel->upgrade_cost
            + $package->customization * $costModel->customization_cost
            + 5 * ($shipping_modifier) ;
    }

    /**
     * Scopes
     */

    /**
     * @param Builder $query
     * @param int $leadTimeInDays
     * @return mixed
     */
    public function scopeNeedsOrder(Builder $query, $leadTimeInDays = 18) {
        // 1 week at a time, will be all orders
        //      as long as there are no orders with....
        //          deliver_by is within the next two weeks
        // 2 weeks at a time, will be all orders, as long as there isn't an order already made for that day
        // 3 weeks at a time will be if the latest_delivery_at is older than 1 week
        // 4 weeks at a time will be if the latest_delivery_at delivery_at is older than 2 weeks
        return $query
            ->active()
            ->where(function(Builder $activeBuilder) use ($leadTimeInDays) {
                $activeBuilder
                    ->doesntHave('orders')
                    ->orWhere(function(Builder $subQ1) use ($leadTimeInDays) {
                        $subQ1
                            ->where('ships_every_x_weeks', '=', 1)
                            ->whereDoesntHave('orders', function(Builder $subQ) use ($leadTimeInDays) {
                                $subQ
                                    ->where('deliver_by', '>', Carbon::now()->addDays($leadTimeInDays - 7)->toDateString());
                            });
                    })
                    ->orWhere(function(Builder $subQ1) use ($leadTimeInDays) {
                        $subQ1
                            ->where('ships_every_x_weeks', '=', 2)
                            ->whereDoesntHave('orders', function(Builder $subQ) use ($leadTimeInDays) {
                                $subQ
                                    ->where('deliver_by', '>', Carbon::now()->addDays($leadTimeInDays - 14)->toDateString());
                            });
                    })
                    ->orWhere(function(Builder $subQ1) use ($leadTimeInDays) {
                        $subQ1
                            ->where('ships_every_x_weeks', '=', 3)
                            ->whereDoesntHave('orders', function(Builder $subQ) use ($leadTimeInDays) {
                                $subQ
                                    ->where('deliver_by', '>', Carbon::now()->addDays($leadTimeInDays - 21)->toDateString());
                            });
                    })
                    ->orWhere(function(Builder $subQ1) use ($leadTimeInDays) {
                        $subQ1
                            ->where('ships_every_x_weeks', '=', 4)
                            ->whereDoesntHave('orders', function(Builder $subQ) use ($leadTimeInDays) {
                                $subQ
                                    ->where('deliver_by', '>', Carbon::now()->addDays($leadTimeInDays - 28)->toDateString());
                            });
                    });
            });
    }

    /**
     * @param Builder $query
     * @return $this
     */
    public function scopeActive(Builder $query) {
        return $query->where('active', true);
    }

    /**
     * Mutators
     */

    /**
     * @param $value
     * @return float|int
     */
    public function getInternalCostAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setInternalCostAttribute($value) {
        $this->attributes['internal_cost'] = round($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getShippingCostAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setShippingCostAttribute($value) {
        $this->attributes['shipping_cost'] = round($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getWeeklyCostAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setWeeklyCostAttribute($value) {
        $this->attributes['weekly_cost'] = round($value * 100);
    }

    /**
     * @param $value
     * @return float|int
     */
    public function getPetActivityLevelAttribute($value) {
        return $value / 100;
    }

    /**
     * @param $value
     */
    public function setPetActivityLevelAttribute($value) {
        $this->attributes['pet_activity_level'] = round($value * 100);
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
    public function package() {
        return $this->belongsTo(Package::class, 'package_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payments() {
        return $this->morphMany(Payment::class, 'paymentable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders() {
        return $this->hasMany(Order::class, 'plan_id');
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
    public function pet() {
        return $this->belongsTo(Pet::class, 'pet_id');
    }

    /**
     * Orders
     */

    /**
     * @return mixed
     */
    public function getLatestOrder() {
        return $this->orders()
            ->orderBy('deliver_by', 'DESC')
            ->first();
    }

    /**
     * @return bool
     */
    public function hasOrders() {
        return !! $this->orders()->count();
    }

    /**
     * @param Meal|null $specificMeal
     * @return mixed
     */
    public function mealCounts(Meal $specificMeal = null, $number_of_weeks = null) {
        $weeks_of_food_per_shipment = $number_of_weeks ?: $this->weeks_of_food_per_shipment;
        $breakfast_modifier = $this->pet->daily_meals == 3 ? 1 : 0;
        $breakfasts = ['B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'B7'];
        $counted = $this->package->meals->map(function($meal) use ($breakfast_modifier, $breakfasts) {
            $calendar_code = $meal->calendar_code ?: $meal->pivot->calendar_code;
            $increment = in_array($calendar_code, $breakfasts) ? $breakfast_modifier : 0;
            $meal->count = 1 + $increment;
            $meal->calendar_code = $calendar_code;
            unset($meal->pivot);
            return $meal;
        });
        $grouped = $counted->mapToGroups(function($meal, $key) {
            return [$meal->id => $meal];
        })->map(function($group) {
            return $group->reduce(function($carry, $meal) {
                if (!$carry) {
                    return $meal;
                }
                $carry->count += $meal->count;
                return $carry;
            }, null);
        });

        if ($weeks_of_food_per_shipment > 1) {
            $grouped->map(function($meal) use ($weeks_of_food_per_shipment) {
                $meal->count *= $weeks_of_food_per_shipment;
                return $meal;
            });
        }

        if (! $specificMeal)
            return $grouped;

        return $grouped->where('id', $specificMeal->id)
            ->first()
            ->count;
    }

    /**
     * Generators
     */

    /**
     * TOD: Make the deliveryDate 'smarter'
     *
     * @return Order
     */
    public function generateOrder(): Order {
        $delivery_date = $this->getNextDeliveryDate();

        $subtotal = $this->calculateSubtotal();

        $tax = $this->deliveryAddress->getTax();

        return $this->orders()->create([
            'customer_id'   => $this->customer_id,
            'delivery_address_id'   => $this->delivery_address_id,
//            'shipping_cost' => $this->deliveryAddress
//                ->getShippingCostByMealSize($this->pet->mealSizeInGrams()),
            'subtotal'      => $subtotal,
            'tax'           => $tax,
            'total_cost'    => $tax + $subtotal,
            'deliver_by'    => $delivery_date,
            'plan_order'    => true,
        ]);
    }

    /**
     * @return array
     */
    public function getMeatWeightsByCode() {

        $packageMealWeights = [$this->package->code => 0];
        $meatWeights = [];

        $mealSize = $this->pet->mealSizeInGrams();
        $packageMealWeights[$this->package->code] += $this->pet->weeklyConsumption();

        foreach ($this->package->meals as $meal) {
            foreach ($meal->meats as $meat) {
                if ( ! isset($meatWeights[$meat->code]))
                    $meatWeights[$meat->code] = 0;

                $meatWeights[$meat->code] += $mealSize;
            }
        }
        return $meatWeights;
    }


    /**
     * Other
     */

    /**
     * TODO: Seriously think about the data flow here and how
     * each part will know the status of each other.. what happens in the flow
     * and when to notify each other that more food needs to be packed
     * or whatnot
     *
     * @return mixed
     */
    public function getNextDeliveryDate() {
        $lead_time_in_days = 4;

        if ( ! $this->orders()->count()) {
            if ($this->latest_delivery_at)
                return $this->latest_delivery_at->addDays($this->ships_every_x_weeks * 7);

            return $this->created_at->addDays($lead_time_in_days);
        }

        $latestOrder = $this->getLatestOrder();

        $weeks_delay = max($latestOrder->weeks_shipped,
             $latestOrder->weeks_packed,
             $this->ships_every_x_weeks);

        return $latestOrder->deliver_by->addDays($weeks_delay * 7);
    }

    /**
     * @return mixed
     */
    public function calculateSubtotal() {
        return self::getPrice($this->pet_weight, $this->package, $this->weeks_of_food_per_shipment === 4 ? 0 : 1);
    }

    /**
     * TODO: Make this 'smarter'
     *
     * @return float
     */
    public function packagingCost() {
        return Container::selectContainer($this->pet->mealSizeInGrams())
            ->costPerWeek();
    }

    /**
     * TODO: Make this 'smarter'
     *
     * @return float
     */
    public function packingCost() {
        return self::HOURLY_RATE_FOR_PACKING_ORDERS
            * (self::MINUTES_REQUIRED_TO_PACK_A_WEEK / 60);
    }

    /**
     * @return float
     */
    public function totalPackingCost() {
        return $this->packingCost() + $this->packagingCost();
    }


    /**
     * Return the internal cost per week for this Pet
     *
     * @return mixed
     */
    public function costPerWeek() {
        return $this->package
            ->costPerWeek($this->pet);
    }

    /**
     * Return the Cost as a function of the weight of the Pet for this plan
     *
     * @return float|int
     */
    public function costPerPoundOfDog() {
        return $this->weekly_cost / $this->pet_weight;
    }

    /**
     * Return the profit earned for this Plan
     *
     * @return mixed
     */
    public function profit() {
        return $this->weekly_cost -
            ($this->totalPackingCost() + $this->costPerWeek());
    }

    /**
     * Update the Package for a Plan
     *
     * @param $package_id
     * @param bool $propagate
     * @return $this
     */
    public function updatePackage($package_id, $propagate = true) {
        $this->package_id = $package_id;
        $this->save();
        return $this;
    }

}
