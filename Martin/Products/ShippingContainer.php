<?php

namespace Martin\Products;

class ShippingContainer {

    public $size;
    public $shipper_cost;
    public $capacity;

    // TODO: Decide how to store this data (DB? sp Vivian can change
    public static $shippers = [
        [
            'size'          => '10x10x8',
            'cost'          => 0.99,
            'capacity' => [
                '8oz'   => 16,
                '16oz'  => 8
            ],
        ], [
            'size'          => '10x10x12',
            'cost'          => 1.25,
            'capacity' => [
                '8oz'   => 32, // TODO: Confirm this ShippingContainer can hold 2 weeks.
                '16oz'  => 16,
            ],
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
        $this->shipper_cost = $properties['cost'];
        $this->capacity['8oz'] = $properties['capacity']['8oz'];
        $this->capacity['16oz'] = $properties['capacity']['16oz'];
    }

    /**
     * Static constructor to build a Container based on the meal weight
     *
     * @param Container $container
     * @param int $numberOfWeeks
     * @return static
     */
    public static function selectContainer(Container $container, $numberOfWeeks = 1) {
        $props = collect(ShippingContainer::$shippers)
            ->filter(function($shipper) use ($container, $numberOfWeeks) {
                return $shipper['capacity'][$container->size]
                    > $numberOfWeeks * $container->containersPerWeek() ;
            })
            ->sortBy('cost') // TODO: Insert a callback function to sort based on the current Container size (8oz or 16oz)
            ->first();
        if (! $props)
            return null;

        return new static($props);
    }

    /**
     * Return the unit cost of the containers including lids
     *
     * @return float|int
     */
    public function cost() {
        return round($this->shipper_cost
            + $this->inlay['cost']
            + $this->calendar_pouch['cost']
            + $this->instruction_card['cost'], 2);
    }
}