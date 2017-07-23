<?php

namespace Martin\Products;

class Container {

    public $size;
    public $cost_per_hundred;
    public $capacity_in_grams;

    // TODO: Decide how to store this data (DB? sp Vivian can change
    public static $containers = [
        [
            'size'                  => '8oz',
            'cost_per_hundred'      => 72 / 5,
            'capacity_in_grams'     => 250
        ], [
            'size'                  => '16oz',
            'cost_per_hundred'      => 79 / 5,
            'capacity_in_grams'     => 500
        ],
    ];

    private function __construct(array $properties) {
        $this->size = $properties['size'];
        $this->cost_per_hundred = $properties['cost_per_hundred'];
        $this->capacity_in_grams = $properties['capacity_in_grams'];
    }

    /**
     * Static constructor to build a Container based on the meal weight
     *
     * @param $weightInGrams
     * @return static
     */
    public static function selectContainer($weightInGrams) {
        return new static(
            collect(Container::$containers)
                ->filter(function($container) use ($weightInGrams) {
                    return $container['capacity_in_grams'] > $weightInGrams;
                })
                ->sortBy('capacity_in_grams')
                ->first()
        );
    }

    /**
     * Return the unit cost of the containers including lids
     *
     * @return float|int
     */
    public function cost() {
        return $this->cost_per_hundred / 100;
    }
}