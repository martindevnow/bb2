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

        $plan = $order->plan;

        $packages = Package::all()->map(function($package) {
            return $package->code;
        })->flatten();

        foreach ($packages as $key => $val) {
            echo "The Key is " . $key . " and the $val is " . $val . " \n\r ";
        }

    }
}
