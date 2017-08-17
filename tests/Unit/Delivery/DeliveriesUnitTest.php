<?php

namespace Tests\Unit\Delivery;

use Carbon\Carbon;
use Martin\ACL\User;
use Martin\Delivery\Courier;
use Martin\Delivery\Delivery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeliveriesUnitTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_delivery_has_a_model_factory() {
        $delivery = factory(Delivery::class)->create();
        $this->assertTrue($delivery instanceof Delivery);
    }

    /** @test */
    public function a_delivery_has_all_fields_mass_assignable() {
        $delivery = factory(Delivery::class)->make();

        $delivery_DB = Delivery::create($delivery->toArray());

        $this->assertEquals($delivery->deliverer_id, $delivery_DB->deliverer_id);
        $this->assertEquals($delivery->recipient_id, $delivery_DB->recipient_id);
        $this->assertEquals($delivery->shipped_at, $delivery_DB->shipped_at);
        $this->assertEquals($delivery->delivered_at, $delivery_DB->delivered_at);
        $this->assertEquals($delivery->courier_id, $delivery_DB->courier_id);
        $this->assertEquals($delivery->tracking_number, $delivery_DB->tracking_number);
        $this->assertEquals($delivery->instructions, $delivery_DB->instructions);
        $this->assertEquals($delivery->days_of_food_delivered, $delivery_DB->days_of_food_delivered);
        $this->assertEquals($delivery->deliverable_id, $delivery_DB->deliverable_id);
        $this->assertEquals($delivery->deliverable_type, $delivery_DB->deliverable_type);
    }


    /**
     * Dates
     */

    /** @test */
    public function it_returns_date_fields_as_carbon() {
        $delivery = factory(Delivery::class)->create();

        $this->assertTrue($delivery->shipped_at instanceof Carbon);
        $this->assertTrue($delivery->delivered_at instanceof Carbon);
    }

    // TODO: Think about how to implement the Delivery model with the order.....
    // When should the delivery model be created, and who owns it....
    //
    /**
     * Relationships
     */

    /** @test */
    public function it_has_a_delivery_recipient() {
        $user = factory(User::class)->create();
        $delivery = factory(Delivery::class)->create([
            'recipient_id'  => $user->id
        ]);

        $this->assertEquals($delivery->recipient->id, $user->id);
    }

    /** @test */
    public function it_has_a_delivery_courier() {
        $courier = factory(Courier::class)->create();
        $delivery = factory(Delivery::class)->create([
            'courier_id'  => $courier->id
        ]);

        $this->assertEquals($delivery->courier->id, $courier->id);
    }


}
