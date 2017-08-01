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

    if ($request->ref === env('GITHUB_REF')) {
        Log::info(`bash ../Martin/update.sh`);
    }

    echo `echo "v1.0.1" >> version.html`;
    return 'gotcha';

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
