<?php

namespace Tests\Feature\Admin;

use Martin\ACL\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_guest_is_redirected_from_admin_users_page() {
        $user = factory(User::class)->create();

        $this->get('/admin/users')                  // index
            ->assertStatus(302);

        $this->get('/admin/users/create')           // create
            ->assertStatus(302);

        $this->get('/admin/users/' . $user->id)     // show
            ->assertStatus(302);

        $this->get('/admin/users/' . $user->id . '/edit')     // edit
            ->assertStatus(302);

        $this->post('/admin/users')                 // store
            ->assertStatus(302);

        $this->patch('/admin/users/' . $user->id)   // update
            ->assertStatus(302);

        $this->delete('/admin/users/' . $user->id)  // delete
            ->assertStatus(302);
    }

    /** @test */
    public function an_admin_may_visit_the_admin_users_page() {
        $this->loginAsAdmin();
        $this->assertTrue($this->user->isAdmin());

        $this->get('/admin/users')   // INDEX method
            ->assertStatus(200);
    }

    /** @test */
    public function an_admin_can_see_existing_users_on_the_index() {
        $user = factory(User::class)->create();
        $this->loginAsAdmin();

        $this->get('/admin/users')   // INDEX method
            ->assertSee($user->name);
    }

    /** @test */
    public function an_admin_can_view_a_single_user() {
        $this->loginAsAdmin();

        $user = factory(User::class)->create();

        $this->get('/admin/users/' . $user->id)     // SHOW method
            ->assertSee($user->name)
            ->assertSee($user->email);
    }

    /** @test */
    public function an_admin_can_see_the_form_to_add_a_user() {
        $this->loginAsAdmin();

        $this->get('/admin/users/create')    // CREATE method
            ->assertStatus(200)
            ->assertSee('<form');
    }

    /** @test */
    public function an_admin_can_submit_a_form_to_add_a_user() {
        $this->loginAsAdmin();

        $user = factory(User::class)->make();

        $request = $user->toArray();
        unset($request['password']);

        $request['password'] = "ho";
        $request['_token'] = csrf_token();
        $this->post('/admin/users', $request) // STORE method
            ->assertStatus(302);

        $this->assertDatabaseHas('users', $user->toArray());
    }

    /** @test */
    public function an_admin_can_edit_a_user() {
        $this->loginAsAdmin();

        $user = factory(User::class)->create();

        $this->get('/admin/users/' . $user->id . '/edit')   // EDIT method
            ->assertStatus(200)
            ->assertSee('<form')
            ->assertSee($user->name);
    }

    /** @test */
    public function an_admin_can_save_changes_to_a_user() {
        $this->loginAsAdmin();

        $user = factory(User::class)->create();
        $id = $user->id;

        $post_data = $user->toArray();
        unset($post_data['id']);

        $post_data['name'] = 'NEW_NAME';
        $post_data['_method'] = 'PATCH';

        $this->post('/admin/users/'. $id, $post_data)   // UPDATE method
        ->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'name' => $post_data['name'],
            'email' => $post_data['email'],
            'id' => $id
        ]);
    }

    /** @test */
    public function an_admin_can_delete_a_user_from_the_db() {
        $this->loginAsAdmin();

        $user = factory(User::class)->create();
        $id = $user->id;

        $post_data = [
            '_method' => 'DELETE',
        ];

        $this->post('/admin/users/'. $id, $post_data)   // UPDATE method
        ->assertStatus(302);
        $this->seeIsSoftDeletedInDatabase('users', [
            'id' => $id
        ]);
    }
}
