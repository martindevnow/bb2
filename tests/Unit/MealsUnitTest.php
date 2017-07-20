<?php

namespace Tests\Unit;

use Martin\Products\Meal;
use Martin\Products\Meat;
use Martin\Products\Topping;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MealsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_has_a_model_factory() {
        $meal = factory(Meal::class)->create();
        $this->assertTrue($meal instanceof Meal);
    }

    /** @test */
    public function it_has_all_fields_assignable() {
        $meal = factory(Meal::class)->create([
            'code'  => 'CH-GR',
            'label'  => 'Chicken',
            'meal_value'   => 2,
        ]);

        $this->assertEquals('CH-GR', $meal->code);
        $this->assertEquals('Chicken', $meal->label);
        $this->assertEquals(2, $meal->meal_value);
    }

    /**
     * MEATS
     */

    /** @test */
    public function it_has_many_meats_that_belong_to_it() {
        $meat = factory(Meat::class, 2)->create();
        $meal = factory(Meal::class, 2)->create();

        $meal[0]->meats()->attach($meat[0]);

        $this->assertCount(1, $meal[0]->meats);

        $meal[0]->meats()->attach($meat[1]);
        $meal[0] = $meal[0]->fresh(['meats']);
        $this->assertCount(2, $meal[0]->meats);
    }

    /** @test */
    public function it_can_add_a_meat_by_object() {
        $meal = factory(Meal::class)->create();
        $meat = factory(Meat::class)->create();

        $meal->addMeat($meat);
        $this->assertDatabaseHas('meal_meat', [
            'meal_id'   => $meal->id,
            'meat_id'   => $meat->id,
        ]);

        $this->assertTrue($meal->hasMeat($meat));
        $this->assertTrue($meal->hasMeat($meat->id));
        $this->assertTrue($meal->hasMeat($meat->code));
    }

    /** @test */
    public function it_can_add_a_meat_by_code() {
        $meal = factory(Meal::class)->create();
        $meat = factory(Meat::class)->create();

        $meal->addMeat($meat->code);
        $this->assertDatabaseHas('meal_meat', [
            'meal_id'   => $meal->id,
            'meat_id'   => $meat->id,
        ]);

        $this->assertTrue($meal->hasMeat($meat));
        $this->assertTrue($meal->hasMeat($meat->id));
        $this->assertTrue($meal->hasMeat($meat->code));
    }

    /** @test */
    public function it_can_add_a_meat_by_id() {
        $meal = factory(Meal::class)->create();
        $meat = factory(Meat::class)->create();

        $meal->addMeat($meat->id);
        $this->assertDatabaseHas('meal_meat', [
            'meal_id'   => $meal->id,
            'meat_id'   => $meat->id,
        ]);

        $this->assertTrue($meal->hasMeat($meat));
        $this->assertTrue($meal->hasMeat($meat->id));
        $this->assertTrue($meal->hasMeat($meat->code));
    }

    public function it_can_calculate_its_average_cost_per_lb() {
        $meal = factory(Meal::class)->create();
        $meat[] = factory(Meat::class)->create(['cost_per_lb', 1]);
        $meat[] = factory(Meat::class)->create(['cost_per_lb', 2]);

        $meal->addMeat($meat[0]);
        $meal->addMeat($meat[1]);

        $this->assertEquals(1.5, $meal->costPerLb());
    }

    /**
     * TOPPINGS
     */

    /** @test */
    public function it_has_many_toppings_that_belong_to_it() {
        $topping = factory(Topping::class, 2)->create();
        $meal = factory(Meal::class, 2)->create();

        $meal[0]->toppings()->attach($topping[0]);

        $this->assertCount(1, $meal[0]->toppings);

        $meal[0]->toppings()->attach($topping[1]);
        $meal[0] = $meal[0]->fresh(['toppings']);
        $this->assertCount(2, $meal[0]->toppings);
    }

    /** @test */
    public function it_can_add_a_topping_by_object() {
        $meal = factory(Meal::class)->create();
        $topping = factory(Topping::class)->create();

        $meal->addTopping($topping);
        $this->assertDatabaseHas('meal_topping', [
            'meal_id'   => $meal->id,
            'topping_id'   => $topping->id,
        ]);

        $this->assertTrue($meal->hasTopping($topping));
        $this->assertTrue($meal->hasTopping($topping->id));
        $this->assertTrue($meal->hasTopping($topping->code));
    }

    /** @test */
    public function it_can_add_a_topping_by_code() {
        $meal = factory(Meal::class)->create();
        $topping = factory(Topping::class)->create();

        $meal->addTopping($topping->code);
        $this->assertDatabaseHas('meal_topping', [
            'meal_id'   => $meal->id,
            'topping_id'   => $topping->id,
        ]);

        $this->assertTrue($meal->hasTopping($topping));
        $this->assertTrue($meal->hasTopping($topping->id));
        $this->assertTrue($meal->hasTopping($topping->code));
    }

    /** @test */
    public function it_can_add_a_topping_by_id() {
        $meal = factory(Meal::class)->create();
        $topping = factory(Topping::class)->create();

        $meal->addTopping($topping->id);
        $this->assertDatabaseHas('meal_topping', [
            'meal_id'   => $meal->id,
            'topping_id'   => $topping->id,
        ]);

        $this->assertTrue($meal->hasTopping($topping));
        $this->assertTrue($meal->hasTopping($topping->id));
        $this->assertTrue($meal->hasTopping($topping->code));
    }
}
