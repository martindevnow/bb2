<?php

namespace Tests\Unit\ACL;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Martin\ACL\User;
use Martin\Core\Address;
use Martin\Customers\Pet;
use Martin\Subscriptions\Plan;
use Tests\TestCase;

class AddressesUnitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function addresses_have_a_model_factory() {
        $address = factory(Address::class)->create();
        $this->assertTrue($address instanceof Address);
    }

    /** @test */
    public function addresses_can_have_most_fields_mass_assignable() {
        $address = factory(Address::class)->make();
        $addressData = $address->toArray();

        Address::create($addressData);
        $this->assertDatabaseHas('addresses', $addressData);
    }

    /** @test */
    public function addresses_can_be_assigned_to_anything() {
        $address = factory(Address::class)->make();

        $user = factory(User::class)->create();
        $user->addresses()->save($address);

        /** @var Address $userAddress */
        $userAddress = $user->addresses()->first();

        $this->assertTrue($userAddress instanceof Address);
        $this->assertCount(1, $user->addresses);

        $this->assertEquals('user', $userAddress->getAddressableType());
        $this->assertEquals('/admin/'
                . $userAddress->getAddressableType()
                . '/'. $userAddress->addressable_id,
            $userAddress->getUrlToAddressable());
    }
}
