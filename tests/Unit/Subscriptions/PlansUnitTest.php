<?php

namespace Tests\Unit\Subscriptions;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Martin\ACL\User;
use Martin\Core\Address;
use Martin\Customers\Pet;
use Martin\Products\Meal;
use Martin\Products\Meat;
use Martin\Subscriptions\Package;
use Martin\Subscriptions\Plan;
use Martin\Transactions\Order;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlansUnitTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_has_a_model_factory() {
        $plan = factory(Plan::class)->create();
        $this->assertTrue($plan instanceof Plan);
    }

    /** @test */
    public function it_has_all_fields_assignable() {
        $user = factory(User::class)->create();
        $address = factory(Address::class)->create();
        $pet = factory(Pet::class)->create();
        $package = factory(Package::class)->create();

        $plan = factory(Plan::class)->create([
            'customer_id'  => $user->id,
            'delivery_address_id'  => $address->id,
            'shipping_cost' => 11.5,
            'pet_id'  => $pet->id,
            'pet_weight' => 55,
            'package_id' => $package->id,
            'package_stripe_code' => 'BASIC',
            'package_base' => 10,
            'weeks_at_a_time' => 1,
            'active' => 1,
        ]);

        $this->assertEquals(11.5, $plan->shipping_cost);
        $this->assertEquals(55, $plan->pet_weight);
        $this->assertEquals(10, $plan->package_base);
        $this->assertEquals(1, $plan->weeks_at_a_time);
    }

    /**
     * Mutators
     */

    /** @test */
    public function package_base_is_mutated_when_saving() {
        $package_baseInDollars = 1;
        $package_baseInCents = $package_baseInDollars * 100;

        factory(Plan::class)->create(['package_base' => $package_baseInDollars]);
        $this->assertDatabaseHas('plans', ['package_base' => $package_baseInCents]);
    }

    /** @test */
    public function package_base_is_mutated_when_retrieving() {
        $package_baseInDollars = 1;
        $package_baseInCents = $package_baseInDollars * 100;

        $plan = factory(Plan::class)->make([
            'package_stripe_code'=> 'THIS_PLAN',
            'package_base' => $package_baseInCents
        ]);
        DB::table('plans')->insert($plan->toArray());
        $plan_clone = Plan::where('package_stripe_code', 'THIS_PLAN')->firstOrFail();
        $this->assertEquals($package_baseInDollars, $plan_clone->package_base);
    }

    /**
     * Relationships
     */

    /** @test */
    public function a_plan_belongs_to_a_customer() {
        $plan = factory(Plan::class)->create();
        $this->assertTrue($plan->customer instanceof User);
    }

    /** @test */
    public function a_plan_can_have_many_orders() {
        $order = factory(Order::class)->create();
        $plan = $order->plan;

        $this->assertTrue($plan instanceof Plan);
        $this->assertCount(1, $plan->orders);
    }

    /** @test */
    public function a_plan_knows_if_it_has_orders() {
        $plan = factory(Plan::class)->create();
        $this->assertFalse($plan->hasOrders());

        $plan->generateOrder();

        /** @var Plan $plan */
        $plan = $plan->fresh(['orders']);
        $this->assertTrue($plan->hasOrders());
    }

    /** @test */
    public function a_plan_knows_when_the_first_order_should_be_placed() {
        /** @var Plan $plan */
        $plan = factory(Plan::class)->create([
            'weeks_at_a_time'   => 1,
        ]);

        $this->assertEquals(
            Carbon::now()->format('Y-m-d'),
            $plan->getNextOrderDate()->format('Y-m-d')
        );
    }

    /** @test */
    public function a_plan_knows_when_the_first_order_should_be_placed_bi_weekly() {
        /** @var Plan $plan */
        $plan = factory(Plan::class)->create([
            'weeks_at_a_time'   => 2,
        ]);

        $this->assertEquals(
            Carbon::now()->format('Y-m-d'),
            $plan->getNextOrderDate()->format('Y-m-d')
        );
    }

    /** @test */
    public function a_plan_knows_when_the_next_order_should_be_generated() {
        /** @var Plan $plan */
        $plan = factory(Plan::class)->create([
            'weeks_at_a_time'   => 1,
        ]);
        $plan->generateOrder();

        $this->assertEquals(
            Carbon::now()->addDays(7)->format('Y-m-d'),
            $plan->getNextOrderDate()->format('Y-m-d')
        );

        $newOrder = $plan->generateOrder();
        $this->assertTrue($newOrder instanceof Order);
//        $newOrder->dlive

    }

    /** @test */
    public function a_plan_knows_when_the_next_order_should_be_generated_bi_weekly() {
        /** @var Plan $plan */
        $plan = factory(Plan::class)->create([
            'weeks_at_a_time'   => 2,
        ]);
        $plan->generateOrder();

        $this->assertEquals(
            Carbon::now()->addDays(2 * 7)->format('Y-m-d'),
            $plan->getNextOrderDate()->format('Y-m-d')
        );
    }

    /** @test */
    public function a_plan_knows_its_packing_cost() {
        $plan = factory(Plan::class)->create();
        $this->assertTrue(is_numeric($plan->packingCost()));
        $this->assertTrue(is_numeric($plan->packagingCost()));
        $this->assertTrue(is_numeric($plan->totalPackingCost()));
    }

    /** @test */
    public function a_plan_knows_the_internal_cost_per_week() {
        /** @var Pet $pet */
        $pet = factory(Pet::class)->create(['weight' => 50, 'activity_level' => 2]);
        /** @var Plan $plan */
        $plan = factory(Plan::class)->create(['pet_id' => $pet->id]);
        /** @var Package $package */
        $package = $plan->package;

        $chickenCost = 1;
        $turkeyCost = 6;

        $chkMeal = factory(Meal::class)->create();
        $turkMeal = factory(Meal::class)->create();

        $chicken = factory(Meat::class)->create(['cost_per_lb' => $chickenCost]);
        $turkey = factory(Meat::class)->create(['cost_per_lb' => $turkeyCost]);

        $chkMeal->addMeat($chicken);
        $turkMeal->addMeat($turkey);

        $package->addMeal($chkMeal, '1B');
        $package->addMeal($chkMeal, '2B');
        $package->addMeal($chkMeal, '3B');
        $package->addMeal($chkMeal, '4B');
        $package->addMeal($chkMeal, '5B');
        $package->addMeal($chkMeal, '6B');
        $package->addMeal($chkMeal, '7B');
        $package->addMeal($turkMeal, '1B');
        $package->addMeal($turkMeal, '2B');
        $package->addMeal($turkMeal, '3B');
        $package->addMeal($turkMeal, '4B');
        $package->addMeal($turkMeal, '5B');
        $package->addMeal($turkMeal, '6B');
        $package->addMeal($turkMeal, '7B');

        $plan = $plan->fresh(['package', 'package.meals']);
        $this->assertEquals(24.5, $plan->costPerWeek());
    }


    /**
     * Generators
     */

    /** @test */
    public function a_plan_can_generate_the_first_order() {
        $plan = factory(Plan::class)->create();

        $order = $plan->generateOrder();
        $orderData = $order->toArray();
        $orderData['subtotal'] *= 100;
        $orderData['tax'] *= 100;
        $orderData['total_cost'] *= 100;
        $this->assertTrue($order instanceof Order);
        $this->assertDatabaseHas('orders', $orderData);
    }


    /**
     * Scopes
     */

    /** @test */
    public function it_fetches_a_weekly_plan_with_pending_orders() {
        $weekly_plan = factory(Plan::class)->create([
            'last_delivery_at' => Carbon::now(),
            'weeks_at_a_time'   => 1,
        ]);     // IS pending

        $pendingPlans = Plan::needsOrder()->get();
        $this->assertCount(1, $pendingPlans);
    }

    /** @test */
    public function it_fetches_bi_weekly_plans_with_pending_orders() {
        $weekly_plan = factory(Plan::class)->create([
            'last_delivery_at' => Carbon::now(),
            'weeks_at_a_time'   => 1,
        ]);     // IS pending

        $bi_weekly_plan = factory(Plan::class)->create([
            'last_delivery_at'  => Carbon::now(),
            'weeks_at_a_time'   => 2,
        ]);

        $pendingPlans = Plan::needsOrder()->get();
        $this->assertCount(2, $pendingPlans);
    }

    /** @test */
    public function it_ignores_plans_that_are_not_pending() {
        $weekly_plan = factory(Plan::class)->create([
            'last_delivery_at' => Carbon::now(),
            'weeks_at_a_time'   => 1,
        ]);     // IS pending

        $bi_weekly_plan = factory(Plan::class)->create([
            'last_delivery_at'  => Carbon::now(),
            'weeks_at_a_time'   => 2,
        ]);

        $tri_weekly_plan = factory(Plan::class)->create([
            'last_delivery_at'  => Carbon::now(),
            'weeks_at_a_time'   => 3,
        ]);

        $monthly_plan = factory(Plan::class)->create([
            'last_delivery_at'  => Carbon::now(),
            'weeks_at_a_time'   => 4,
        ]);

        $pendingPlans = Plan::needsOrder()->get();
        $this->assertCount(2, $pendingPlans);
    }

    /** @test */
    public function it_fetches_tri_weekly_orders_that_are_pending() {
        $weekly_plan = factory(Plan::class)->create([
            'last_delivery_at' => Carbon::now(),
            'weeks_at_a_time'   => 1,
        ]);     // IS pending

        $bi_weekly_plan = factory(Plan::class)->create([
            'last_delivery_at'  => Carbon::now(),
            'weeks_at_a_time'   => 2,
        ]);

        $tri_weekly_plan = factory(Plan::class)->create([
            'last_delivery_at'  => Carbon::now()->subDays(8),
            'weeks_at_a_time'   => 3,
        ]);

        $pendingPlans = Plan::needsOrder()->get();
        $this->assertCount(3, $pendingPlans);
    }

    /** @test */
    public function it_fetches_monthly_orders_that_are_pending() {
        $weekly_plan = factory(Plan::class)->create([
            'last_delivery_at' => Carbon::now(),
            'weeks_at_a_time'   => 1,
        ]);     // IS pending

        $bi_weekly_plan = factory(Plan::class)->create([
            'last_delivery_at'  => Carbon::now(),
            'weeks_at_a_time'   => 2,
        ]);

        $tri_weekly_plan = factory(Plan::class)->create([
            'last_delivery_at'  => Carbon::now()->subDays(8),
            'weeks_at_a_time'   => 3,
        ]);

        $monthly_plan = factory(Plan::class)->create([
            'last_delivery_at'  => Carbon::now()->subDays(16),
            'weeks_at_a_time'   => 4,
        ]);

        $pendingPlans = Plan::needsOrder()->get();
        $this->assertCount(4, $pendingPlans);
    }
}
