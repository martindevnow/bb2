<?php

namespace Tests\Smoke;

use Martin\Products\Product;
use Martin\Subscriptions\Package;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AllLoadingTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    /** @test */
    public function it_loads_the_home_page() {
        $this->get('/')
            ->assertStatus(200);
    }

    /** @test */
    public function it_loads_the_about_page() {
        $this->get('/about')
            ->assertStatus(200);
    }

    /** @test */
    public function it_loads_the_contact_page() {
        $this->get('/contact')
            ->assertStatus(200);
    }

    /** @test */
    public function it_loads_the_treats_page() {
        $product = factory(Product::class)->create();
        $this->get('/treats')
            ->assertStatus(200);
    }

    /** @test */
    public function it_loads_the_packages_page() {
        $package = factory(Package::class)->create();
        $this->get('/packages')
            ->assertStatus(200);
    }

    /** @test */
    public function it_loads_the_quote_page() {
        $this->get('/quote')
            ->assertStatus(200);
    }

    /** @test */
    public function it_loads_the_login_page() {
        $this->get('/login')
            ->assertStatus(200);
    }

    /** @test */
    public function it_loads_the_register_page() {
        $this->get('/register')
            ->assertStatus(200);
    }

    /** @test */
    public function it_loads_the_shipping_page() {
        $this->get('/shipping')
            ->assertStatus(200);
    }
}
