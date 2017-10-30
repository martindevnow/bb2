<?php

namespace Tests\Unit\Subscriptions;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Martin\ACL\User;
use Martin\Core\Address;
use Martin\Customers\Pet;
use Martin\Delivery\Delivery;
use Martin\Products\Meal;
use Martin\Products\Meat;
use Martin\Subscriptions\CostModel;
use Martin\Subscriptions\Package;
use Martin\Subscriptions\Plan;
use Martin\Transactions\Order;
use Martin\Transactions\Payment;
use Tests\TestCase;

class PlansUnitTest extends TestCase
{
    use RefreshDatabase;

    public $firstOrderLeadTime = 4;

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
            'internal_cost' => 10,
            'weeks_of_food_per_shipment' => 1,
            'active' => 1,
        ]);

        $this->assertEquals(11.5, $plan->shipping_cost);
        $this->assertEquals(55, $plan->pet_weight);
        $this->assertEquals(10, $plan->internal_cost);
        $this->assertEquals(1, $plan->weeks_of_food_per_shipment);
    }

    /**
     * Mutators
     */

    /** @test */
    public function internal_cost_is_mutated_when_saving() {
        $internal_costInDollars = 1;
        $internal_costInCents = $internal_costInDollars * 100;

        factory(Plan::class)->create(['internal_cost' => $internal_costInDollars]);
        $this->assertDatabaseHas('plans', ['internal_cost' => $internal_costInCents]);
    }

    /** @test */
    public function internal_cost_is_mutated_when_retrieving() {
        $internal_costInDollars = 1;
        $internal_costInCents = $internal_costInDollars * 100;

        $plan = factory(Plan::class)->make([
            'hash'=> 'THIS_PLAN',
            'internal_cost' => $internal_costInCents
        ]);
        DB::table('plans')->insert($plan->toArray());
        $plan_clone = Plan::where('hash', 'THIS_PLAN')->firstOrFail();
        $this->assertEquals($internal_costInDollars, $plan_clone->internal_cost);
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
            'weeks_of_food_per_shipment'   => 1,
        ]);

        $this->assertEquals(
            Carbon::now()->addDays($this->firstOrderLeadTime)->format('Y-m-d'),
            $plan->getNextDeliveryDate()->format('Y-m-d')
        );
    }

    /** @test */
    public function a_plan_knows_when_the_first_order_should_be_placed_bi_weekly() {
        /** @var Plan $plan */
        $plan = factory(Plan::class)->create([
            'weeks_of_food_per_shipment'   => 2,
        ]);

        $this->assertEquals(
            Carbon::now()->addDays($this->firstOrderLeadTime)->format('Y-m-d'),
            $plan->getNextDeliveryDate()->format('Y-m-d')
        );
    }

    /** @test */
    public function a_plan_knows_when_the_next_order_should_be_generated_weekly() {
        /** @var Plan $plan */
        $plan = factory(Plan::class)->create([
            'weeks_of_food_per_shipment'   => 1,
            'ships_every_x_weeks'   => 1,
        ]);

        $order = $plan->generateOrder();

        $this->assertEquals(
            Carbon::now()->addDays($this->firstOrderLeadTime)->format('Y-m-d'),
            $order->deliver_by->format('Y-m-d')
        );

        $plan = $plan->fresh(['orders']);

        $this->assertEquals(
            Carbon::now()->addDays(7 + $this->firstOrderLeadTime)->format('Y-m-d'),
            $plan->getNextDeliveryDate()->format('Y-m-d')
        );

        $newOrder = $plan->generateOrder();
        $this->assertTrue($newOrder instanceof Order);
    }

    /** @test */
    public function a_plan_knows_when_the_next_order_should_be_generated_bi_weekly() {
        /** @var Plan $plan */
        $plan = factory(Plan::class)->create([
            'weeks_of_food_per_shipment'   => 2,
            'ships_every_x_weeks'   => 2,
        ]);
        $order = $plan->generateOrder();

        $this->assertEquals(
            $delivery = Carbon::now()->addDays($this->firstOrderLeadTime)->format('Y-m-d'),
            $order->deliver_by->format('Y-m-d')
        );

        $plan = $plan->fresh(['orders']);

        $this->assertEquals(
            $delivery = Carbon::now()->addDays(2 * 7 + $this->firstOrderLeadTime)->format('Y-m-d'),
            $plan->getNextDeliveryDate()->format('Y-m-d')
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
        $this->assertDatabaseHas('orders', [
            'id'    => $order->id,
        ]);
    }


    /**
     * Scopes
     */

    /** @test */
    public function it_fetches_bi_weekly_plans_with_pending_orders() {
        $weekly_plan = factory(Plan::class)->create([
            'latest_delivery_at' => Carbon::now(),
            'weeks_of_food_per_shipment'   => 1,
            'ships_every_x_weeks'   => 1,
        ]);     // IS pending

        $bi_weekly_plan = factory(Plan::class)->create([
            'latest_delivery_at'  => Carbon::now(),
            'weeks_of_food_per_shipment'   => 2,
            'ships_every_x_weeks'   => 2,
        ]);

        $pendingPlans = Plan::needsOrder(18)->get();
        $this->assertCount(2, $pendingPlans);
    }

    /** @test */
    public function it_fetches_tri_weekly_orders_that_are_pending() {
        $weekly_plan = factory(Plan::class)->create([
            'latest_delivery_at' => Carbon::now(),
            'weeks_of_food_per_shipment'   => 1,
        ]);     // IS pending

        $bi_weekly_plan = factory(Plan::class)->create([
            'latest_delivery_at'  => Carbon::now(),
            'weeks_of_food_per_shipment'   => 2,
        ]);

        $tri_weekly_plan = factory(Plan::class)->create([
            'latest_delivery_at'  => Carbon::now()->subDays(8),
            'weeks_of_food_per_shipment'   => 3,
        ]);

        $pendingPlans = Plan::needsOrder(18)->get();
        $this->assertCount(3, $pendingPlans);
    }

    /** TODO: Validate this after building renewed tests for generating orders.... */
    public function it_fetches_monthly_orders_that_are_pending() {
        $weekly_plan = factory(Plan::class)->create([
            'latest_delivery_at' => Carbon::now(),
            'weeks_of_food_per_shipment'   => 1,
        ]);     // IS pending

        $bi_weekly_plan = factory(Plan::class)->create([
            'latest_delivery_at'  => Carbon::now(),
            'weeks_of_food_per_shipment'   => 2,
        ]);

        $tri_weekly_plan = factory(Plan::class)->create([
            'latest_delivery_at'  => Carbon::now()->subDays(8),
            'weeks_of_food_per_shipment'   => 3,
        ]);

        $monthly_plan = factory(Plan::class)->create([
            'latest_delivery_at'  => Carbon::now()->subDays(16),
            'weeks_of_food_per_shipment'   => 4,
        ]);

        $pendingPlans = Plan::needsOrder(18)->get();
        $this->assertCount(4, $pendingPlans);
    }

    /** @test */
    public function a_plan_can_get_meals_by_count() {
        $order = $this->createOrderForBasicPlan();

        $plan = $order->plan;

        $meals = $plan->mealCounts();
        foreach($meals as $meal) {
            $this->assertEquals(14, $meal->count);
        }
    }

    /** @test */
    public function it_can_calculate_the_subtotal() {
        $costModel = factory(CostModel::class)->create([
            'min_weight' => 50,
            'max_weight' => 90,
            'base_cost' => 50.99,
        ]);
        $package = factory(Package::class)->create([
            'customization' => 0,
            'level' => 0,
        ]);
        $this->assertEquals(5099,
            round(Plan::getPrice(50, $package, 0) * 100, 0)
            );
    }

    /** @test */
    public function a_plan_can_generate_the_required_orders() {
        $this->createOrderForBasicPlan();

        $this->assertCount(1, Order::all());
    }

    /** @test */
    public function a_weekly_plan_with_no_orders_knows_when_the_next_order_is_needed() {
        $plan = factory(Plan::class)->create([
            'weeks_of_food_per_shipment'    => 1,
            'ships_every_x_weeks'           => 1,
        ]);

        $next_delivery_date = $plan->getNextDeliveryDate();
        $today = Carbon::now();

        // TODO: Make the lead time determined by business days,
        // TODO: AND where the delivery address is...
        $lead_time_in_days = 4;

        $order = $plan->generateOrder();
        $this->assertEquals(
            $order->deliver_by->format('Y-m-d'),
            $next_delivery_date->format('Y-m-d')
        );

        $this->assertEquals(
            $today->addDays($lead_time_in_days)->format('Y-m-d'),
            $next_delivery_date->format('Y-m-d')
        );
    }

    /** @test */
    public function a_weekly_plan_with_one_order_knows_when_the_next_order_should_bew_delivered_by() {
        $plan = factory(Plan::class)->create([
            'weeks_of_food_per_shipment'    => 1,
            'ships_every_x_weeks'           => 1,
        ]);

        $previousOrder = $plan->generateOrder();

        $plan = $plan->fresh(['orders']);
        $next_delivery_date = $plan->getNextDeliveryDate();

        $days_delay = $plan->ships_every_x_weeks * 7;

        $this->assertEquals(
            $previousOrder->deliver_by->addDays($days_delay)->format('Y-m-d'),
            $next_delivery_date->format('Y-m-d')
        );
    }

    /** @test */
    public function a_biweekly_plan_with_no_orders_knows_when_the_next_order_is_needed() {
        $plan = factory(Plan::class)->create([
            'weeks_of_food_per_shipment'    => 2,
            'ships_every_x_weeks'           => 2,
        ]);

        $next_delivery_date = $plan->getNextDeliveryDate();
        $today = Carbon::now();

        // TODO: Make the lead time determined by business days,
        // TODO: AND where the delivery address is...
        $lead_time_in_days = 4;

        $order = $plan->generateOrder();
        $this->assertEquals(
            $order->deliver_by->format('Y-m-d'),
            $next_delivery_date->format('Y-m-d')
        );

        $this->assertEquals(
            $today->addDays($lead_time_in_days)->format('Y-m-d'),
            $next_delivery_date->format('Y-m-d')
        );
    }

    /** @test */
    public function a_biweekly_plan_with_one_order_knows_when_the_next_order_should_bew_delivered_by() {
        $plan = factory(Plan::class)->create([
            'weeks_of_food_per_shipment'    => 2,
            'ships_every_x_weeks'           => 2,
        ]);

        $previousOrder = $plan->generateOrder();

        $plan = $plan->fresh(['orders']);
        $next_delivery_date = $plan->getNextDeliveryDate();

        $days_delay = $plan->ships_every_x_weeks * 7;

        $this->assertEquals(
            $previousOrder->deliver_by->addDays($days_delay)->format('Y-m-d'),
            $next_delivery_date->format('Y-m-d')
        );
    }

    /** @test */
    public function a_biweekly_shipping_plan_with_no_orders_knows_when_the_next_order_is_needed() {
        $plan = factory(Plan::class)->create([
            'weeks_of_food_per_shipment'    => 1,
            'ships_every_x_weeks'           => 2,
        ]);

        $next_delivery_date = $plan->getNextDeliveryDate();
        $today = Carbon::now();

        // TODO: Make the lead time determined by business days,
        // TODO: AND where the delivery address is...
        $lead_time_in_days = 4;

        $order = $plan->generateOrder();
        $this->assertEquals(
            $order->deliver_by->format('Y-m-d'),
            $next_delivery_date->format('Y-m-d')
        );

        $this->assertEquals(
            Carbon::now()->addDays($lead_time_in_days)->format('Y-m-d'),
            $next_delivery_date->format('Y-m-d')
        );

        $this->assertEquals(
            $order->deliver_by->format('Y-m-d'),
            Carbon::now()->addDays($lead_time_in_days)->format('Y-m-d')
        );
    }

    /** @test */
    public function a_biweekly_shipping_plan_with_one_order_knows_when_the_next_order_should_bew_delivered_by() {
        $plan = factory(Plan::class)->create([
            'weeks_of_food_per_shipment'    => 1,
            'ships_every_x_weeks'           => 2,
        ]);

        $previousOrder = $plan->generateOrder();

        $plan = $plan->fresh(['orders']);
        $next_delivery_date = $plan->getNextDeliveryDate();

        $days_delay = $plan->ships_every_x_weeks * 7;

        $this->assertEquals(
            $previousOrder->deliver_by->addDays($days_delay)->format('Y-m-d'),
            $next_delivery_date->format('Y-m-d')
        );
    }

    /** @test */
    public function a_plan_with_a_order_marked_as_packed_different_from_the_plan_knows_the_next_delivery_date() {
        /** @var Plan $plan */
        $plan = factory(Plan::class)->create([
            'weeks_of_food_per_shipment'    => 1,
            'ships_every_x_weeks'           => 1,
        ]);

        /** @var Order $initialOrder */
        $initialOrder = $plan->generateOrder();

        $weeks_packed = 2;
        $packingData = compact('weeks_packed');

        $payment = factory(Payment::class)->make();
        $initialOrder->markAsPaid($payment);
        $initialOrder->markAsPacked($packingData);

        $nextOrderDate = $plan->getNextDeliveryDate();

        $this->assertEquals(
            $initialOrder->deliver_by->addDays($weeks_packed * 7)->format('Y-m-d'),
            $nextOrderDate->format('Y-m-d')
        );
    }

    /** @test */
    public function a_plan_with_a_order_marked_as_shipped_different_from_the_plan_knows_the_next_delivery_date() {
        /** @var Plan $plan */
        $plan = factory(Plan::class)->create([
            'weeks_of_food_per_shipment'    => 1,
            'ships_every_x_weeks'           => 1,
        ]);

        /** @var Order $initialOrder */
        $initialOrder = $plan->generateOrder();

        $weeks_packed = 1;
        $weeks_shipped = 2;
        $packingData = compact('weeks_packed');

        $payment = factory(Payment::class)->make();
        $initialOrder->markAsPaid($payment);
        $initialOrder->markAsPacked($packingData);
        $initialOrder->markAsPicked();

        $deliveryData = [
            'courier_id'    => 1,
            'shipped_at'    => Carbon::now(),
            'weeks_shipped' => $weeks_shipped,
        ];

        $delivery = factory(Delivery::class)->create($deliveryData);
        $initialOrder->markAsShipped($delivery);

        $plan = $plan->fresh(['orders']);

        $nextOrderDate = $plan->getNextDeliveryDate();

        $this->assertEquals(
            $initialOrder->deliver_by->addDays($weeks_shipped * 7)->format('Y-m-d'),
            $nextOrderDate->format('Y-m-d')
        );
    }

    /**
     * Query Scopes
     */

    /** @test */
    public function a_plan_can_be_retrieved_by_scope_needs_order__active() {
        $plan = $this->createPlanForBasicBento();

        $plans = Plan::needsOrder(18)->get();
        $this->assertCount(1, $plans);
    }

    /** @test */
    public function a_plan_can_be_retrieved_by_scope_needs_order__inactive() {
        $plan = $this->createPlanForBasicBento([
            'active'    => 0,
        ]);

        $plans = Plan::needsOrder(18)->get();
        $this->assertCount(0, $plans);
    }

    /** @test */
    public function a_plan_can_be_retrieved_by_scope_needs_order__active__has_old_order() {
        $plan = $this->createPlanForBasicBento([
            'ships_every_x_weeks'           => 1,
            'weeks_of_food_per_shipment'    => 1,
        ]);
        $plan->generateOrder();

        $plans = Plan::needsOrder(15)->get();
        $this->assertCount(1, $plans);
    }

    /** @test */
    public function a_plan_can_be_retrieved_by_scope_needs_order__active__has_new_order__weekly() {
        $plan = $this->createPlanForBasicBento([
            'ships_every_x_weeks'           => 1,
            'weeks_of_food_per_shipment'    => 1,
        ]);
        $plan->generateOrder();

        $order = $plan->orders()->first();

        $plans = Plan::needsOrder(7)->get();
        $this->assertCount(0, $plans);

        $plans = Plan::needsOrder(8)->get();
        $this->assertCount(0, $plans);

        $plans = Plan::needsOrder(9)->get();
        $this->assertCount(0, $plans);

        $plans = Plan::needsOrder(10)->get();
        $this->assertCount(0, $plans);

        $plans = Plan::needsOrder(11)->get();
        $this->assertCount(0, $plans);

        // 7 + 4 (initial order lead time) = 11
        $plans = Plan::needsOrder(12)->get();
        $this->assertCount(1, $plans);
    }

    /** @test */
    public function a_plan_can_be_retrieved_by_scope_needs_order__active__has_new_order__biweekly() {
        $plan = $this->createPlanForBasicBento([
            'ships_every_x_weeks'           => 2,
            'weeks_of_food_per_shipment'    => 2,
        ]);
        $plan->generateOrder();

        $order = $plan->orders()->first();

        $plans = Plan::needsOrder(15)->get();
        $this->assertCount(0, $plans);

        $plans = Plan::needsOrder(18)->get();
        $this->assertCount(0, $plans);

        // 14 + 4 (initial order's lead time) = 18.
        $plans = Plan::needsOrder(19)->get();
        $this->assertCount(1, $plans);

        $plans = Plan::needsOrder(20)->get();
        $this->assertCount(1, $plans);
    }

    /** @test */
    public function a_plan_can_be_retrieved_by_scope_needs_order__active__has_new_order__triweekly() {
        $plan = $this->createPlanForBasicBento([
            'ships_every_x_weeks'           => 3,
            'weeks_of_food_per_shipment'    => 3,
        ]);
        $plan->generateOrder();

        $order = $plan->orders()->first();

        $plans = Plan::needsOrder(24)->get();
        $this->assertCount(0, $plans);

        $plans = Plan::needsOrder(25)->get();
        $this->assertCount(0, $plans);

        // 21 + 4 (initial order's lead time) = 25.
        $plans = Plan::needsOrder(26)->get();
        $this->assertCount(1, $plans);

        $plans = Plan::needsOrder(27)->get();
        $this->assertCount(1, $plans);
    }


    /**
     * Generating Orders
     */

    /** @test */
    public function a_plan_sets_the_deliver_by_of_a_new_order_properly__weekly() {
        $plan = $this->createPlanForBasicBento([
            'ships_every_x_weeks'           => 1,
            'weeks_of_food_per_shipment'    => 1,
        ]);

        $plan->generateOrder();
        $order = $plan->orders()->first();

        $this->assertEquals(
            $order->deliver_by->format('Y-m-d'),
            Carbon::now()->addDays(4)->format('Y-m-d')
        );

        // Second Order
        $plan->generateOrder();

        $plan = $plan->fresh(['orders']);
        $this->assertCount(2, $plan->orders);

        $secondOrder = $plan->orders()
            ->orderBy('deliver_by', 'DESC')
            ->first();

        $this->assertEquals(
            $secondOrder->deliver_by->format('Y-m-d'),
            Carbon::now()->addDays(4 + 7)->format('Y-m-d')
        );

        // Third Order
        $plan->generateOrder();

        $plan = $plan->fresh(['orders']);
        $this->assertCount(3, $plan->orders);

        $secondOrder = $plan->orders()
            ->orderBy('deliver_by', 'DESC')
            ->first();

        $this->assertEquals(
            $secondOrder->deliver_by->format('Y-m-d'),
            Carbon::now()->addDays(4 + 14)->format('Y-m-d')
        );
    }

    /** @test */
    public function a_plan_sets_the_deliver_by_of_a_new_order_properly__biweekly() {
        $plan = $this->createPlanForBasicBento([
            'ships_every_x_weeks'           => 2,
            'weeks_of_food_per_shipment'    => 1,
        ]);

        $plan->generateOrder();
        $order = $plan->orders()->first();

        $this->assertEquals(
            $order->deliver_by->format('Y-m-d'),
            Carbon::now()->addDays(4)->format('Y-m-d')
        );

        // Second Order
        $plan->generateOrder();

        $plan = $plan->fresh(['orders']);
        $this->assertCount(2, $plan->orders);

        $secondOrder = $plan->orders()
            ->orderBy('deliver_by', 'DESC')
            ->first();

        $this->assertEquals(
            $secondOrder->deliver_by->format('Y-m-d'),
            Carbon::now()->addDays(4 + 14)->format('Y-m-d')
        );

        // Third Order
        $plan->generateOrder();

        $plan = $plan->fresh(['orders']);
        $this->assertCount(3, $plan->orders);

        $thirdOrder = $plan->orders()
            ->orderBy('deliver_by', 'DESC')
            ->first();

        $this->assertEquals(
            $thirdOrder->deliver_by->format('Y-m-d'),
            Carbon::now()->addDays(4 + 28)->format('Y-m-d')
        );
    }

    /** @test */
    public function a_plan_sets_the_deliver_by_of_a_new_order_properly__weekly__last_delivered_at() {
        $plan = $this->createPlanForBasicBento([
            'ships_every_x_weeks'           => 1,
            'weeks_of_food_per_shipment'    => 1,
        ]);

        $plan->generateOrder();
        /** @var Order $order */
        $order = $plan->orders()->first();
        $delivery = factory(Delivery::class)->create();

        $order->markAsShipped($delivery);

        $this->assertEquals(
            $order->deliver_by->format('Y-m-d'),
            Carbon::now()->addDays(4)->format('Y-m-d')
        );

        // Second Order
        $plan->generateOrder();

        $plan = $plan->fresh(['orders']);
        $this->assertCount(2, $plan->orders);

        $secondOrder = $plan->orders()
            ->orderBy('deliver_by', 'DESC')
            ->first();

        $this->assertEquals(
            $secondOrder->deliver_by->format('Y-m-d'),
            Carbon::now()->addDays(4 + 7)->format('Y-m-d')
        );

        // Third Order
        $plan->generateOrder();

        $plan = $plan->fresh(['orders']);
        $this->assertCount(3, $plan->orders);

        $thirdOrder = $plan->orders()
            ->orderBy('deliver_by', 'DESC')
            ->first();

        $this->assertEquals(
            $thirdOrder->deliver_by->format('Y-m-d'),
            Carbon::now()->addDays(4 + 14)->format('Y-m-d')
        );
    }

    /** @test */
    public function a_plan_sets_the_deliver_by_of_a_new_order_properly__weekly__last_delivered_at__no_orders() {
        $plan = $this->createPlanForBasicBento([
            'ships_every_x_weeks'           => 1,
            'weeks_of_food_per_shipment'    => 1,
            'latest_delivery_at'            => Carbon::now()->subDays(7),
        ]);

        $plan->generateOrder();
        /** @var Order $order */
        $order = $plan->orders()->first();

        $this->assertEquals(
            $order->deliver_by->format('Y-m-d'),
            Carbon::now()->format('Y-m-d')
        );
    }

    /** @test */
    public function updating_a_package_on_a_plan_can_propogate_by_default() {
        $package = factory(Package::class, 2)->create();

        /** @var Plan $plan */
        $plan = $this->createPlanForBasicBento([
            'ships_every_x_weeks'           => 1,
            'weeks_of_food_per_shipment'    => 1,
            'latest_delivery_at'            => Carbon::now()->subDays(7),
            'package_id'                    => $package[0]->id,
        ]);

        $this->assertEquals($package[0]->id, $plan->package_id);
        $plan->updatePackage($package[1]->id);

        $plan = $plan->fresh(['package']);
        $this->assertEquals($package[1]->id, $plan->package_id);
    }

    /** @test */
    public function fetching_meals_for_a_puppy_results_in_twenty_one_meals() {
        $plan = $this->createPlanForBasicBento([
            'weeks_of_food_per_shipment'    => 1,
        ]);
        $pet = $plan->pet;

        $pet->makePuppy();
        $pet = $pet->fresh();
        $plan = $plan->fresh(['pet']);

        $breakfast = $plan->package->meals->where('calendar_code', '=', 'B1')->first();

        $mealPlan = $plan->mealCounts($breakfast);
        $this->assertCount(2, $mealPlan);
        $this->assertEquals(14, $mealPlan->where('calendar_code', 'B1')->first()->count);
        $this->assertEquals(7, $mealPlan->where('calendar_code', 'D1')->first()->count);
    }

    /** @test */
    public function fetching_meals_for_a_puppy_results_in_fourty_two_meals() {
        $plan = $this->createPlanForBasicBento([
            'weeks_of_food_per_shipment'    => 2
        ]);
        $pet = $plan->pet;

        $pet->makePuppy();
        $pet = $pet->fresh();
        $plan = $plan->fresh(['pet']);

        $breakfast = $plan->package->meals->where('calendar_code', '=', 'B1')->first();

        $mealPlan = $plan->mealCounts($breakfast);
        $this->assertCount(2, $mealPlan);
        $this->assertEquals(28, $mealPlan->where('calendar_code', 'B1')->first()->count);
        $this->assertEquals(14, $mealPlan->where('calendar_code', 'D1')->first()->count);
    }
}
