<?php

namespace Tests\Feature\Admin;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Martin\Transactions\Payment;
use Tests\TestCase;

class PaymentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_is_redirected_from_admin_payments_page() {
        $payment = factory(Payment::class)->create();

        $this->get('/admin/payments')                  // index
            ->assertStatus(302);

        $this->get('/admin/payments/create')           // create
            ->assertStatus(302);

        $this->get('/admin/payments/' . $payment->id)     // show
            ->assertStatus(302);

        $this->get('/admin/payments/' . $payment->id . '/edit')     // edit
            ->assertStatus(302);

        $this->post('/admin/payments')                 // store
            ->assertStatus(302);

        $this->patch('/admin/payments/' . $payment->id)   // update
            ->assertStatus(302);

        $this->delete('/admin/payments/' . $payment->id)  // delete
            ->assertStatus(302);
    }

    /** @test */
    public function an_admin_may_visit_the_admin_payments_page() {
        $this->loginAsAdmin();
        $this->assertTrue($this->user->isAdmin());

        $this->get('/admin/payments')   // INDEX method
            ->assertStatus(200);
    }

    /** @test */
    public function an_admin_can_see_existing_payments_on_the_index() {
        $payment = factory(Payment::class)->create();
        $this->loginAsAdmin();

        $this->get('/admin/payments')   // INDEX method
            ->assertSee($payment->customer->name);
    }

    /** @test */
    public function an_admin_can_view_a_single_payment() {
        $this->loginAsAdmin();

        $payment = factory(Payment::class)->create();

        $this->get('/admin/payments/' . $payment->id)     // SHOW method
            ->assertSee($payment->customer->name)
            ->assertSee($payment->format);
    }

    /** @test */
    public function an_admin_can_see_the_form_to_add_a_payment() {
        $this->loginAsAdmin();

        $this->get('/admin/payments/create')    // CREATE method
            ->assertStatus(200)
            ->assertSee('<form');
    }

    /** @test */
    public function an_admin_can_submit_a_form_to_add_a_payment() {
        $this->loginAsAdmin();

        $payment = factory(Payment::class)->make();

        $request = $payment->toArray();
        unset($request['collector_id']);
        unset($request['paymentable_id']);
        unset($request['paymentable_type']);

        $request['_token'] = csrf_token();
        $request['received_at'] = Carbon::now()->format('Y-m-d');

        $this->post('/admin/payments', $request) // STORE method
            ->assertStatus(302);

        unset($request['_token']);
        unset($request['received_at']);
        $request['amount_paid'] *= 100;
        $this->assertDatabaseHas('payments', $request);
    }

    /** @test */
    public function an_admin_can_edit_a_payment() {
        $this->loginAsAdmin();

        $payment = factory(Payment::class)->create();

        $this->get('/admin/payments/' . $payment->id . '/edit')   // EDIT method
            ->assertStatus(200)
            ->assertSee('<form')
            ->assertSee("".$payment->amount_paid); // TODO: Write this properly
    }

    /** @test */
    public function an_admin_can_save_changes_to_a_payment() {
        $this->loginAsAdmin();

        $payment = factory(Payment::class)->create();
        $id = $payment->id;

        $request = $payment->toArray();
        unset($request['id']);

        $request['amount_paid'] = 500;
        $request['received_at'] = Carbon::now()->format('Y-m-d');
        $request['_method'] = 'PATCH';

        $this->post('/admin/payments/'. $id, $request)   // UPDATE method
        ->assertStatus(302);

        $request['amount_paid'] *= 100;

        $this->assertDatabaseHas('payments', [
            'amount_paid' => $request['amount_paid'],
            'id' => $id
        ]);
    }

    /** @test */
    public function an_admin_can_delete_a_payment_from_the_db() {
        $this->loginAsAdmin();

        $payment = factory(Payment::class)->create();
        $id = $payment->id;

        $request = [
            '_method' => 'DELETE',
        ];

        $this->post('/admin/payments/'. $id, $request)   // UPDATE method
        ->assertStatus(302);
        $this->seeIsSoftDeletedInDatabase('payments', [
            'id' => $id
        ]);
    }
}
