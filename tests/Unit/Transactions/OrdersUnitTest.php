<?php

namespace Tests\Unit\Transactions;

use Illuminate\Support\Facades\DB;
use Martin\ACL\User;
use Martin\Core\Address;
use Martin\Core\Attachment;
use Martin\Products\Meal;
use Martin\Products\Meat;
use Martin\Subscriptions\Package;
use Martin\Subscriptions\Plan;
use Martin\Transactions\Order;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrdersUnitTest extends TestCase
{
    use DatabaseMigrations;

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
        $order = factory(Order::class)->create();
        $this->assertFalse($order->packed);

        $this->order->markAsPacked();
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
}
