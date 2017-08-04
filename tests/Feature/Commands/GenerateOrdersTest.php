<?php

namespace Tests\Unit;

use App\Console\Commands\GenerateOrders;
use Martin\Subscriptions\Plan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GenerateOrdersTest extends TestCase
{
    use DatabaseMigrations;

    // TODO: Flesh this out more and ensure that orders are only generated when they should be....

    /** @test */
    public function it_can_be_run_from_the_cli() {
        $plan = factory(Plan::class)->create();
        (`php artisan orders:generate`);

        $this->assertTrue($plan->hasOrders());
    }

    /** @test */
    public function it_can_be_called_from_the_code() {
        $plan = factory(Plan::class)->Create();

        $command = new GenerateOrders();
        $command->handle();


        // TODO: Research the best way to test console commands...
        $this->assertTrue($plan->hasOrders());
    }

}
