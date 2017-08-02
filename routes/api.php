<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
