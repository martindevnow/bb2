<?php

use Illuminate\Http\Request;
use Martin\Customers\Pet;
use Martin\Subscriptions\Plan;

Route::get('orders', 'OrdersController@index');
Route::post('/orders/{order}/paid', 'OrdersController@storePayment');
Route::post('/orders/{order}/packed', 'OrdersController@markAsPacked');
Route::post('/orders/{order}/picked', 'OrdersController@markAsPicked');
Route::post('/orders/{order}/shipped', 'OrdersController@storeShipment');
Route::post('/orders/{order}/delivered', 'OrdersController@storeDelivery');


Route::get('couriers', 'CouriersController@index');

Route::resource('packages', 'PackagesController');

Route::resource('pets', 'PetsController');

Route::get('meats', 'MeatsController@index');

Route::get('meals', 'MealsController@index');

Route::get('plans', function() {
    return Plan::active()
        ->with(['customer', 'package', 'pet'])
        ->get();
});
Route::post('plans/{plan}/updatePackage', function(Plan $plan, Request $request) {
    $validData = $request->validate([
        'package_id'    => 'required|exists:packages,id',
    ]);

    if ($plan->updatePackage($validData['package_id']))
        return response('Success', 200);
});
Route::post('plans', function(Request $request) {
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
    return $plan;
});

Route::get('purchase-orders', 'PurchaseOrdersController@index');
Route::post('purchase-orders/{purchaseOrder}/ordered', 'PurchaseOrdersController@storeOrdered');
Route::post('purchase-orders/{purchaseOrder}/received', 'PurchaseOrdersController@storeReceived');

Route::resource('users', 'UsersController');
