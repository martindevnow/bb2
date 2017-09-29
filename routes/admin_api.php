<?php

// Orders
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


Route::get('packages', function() {
    return Package::all();
});
