<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Martin\Customers\Pet;
use Martin\Subscriptions\Package;
use Martin\Subscriptions\Plan;
use Tests\TestCase;

class PlansTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_is_redirected_from_admin_plans_page() {
        $plan = factory(Plan::class)->create();

        $this->get('/admin/plans')                  // index
            ->assertStatus(302);

        $this->get('/admin/plans/create')           // create
            ->assertStatus(302);

        $this->get('/admin/plans/' . $plan->id)     // show
            ->assertStatus(302);

        $this->get('/admin/plans/' . $plan->id . '/edit')     // edit
            ->assertStatus(302);

        $this->post('/admin/plans')                 // store
            ->assertStatus(302);

        $this->patch('/admin/plans/' . $plan->id)   // update
            ->assertStatus(302);

        $this->delete('/admin/plans/' . $plan->id)  // delete
            ->assertStatus(302);
    }

    /** @test */
    public function an_admin_may_visit_the_admin_plans_page() {
        $this->loginAsAdmin();
        $this->assertTrue($this->user->isAdmin());

        $this->get('/admin/plans')   // INDEX method
            ->assertStatus(200);
    }

    /** @test */
    public function an_admin_can_see_existing_plans_on_the_index() {
        $plan = factory(Plan::class)->create();
        $this->loginAsAdmin();


        $this->get('/admin/plans')   // INDEX method
            ->assertSee($plan->customer->name)
            ->assertSee($plan->pet->name)
            ->assertSee($plan->package->label);
    }

    /** @test */
    public function an_admin_can_view_a_single_plan() {
        $this->loginAsAdmin();

        $plan = factory(Plan::class)->create();

        $this->get('/admin/plans/' . $plan->id)     // SHOW method
            ->assertSee($plan->customer->name)
            ->assertSee($plan->pet->name)
            ->assertSee("".$plan->pet_weight);
    }

    /** @test */
    public function an_admin_can_see_the_form_to_add_a_plan() {
        $this->loginAsAdmin();

        $this->get('/admin/plans/create')    // CREATE method
            ->assertStatus(200)
            ->assertSee('<form');
    }

    /** @test */
    public function an_admin_can_submit_a_form_to_add_a_plan() {
        $this->loginAsAdmin();

        $pet = factory(Pet::class)->create();
        $package = factory(Package::class)->create();

        $planData = [
            'package_id' => $package->id,
            'customer_id' => $pet->owner_id,
            'pet_id'    => $pet->id,
            'shipping_cost' => 20,
            'weekly_cost' => 20,
            'weeks_of_food_per_shipment' => 1,
            'active'    => 1,
        ];

        $request = $planData;
        $request['_token'] = csrf_token();

        $this->post('/admin/plans', $request) // STORE method
            ->assertStatus(302);
        unset($request['_token']);

        // Adjust for the mutation on activity_level
        $request['weekly_cost'] *= 100;
        $request['shipping_cost'] *= 100;
        $this->assertDatabaseHas('plans', $request);
    }

    /** @test */
    public function an_admin_can_edit_a_plan() {
        $this->loginAsAdmin();

        $plan = factory(Plan::class)->create();

        $this->get('/admin/plans/' . $plan->id . '/edit')   // EDIT method
            ->assertStatus(200)
            ->assertSee('<form')
            ->assertSee($plan->pet->owner->name);
    }

    // TODO: Clean up this POSt request too...
    /** @test */
    public function an_admin_can_save_changes_to_a_plan() {
        $this->loginAsAdmin();

        $plan = factory(Plan::class)->create();
        $id = $plan->id;

        $post_data = $plan->toArray();
        unset($post_data['id']);

        $post_data['package_stripe_code'] = 'THIS_IS_NOT_RIGHT';
        $post_data['_method'] = 'PATCH';

        $this->post('/admin/plans/'. $id, $post_data)   // UPDATE method
            ->assertStatus(302);
        $this->assertDatabaseHas('plans', [
            'package_stripe_code' => $post_data['package_stripe_code'],
            'id' => $id
        ]);
    }

    /** @test */
    public function an_admin_can_delete_a_plan_from_the_db() {
        $this->loginAsAdmin();

        $plan = factory(Plan::class)->create();
        $id = $plan->id;

        $post_data = [
            '_method' => 'DELETE',
        ];

        $this->post('/admin/plans/'. $id, $post_data)   // UPDATE method
        ->assertStatus(302);
        $this->seeIsSoftDeletedInDatabase('plans', [
            'id' => $id
        ]);
    }
}
