<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Martin\Products\Meal;
use Martin\Subscriptions\Package;
use Tests\TestCase;

class PackagesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_is_redirected_from_admin_packages_page() {
        $package = factory(Package::class)->create();

        $this->get('/admin/packages')                  // index
            ->assertStatus(302);

        $this->get('/admin/packages/create')           // create
            ->assertStatus(302);

        $this->get('/admin/packages/' . $package->id)     // show
            ->assertStatus(302);

        $this->get('/admin/packages/' . $package->id . '/edit')     // edit
            ->assertStatus(302);

        $this->post('/admin/packages')                 // store
            ->assertStatus(302);

        $this->patch('/admin/packages/' . $package->id)   // update
            ->assertStatus(302);

        $this->delete('/admin/packages/' . $package->id)  // delete
            ->assertStatus(302);
    }

    /** @test */
    public function an_admin_may_visit_the_admin_packages_page() {
        $this->loginAsAdmin();
        $this->assertTrue($this->user->isAdmin());

        $this->get('/admin/packages')   // INDEX method
            ->assertStatus(200);
    }

    /** TODO: Replace with tests for Vue */
    public function an_admin_can_see_existing_packages_on_the_index() {
        $package = factory(Package::class)->create();
        $this->loginAsAdmin();

        $this->get('/admin/packages')  // INDEX method
            ->assertSee($package->label);
    }

    /** @test */
    public function an_admin_can_view_a_single_package() {
        $this->loginAsAdmin();

        $package = factory(Package::class)->create();

        $this->get('/admin/packages/' . $package->id) // SHOW method
            ->assertSee($package->code);
    }

    /** @test */
    public function meals_are_visible_on_the_individual_package_page() {
        $this->loginAsAdmin();
        $package = factory(Package::class)->create();
        $meal = factory(Meal::class, 3)->create();

        $this->get('/admin/packages/' . $package->id) // SHOW method
            ->assertSee($meal[0]->label)
            ->assertSee($meal[1]->label)
            ->assertSee($meal[2]->label);
    }

    /** @test */
    public function an_admin_can_see_the_form_to_add_a_package() {
        $this->loginAsAdmin();

        $this->get('/admin/packages/create')   // CREATE method
            ->assertStatus(200)
            ->assertSee('<form');
    }

    /** @test */
    public function an_admin_can_submit_a_form_to_add_a_package() {
        $this->loginAsAdmin();

        $package = factory(Package::class)->make();

        $packageData = $package->toArray();
        $packageData['customization'] = $packageData['customization'] ? 'on' : null;

        $this->post('/admin/packages', $packageData);  // STORE method
        $this->assertDatabaseHas('packages', $package->toArray());
    }

    /** @test */
    public function an_admin_can_edit_a_package() {
        $this->loginAsAdmin();

        $package = factory(Package::class)->create();

        $this->get('/admin/packages/' . $package->id . '/edit')   // EDIT method
            ->assertStatus(200)
            ->assertSee('<form')
            ->assertSee($package->label);
    }

    /** @test */
    public function an_admin_can_save_changes_to_a_package() {
        $this->loginAsAdmin();

        $package = factory(Package::class)->create();
        $id = $package->id;

        $post_data = $package->toArray();
        unset($post_data['id']);

        $post_data['label'] = 'NEW_LABEL';
        $post_data['_method'] = 'PATCH';

        $this->post('/admin/packages/'. $id, $post_data)   // UPDATE method
            ->assertStatus(302);
        $this->assertDatabaseHas('packages', [
            'code' => $post_data['code'],
            'label' => $post_data['label'],
            'id' => $id
        ]);
    }

    /** @test */
    public function an_admin_can_delete_a_package_from_the_db() {
        $this->loginAsAdmin();

        $package = factory(Package::class)->create();
        $id = $package->id;

        $post_data = [
            '_method' => 'DELETE',
        ];

        $this->post('/admin/packages/'. $id, $post_data)   // UPDATE method
            ->assertStatus(302);
        $this->seeIsSoftDeletedInDatabase('packages', [
            'id' => $id
        ]);
    }

    /** @test */
    public function an_admin_can_update_the_calendar() {
        $this->loginAsAdmin();

        $package = factory(Package::class)->create();
        $meals = factory(Meal::class, 2)->create();

        $post_data = [];
        $post_data['selected-1B'] = $meals[0]->id;
        $post_data['selected-2B'] = $meals[0]->id;
        $post_data['selected-3B'] = $meals[0]->id;
        $post_data['selected-4B'] = $meals[0]->id;
        $post_data['selected-5B'] = $meals[0]->id;
        $post_data['selected-6B'] = $meals[0]->id;
        $post_data['selected-7B'] = $meals[0]->id;
        $post_data['selected-1D'] = $meals[1]->id;
        $post_data['selected-2D'] = $meals[1]->id;
        $post_data['selected-3D'] = $meals[1]->id;
        $post_data['selected-4D'] = $meals[1]->id;
        $post_data['selected-5D'] = $meals[1]->id;
        $post_data['selected-6D'] = $meals[1]->id;
        $post_data['selected-7D'] = $meals[1]->id;
        $post_data['_method'] = 'PUT';

        $this->post('/admin/packages/' . $package->id . '/updateCalendar', $post_data)
            ->assertStatus(302);

        $this->assertDatabaseHas('meal_package', [
            'package_id' => $package->id,
            'meal_id'   => $meals[0]->id,
            'calendar_code' => '1B'
        ]);
        $this->assertDatabaseHas('meal_package', [
            'package_id' => $package->id,
            'meal_id'   => $meals[1]->id,
            'calendar_code' => '1D'
        ]);
    }

}
