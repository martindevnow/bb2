<?php

Route::get('/', function () {
    return view('admin.index');
});

// Deliveries
Route::resource('/deliveries', 'DeliveriesController');

// FAQs
Route::resource('/faqs', 'FaqsController');

// Meals
Route::resource('/meals', 'MealsController');
Route::post('/meals/{meal}/addMeat', 'MealsController@addMeat');
Route::post('/meals/{meal}/removeMeat', 'MealsController@removeMeat');
Route::post('/meals/{meal}/addTopping', 'MealsController@addTopping');
Route::post('/meals/{meal}/removeTopping', 'MealsController@removeTopping');

// Meats
Route::resource('/meats', 'MeatsController');

// Orders
Route::get('/orders/{order}/paid', 'OrdersController@createPayment');
Route::post('/orders/{order}/paid', 'OrdersController@storePayment');
Route::get('/orders/{order}/packed', 'OrdersController@markAsPacked');
Route::get('/orders/{order}/picked', 'OrdersController@markAsPicked');

Route::get('/orders/{order}/shipped', 'OrdersController@createShipment');
Route::post('/orders/{order}/shipped', 'OrdersController@storeShipment');

Route::get('/orders/{order}/delivered', 'OrdersController@createDelivery');
Route::post('/orders/{order}/delivered', 'OrdersController@storeDelivery');

Route::get('/orders/export/view/{perPage}', 'OrdersController@exportView');
Route::get('/orders/export/{status}/{perPage}', 'OrdersController@export');

Route::post('/orders/{order}/packed', 'OrdersController@packed');
Route::resource('/orders', 'OrdersController');

// Packages
Route::resource('/packages', 'PackagesController');
Route::post('/packages/{package}/setMeal', 'PackagesController@setMeal');
Route::put('/packages/{package}/updateCalendar', 'PackagesController@updateCalendar');

// Payments
Route::resource('/payments', 'PaymentsController');

// Pets
Route::resource('/pets', 'PetsController');

// Plans
Route::resource('/plans', 'PlansController');

// Toppings
Route::resource('/toppings', 'ToppingsController');

// Users
Route::resource('/users', 'UsersController');


