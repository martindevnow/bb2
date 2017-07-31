<?php

namespace Tests\Unit\Customers;

use Illuminate\Support\Facades\DB;
use Martin\Customers\Pet;
use Martin\Products\Container;
use Martin\Products\Meal;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PetsUnitTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_has_a_model_factory() {
        $pet = factory(Pet::class)->create();
        $this->assertTrue($pet instanceof Pet);
    }

    /** @test */
    public function it_has_all_fields_assignable() {
        $pet = factory(Pet::class)->create([
            'name'  => 'Halley',
            'species'  => 'Dog',
            'breed'   => 'Husky',
            'weight'   => 72,
            'activity_level'   => 2,
            'birthday'   => time(),
        ]);

        $this->assertEquals('Halley', $pet->name);
        $this->assertEquals('Dog', $pet->species);
        $this->assertEquals('Husky', $pet->breed);
        $this->assertEquals(72, $pet->weight);
        $this->assertEquals(2, $pet->activity_level);
    }

    /**
     * Computed Elements
     */

    /** @test */
    public function it_can_determine_the_meal_weight() {
        $pet = factory(Pet::class)->create(['weight' => 50, 'activity_level' => 2]);

        $this->assertEquals(50 * .02 * 7 / 14, $pet->mealSize());
        $this->assertEquals(50 * .02 * 7 / 14 * 454, $pet->mealSizeInGrams());
    }

    /**
     * Mutators
     */

    /** @test */
    public function activity_level_is_mutated_when_saving() {
        $activity_level = 2.0;
        $activity_level_no_decimal = $activity_level * 100;

        factory(Pet::class)->create(['activity_level' => $activity_level]);
        $this->assertDatabaseHas('pets', ['activity_level' => $activity_level_no_decimal]);
    }

    /** @test */
    public function activity_level_is_mutated_when_retrieving() {
        $activity_level = 1;
        $activity_level_no_decimal = $activity_level * 100;

        $pet = factory(Pet::class)->make([
            'name'=> 'THISMEAT',
            'activity_level' => $activity_level_no_decimal
        ]);
        DB::table('pets')->insert($pet->toArray());
        $pet_clone = Pet::whereName('THISMEAT')->firstOrFail();
        $this->assertEquals($activity_level, $pet_clone->activity_level);
    }

    /**
     * Containers
     */

    /** @test */
    public function it_can_select_the_right_container_by_weight() {
        $pet = factory(Pet::class)->create(['weight' => 50, 'activity_level' => 2]);

        $container = Container::selectContainer($pet->mealSizeInGrams());
        $this->assertEquals('8oz', $container->size);
        $this->assertEquals((
            Container::COST_PER_500_8OZ_CONTAINER / 500
                + Container::COST_PER_1000_STICKERS / 1000),
            round($container->cost(), 3));
    }

    /** @test */
    public function the_container_knows_number_of_meals_per_container() {
        /**
         * 2 meals per 8oz container
         */
        $pet = factory(Pet::class)->create(['weight' => 22, 'activity_level' => 2]);

        // meal_weight = weight * activity_level * 454 / 2;
        // meal_weight should be 99.88 g or 0.22 lb
        $this->assertEquals(0.22, $pet->mealSize());
        $this->assertEquals(99.88, $pet->mealSizeInGrams());

        $container = Container::selectContainer($pet->mealSizeInGrams());
        $this->assertEquals(2, $container->mealsPerContainer());
        $this->assertEquals(7, $container->containersPerWeek());


        /**
         * 1 meal / 8oz container
         */
        $pet2 = factory(Pet::class)->create(['weight' => 30, 'activity_level' => 2]);

        // meal_weight = weight * activity_level * 454 / 2;
        // meal_weight should be 136.2 g or 0.3 lb
        $this->assertEquals(0.3, $pet2->mealSize());
        $this->assertEquals(136.2, $pet2->mealSizeInGrams());

        $container2 = Container::selectContainer($pet2->mealSizeInGrams());
        $this->assertEquals('8oz', $container2->size);
        $this->assertEquals(1, $container2->mealsPerContainer());
        $this->assertEquals(14, $container2->containersPerWeek());


        /**
         * 1 meal per 16 oz container
         */
        $pet3 = factory(Pet::class)->create(['weight' => 55, 'activity_level' => 2]);

        // meal_weight = weight * activity_level * 454 / 2;
        // meal_weight should be 136.2 g or 0.3 lb
        $this->assertEquals(0.55, $pet3->mealSize());
        $this->assertEquals(249.7, $pet3->mealSizeInGrams());

        $container3 = Container::selectContainer($pet3->mealSizeInGrams());
        $this->assertEquals('16oz', $container3->size);
        $this->assertEquals(1, $container3->mealsPerContainer());
        $this->assertEquals(14, $container3->containersPerWeek());
        $this->assertEquals((
            14 * (Container::COST_PER_500_16OZ_CONTAINER / 500
                + Container::COST_PER_1000_STICKERS / 1000)),
            $container3->costPerWeek());
    }
}
