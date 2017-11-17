<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Martin\Customers\Pet;
use Martin\Products\Meal;
use Martin\Subscriptions\Plan;

class PlansController extends Controller {

    public function index() {
        return Plan::active()
            ->with(['deliveryAddress', 'customer', 'package', 'pet', 'package.meals', 'package.meals.meats'])
            ->get();
    }

    /**
     * Add a new Pet. Their owner must exist
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request) {
        $validData = $request->validate([
            'pet_id'                    => 'required|exists:pets,id',
            'package_id'                => 'required|exists:packages,id',
            'delivery_address_id'       => 'required|exists:addresses,id',
            'shipping_cost'             => 'required|numeric',
            'weekly_cost'               => 'required|numeric',
            'weeks_of_food_per_shipment'    => 'required|integer',
            'ships_every_x_weeks'       => 'required|integer',
            'first_delivery_at'         => 'required|date_format:Y-m-d',
            'payment_method'            => 'required',
        ]);

        $pet = Pet::find($validData['pet_id']);
        $validData['customer_id'] = $pet->owner_id;
        $validData['pet_weight'] = $pet->weight;
        $validData['pet_activity_level'] = $pet->activity_level;

        $plan = Plan::create($validData);
        return $plan->fresh(['customer', 'pet', 'package']);
    }

    /**
     * Add a new Pet. Their owner must exist
     *
     * @param Pet $pet
     * @param Request $request
     * @return mixed
     */
    public function update(Plan $plan, Request $request) {
        $validData = $request->validate([
            'pet_id'                    => 'required|exists:pets,id',
            'package_id'                => 'required|exists:packages,id',
            'delivery_address_id'       => 'required|exists:addresses,id',
            'shipping_cost'             => 'required|numeric',
            'weekly_cost'               => 'required|numeric',
            'weeks_of_food_per_shipment'    => 'required|integer',
            'ships_every_x_weeks'       => 'required|integer',
            'first_delivery_at'         => 'nullable|date_format:Y-m-d',
            'payment_method'            => 'required',
        ]);

        $pet = Pet::find($validData['pet_id']);
        $validData['customer_id'] = $pet->owner_id;
        $validData['pet_weight'] = $pet->weight;
        $validData['pet_activity_level'] = $pet->activity_level;

        $plan->update($validData);
        return $plan->fresh(['customer', 'pet', 'package']);
    }

    /**
     * @param Plan $plan
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function replaceMeal(Plan $plan, Request $request) {
        $validData = $request->validate([
            'removed_meal_id'   => 'required|exists:meals,id',
            'added_meal_id'     => 'required|exists:meals,id',
        ]);

        $removedMeal = Meal::find($validData['removed_meal_id']);
        $addedMeal = Meal::find($validData['added_meal_id']);
        $plan->replaceMeal($removedMeal)->withMeal($addedMeal)->save();

        return response('Success', 200);
    }
}