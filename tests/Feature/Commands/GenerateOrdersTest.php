<?php

namespace Tests\Unit;

use App\Console\Commands\GenerateOrders;
use Illuminate\Support\Facades\Artisan;
use Martin\Subscriptions\Plan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GenerateOrdersTest extends TestCase
{
    use DatabaseTransactions;

    // TODO: Flesh this out more and ensure that orders are only generated when they should be....

    /** @test */
    public function it_can_be_run() {
        $plan = factory(Plan::class)->create();
        Artisan::call('orders:generate');

        $this->assertTrue($plan->hasOrders());
    }

    /** @test */
    public function it_can_be_called_and_confirms_output() {
        $plan = factory(Plan::class)->create();
        Artisan::call('orders:generate');
        $result = Artisan::output();

        // TODO: Research the best way to test console commands...
        $this->assertTrue($plan->hasOrders());
        $this->assertContains('There were 1 orders generated.', $result);
    }

    /** @test */
    public function it_can_be_called_when_no_orders_are_pending_and_confirms_output() {
        Artisan::call('orders:generate');
        $result = Artisan::output();

        // TODO: Research the best way to test console commands...
        $this->assertContains('No orders were generated this time.', $result);
    }

    // TODO: Build a function in Plans (static, or a query scope...) that will get me the plans
    // ...that require a new order to be generated.. Orders should be generated 2 weeks in advance
    // ... that way, we can confirm the meat required to order to pack the shipments...
    // (and subsequently, the meals that need to be pciked once they have been packed.)
}
