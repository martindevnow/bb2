<?php

use Illuminate\Http\Request;
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

Route::get('purchase-orders', 'PurchaseOrdersController@index');
Route::post('purchase-orders/{purchaseOrder}/ordered', 'PurchaseOrdersController@storeOrdered');
Route::post('purchase-orders/{purchaseOrder}/received', 'PurchaseOrdersController@storeReceived');

Route::resource('users', 'UsersController');
