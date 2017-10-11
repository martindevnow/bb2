<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Facades\DB;
use Martin\ACL\Role;
use Martin\ACL\User;
use Martin\Customers\Pet;
use Martin\Products\Meal;
use Martin\Products\Meat;
use Martin\Subscriptions\Package;
use Martin\Subscriptions\Plan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use SupportsSoftDeletes;

    public $user;

    public function createAdminUser() {
        $role = factory(Role::class)->create(['code' => 'admin']);
        $this->user = factory(User::class)->create();
        $this->user->assignRole($role);
        return $this->user = $this->user->fresh(['roles']);
    }

    public function createCustomer() {
        return $this->user = factory(User::class)->create();
    }

    public function loginAsAdmin() {
        $this->createAdminUser();
        $this->be($this->user);
    }

    public function loginAsCustomer() {
        $this->createCustomer();
        $this->be($this->user);
    }

    protected function followRedirects(TestResponse $response)
    {
        while ($response->isRedirect()) {
            $response = $this->get($response->headers->get('Location'));
        }

        return $response;
    }

    public function tearDown()
    {
        $this->beforeApplicationDestroyed(function () {
            DB::disconnect();
        });

        parent::tearDown();
    }

    /**
     * @return mixed
     */
    public function createPlanForBasicBento($overrides = []) {
        $package = factory(Package::class)->create([
            'code'  => 'Basic Package',
        ]);

        $chkMeal = factory(Meal::class)->create([
            'code'  => 'chickenMeal',
        ]);
        $turkMeal = factory(Meal::class)->create([
            'code'  => 'chickenMeal',
        ]);

        $chickenCost = 1;
        $turkeyCost = 6;

        $chicken = factory(Meat::class)->create([
            'code'  => 'chicken',
            'cost_per_lb' => $chickenCost
        ]);
        $turkey = factory(Meat::class)->create([
            'code'  => 'turkey',
            'cost_per_lb' => $turkeyCost
        ]);

        $chkMeal->addMeat($chicken);
        $turkMeal->addMeat($turkey);

        $package->addMeal($chkMeal, '1B');
        $package->addMeal($chkMeal, '2B');
        $package->addMeal($chkMeal, '3B');
        $package->addMeal($chkMeal, '4B');
        $package->addMeal($chkMeal, '5B');
        $package->addMeal($chkMeal, '6B');
        $package->addMeal($chkMeal, '7B');
        $package->addMeal($turkMeal, '1B');
        $package->addMeal($turkMeal, '2B');
        $package->addMeal($turkMeal, '3B');
        $package->addMeal($turkMeal, '4B');
        $package->addMeal($turkMeal, '5B');
        $package->addMeal($turkMeal, '6B');
        $package->addMeal($turkMeal, '7B');
        $package = $package->fresh(['meals']);

        $pet = factory(Pet::class)->create(['weight' => 50, 'activity_level'=> 2]);

        $data = array_merge([
            'package_id'    => $package->id,
            'weeks_of_food_per_shipment'   => 2,
            'ships_every_x_weeks'   => 2,
            'pet_weight'    => $pet->weight,
            'pet_id'    => $pet->id,
            'pet_activity_level'    => $pet->activity_level,
        ], $overrides);

        /** @var Plan $plan */
        return factory(Plan::class)->create($data);
    }

    /**
     * @return mixed
     */
    public function createOrderForBasicPlan() {
        /** @var Plan $plan */
        $plan = $this->createPlanForBasicBento();

        $plan->generateOrder();
        return $plan->orders->first();
    }
}
