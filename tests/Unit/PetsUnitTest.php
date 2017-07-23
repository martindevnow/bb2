<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Martin\Customers\Pet;
use Martin\Products\Container;
use Martin\Products\Meal;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PetsTest extends TestCase
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

        $container = Container::selectContainer($pet->mealSize());
        $this->assertEquals(250, $container->capacity_in_grams);
        $this->assertEquals(.144, round($container->cost(), 3));
    }
}
