<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;

Auth::routes();

Route::get('/version', function () {
    return 'v1.0.1';
});

Route::get('/', 'PagesController@index');
Route::get('/home', 'PagesController@index');
Route::get('/index', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/shipping', 'PagesController@shipping');

Route::get('/faq', 'FaqController@index');

Route::get('/cart', 'CartController@index');
Route::get('/contact', 'ContactController@index');
Route::post('/contact/send', 'ContactController@send');
Route::get('/contact/success', 'ContactController@success');
Route::get('/packages', 'PackagesController@index');


Route::get('/quote/subscribe/{hash}', 'QuoteController@subscribe');
Route::get('/quote/details/{hash}', 'QuoteController@details');
Route::get('/quote/confirm/{hash}', 'QuoteController@confirm');

Route::get('/quote/calculator', 'QuoteController@calculator');
Route::get('/quote', 'QuoteController@index');

Route::resource('/treats', 'TreatsController');


Route::post('/plans/subscribe', 'PlansController@subscribe');

Route::get('camera', function () {
    return view('camera');
});

Route::post('camera', function(Request $request) {

//    dd ($request);
    $path = $request->file('photo')
        ->storeAs('images', 'file.jpg');
    dd ($path);

});