<?php

namespace Tests\Feature\Web;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FaqTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function a_user_can_visit_the_faq_page()
    {
        $response = $this->get('/faq');

        $response->assertStatus(200);
    }
}
