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

use App\EventItem;

Auth::routes();

Route::get('/version', function () {
    return 'v1.0.0';
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

Route::get('schedule/preview2', function() {
    $fridayEvents = EventItem::where('day', '=', 'Friday')->get();
    $saturdayEvents = EventItem::where('day', '=', 'Saturday')->get();

//    dd($fridayEvents->toArray());
    return view('oobs-html2')
        ->with(compact('fridayEvents', 'saturdayEvents'));
});
Route::get('schedule/preview', function() {
    $fridayEvents = EventItem::where('day', '=', 'Friday')->get();
    $saturdayEvents = EventItem::where('day', '=', 'Saturday')->get();

    return view('oobs-html')
        ->with(compact('fridayEvents', 'saturdayEvents'));
});
Route::get('schedule', function() {
    $fridayEvents = EventItem::where('day', '=', 'Friday')
        ->orderBy('time', 'ASC')
        ->get();
    $saturdayEvents = EventItem::where('day', '=', 'Saturday')
        ->orderBy('time', 'ASC')
        ->get();
    return view('oobs')
        ->with(compact('fridayEvents', 'saturdayEvents'));
});