<?php

Route::get('/', function () {
    return view('admin.index');
});

//Route::resource('/deliveries',      'DeliveriesController');
Route::resource('/meats',           'MeatsController');
Route::resource('/meals',           'MealsController');
//Route::resource('/payments',        'PaymentsController');
//Route::resource('/pets',            'PetsController');
//Route::resource('/subscriptions',   'SubscriptionsController');
//Route::resource('/subpackages',     'SubpackagesController');
//Route::resource('/users',           'UsersController');

