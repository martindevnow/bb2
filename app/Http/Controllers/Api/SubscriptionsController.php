<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Martin\Subscriptions\CostModel;
use Martin\Subscriptions\Package;
use Martin\Transactions\ShoppingCart;

class SubscriptionsController extends Controller
{
    public function __construct() {}

    public function sizes() {
        return CostModel::all();
    }

    public function start(Request $request) {
        $this->validate($request, [
            'weight'            => 'required|integer',
            'package_id'        => 'required|exists:packages,id',
            'shipping_modifier' => 'required|integer'
        ]);

        $cart = ShoppingCart::build(
            $request->get('weight'),
            $request->get('package_id'),
            $request->get('shipping_modifier')
        );
        return $cart->hash;
    }

    public function details(Request $request) {
        $this->validate($request, [
            'hash'      => 'required|exists:shopping_carts,hash',
            'pet'       => 'required',
            'address'   => 'required',
        ]);

        $cart = ShoppingCart::byHash($request->get('hash'));

        /** @var Package $package */
        $package = Package::findOrFail($cart->sub_package_id);

        $pet = $request->user()->pets()->create([
            'name'     => $request->get('pet')['name'],
            'weight'    => $cart->sub_weight,
            'breed'     => $request->get('pet')['breed'],
            'species'   => 'dog',
            'activity_level'    => 2,
        ]);

        $addressData = $request->get('address');
        $address = $request->user()->addresses()->create([
            'street_1'  => $addressData['street_1'],
            'street_2'  => array_key_exists('street_2',
                $addressData) ? $addressData['street_2'] : '',
            'city'  => $addressData['city'],
            'province'  => $addressData['province'],
            'country'  => $addressData['country'],
            'postal_code'  => $addressData['postal'],
        ]);

        $plan = $request->user()->plans()->create([
            'shipping_cost' => 20,
            'pet_id'    => $pet->id,
            'pet_weight'    => $pet->weight,
            'pet_activity_level'    => 2,
            'package_id'    => $cart->sub_package_id,
            'weekly_cost'   => calculateCost($pet->weight, $package),
            'weeks_of_food_per_shipment'   => weeksAtATime($cart->sub_shipping_modifier),
            'hash'  => $request->get('hash'),
        ]);

        return $plan;
    }

}
