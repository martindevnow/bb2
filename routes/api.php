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

Route::post('login', 'LoginController@login');
Route::post('register', 'RegisterController@register');

Route::post('/stripe/webhook', 'WebhooksController@handle');

Route::get('user/addresses', function(Request $request) {
    return $request->user()->addresses;
});

Route::get('user/pets', function(Request $request) {
    return $request->user()->pets;
});

Route::get('cart/{hash}', function  ($hash) {
    return ShoppingCart::byHash($hash);
});



Route::post('/subscribe', 'SubscriptionsController@start');
Route::post('/subscribe/details', 'SubscriptionsController@details');



Route::post('github', function(Request $request) {

    Log::info($request->all());

    $requestData = $request->all();
    if ($requestData['ref'] === env('GITHUB_REF')
        && $requestData['repository']['full_name'] === env('GITHUB_FULL_NAME', 'martindevnow/bb2')
    ) {
        echo (`bash ../Martin/update.sh`);
        echo (`echo "v1.0.1" >> version.html`);
        return 'gotcha';
    }

    return "This branch for this Repo is not being deployed.";
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
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

Route::get('sizes', function() {
    return getSizes();
});

Route::get('postal-to-city/{postal}', function($postal) {

    $postal = str_replace(" ", "", $postal);

    //regex against the postal code
    if (preg_match("/^([a-ceghj-npr-tv-z]){1}[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1}$/i", $postal, $postal_code)):

        $api = new GeoHelperMultiGeocoder();
        $rc = $api->geocode($postal_code[0]);

        //get latitude and longitude
        $ll = $rc->ll();
        //set up the query
        $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=$ll&sensor=false";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curlData = curl_exec($curl);
        curl_close($curl);
        //get the address
        $address = json_decode($curlData, TRUE);

        echo $address['results'][0]['formatted_address'];
    endif;
});
