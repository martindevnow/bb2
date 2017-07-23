<?php

namespace Martin\Products;

class Container {

    const MEALS_PER_WEEK = 14;
    const COST_PER_500_8OZ_CONTAINER = 72;
    const COST_PER_500_16OZ_CONTAINER = 79;
    const COST_PER_500_32OZ_CONTAINER = 109;

    const COST_PER_1000_STICKERS = 74;

    public $size;
    public $cost_per_hundred;
    public $capacity_in_grams;
    public $meal_weight;

    // TODO: Decide how to store this data (DB? sp Vivian can change
    public static $containers = [
        [
            'size'                  => '8oz',
            'cost_per_hundred'      => self::COST_PER_500_8OZ_CONTAINER / 5,
            'capacity_in_grams'     => 249,
            'weight_in_grams'       => 12.35
        ], [
            'size'                  => '16oz',
            'cost_per_hundred'      => self::COST_PER_500_16OZ_CONTAINER / 5,
            'capacity_in_grams'     => 449,
            'weight_in_grams'       => 14.9
        ],[
            'size'                  => '32oz',
            'cost_per_hundred'      => self::COST_PER_500_32OZ_CONTAINER / 5,
            'capacity_in_grams'     => 900, // TODO: Confirm this number is correct
            'weight_in_grams'       => 20
        ],
    ];

    public $sticker = [
        'cost'  => self::COST_PER_1000_STICKERS / 1000,
    ];

    private function __construct(array $properties, $meal_weight) {
        $this->size = $properties['size'];
        $this->cost_per_hundred = $properties['cost_per_hundred'];
        $this->capacity_in_grams = $properties['capacity_in_grams'];
        $this->meal_weight = $meal_weight;
    }

    /**
     * Static constructor to build a Container based on the meal weight
     *
     * @param $meal_weight
     * @return static
     */
    public static function selectContainer($meal_weight) {
        return new static(
            collect(Container::$containers)
                ->filter(function($container) use ($meal_weight) {
                    return $container['capacity_in_grams'] > $meal_weight;
                })
                ->sortBy('capacity_in_grams')
                ->first(),
            $meal_weight
        );
    }

    /**
     * Return the unit cost of the containers including lids
     *
     * @return float|int
     */
    public function cost() {
        return $this->cost_per_hundred / 100
            + $this->sticker['cost'];
    }

    public function costPerWeek() {
        return $this->cost() * $this->containersPerWeek();
    }

    /**
     * Rerturns the number of meals that can be fit into each container
     *
     * @return int
     */
    public function mealsPerContainer() {
        return $this->capacity_in_grams * .81 / 2 > $this->meal_weight
            ? 2
            : 1;
    }

    /**
     * Returns the number of containers needed for 1 week of meals
     *
     * @return float|int
     */
    public function containersPerWeek() {
        return self::MEALS_PER_WEEK / $this->mealsPerContainer();
    }
}