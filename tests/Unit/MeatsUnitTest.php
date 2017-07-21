<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Martin\Products\Meal;
use Martin\Products\Meat;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MeatsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_has_a_model_factory() {
        $meat = factory(Meat::class)->create();
        $this->assertTrue($meat instanceof Meat);
    }

    /** @test */
    public function it_has_all_fields_assignable() {
        $meat = factory(Meat::class)->create([
            'code'  => 'CH-GR',
            'type'  => 'Chicken',
            'variety'   => 'Ground',
            'cost_per_lb'   => 1.50,
        ]);

        $this->assertEquals('CH-GR', $meat->code);
        $this->assertEquals('Chicken', $meat->type);
        $this->assertEquals('Ground', $meat->variety);
        $this->assertEquals(1.5, $meat->cost_per_lb);
    }

    /**
     * Mutators
     */

    /** @test */
    public function cost_is_mutated_when_saving() {
        $costInDollars = 1;
        $costInCents = $costInDollars * 100;

        factory(Meat::class)->create(['cost_per_lb' => $costInDollars]);
        $this->assertDatabaseHas('meats', ['cost_per_lb' => $costInCents]);
    }

    /** @test */
    public function cost_is_mutated_when_retrieving() {
        $costInDollars = 1;
        $costInCents = $costInDollars * 100;

        $meat = factory(Meat::class)->make([
            'code'=> 'THISMEAT',
            'cost_per_lb' => $costInCents
        ]);
        DB::table('meats')->insert($meat->toArray());
        $meat_clone = Meat::whereCode('THISMEAT')->firstOrFail();
        $this->assertEquals($costInDollars, $meat_clone->cost_per_lb);

    }

    /**
     * Relationships
     */

    /** @test */
    public function it_has_many_meals_that_it_belongs_to() {
        $meat = factory(Meat::class, 2)->create();
        $meal = factory(Meal::class, 2)->create();

        $meat[0]->meals()->attach($meal[0]);

        $this->assertCount(1, $meat[0]->meals);

        $meat[0]->meals()->attach($meal[1]);
        $meat[0] = $meat[0]->fresh(['meals']);
        $this->assertCount(2, $meat[0]->meals);
    }
}
