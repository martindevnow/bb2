<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Martin\Customers\Pet;
use Martin\Subscriptions\Plan;

class PlansController extends Controller {

    public function index() {
        return Plan::active()
            ->with(['customer', 'package', 'pet'])
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
}