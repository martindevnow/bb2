<?php

Route::get('/', function () {
    return view('admin.index');
});

//Route::resource('/deliveries',      'DeliveriesController');

Route::resource('/packages', 'PackagesController');
Route::post('/packages/{package}/setMeal', 'PackagesController@setMeal');
Route::put('/packages/{package}/updateCalendar', 'PackagesController@updateCalendar');
Route::resource('/meats', 'MeatsController');
Route::resource('/toppings', 'ToppingsController');
Route::resource('/meals', 'MealsController');
Route::post('/meals/{meal}/addMeat', 'MealsController@addMeat');
Route::post('/meals/{meal}/removeMeat', 'MealsController@removeMeat');
Route::post('/meals/{meal}/addTopping', 'MealsController@addTopping');
Route::post('/meals/{meal}/removeTopping', 'MealsController@removeTopping');

//Route::resource('/payments',        'PaymentsController');
//Route::resource('/pets',            'PetsController');
//Route::resource('/subscriptions',   'SubscriptionsController');
//Route::resource('/subpackages',     'SubpackagesController');
//Route::resource('/users',           'UsersController');

