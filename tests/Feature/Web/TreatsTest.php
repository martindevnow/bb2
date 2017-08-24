<?php

namespace Tests\Feature\Web;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TreatsTest extends TestCase
{

    use DatabaseTransactions;

    /** @test */
    public function a_guest_can_see_treats() {
        $this->get('/treats')
            ->assertStatus(200);
    }
}
