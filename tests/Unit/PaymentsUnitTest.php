<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Martin\ACL\User;
use Martin\Subscriptions\Plan;
use Martin\Transactions\Payment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PaymentsUnitTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_payment_has_a_factory() {
        $payment = factory(Payment::class)->create();
        $this->assertTrue($payment instanceof Payment);
    }

    /** @test */
    public function a_payment_has_all_fields_assignable() {
        $payment = factory(Payment::class)->create([
            'payer_id'      => factory(User::class)->create()->id,
            'collector_id'  => factory(User::class)->create()->id,
            'received_at'   => time(),
            'format'        => 'paypal',
            'amount_paid'   => 5000,
        ]);

        $this->assertEquals('paypal', $payment->format);
        $this->assertEquals(5000, $payment->amount_paid);
    }


    /**
     * Mutators
     */

    /** @test */
    public function amount_paid_is_mutated_when_saving() {
        $amount_paidInDollars = 1;
        $amount_paidInCents = $amount_paidInDollars * 100;

        factory(Payment::class)->create(['amount_paid' => $amount_paidInDollars]);
        $this->assertDatabaseHas('payments', ['amount_paid' => $amount_paidInCents]);
    }

    /** @test */
    public function amount_paid_is_mutated_when_retrieving() {
        $amount_paidInDollars = 1;
        $amount_paidInCents = $amount_paidInDollars * 100;

        $payment = factory(Payment::class)->make([
            'amount_paid' => $amount_paidInCents,
            'paymentable_type' => 'THIS_IS_NOT_NORMAL'
        ]);
        DB::table('payments')->insert($payment->toArray());
        $payment_clone = Payment::where('paymentable_type', 'THIS_IS_NOT_NORMAL')->firstOrFail();
        $this->assertEquals($amount_paidInDollars, $payment_clone->amount_paid);
    }


    /**
     * Relationships
     */

    /** @test */
    public function a_payment_has_a_collector_and_a_payer() {
        $this->createAdminUser();

        $guest = factory(User::class)->create();

        $payment = factory(Payment::class)->create([
            'payer_id'  => $guest->id,
            'collector_id'  => $this->user->id,
        ]);

        $this->assertEquals($guest->name, $payment->payer->name);
        $this->assertEquals($this->user->name, $payment->collector->name);
    }

    /** @test */
    public function a_payment_can_be_assigned_to_a_plan() {
        $payment = factory(Payment::class)->create();
        $plan = factory(Plan::class)->create();

        $plan->payments()->save($payment);
        $plan = $plan->fresh(['payments']);

        $payment = $payment->fresh();

        $this->assertEquals(Plan::class, $payment->paymentable_type);
        $this->assertEquals($plan->id, $payment->paymentable_id);

    }
}
