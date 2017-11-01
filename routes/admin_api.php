<?php

use Illuminate\Http\Request;
use Martin\Customers\Pet;
use Martin\Products\Topping;
use Martin\Subscriptions\Package;
use Martin\Subscriptions\Plan;

Route::get('orders', 'OrdersController@index');
Route::post('/orders/{order}/paid', 'OrdersController@storePayment');
Route::post('/orders/{order}/packed', 'OrdersController@markAsPacked');
Route::post('/orders/{order}/picked', 'OrdersController@markAsPicked');
Route::post('/orders/{order}/shipped', 'OrdersController@storeShipment');
Route::post('/orders/{order}/delivered', 'OrdersController@storeDelivery');


Route::get('couriers', 'CouriersController@index');

Route::resource('packages', 'PackagesController');
Route::patch('packages/{package}/mealPlan', function(Package $package, Request $request) {
    $meals = $request->get('meals');
    $package->removeAllMeals();
    foreach ($meals as $meal) {
        if ($meal['id'])
            $package->addMeal($meal['id'], $meal['calendar_code']);
//        else
//            $package->removeMeal($meal['calendar_code']);
    }
    return $package->fresh(['meals']);
});

Route::resource('pets', 'PetsController');

Route::resource('meats', 'MeatsController');

Route::resource('meals', 'MealsController');

Route::resource('plans', 'PlansController');

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

Route::get('toppings', function() {
    return Topping::all();
});

Route::resource('users', 'UsersController');
