<?php

namespace Tests\Feature\Admin;

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

        $package = factory(Package::class)->create();

        $chkMeal = factory(Meal::class)->create();
        $turkMeal = factory(Meal::class)->create();

        $chickenCost = 1;
        $turkeyCost = 6;

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
        $package = $package->fresh(['meals']);

        /** @var Plan $plan */
        $plan = factory(Plan::class)->create([
            'package_id'    => $package->id,
            'weeks_at_a_time'   => 2,
        ]);

        $plan->generateOrder();
        $order = $plan->orders->first();

        $meals = $order->mealCounts();
        $firstMeal = $meals->where('label', $chkMeal->label)
            ->first();

        $secondMeal = $meals->where('label', $turkMeal->label)
            ->first();

        $this->get('/admin/orders/' . $order->id) // SHOW method
            ->assertSee($firstMeal->label . ' x ' . $firstMeal->count)
            ->assertSee($secondMeal . ' x ' . $secondMeal->count);
    }
}
