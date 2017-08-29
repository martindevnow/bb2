<?php

namespace Tests\Api;

use Martin\ACL\User;
use Martin\Core\Address;
use Martin\Customers\Pet;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersApiTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_fetch_the_logged_in_user_object() {
        factory(User::class)->create();

        // TODO: Either this isn't loggin in the user...
        $this->loginAsCustomer();
        // TODO: Or, the middleware here isn't correct...
        $response = $this->get('/api/user')
            ->assertStatus(200);

        $data = $response->decodeResponseJson();

        $this->assertEquals($this->user->toArray(), $data);

    }

    /** @test */
    public function it_can_fetch_a_users_addresses() {
        factory(Address::class)->create();

        $this->loginAsCustomer();
        $address = factory(Address::class, 2)->create();

        $this->user->addresses()->save($address[0]);
        $this->user->addresses()->save($address[1]);

        $response = $this->get('/api/user/addresses')
            ->assertStatus(200);

        $data = $response->decodeResponseJson();
        $this->assertCount(2, $data);
    }

    /** @test */
    public function it_can_fetch_a_users_pets() {
        factory(Pet::class)->create();

        $this->loginAsCustomer();
        $pets = factory(Pet::class, 2)->create([
            'owner_id'  => $this->user->id,
        ]);

        $response = $this->get('/api/user/pets')
            ->assertStatus(200);

        $data = $response->decodeResponseJson();
        $this->assertCount(2, $data);
    }



}
