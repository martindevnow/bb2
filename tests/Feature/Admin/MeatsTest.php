<?php

namespace Tests\Feature\Admin;

use Martin\ACL\User;
use Martin\Products\Meat;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MeatsTest extends TestCase
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

        $this->get('/admin/meats')  // INDEX method
            ->assertStatus(200);
    }

    /** @test */
    public function an_admin_can_see_existing_meats_on_the_index() {
        $meat = factory(Meat::class)->create();
        $this->loginAsAdmin();

        $this->get('/admin/meats')  // INDEX method
            ->assertSee($meat->type);
    }

    /** @test */
    public function an_admin_can_view_a_single_meat() {
        $this->loginAsAdmin();

        $meat = factory(Meat::class)->create();

        $this->get('/admin/meats/' . $meat->id) // SHOW method
            ->assertSee($meat->code)
            ->assertSee($meat->type)
            ->assertSee($meat->variety);
    }

    /** @test */
    public function an_admin_can_see_the_form_to_add_a_meat() {
        $this->loginAsAdmin();

        $this->get('/admin/meats/create')   // CREATE method
            ->assertStatus(200)
            ->assertSee('<form');
    }

    /** @test */
    public function an_admin_can_submit_a_form_to_add_a_meat() {
        $this->loginAsAdmin();

        $meat = factory(Meat::class)->make();

        $this->post('/admin/meats', $meat->toArray());  // STORE method

        // Make adjustment for the mutator on create();
        $meat->cost_per_lb *= 100;

        $this->assertDatabaseHas('meats', $meat->toArray());
    }

    /** @test */
    public function an_admin_can_edit_a_meat() {
        $this->loginAsAdmin();

        $meat = factory(Meat::class)->create();

        $this->get('/admin/meats/' . $meat->id . '/edit')   // EDIT method
        ->assertStatus(200)
            ->assertSee('<form')
            ->assertSee($meat->type);
    }

    /** @test */
    public function an_admin_can_save_changes_to_a_meat() {
        $this->loginAsAdmin();

        $meat = factory(Meat::class)->create();
        $id = $meat->id;

        $post_data = $meat->toArray();
        unset($post_data['id']);

        $post_data['type'] = 'NEW_TYPE';
        $post_data['_method'] = 'PATCH';

        $this->post('/admin/meats/'. $id, $post_data)   // UPDATE method
        ->assertStatus(302);
        $this->assertDatabaseHas('meats', [
            'type' => $post_data['type'],
            'variety' => $post_data['variety'],
            'id' => $id
        ]);
    }

    /** @test */
    public function an_admin_can_delete_a_meat_from_the_db() {
        $this->loginAsAdmin();

        $meat = factory(Meat::class)->create();
        $id = $meat->id;

        $post_data = [
            '_method' => 'DELETE',
        ];

        $this->post('/admin/meats/'. $id, $post_data)   // UPDATE method
        ->assertStatus(302);
        $this->seeIsSoftDeletedInDatabase('meats', [
            'id' => $id
        ]);
    }
}
