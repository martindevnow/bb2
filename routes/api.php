<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Martin\Geo\GeoHelperMultiGeocoder;
use Martin\Transactions\ShoppingCart;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/**
 * Authentication via Ajax request
 */
Route::post('login', 'LoginController@login');
Route::post('register', 'RegisterController@register');

/**
 * Stripe's WebHook Endpoint
 */
Route::post('/stripe/webhook', 'WebhooksController@handle');

/**
 * User Related Functions
 */
// TODO: Double check all the middleware being applied to the API routes..
// Confirm is applying this middleware here is required...
// Probably need to put some of these behind the AUTH middleware...
// No need to expose every endpoint.. many will fail if there is no user() object.
Route::middleware('auth:api')
     ->get('/user', 'UsersController@user');
Route::get('/user/addresses', 'UsersController@addresses');
Route::get('/user/pets', 'UsersController@pets');

/**
 * Shopping Cart Functions
 */
Route::get('cart/{hash}', 'ShoppingCartsController@cartByHash');

/**
 * Subscription Specific Functions
 */
Route::post('/subscribe', 'SubscriptionsController@start');
Route::post('/subscribe/details', 'SubscriptionsController@details');

/**
 * Used for Pricing Model
 */
Route::get('/sizes', 'SubscriptionsController@sizes');

/**
 * GitHub WebHook Endpoint
 */
Route::post('github', 'GitHubController@handle');



Route::get('meats', function() {
    return \Martin\Products\Meat::all();
});

Route::get('meals', function() {
    return \Martin\Products\Meal::all();
});

Route::get('packages', function() {
    return \Martin\Subscriptions\Package::all()->map(function($pkg, $index) {
        /** @var \Martin\Subscriptions\Package $pkg */
        $pkg->costPerLb = round($pkg->costPerLb() * 1.2, 2);
        return $pkg;
    });
});