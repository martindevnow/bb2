<?php

namespace Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FaqTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_the_faq_page()
    {
        $response = $this->get('/faq');

        $response->assertStatus(200);
    }
}
