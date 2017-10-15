<?php

namespace Tests\Unit\Transactions;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Martin\ACL\User;
use Martin\Core\Address;
use Martin\Core\Attachment;
use Martin\Delivery\Courier;
use Martin\Delivery\Delivery;
use Martin\Products\Meal;
use Martin\Products\Meat;
use Martin\Subscriptions\Package;
use Martin\Subscriptions\Plan;
use Martin\Transactions\Order;
use Martin\Transactions\Payment;
use Tests\TestCase;

class OrdersUnitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_order_has_a_factory() {
        $order = factory(Order::class)->create();
        $this->assertTrue($order instanceof Order);
    }

    /** @test */
    public function a_order_has_all_fields_assignable() {
        $order = factory(Order::class)->create([
            'customer_id'           => factory(User::class)->create()->id,
            'delivery_address_id'   => factory(Address::class)->create()->id,
            'subtotal'   => 5000,
            'tax'        => 500,
            'total_cost'   => 5500,
        ]);

        $this->assertEquals(5000, $order->subtotal);
        $this->assertEquals(500, $order->tax);
        $this->assertEquals(5500, $order->total_cost);
    }


    /**
     * Mutators
     */

    /** @test */
    public function subtotal_is_mutated_when_saving() {
        $subtotalInDollars = 1;
        $subtotalInCents = $subtotalInDollars * 100;

        factory(Order::class)->create(['subtotal' => $subtotalInDollars]);
        $this->assertDatabaseHas('orders', ['subtotal' => $subtotalInCents]);
    }

    /** @test */
    public function subtotal_is_mutated_when_retrieving() {
        $subtotalInDollars = 1;
        $subtotalInCents = $subtotalInDollars * 100;

        $order = factory(Order::class)->make([
            'subtotal' => $subtotalInCents,
        ]);
        DB::table('orders')->insert($order->toArray());
        $order_clone = Order::where('customer_id', $order->customer_id)->firstOrFail();
        $this->assertEquals($subtotalInDollars, $order_clone->subtotal);
    }

    /** @test */
    public function tax_is_mutated_when_saving() {
        $taxInDollars = 1;
        $taxInCents = $taxInDollars * 100;

        factory(Order::class)->create(['tax' => $taxInDollars]);
        $this->assertDatabaseHas('orders', ['tax' => $taxInCents]);
    }

    /** @test */
    public function tax_is_mutated_when_retrieving() {
        $taxInDollars = 1;
        $taxInCents = $taxInDollars * 100;

        $order = factory(Order::class)->make([
            'tax' => $taxInCents,
        ]);
        DB::table('orders')->insert($order->toArray());
        $order_clone = Order::where('customer_id', $order->customer_id)->firstOrFail();
        $this->assertEquals($taxInDollars, $order_clone->tax);
    }

    /** @test */
    public function total_cost_is_mutated_when_saving() {
        $total_costInDollars = 1;
        $total_costInCents = $total_costInDollars * 100;

        factory(Order::class)->create(['total_cost' => $total_costInDollars]);
        $this->assertDatabaseHas('orders', ['total_cost' => $total_costInCents]);
    }

    /** @test */
    public function total_cost_is_mutated_when_retrieving() {
        $total_costInDollars = 1;
        $total_costInCents = $total_costInDollars * 100;

        $order = factory(Order::class)->make([
            'total_cost' => $total_costInCents,
        ]);
        DB::table('orders')->insert($order->toArray());
        $order_clone = Order::where('customer_id', $order->customer_id)->firstOrFail();
        $this->assertEquals($total_costInDollars, $order_clone->total_cost);
    }

    /** @test */
    public function an_order_can_get_the_meal_counts() {
        $order = $this->createOrderForBasicPlan();
        $meals = $order->mealCounts();

        $this->assertCount(2, $order->mealCounts());

        foreach ($meals as $meal)
            $this->assertEquals(14, $order->mealCounts($meal));
    }


    /**
     * Order Packing Workflow
     */

    /** @test */
    public function marking_an_order_as_packed_affects_the_inventory() {
        /** @var Order $order */
        $order = $this->createOrderForBasicPlan();
        $order->markAsPacked();

        $this->assertDatabaseHas('orders', [
            'id'        => $order->id,
            'packed'    => 1,
        ]);

        foreach($order->mealCounts() as $meal) {
            foreach($meal->meats as $meat) {
                $this->assertDatabaseHas('inventories', [
                    'changeable_id'         => $order->id,
                    'changeable_type'       => get_class($order),
                    'inventoryable_id'      => $meat->id,
                    'inventoryable_type'    => get_class($meat),
                    'change'                => -700,     // this is LBS * 100
                    'size'                  => null
                ]);
            }
            $this->assertDatabaseHas('inventories', [
                'changeable_id'         => $order->id,
                'changeable_type'       => get_class($order),
                'inventoryable_id'      => $meal->id,
                'inventoryable_type'    => get_class($meal),
                'change'                => 1400,         // this is 14 meals * 100
                'size'                  => $order->plan->pet->mealSize() * 100,
            ]);
        }
    }

    /** @test */
    public function marking_an_order_as_picked_affects_the_inventory() {
        /** @var Order $order */
        $order = $this->createOrderForBasicPlan();
        $order->markAsPicked();

        $this->assertDatabaseHas('orders', [
            'id'        => $order->id,
            'picked'    => 1,
        ]);

        foreach($order->mealCounts() as $meal) {
            $this->assertDatabaseHas('inventories', [
                'changeable_id'         => $order->id,
                'changeable_type'       => get_class($order),
                'inventoryable_id'      => $meal->id,
                'inventoryable_type'    => get_class($meal),
                'change'                => -1400,         // this is 14 meals * 100
                'size'                  => $order->plan->pet->mealSize() * 100,
            ]);
        }
    }

    /**
     * Relationships
     */

    /** @test */
    public function an_order_belongs_to_a_customer() {
        $this->createAdminUser();

        $guest = factory(User::class)->create();
        $order = factory(Order::class)->create([
            'customer_id'  => $guest->id,
        ]);

        $this->assertEquals($guest->name, $order->customer->name);
    }

    /** @test */
    public function an_order_has_a_delivery_address() {
        $address = factory(Address::class)->create();
        $order = factory(Order::class)->create();

        $address->orders()->save($order);
        $order = $order->fresh(['deliveryAddress']);

        $this->assertEquals($address->id, $order->delivery_address_id);
    }

    /** @test */
    public function an_order_belongs_to_a_plan() {
        $plan = factory(Plan::class)->create();
        $order = factory(Order::class)->create();

        $plan->orders()->save($order);
        $order = $order->fresh(['plan']);

        $this->assertEquals($plan->id, $order->plan_id);
    }

    /** @test */
    public function an_order_can_have_attachments() {
        $plan = factory(Plan::class)->create();
        $plan->generateOrder();
        $order = $plan->orders()->first();

        $order->attachments()->save(factory(Attachment::class)->create());

        $this->assertCount(1, $order->attachments);
    }

    /**
     * Query Scope
     */

    /** @test */
    public function orders_that_need_packing_can_be_fetched() {
        /** @var Plan $plan */
        $plan = factory(Plan::class)->create();
        $plan->generateOrder();

        /** @var Order $order */
        $order = $plan->orders()->first();
        $order->markAsPacked();

        $ordersNeedingPacking = Order::needsPacking()->get();
        $this->assertCount(0, $ordersNeedingPacking);
    }

    /** @test */
    public function an_order_can_be_marked_as_paid() {
        /** @var Plan $plan */
        $plan = factory(Plan::class)->create();
        $plan->generateOrder();

        /** @var Order $order */
        $order = $plan->orders()->first();

        $payment = factory(Payment::class)->make([
            'paymentable_id'    => null,
            'paymentable_type'    => null,
        ]);
        $order->markAsPaid($payment);

        $order = $order->fresh();
        $this->assertEquals(1, $order->paid);
    }

    /** @test */
    public function an_order_can_be_marked_as_shipped() {
        $courier = factory(Courier::class)->create();

        /** @var Plan $plan */
        $plan = factory(Plan::class)->create();
        $plan->generateOrder();

        /** @var Order $order */
        $order = $plan->orders()->first();
        $delivery = factory(Delivery::class)->create();
        $order->markAsShipped($delivery);

        $order = $order->fresh();
        $this->assertTrue($order->delivery instanceof Delivery);
        $this->assertEquals(1, $order->shipped);
    }

    /** @test */
    public function shipping_an_uniquely_large_order_affects_the_deliver_by_date_of_existing_orders() {
        $plan = $this->createPlanForBasicBento([
            'ships_every_x_weeks'           => 1,
            'weeks_of_food_per_shipment'    => 1,
        ]);

        /** @var Plan $plan */
        $order = $plan->generateOrder();

        $this->assertEquals(
            Carbon::now()->addDays(4)->format('Y-m-d'),
            $order->deliver_by->format('Y-m-d')
        );

        $order2 = $plan->generateOrder();
        $order3 = $plan->generateOrder();
        $this->assertEquals(
            Carbon::now()->addDays(4 + 7)->format('Y-m-d'),
            $order2->deliver_by->format('Y-m-d')
        );
        $this->assertEquals(
            Carbon::now()->addDays(4 + 14)->format('Y-m-d'),
            $order3->deliver_by->format('Y-m-d')
        );

        $order->markAsPaid(factory(Payment::class)->create());
        $order->markAsPacked([
            'weeks_packed'  => 2,
        ]);

        $order->markAsShipped(factory(Delivery::class)->create([
            'weeks_shipped' => 2,
            'shipped_at'    => Carbon::now()->addDays(4),
        ]));

        $order2 = $order2->fresh();
        $order3 = $order3->fresh();

        $this->assertEquals(
            Carbon::now()->addDays(4 + 14)->format('Y-m-d'),
            $order2->deliver_by->format('Y-m-d')
        );
        $this->assertEquals(
            Carbon::now()->addDays(4 + 21)->format('Y-m-d'),
            $order3->deliver_by->format('Y-m-d')
        );
    }
}
