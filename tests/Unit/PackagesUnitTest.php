<?php

namespace Tests\Unit;

use Martin\Products\Meal;
use Martin\Products\Topping;
use Martin\Subscriptions\MealPackage;
use Martin\Subscriptions\Package;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PackagesUnitTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_has_a_model_factory() {
        $package = factory(Package::class)->create();
        $this->assertTrue($package instanceof Package);
    }

    /** @test */
    public function it_has_all_fields_assignable() {
        $package = factory(Package::class)->create([
            'code'  => 'BASIC',
            'label'  => 'Basic',
        ]);

        $this->assertEquals('BASIC', $package->code);
        $this->assertEquals('Basic', $package->label);


    }

    /**
     * MEALS
     */

    /** @test */
    public function it_has_many_meals_that_belong_to_it() {
        $meal = factory(Meal::class, 2)->create();
        $package = factory(Package::class)->create();

        $package->addMeal($meal[0], '1-B');

        $package = $package->fresh(['meals']);
        $this->assertCount(1, $package->meals);

        $package->addMeal($meal[1], '1-D');
        $package = $package->fresh(['meals']);
        $this->assertCount(2, $package->meals);
    }

    /** @test */
    public function it_can_fetch_a_meal_by_calendar_code() {
        $meal = factory(Meal::class)->create();
        $package = factory(Package::class)->create();

        $package->addMeal($meal, '1-B');
        $package = $package->fresh(['meals']);
        $package->removeMeal('1-B');

        $package = $package->fresh(['meals']);
        $this->assertCount(0, $package->meals);
    }

    /** @test */
    public function it_can_add_a_meal_by_object() {
        $package = factory(Package::class)->create();
        $meal = factory(Meal::class)->create();

        $package->addMeal($meal, '1-D');
        $this->assertDatabaseHas('meal_package', [
            'package_id'   => $package->id,
            'meal_id'   => $meal->id,
        ]);

        $package = $package->fresh(['meals']);

        $this->assertTrue($package->hasMeal($meal));
        $this->assertTrue($package->hasMeal($meal->id));
    }

    /** @test */
    public function it_can_add_a_meal_by_code() {
        $package = factory(Package::class)->create();
        $meal = factory(Meal::class)->create();

        $package->addMeal($meal->code, '1-B');
        $this->assertDatabaseHas('meal_package', [
            'package_id'   => $package->id,
            'meal_id'   => $meal->id,
        ]);
        $package = $package->fresh(['meals']);

        $this->assertTrue($package->hasMeal($meal));
        $this->assertTrue($package->hasMeal($meal->id));
    }

    /** @test */
    public function it_can_add_a_meal_by_id() {
        $package = factory(Package::class)->create();
        $meal = factory(Meal::class)->create();

        $package->addMeal($meal->id, '2-B');
        $this->assertDatabaseHas('meal_package', [
            'package_id'   => $package->id,
            'meal_id'   => $meal->id,
        ]);

        $package = $package->fresh(['meals']);

        $this->assertTrue($package->hasMeal($meal));
        $this->assertTrue($package->hasMeal($meal->id));
    }

    /** @test */
    public function it_can_remove_a_meal_by_calendar_code() {
        $package = factory(Package::class)->create();
        $meal = factory(Meal::class)->create();

        $package->addMeal($meal->id, '2-B');
        $package = $package->fresh(['meals']);

        $package->removeMeal('2-B');

        $package = $package->fresh(['meals']);
        $this->assertCount(0, $package->meals);
    }

    /** @test */
    public function adding_a_meal_with_same_calendar_code_replaces_old() {
        $package = factory(Package::class)->create(['code' => 'package']);
        $meal = factory(Meal::class, 2)->create(['code' => 'meal']);

        $package->addMeal($meal[0]->id, '2-B');
        $package = $package->fresh(['meals']);

        $package->addMeal($meal[1]->id, '2-B');

        $package = $package->fresh(['meals']);

        $this->assertEquals($meal[1]->id, $package->meals()->first()->id);
    }
}
