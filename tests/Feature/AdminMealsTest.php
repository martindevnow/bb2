<?php

namespace Tests\Feature;

use Martin\ACL\User;
use Martin\Products\Meal;
use Martin\Products\Meat;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminMealsTest extends TestCase
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

        $this->get('/admin/meals')  // INDEX method
            ->assertSee($meal->label);
    }

    /** @test */
    public function an_admin_can_view_a_single_meal() {
        $this->loginAsAdmin();

        $meal = factory(Meal::class)->create();

        $this->get('/admin/meals/' . $meal->id) // SHOW method
            ->assertSee($meal->code)
            ->assertSee($meal->label);
    }

    /** @test */
    public function meats_are_visible_on_the_individual_meal_page() {
        $this->loginAsAdmin();
        $meal = factory(Meal::class)->create();
        $meat = factory(Meat::class, 3)->create();

        $this->get('/admin/meals/' . $meal->id) // SHOW method
            ->assertSee($meat[0]->code)
            ->assertSee($meat[1]->code)
            ->assertSee($meat[2]->code);
    }

    /** @test */
    public function an_admin_can_see_the_form_to_add_a_meal() {
        $this->loginAsAdmin();

        $this->get('/admin/meals/create')   // CREATE method
            ->assertStatus(200)
            ->assertSee('<form');
    }

    /** @test */
    public function an_admin_can_submit_a_form_to_add_a_meal() {
        $this->loginAsAdmin();

        $meal = factory(Meal::class)->make();

        $this->post('/admin/meals', $meal->toArray());  // STORE method
        $this->assertDatabaseHas('meals', $meal->toArray());
    }

    /** @test */
    public function an_admin_can_edit_a_meal() {
        $this->loginAsAdmin();

        $meal = factory(Meal::class)->create();

        $this->get('/admin/meals/' . $meal->id . '/edit')   // EDIT method
            ->assertStatus(200)
            ->assertSee('<form')
            ->assertSee($meal->label);
    }

    /** @test */
    public function an_admin_can_save_changes_to_a_meal() {
        $this->loginAsAdmin();

        $meal = factory(Meal::class)->create();
        $id = $meal->id;

        $post_data = $meal->toArray();
        unset($post_data['id']);

        $post_data['label'] = 'NEW_LABEL';
        $post_data['_method'] = 'PATCH';

        $this->post('/admin/meals/'. $id, $post_data)   // UPDATE method
            ->assertStatus(302);
        $this->assertDatabaseHas('meals', [
            'code' => $post_data['code'],
            'label' => $post_data['label'],
            'id' => $id
        ]);
    }

    /** @test */
    public function an_admin_can_delete_a_meal_from_the_db() {
        $this->loginAsAdmin();

        $meal = factory(Meal::class)->create();
        $id = $meal->id;

        $post_data = [
            '_method' => 'DELETE',
        ];

        $this->post('/admin/meals/'. $id, $post_data)   // UPDATE method
            ->assertStatus(302);
        $this->seeIsSoftDeletedInDatabase('meals', [
            'id' => $id
        ]);
    }

}
