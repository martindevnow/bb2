<?php

namespace Tests\Unit;

use Martin\Products\Container;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContainerUnitTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_select_a_container_based_on_meal_weight() {
        $meal_weight_in_grams = 200;
        $container = Container::selectContainer($meal_weight_in_grams);
        $this->assertEquals('8oz', $container->size);

        $meal_weight_in_grams = 400;
        $container = Container::selectContainer($meal_weight_in_grams);
        $this->assertEquals('16oz', $container->size);

        $meal_weight_in_grams = 800;
        $container = Container::selectContainer($meal_weight_in_grams);
        $this->assertEquals('32oz', $container->size);
    }

    /** @test */
    public function it_knows_the_cost_of_itself() {

        $cost['8oz'] = (Container::COST_PER_500_8OZ_CONTAINER / 500
            + Container::COST_PER_1000_STICKERS / 1000)
            * Container::MARKUP_PERCENTAGE;

        $cost['16oz'] = (Container::COST_PER_500_16OZ_CONTAINER / 500
            + Container::COST_PER_1000_STICKERS / 1000)
            * Container::MARKUP_PERCENTAGE;

        $cost['32oz'] = (Container::COST_PER_500_32OZ_CONTAINER / 500
            + Container::COST_PER_1000_STICKERS / 1000)
            * Container::MARKUP_PERCENTAGE;

        $meal_weight_in_grams = 200;
        $container = Container::selectContainer($meal_weight_in_grams);
        $this->assertEquals($cost['8oz'], $container->cost());
        $this->assertEquals($cost['8oz']*14, $container->costPerWeek());

        $meal_weight_in_grams = 400;
        $container = Container::selectContainer($meal_weight_in_grams);
        $this->assertEquals($cost['16oz'], $container->cost());
        $this->assertEquals($cost['16oz']*14, $container->costPerWeek());

        $meal_weight_in_grams = 800;
        $container = Container::selectContainer($meal_weight_in_grams);
        $this->assertEquals($cost['32oz'], $container->cost());
        $this->assertEquals($cost['32oz']*14, $container->costPerWeek());
    }

    /** @test */
    public function it_knows_small_meals_are_two_per_container() {
        $meal_weight_in_grams = 100;
        $container = Container::selectContainer($meal_weight_in_grams);

        $this->assertEquals(2, $container->mealsPerContainer());
        $this->assertEquals(7, $container->containersPerWeek());
    }
}
