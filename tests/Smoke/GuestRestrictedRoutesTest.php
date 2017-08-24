<?php

namespace Tests\Smoke;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GuestRestrictedRoutesTest extends TestCase
{

    use DatabaseTransactions;

    /** @test */
    public function it_loads_the_home_page() {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /** @test */
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
