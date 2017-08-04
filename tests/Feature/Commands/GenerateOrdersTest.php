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
    use DatabaseMigrations;

    // TODO: Flesh this out more and ensure that orders are only generated when they should be....

    /** @test */
    public function it_can_be_run() {
        $plan = factory(Plan::class)->create();
//        (`php artisan orders:generate`);
        Artisan::call('orders:generate');


        $this->assertTrue($plan->hasOrders());
    }

    /** @test */
    public function it_can_be_called_and_confirms_output() {
        $plan = factory(Plan::class)->Create();

        Artisan::call('orders:generate');
        $result = Artisan::output();

        // TODO: Research the best way to test console commands...
        $this->assertTrue($plan->hasOrders());
        $this->assertContains('There were 1 orders generated.', $result);
    }

}
