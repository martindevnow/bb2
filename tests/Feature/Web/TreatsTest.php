<?php

namespace Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TreatsTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_guest_can_see_treats() {
        $this->get('/treats')
            ->assertStatus(200);
    }
}
