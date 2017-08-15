<?php

namespace Tests\Unit\ACL;

use Carbon\Carbon;
use Martin\ACL\User;
use Martin\Core\Address;
use Martin\Customers\Pet;
use Martin\Subscriptions\Plan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersUnitTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function users_have_a_model_factory() {
        $user = factory(User::class)->create();
        $this->assertTrue($user instanceof User);
    }

    /** @test */
    public function users_can_have_most_fields_mass_assignable() {
        $user = factory(User::class)->make();

        $userData = $user->toArray();

        // Add the 'hidden' fields
        $userData['password'] = '12345';

        User::create($userData);
        $this->assertDatabaseHas('users', $userData);
    }

    /** @test */
    public function it_has_all_fields_assignable() {
        $time = Carbon::now();
        $userData = [
            'name'                  => 'name',
            'email'                 => 'email@email.com',
            'password'              => 'pass',
            'stripe_customer_id'    => 'testing...',
            'stripe_active'         => true,
            'subscription_end_at'   => $time,
        ];
        $user = factory(User::class)->create($userData);

        $this->assertEquals('name', $user->name);
        $this->assertEquals('email@email.com', $user->email);
        $this->assertEquals('pass', $user->password);
        $this->assertEquals('testing...', $user->stripe_customer_id);
        $this->assertEquals(true, $user->stripe_active);
        $this->assertEquals($time, $user->subscription_end_at);
    }

    /** @test */
    public function it_has_all_fields_fillable() {
        $time = Carbon::now();
        $userData = [
            'name'                  => 'name',
            'email'                 => 'email@email.com',
            'password'              => 'pass',
            'stripe_customer_id'    => 'testing...',
            'stripe_active'         => true,
            'subscription_end_at'   => $time,
        ];
        $user = factory(User::class)->create($userData);
        $this->assertDatabaseHas('users', $userData);
    }

    /** @test */
    public function a_user_has_many_pets_that_belongs_to_the_user() {
        $user = factory(User::class, 2)->create();
        $pet = factory(Pet::class, 2)->create();

        $user[0]->pets()->save($pet[0]);

        $this->assertCount(1, $user[0]->pets);

        $user[0]->pets()->save($pet[1]);
        $user[0] = $user[0]->fresh(['pets']);
        $this->assertCount(2, $user[0]->pets);
    }

    /** @test */
    public function a_user_has_many_plans_that_belongs_to_the_user() {
        $user = factory(User::class, 2)->create();
        $plan = factory(Plan::class, 2)->create();

        $user[0]->plans()->save($plan[0]);

        $this->assertCount(1, $user[0]->plans);

        $user[0]->plans()->save($plan[1]);
        $user[0] = $user[0]->fresh(['plans']);
        $this->assertCount(2, $user[0]->plans);
    }

    /** @test */
    public function users_can_retrieve_pets_by_id() {
        $user = factory(User::class)->create();
        $pets = factory(Pet::class, 3)->create([
            'owner_id'  => $user->id
        ]);

        $this->assertCount(3, $user->pets);
        $this->assertTrue($user->getPetById($pets[0]->id) instanceof Pet);
    }

    /** @test */
    public function users_can_retrieve_a_string_with_all_pets_names() {
        $user = factory(User::class)->create();
        $pets = factory(Pet::class, 3)->create([
            'owner_id'  => $user->id
        ]);

        $this->assertTrue(stripos($user->getPets(), $pets[0]->name) !== false);
        $this->assertTrue(stripos($user->getPets(), $pets[1]->name) !== false);
        $this->assertTrue(stripos($user->getPets(), $pets[2]->name) !== false);
    }

    /**
     * Addresses
     */

    /** @test */
    public function a_user_can_have_many_addresses_to_assign_to_a_plan() {
        $user = factory(User::class)->create();
        $user->addresses()->save(factory(Address::class)->make());

        $user = $user->fresh(['addresses']);
        $this->assertCount(1, $user->addresses);
    }
}
