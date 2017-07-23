<?php

namespace Martin\Products;

class ShippingContainer {

    public $size;
    public $cost_per_hundred;
    public $capacity_in_grams;

    // TODO: Decide how to store this data (DB? sp Vivian can change
    public static $shippers = [
        [
            'size'          => '10x10x8',
            'cost'          => 0.99,
            'capacity_8oz'  => 16,
            'capacity_16oz' => 8    // TODO: Confirm this number (not required anyway...)
        ], [
            'size'          => '10x10x12',
            'cost'          => 1.25,
            'capacity_8oz'  => 32,  // TODO: Confirm this ShippingContainer can hold 2 weeks..
            'capacity_16oz' => 16
        ]
    ];

    public $inlay = [
        'cost'  => 49.50 / 250,
        'weight_in_grams'   => 15   // TODO: Confirm this number is correct
    ];

    public $calendar_pouch = [
        'cost'  => 61 / 1000,
    ];

    public $instruction_card = [
        'cost' => 105 / 1000,
    ];


    private function __construct(array $properties) {
        $this->size = $properties['size'];
        $this->cost_per_hundred = $properties['cost_per_hundred'];
        $this->capacity_in_grams = $properties['capacity_in_grams'];
    }

    /**
     * Static constructor to build a Container based on the meal weight
     *
     * @param Container $container
     * @return static
     */
    public static function selectContainer(Container $container, integer $numberOfWeeks = 1) {
        return new static(
            collect(ShippingContainer::$shippers)
                ->filter(function($shipper) use ($container, $numberOfWeeks) {
                    return $shipper['capacity_' . $container->size]
                        > $numberOfWeeks * $container->containersPerWeek() ;
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
        return $this->cost_per_hundred / 100
            + $this->inlay['cost']
            + $this->calendar_pouch['cost']
            + $this->instruction_card['cost'];
    }
}