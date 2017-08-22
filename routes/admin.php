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
Route::get('/orders/export', 'OrdersController@export');
Route::get('/orders/export/view', 'OrdersController@exportView');
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


