<?php

namespace Tests\Feature\Admin;

use Carbon\Carbon;
use Martin\Delivery\Courier;
use Martin\Products\Meal;
use Martin\Products\Meat;
use Martin\Subscriptions\Package;
use Martin\Subscriptions\Plan;
use Martin\Transactions\Order;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrdersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_guest_is_redirected_from_admin_orders_page() {
        $order = factory(Order::class)->create();

        $this->get('/admin/orders')                  // index
            ->assertStatus(302);

        $this->get('/admin/orders/create')           // create
            ->assertStatus(302);

        $this->get('/admin/orders/' . $order->id)     // show
            ->assertStatus(302);

        $this->get('/admin/orders/' . $order->id . '/edit')     // edit
            ->assertStatus(302);

        $this->post('/admin/orders')                 // store
            ->assertStatus(302);

        $this->patch('/admin/orders/' . $order->id)   // update
            ->assertStatus(302);

        $this->delete('/admin/orders/' . $order->id)  // delete
            ->assertStatus(302);
    }

    /** @test */
    public function an_admin_may_visit_the_admin_orders_page() {
        $this->loginAsAdmin();
        $this->assertTrue($this->user->isAdmin());

        $this->get('/admin/orders')   // INDEX method
            ->assertStatus(200);
    }

    /** @test */
    public function an_admin_can_see_existing_orders_on_the_index() {
        $order = factory(Order::class)->create();
        $this->loginAsAdmin();

        $this->get('/admin/orders')  // INDEX method
            ->assertSee($order->customer->name);
    }

    /** @test */
    public function an_admin_can_view_a_single_order() {
        $this->loginAsAdmin();

        $order = factory(Order::class)->create();

        $this->get('/admin/orders/' . $order->id) // SHOW method
            ->assertSee($order->customer->name);
    }

    /**  */
    public function an_admin_can_see_the_form_to_add_an_order() {
        // TODO: Decide if there is a use case for this method
    }

    /**  */
    public function an_admin_can_submit_a_form_to_add_an_order() {
        // TODO: Decide if there is a use case for this method
    }

    /**  */
    public function an_admin_can_edit_an_order() {
        // TODO: Decide if there is a use case for this method
    }

    /**  */
    public function an_admin_can_save_changes_to_an_order() {
        // TODO: Decide if there is a use case for this method
    }

    /** @test */
    public function an_admin_can_delete_a_order_from_the_db() {
        $this->loginAsAdmin();

        $order = factory(Order::class)->create();
        $id = $order->id;

        $post_data = [
            '_method' => 'DELETE',
        ];

        $this->post('/admin/orders/'. $id, $post_data)   // UPDATE method
            ->assertStatus(302);
        $this->seeIsSoftDeletedInDatabase('orders', [
            'id' => $id
        ]);
    }

    /** @test */
    public function an_admin_can_see_the_meal_counts_on_show_page() {
        $this->loginAsAdmin();

        $order = $this->createOrderForBasicPlan();

        $meals = $order->mealCounts()
            ->toArray();

        $firstMeal = $meals[1];
        $secondMeal = $meals[2];

        $this->get('/admin/orders/' . $order->id) // SHOW method
            ->assertSee($firstMeal['label'] . ' x ' . $firstMeal['count'])
            ->assertSee($secondMeal['label'] . ' x ' . $secondMeal['count']);
    }

    /** @test */
    public function an_admin_can_mark_the_order_as_packed() {
        $this->loginAsAdmin();
        $order = $this->createOrderForBasicPlan();

        $this->post('/admin/orders/' . $order->id . '/packed')
            ->assertStatus(302);

        $this->assertDatabaseHas('orders', [
            'id'    => $order->id,
            'packed'    => true,
        ]);
    }

    /** @test */
    public function an_admin_can_view_the_form_to_mark_an_order_as_paid() {
        $this->loginAsAdmin();
        $order = $this->createOrderForBasicPlan();
        $this->get('/admin/orders/'. $order->id . '/paid')
            ->assertSee('<form action="/admin/orders/'. $order->id .'/paid"');
    }

    /** @test */
    public function an_admin_can_submit_a_payment_form_for_an_order() {
        $this->loginAsAdmin();
        $order = $this->createOrderForBasicPlan();

        $response = $this->post('/admin/orders/' . $order->id . '/paid', [
            'format'    => 'cash',
            'amount_paid'   => 15,
            'received_at'   => Carbon::now()->format('Y-m-d'),
        ])
            ->assertStatus(302)
            ->assertRedirect('/admin/orders');

        $this->assertDatabaseHas('orders', [
            'id'    => $order->id,
            'paid'  => 1,
        ]);

        $this->followRedirects($response)
            ->assertSee('That order was marked as paid.');
    }

    /** @test */
    public function an_admin_can_mark_an_order_as_packed() {
        $this->loginAsAdmin();
        $order = $this->createOrderForBasicPlan();

        $response = $this->get('/admin/orders/' . $order->id .'/packed')
            ->assertStatus(302)
            ->assertRedirect('/admin/orders');

        $this->assertDatabaseHas('orders', [
            'id'    => $order->id,
            'packed'  => 1,
        ]);

        $this->followRedirects($response)
            ->assertSee('That order was marked as packed.');
    }

    /** @test */
    public function an_admin_can_mark_an_order_as_picked() {
        $this->loginAsAdmin();
        $order = $this->createOrderForBasicPlan();

        $response = $this->get('/admin/orders/' . $order->id .'/picked')
            ->assertStatus(302)
            ->assertRedirect('/admin/orders');

        $this->assertDatabaseHas('orders', [
            'id'    => $order->id,
            'picked'  => 1,
        ]);

        $this->followRedirects($response)
            ->assertSee('That order was marked as picked.');
    }

    /** @test */
    public function an_admin_can_view_the_form_to_mark_an_order_as_shipped() {
        $this->loginAsAdmin();
        $order = $this->createOrderForBasicPlan();
        $this->get('/admin/orders/'. $order->id . '/shipped')
            ->assertSee('<form action="/admin/orders/'. $order->id .'/shipped"');
    }


    /** @test */
    public function an_admin_can_submit_a_shipment_form_for_an_order() {
        $this->loginAsAdmin();
        $order = $this->createOrderForBasicPlan();
        $courier = factory(Courier::class)->create();


        $response = $this->post('/admin/orders/' . $order->id . '/shipped', [
            'courier_id'    => $courier->id,
            'tracking_number'   => 1532153425,
            'shipped_at'   => Carbon::now()->format('Y-m-d'),
        ])
            ->assertStatus(302)
            ->assertRedirect('/admin/orders');

        $this->assertDatabaseHas('orders', [
            'id'    => $order->id,
            'shipped'  => 1,
        ]);

        $this->followRedirects($response)
            ->assertSee('That order was marked as shipped.');
    }

    /** @test */
    public function an_admin_can_view_the_form_to_mark_an_order_as_delivered() {
        $this->loginAsAdmin();
        $order = $this->createOrderForBasicPlan();
        $this->get('/admin/orders/'. $order->id . '/delivered')
            ->assertSee('<form action="/admin/orders/'. $order->id .'/delivered"');
    }


    /** @test */
    public function an_admin_can_submit_a_delivery_form_for_an_order() {
        $this->loginAsAdmin();
        $order = $this->createOrderForBasicPlan();
        $courier = factory(Courier::class)->create();
        $this->post('/admin/orders/' . $order->id . '/shipped', [
            'courier_id'    => $courier->id,
            'tracking_number'   => 1532153425,
            'shipped_at'   => Carbon::now()->format('Y-m-d'),
        ]);

        $response = $this->post('/admin/orders/' . $order->id . '/delivered', [
            'delivered_at'   => Carbon::now()->format('Y-m-d'),
        ])
            ->assertStatus(302)
            ->assertRedirect('/admin/orders');

        $this->assertDatabaseHas('orders', [
            'id'    => $order->id,
            'delivered'  => 1,
        ]);

        $this->followRedirects($response)
            ->assertSee('That order was marked as delivered.');
    }
}
