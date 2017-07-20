<?php

namespace Tests\Unit;

use Martin\Products\Meal;
use Martin\Products\Topping;
use Martin\Products\Meat;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ToppingsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_has_a_model_factory() {
        $topping = factory(Topping::class)->create();
        $this->assertTrue($topping instanceof Topping);
    }

    /** @test */
    public function it_has_all_fields_assignable() {
        $topping = factory(Topping::class)->create([
            'code'  => 'CH-GR',
            'label'  => 'Chicken',
            'cost_per_kg'   => 2,
        ]);

        $this->assertEquals('CH-GR', $topping->code);
        $this->assertEquals('Chicken', $topping->label);
        $this->assertEquals(2, $topping->cost_per_kg);
    }

    /** @test */
    public function it_has_many_meals_that_it_belongs_to() {
        $topping = factory(Topping::class, 2)->create();
        $meal = factory(Meal::class, 2)->create();

        $topping[0]->meals()->attach($meal[0]);

        $this->assertCount(1, $topping[0]->meals);

        $topping[0]->meals()->attach($meal[1]);
        $topping[0] = $topping[0]->fresh(['meals']);
        $this->assertCount(2, $topping[0]->meals);
    }
}
