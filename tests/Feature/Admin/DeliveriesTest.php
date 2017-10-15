<?php

namespace Tests\Feature\Admin;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Martin\ACL\User;
use Martin\Delivery\Delivery;
use Martin\Transactions\Order;
use Tests\TestCase;

class DeliveriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_is_redirected_from_admin_deliveries_page() {
        $delivery = factory(Delivery::class)->create();

        $this->get('/admin/deliveries')                  // index
            ->assertStatus(302);

        $this->get('/admin/deliveries/create')           // create
            ->assertStatus(302);

        $this->get('/admin/deliveries/' . $delivery->id)     // show
            ->assertStatus(302);

        $this->get('/admin/deliveries/' . $delivery->id . '/edit')     // edit
            ->assertStatus(302);

        $this->post('/admin/deliveries')                 // store
            ->assertStatus(302);

        $this->patch('/admin/deliveries/' . $delivery->id)   // update
            ->assertStatus(302);

        $this->delete('/admin/deliveries/' . $delivery->id)  // delete
            ->assertStatus(302);
    }

    /** @test */
    public function an_admin_may_visit_the_admin_deliveries_page() {
        $this->loginAsAdmin();
        $this->assertTrue($this->user->isAdmin());

        $this->get('/admin/deliveries')   // INDEX method
            ->assertStatus(200);
    }

    /** @test */
    public function an_admin_can_see_existing_deliveries_on_the_index() {
        $delivery = factory(Delivery::class)->create();
        $this->loginAsAdmin();

        $this->get('/admin/deliveries')   // INDEX method
            ->assertSee($delivery->recipient->name);
    }

    /** @test */
    public function an_admin_can_view_a_single_delivery() {
        $this->loginAsAdmin();

        $delivery = factory(Delivery::class)->create();

        $this->get('/admin/deliveries/' . $delivery->id)     // SHOW method
            ->assertSee($delivery->recipient->name)
            ->assertSee($delivery->tracking_number)
            ->assertSee($delivery->courier->label);
    }

    /** @test */
    public function an_admin_can_see_the_form_to_add_a_delivery() {
        $this->loginAsAdmin();

        $this->get('/admin/deliveries/create')    // CREATE method
            ->assertStatus(200)
            ->assertSee('<form');
    }

    /** @test */
    public function an_admin_can_submit_a_form_to_add_a_delivery() {
        $this->loginAsAdmin();

        $delivery = factory(Delivery::class)->make();

        $request = $delivery->toArray();

        $request['_token'] = csrf_token();
        $request['shipped_at'] = Carbon::now()->format('Y-m-d');
        $request['delivered_at'] = Carbon::now()->format('Y-m-d');

        $this->post('/admin/deliveries', $request) // STORE method
            ->assertStatus(302);

        unset($request['_token']);
        unset($request['shipped_at']);
        unset($request['delivered_at']);
        $this->assertDatabaseHas('deliveries', $request);
    }

    /** @test */
    public function an_admin_can_edit_a_delivery() {
        $this->loginAsAdmin();

        $delivery = factory(Delivery::class)->create();
        $this->assertTrue($delivery->order instanceof Order);
        $this->assertTrue($delivery->order->customer instanceof User);

        $this->get('/admin/deliveries/' . $delivery->id . '/edit')   // EDIT method
            ->assertStatus(200)
            ->assertSee('<form')
            ->assertSee($delivery->tracking_number);
    }

    /** @test */
    public function an_admin_can_save_changes_to_a_delivery() {
        $this->loginAsAdmin();

        $delivery = factory(Delivery::class)->create();
        $id = $delivery->id;

        $request = $delivery->toArray();
        unset($request['id']);

        $request['instructions'] = "NEW_INSTRUCTIONS";
        $request['shipped_at'] = Carbon::now()->format('Y-m-d');
        $request['delivered_at'] = Carbon::now()->format('Y-m-d');
        $request['_method'] = 'PATCH';

        $this->post('/admin/deliveries/'. $id, $request)   // UPDATE method
        ->assertStatus(302);


        $this->assertDatabaseHas('deliveries', [
            'instructions' => $request['instructions'],
            'id' => $id
        ]);
    }

    /** @test */
    public function an_admin_can_delete_a_delivery_from_the_db() {
        $this->loginAsAdmin();

        $delivery = factory(Delivery::class)->create();
        $id = $delivery->id;

        $request = [
            '_method' => 'DELETE',
        ];

        $this->post('/admin/deliveries/'. $id, $request)   // UPDATE method
        ->assertStatus(302);
        $this->seeIsSoftDeletedInDatabase('deliveries', [
            'id' => $id
        ]);
    }
}
