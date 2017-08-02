<?php

namespace Tests\Unit\Subscriptions;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Martin\ACL\User;
use Martin\Core\Address;
use Martin\Customers\Pet;
use Martin\Products\Meal;
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

}
