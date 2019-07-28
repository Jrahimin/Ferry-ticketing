<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/port/all', 'PortController@allApi');
Route::get('/', 'HomeController@indexApi')->name('index');
Route::get('/trip/search', 'HomeController@searchApi')->name('search_trip');
Route::get('/trip/all', 'TripController@all')->name('view_all_trip');
Route::get('/trip/upcoming', 'TripController@upcomingTripsApi');

Route::get('/booking/passenger-details', 'TicketBookingController@passengerDetailsApi')->name('passenger_details');
Route::get('/booking/check', 'TicketBookingController@checkTicketApi');
Route::post('login', 'UserController@loginApi');