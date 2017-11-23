<?php

namespace Tests\Unit\Customers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Martin\Customers\Pet;
use Martin\Products\Container;
use Martin\Products\Meal;
use Martin\Subscriptions\Plan;
use Tests\TestCase;

class PetsUnitTest extends TestCase
{
    use RefreshDatabase;

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
    public function it_can_determine_the_meal_weight_and_weekly_consumption() {
        $WEIGHT_IN_POUNDS = 50;
        $ACTIVITY_LEVEL = 2;
        $pet = factory(Pet::class)->create(['weight' => $WEIGHT_IN_POUNDS, 'activity_level' => $ACTIVITY_LEVEL]);
        $MEALS_PER_DAY = 2;
        $GRAMS_PER_POUND = 454;

        $this->assertEquals($WEIGHT_IN_POUNDS * $ACTIVITY_LEVEL / 100 / $MEALS_PER_DAY, $pet->mealSize());
        $this->assertEquals($WEIGHT_IN_POUNDS * $ACTIVITY_LEVEL / 100 * 7, $pet->weeklyConsumption());
        $this->assertEquals($WEIGHT_IN_POUNDS * $ACTIVITY_LEVEL / 100 / $MEALS_PER_DAY * $GRAMS_PER_POUND, $pet->mealSizeInGrams());
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
            'name'              => 'THISMEAT',
            'activity_level'    => $activity_level_no_decimal
        ]);
        $petData = $pet->toArray();
        unset($petData['owner']);
        unset($petData['owner_name']);

        DB::table('pets')->insert($petData);
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
        $this->assertEquals(
            round((Container::COST_PER_500_8OZ_CONTAINER / 500
                + Container::COST_PER_1000_STICKERS / 1000)
                * Container::MARKUP_PERCENTAGE, 3),
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
                + Container::COST_PER_1000_STICKERS / 1000))
            * Container::MARKUP_PERCENTAGE,
            $container3->costPerWeek());
    }

    /** @test */
    public function a_pets_weight_should_be_rounded_to_a_multiple_of_5() {
        $weight = 15;
        /** @var Pet $pet */
        $pet = factory(Pet::class)->create(['weight' => $weight]);
        $this->assertEquals($weight / 5, $pet->getPlanQuantity());

        $weight = 10;
        $pet = factory(Pet::class)->create(['weight' => $weight]);
        $this->assertEquals($weight / 5, $pet->getPlanQuantity());

        $weight = 11;
        $pet = factory(Pet::class)->create(['weight' => $weight]);
        $this->assertEquals(round($weight / 5), $pet->getPlanQuantity());

        $weight = 12;
        $pet = factory(Pet::class)->create(['weight' => $weight]);
        $this->assertEquals(round($weight / 5), $pet->getPlanQuantity());

        $weight = 13;
        $pet = factory(Pet::class)->create(['weight' => $weight]);
        $this->assertEquals(round($weight / 5), $pet->getPlanQuantity());

        $weight = 14;
        $pet = factory(Pet::class)->create(['weight' => $weight]);
        $this->assertEquals(round($weight / 5), $pet->getPlanQuantity());
    }

    /** @test */
    public function a_pet_has_plans() {
        $pet = factory(Pet::class)->create();
        $plan = factory(Plan::class)->create([
            'pet_id'    => $pet->id,
            'pet_weight'    => $pet->weight,
            'pet_activity_level'    => $pet->activity_level,
        ]);

        $pet = $pet->fresh(['plans']);
        $this->assertCount(1, $pet->plans);
    }

    /** @test */
    public function a_pet_can_be_a_puppy() {
        $pet = factory(Pet::class)->create([
            'weight'    => 50,
            'activity_level'    => 2,
        ]);

        $this->assertEquals(2, $pet->daily_meals);

        $pet->makePuppy();
        $pet = $pet->fresh();

        $this->assertEquals(3, $pet->daily_meals);
    }

}
