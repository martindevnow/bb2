<?php

namespace Tests\Unit\Subscriptions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Martin\Products\Meal;
use Tests\TestCase;

class MealReplacementsUnitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_plan_can_have_a_meal_replaced() {
        $this->buildPlan();

        $meal = Meal::where('code', 'turkeyMeal')->firstOrFail();

        $newMeal = factory(Meal::class)->create([
            'code'  => 'beef',
            'label' => 'Beef',
        ]);

        $this->plan->replaceMeal($meal)->withMeal($newMeal)->save();

        $this->assertDatabaseHas('meal_replacements', [
            'removed_meal_id'   => $meal->id,
            'added_meal_id'     => $newMeal->id,
            'plan_id'           => $this->plan->id,
        ]);

        $this->refreshPlan();

        $this->assertEquals(28, $this->plan->mealCounts()->sum('count'));

        $this->assertCount(
            1,
            $this->plan->mealCounts()
                ->where('code', 'beef'));
        $this->assertEquals(
            14,
            $this->plan->mealCounts()
                ->where('code', 'beef')
                ->first()->count);

    }
}
