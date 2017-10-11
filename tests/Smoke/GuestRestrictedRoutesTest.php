<?php

namespace Tests\Smoke;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestRestrictedRoutesTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_loads_the_home_page() {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /** TODO: This test is unreliable */
    public function it_loads_the_about_page() {
        $response = $this->get('/about');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_loads_the_contact_page() {
        $response = $this->get('/contact');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_loads_the_treats_page() {
        $response = $this->get('/treats');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_loads_the_packages_page() {
        $response = $this->get('/packages');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_loads_the_quote_page() {
        $response = $this->get('/quote');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_loads_the_login_page() {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_loads_the_register_page() {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }
}
