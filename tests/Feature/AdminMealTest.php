<?php

namespace Tests\Feature;

use Martin\ACL\User;
use Martin\Products\Meal;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminMealTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_guest_is_redirected_from_admin_meals_page() {
        $meal = factory(Meal::class)->create();

        $this->get('/admin/meals')                  // index
            ->assertStatus(302);

        $this->get('/admin/meals/create')           // create
            ->assertStatus(302);

        $this->get('/admin/meals/' . $meal->id)     // show
            ->assertStatus(302);

        $this->get('/admin/meals/' . $meal->id . '/edit')     // edit
            ->assertStatus(302);

        $this->post('/admin/meals')                 // store
            ->assertStatus(302);

        $this->patch('/admin/meals/' . $meal->id)   // update
            ->assertStatus(302);

        $this->delete('/admin/meals/' . $meal->id)  // delete
            ->assertStatus(302);
    }

    /** @test */
    public function an_admin_may_visit_the_admin_meals_page() {
        $this->loginAsAdmin();
        $this->assertTrue($this->user->isAdmin());

        $this->get('/admin/meals')
            ->assertStatus(200);
    }

    /** @test */
    public function an_admin_can_see_existing_meals_on_the_index() {
        $meal = factory(Meal::class)->create();
        $this->loginAsAdmin();

        $this->get('/admin/meals')
            ->assertSee($meal->label);
    }

    /** @test */
    public function an_admin_can_see_the_form_to_add_a_meal() {
        $this->loginAsAdmin();

        $this->get('/admin/meals/create')
            ->assertStatus(200)
            ->assertSee('<form');
    }

    /** @test */
    public function an_admin_can_submit_a_form_to_add_a_meal() {
        $this->loginAsAdmin();

        $meal = factory(Meal::class)->make();

        $this->post('/admin/meals', $meal->toArray());
        $this->assertDatabaseHas('meals', $meal->toArray());
    }
}
