<?php

namespace Tests\Unit;

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
        $plans = factory(Plan::class)->create();
        dd (`php artisan orders:generate`);
    }
}
