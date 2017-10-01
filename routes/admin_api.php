<?php

// Orders
use Martin\ACL\User;
use Martin\Customers\Pet;
use Martin\Delivery\Courier;
use Martin\Products\Meat;
use Martin\Subscriptions\Package;
use Martin\Transactions\Order;

Route::get('orders', function () {
    return Order::with('customer', 'plan.pet', 'plan', 'plan.package', 'deliveryAddress')->get();
});

Route::post('/orders/{order}/paid', 'OrdersController@storePayment');
Route::post('/orders/{order}/packed', 'OrdersController@markAsPacked');
Route::post('/orders/{order}/picked', 'OrdersController@markAsPicked');
Route::post('/orders/{order}/shipped', 'OrdersController@storeShipment');
Route::post('/orders/{order}/delivered', 'OrdersController@storeDelivery');


Route::get('couriers', function() {
    return Courier::all();
});

Route::get('packages', function() {
    return Package::all();
});

Route::resource('pets', 'PetsController');

Route::get('meats', function() {
    return Meat::all();
});

Route::get('users', function() {
    return User::all();
});
