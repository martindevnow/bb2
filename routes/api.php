<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Martin\Geo\GeoHelperMultiGeocoder;
use Martin\Transactions\Order;
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
Route::get('/user', 'UsersController@user');
Route::get('/user/addresses', 'UsersController@addresses');
Route::get('/user/pets', 'UsersController@pets');
Route::post('/user/pets', function(Request $request) {

    $requestData = $request->validate([
        'name'  => 'required',
        'breed' => 'required',
        'weight'    => 'required|numeric',
    ]);

    $request->user()->pets()->create($requestData);
    return $request->user()->pets;
});
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

Route::get('products', function() {
    return [
     'id' => 1,
     'manId' => 3,
     'name' => 'Samsung S7 Edge',
     'price' => 659,
     'image' => 'http://www.brandsmartusa.com/images/product/large/20208018.jpg',
     'description' => '5.5" Quad HD Super AMOLED | 12 MP Phase Detection Autofocus Rear Camera / 5 MP Front Facing Camera | Android Marshmallow 6.0 | Wi-Fi 802.11 a/b/g/n/ac, Dual-Band, Wi-Fi Direct, Hotspot | Water-Resistant Features an IP68 Rating (30 Min. In 1m Of Water) | Low-Light Camera | Expandable Storage Up To 200 GB | Samsung Pay',
     'manufacturer' => [
       'id' => 3,
       'name' => 'Samsung'
     ]
   ];
});




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

/**
 * Return the cost model for the different sizes
 */
Route::get('pricing', function() {
    return \Martin\Subscriptions\CostModel::all();
});




/**
 * Admin Specific
 */

Route::get('orders', function () {
    return Order::with('customer', 'plan.pet', 'plan', 'plan.package', 'deliveryAddress')->get();
});