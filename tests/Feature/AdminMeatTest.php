<?php

namespace Tests\Feature;

use Martin\ACL\User;
use Martin\Products\Meat;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminMeatTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_guest_is_redirected_from_admin_meats_page() {
        $meat = factory(Meat::class)->create();

        $this->get('/admin/meats')                  // index
            ->assertStatus(302);

        $this->get('/admin/meats/create')           // create
            ->assertStatus(302);

        $this->get('/admin/meats/' . $meat->id)     // show
            ->assertStatus(302);

        $this->get('/admin/meats/' . $meat->id . '/edit')     // edit
            ->assertStatus(302);

        $this->post('/admin/meats')                 // store
            ->assertStatus(302);

        $this->patch('/admin/meats/' . $meat->id)   // update
            ->assertStatus(302);

        $this->delete('/admin/meats/' . $meat->id)  // delete
            ->assertStatus(302);
    }

    /** @test */
    public function an_admin_may_visit_the_admin_meats_page() {
        $this->loginAsAdmin();
        $this->assertTrue($this->user->isAdmin());

        $this->get('/admin/meats')
            ->assertStatus(200);
    }

    /** @test */
    public function an_admin_can_see_existing_meats_on_the_index() {
        $meat = factory(Meat::class)->create();
        $this->loginAsAdmin();

        $this->get('/admin/meats')
            ->assertSee($meat->type);
    }

    /** @test */
    public function an_admin_can_see_the_form_to_add_a_meat() {
        $this->loginAsAdmin();

        $this->get('/admin/meats/create')
            ->assertStatus(200)
            ->assertSee('<form');
    }

    /** @test */
    public function an_admin_can_submit_a_form_to_add_a_meat() {
        $this->loginAsAdmin();

        $meat = factory(Meat::class)->make();

        $this->post('/admin/meats', $meat->toArray());

        // Make adjustment for the mutator on create();
        $meat->cost_per_lb *= 100;

        $this->assertDatabaseHas('meats', $meat->toArray());
    }
}
