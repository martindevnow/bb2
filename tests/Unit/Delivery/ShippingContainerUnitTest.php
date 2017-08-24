<?php

namespace Tests\Unit;

use Martin\Products\Container;
use Martin\Products\ShippingContainer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShippingContainerUnitTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_select_a_shipping_container_based_on_meal_weight() {
        $number_of_weeks = 1;
        $meal_weight_in_grams = 200;
        $container = Container::selectContainer($meal_weight_in_grams);
        $shipper = ShippingContainer::selectContainer($container, $number_of_weeks);
        $this->assertEquals('10x10x8', $shipper->size);

        $meal_weight_in_grams = 400;
        $container = Container::selectContainer($meal_weight_in_grams);
        $shipper = ShippingContainer::selectContainer($container, $number_of_weeks);
        $this->assertEquals('10x10x12', $shipper->size);

        $number_of_weeks = 2;
        $meal_weight_in_grams = 200;
        $container = Container::selectContainer($meal_weight_in_grams);
        $shipper = ShippingContainer::selectContainer($container, $number_of_weeks);
        $this->assertEquals('10x10x12', $shipper->size);

        $meal_weight_in_grams = 400;
        $container = Container::selectContainer($meal_weight_in_grams);
        $shipper = ShippingContainer::selectContainer($container, $number_of_weeks);
        $this->assertEquals(null, $shipper);
    }

    /** @test */
    public function it_knows_the_cost_of_itself() {
        $number_of_weeks = 1;
        $meal_weight_in_grams = 200;
        $container = Container::selectContainer($meal_weight_in_grams);
        $shipper = ShippingContainer::selectContainer($container, $number_of_weeks);
        $this->assertEquals('10x10x8', $shipper->size);
        $this->assertEquals(1.35, $shipper->cost());

        $meal_weight_in_grams = 400;
        $container = Container::selectContainer($meal_weight_in_grams);
        $shipper = ShippingContainer::selectContainer($container, $number_of_weeks);
        $this->assertEquals('10x10x12', $shipper->size);
        $this->assertEquals(1.61, $shipper->cost());
    }
}
