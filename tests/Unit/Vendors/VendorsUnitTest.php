<?php

namespace Tests\Unit;

use Martin\Vendors\Vendor;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_has_a_model_factory() {
        $vendor = factory(Vendor::class)->create()
        $this->assertTrue(true);
    }
}
