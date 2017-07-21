<?php

namespace Tests\Feature;

use Martin\ACL\User;
use Martin\Products\Topping;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminToppingsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_guest_is_redirected_from_admin_toppings_page() {
        $topping = factory(Topping::class)->create();

        $this->get('/admin/toppings')                  // index
            ->assertStatus(302);

        $this->get('/admin/toppings/create')           // create
            ->assertStatus(302);

        $this->get('/admin/toppings/' . $topping->id)     // show
            ->assertStatus(302);

        $this->get('/admin/toppings/' . $topping->id . '/edit')     // edit
            ->assertStatus(302);

        $this->post('/admin/toppings')                 // store
            ->assertStatus(302);

        $this->patch('/admin/toppings/' . $topping->id)   // update
            ->assertStatus(302);

        $this->delete('/admin/toppings/' . $topping->id)  // delete
            ->assertStatus(302);
    }

    /** @test */
    public function an_admin_may_visit_the_admin_toppings_page() {
        $this->loginAsAdmin();
        $this->assertTrue($this->user->isAdmin());

        $this->get('/admin/toppings')   // INDEX method
            ->assertStatus(200);
    }

    /** @test */
    public function an_admin_can_see_existing_toppings_on_the_index() {
        $topping = factory(Topping::class)->create();
        $this->loginAsAdmin();

        $this->get('/admin/toppings')   // INDEX method
            ->assertSee($topping->code);
    }

    /** @test */
    public function an_admin_can_view_a_single_topping() {
        $this->loginAsAdmin();

        $topping = factory(Topping::class)->create();

        $this->get('/admin/toppings/' . $topping->id)     // SHOW method
        ->assertSee($topping->code);
    }

    /** @test */
    public function an_admin_can_see_the_form_to_add_a_topping() {
        $this->loginAsAdmin();

        $this->get('/admin/toppings/create')    // CREATE method
            ->assertStatus(200)
            ->assertSee('<form');
    }

    /** @test */
    public function an_admin_can_submit_a_form_to_add_a_topping() {
        $this->loginAsAdmin();

        $topping = factory(Topping::class)->make();

        $request = $topping->toArray();
        $request['_token'] = csrf_token();
        $this->post('/admin/toppings', $topping->toArray()) // STORE method
        ->assertStatus(302);

        // Make adjustment for the mutator on create();
        $topping->cost_per_kg *= 100;

        $this->assertDatabaseHas('toppings', $topping->toArray());
    }

    /** @test */
    public function an_admin_can_edit_a_topping() {
        $this->loginAsAdmin();

        $topping = factory(Topping::class)->create();

        $this->get('/admin/toppings/' . $topping->id . '/edit')   // EDIT method
            ->assertStatus(200)
            ->assertSee('<form')
            ->assertSee($topping->code);
    }

    /** @test */
    public function an_admin_can_save_changes_to_a_topping() {
        $this->loginAsAdmin();

        $topping = factory(Topping::class)->create();
        $id = $topping->id;

        $post_data = $topping->toArray();
        unset($post_data['id']);

        $post_data['code'] = 'NEW_CODE';
        $post_data['_method'] = 'PATCH';

        $this->post('/admin/toppings/'. $id, $post_data)   // UPDATE method
        ->assertStatus(302);
        $this->assertDatabaseHas('toppings', [
            'code' => $post_data['code'],
            'label' => $post_data['label'],
            'id' => $id
        ]);
    }

    /** @test */
    public function an_admin_can_delete_a_topping_from_the_db() {
        $this->loginAsAdmin();

        $topping = factory(Topping::class)->create();
        $id = $topping->id;

        $post_data = [
            '_method' => 'DELETE',
        ];

        $this->post('/admin/toppings/'. $id, $post_data)   // UPDATE method
        ->assertStatus(302);
        $this->seeIsSoftDeletedInDatabase('toppings', [
            'id' => $id
        ]);
    }
}
