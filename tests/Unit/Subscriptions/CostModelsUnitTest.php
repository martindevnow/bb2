<?php

namespace Tests\Unit\Subscriptions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Martin\Subscriptions\CostModel;
use Tests\TestCase;

class CostModelsUnitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_cost_model_has_a_model_factory() {
        $costModel = factory(CostModel::class)->create();
        $this->assertTrue($costModel instanceof CostModel);
    }

    /** @test */
    public function a_cost_model_has_all_fields_assignable() {
        $costModel = factory(CostModel::class)->create([
            'size'  => 'LLLLL',
        ]);

        $this->assertEquals('LLLLL', $costModel->size);
    }

    /**
     * Mutators
     */

    /** @test */
    public function a_cost_models_base_cost_is_mutated_when_saving() {
        $base_costInDollars = 1;
        $base_costInCents = $base_costInDollars * 100;

        factory(CostModel::class)->create(['base_cost' => $base_costInDollars]);
        $this->assertDatabaseHas('cost_models', ['base_cost' => $base_costInCents]);
    }

    /** @test */
    public function a_cost_models_base_cost_is_mutated_when_retrieving() {
        $base_costInDollars = 1;
        $base_costInCents = $base_costInDollars * 100;

        $cm = factory(CostModel::class)->make([
            'size'=> 'LLLLL',
            'base_cost' => $base_costInCents
        ]);
        DB::table('cost_models')->insert($cm->toArray());
        $cm_clone = CostModel::where('size', 'LLLLL')->firstOrFail();
        $this->assertEquals($base_costInDollars, $cm_clone->base_cost);
    }

    /** @test */
    public function a_cost_models_incremental_cost_is_mutated_when_saving() {
        $incremental_costInDollars = 1;
        $incremental_costInCents = $incremental_costInDollars * 100;

        factory(CostModel::class)->create(['incremental_cost' => $incremental_costInDollars]);
        $this->assertDatabaseHas('cost_models', ['incremental_cost' => $incremental_costInCents]);
    }

    /** @test */
    public function a_cost_models_incremental_cost_is_mutated_when_retrieving() {
        $incremental_costInDollars = 1;
        $incremental_costInCents = $incremental_costInDollars * 100;

        $cm = factory(CostModel::class)->make([
            'size'=> 'LLLLL',
            'incremental_cost' => $incremental_costInCents
        ]);
        DB::table('cost_models')->insert($cm->toArray());
        $cm_clone = CostModel::where('size', 'LLLLL')->firstOrFail();
        $this->assertEquals($incremental_costInDollars, $cm_clone->incremental_cost);
    }

    /** @test */
    public function a_cost_models_upgrade_cost_is_mutated_when_saving() {
        $upgrade_costInDollars = 1;
        $upgrade_costInCents = $upgrade_costInDollars * 100;

        factory(CostModel::class)->create(['upgrade_cost' => $upgrade_costInDollars]);
        $this->assertDatabaseHas('cost_models', ['upgrade_cost' => $upgrade_costInCents]);
    }

    /** @test */
    public function a_cost_models_upgrade_cost_is_mutated_when_retrieving() {
        $upgrade_costInDollars = 1;
        $upgrade_costInCents = $upgrade_costInDollars * 100;

        $cm = factory(CostModel::class)->make([
            'size'=> 'LLLLL',
            'upgrade_cost' => $upgrade_costInCents
        ]);
        DB::table('cost_models')->insert($cm->toArray());
        $cm_clone = CostModel::where('size', 'LLLLL')->firstOrFail();
        $this->assertEquals($upgrade_costInDollars, $cm_clone->upgrade_cost);
    }

    /** @test */
    public function a_cost_models_customization_cost_is_mutated_when_saving() {
        $customization_costInDollars = 1;
        $customization_costInCents = $customization_costInDollars * 100;

        factory(CostModel::class)->create(['customization_cost' => $customization_costInDollars]);
        $this->assertDatabaseHas('cost_models', ['customization_cost' => $customization_costInCents]);
    }

    /** @test */
    public function a_cost_models_customization_cost_is_mutated_when_retrieving() {
        $customization_costInDollars = 1;
        $customization_costInCents = $customization_costInDollars * 100;

        $cm = factory(CostModel::class)->make([
            'size'=> 'LLLLL',
            'customization_cost' => $customization_costInCents
        ]);
        DB::table('cost_models')->insert($cm->toArray());
        $cm_clone = CostModel::where('size', 'LLLLL')->firstOrFail();
        $this->assertEquals($customization_costInDollars, $cm_clone->customization_cost);
    }

}
