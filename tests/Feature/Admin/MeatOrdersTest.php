<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Martin\Products\Meat;
use Martin\Subscriptions\Package;
use Tests\TestCase;

class MeatOrdersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_plan_can_return_the_meat_needed_to_fill_an_order() {
        $order = $this->createOrderForBasicPlan();
        $order2 = $this->createOrderForBasicPlan();

        $plan = $order->plan;
        $plan2 = $order->plan;

//        $packages = Package::all();
//        $packageMealWeights = $packages->pluck('code')
//            ->flip()
//            ->map(function($val) {
//                return 0;
//            })
//            ->toArray();
//
//        $meats = Meat::all();
//        $meatWeights = $meats->pluck('code')->flip()->map(function($val) {
//            return 0;
//        })->toArray();
//
//
////        foreach($plans as $plan) {
//        $mealSize = $plan->pet->mealSizeInGrams();
//        $packageMealWeights[$plan->package->code] += $mealSize / 454 * 14;
////        }
//
//        print_r($packageMealWeights);
//
//        foreach ($packages as $package) {
//            if ($packageMealWeights[$package->code] <= 0)
//                continue;
//
//            foreach ($package->meals as $meal) {
//                foreach ($meal->meats as $meat) {
//                    $meatWeights[$meat->code] += $mealSize;
//                }
//            }
//        }

        $meats = $plan->package->meals
            ->map(function($meal) {
                return $meal->meats;
            })
            ->flatten()
            ->unique('id');

        $meatWeights = $plan->getMeatWeightsByCode();

        $meat = $meats->pop();
        $this->assertEquals(50 * 0.02 * 7 / 2 * 454,
            $meatWeights[$meat->code]);

        $meat = $meats->pop();
        $this->assertEquals(50 * 0.02 * 7 / 2 * 454,
            $meatWeights[$meat->code]);


    }
    /** @test */
    public function a_plan_can_return_the_meat_needed_to_fill_two_orders() {
        $order[] = $this->createOrderForBasicPlan();
        $order[] = $this->createOrderForBasicPlan();

        $plans[] = $order[0]->plan;
        $plans[] = $order[1]->plan;


        foreach ($plans as $plan) {
            $meatWeights = $plan->getMeatWeightsByCode();

            foreach($meatWeights as $code => $weight) {
                if ( ! isset($meatOrder[$code]))
                    $meatOrder[$code] = 0;

                $meatOrder[$code] += $weight;
            }
        }

    }
}
