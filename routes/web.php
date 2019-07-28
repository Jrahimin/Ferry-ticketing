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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', ['as'=>'home', 'uses' => 'Admin\HomeController@index']);
Route::get('/company_home', ['as'=>'CompanyHome', 'uses' => 'Company\HomeController@index']);

Route::post('/login',['as'=>'userLogin', 'uses'=>'UserAuthenticationController@Login']);

// Home
Route::get('/', 'HomeController@index')->name('index');
Route::get('/trip/search', 'HomeController@search')->name('search_trip');

// Ticket Booking
Route::get('/booking/passenger-details', 'TicketBookingController@passengerDetails')->name('passenger_details');
Route::post('/booking/passenger-details/post', 'TicketBookingController@passengerDetailsPost')->name('passenger_details_post');

// Company
Route::get('/company/all', 'CompanyController@all')->name('view_all_company')->middleware('admin');
Route::get('/company/add', 'CompanyController@add')->name('add_company')->middleware('admin');
Route::post('/company/add', 'CompanyController@addPost')->name('add_company_post')->middleware('admin');
Route::get('/company/edit/{company}', 'CompanyController@edit')->name('edit_company')->middleware('company_user');
Route::post('/company/edit/{company}', 'CompanyController@editPost')->name('edit_company_post')->middleware('company_user');
Route::post('/company/delete', 'CompanyController@delete')->name('delete_company')->middleware('admin');

// Users
Route::get('/user/all', 'UserController@all')->name('view_all_user')->middleware('company_user');
Route::get('/user/add', 'UserController@add')->name('add_user')->middleware('company_user');
Route::post('/user/add', 'UserController@addPost')->name('add_user_post')->middleware('company_user');
Route::get('/user/edit/{user}', 'UserController@edit')->name('edit_user')->middleware('company_user');
Route::post('/user/edit/{user}', 'UserController@editPost')->name('edit_user_post')->middleware('company_user');
Route::post('/user/delete', 'UserController@delete')->name('delete_user')->middleware('company_user');

// Port
Route::get('/port/all', 'PortController@all')->name('view_all_port')->middleware('admin');
Route::get('/port/add', 'PortController@add')->name('add_port')->middleware('admin');
Route::post('/port/add', 'PortController@addPost')->name('add_port_post')->middleware('admin');
Route::get('/port/edit/{port}', 'PortController@edit')->name('edit_port')->middleware('admin');
Route::post('/port/edit/{port}', 'PortController@editPost')->name('edit_port_post')->middleware('admin');
Route::post('/port/delete', 'PortController@delete')->name('delete_port')->middleware('admin');

// Passenger Type
Route::get('/passenger-type/all', 'PassengerTypeController@all')->name('view_all_passenger_type')->middleware('admin');
Route::get('/passenger-type/add', 'PassengerTypeController@add')->name('add_passenger_type')->middleware('admin');
Route::post('/passenger-type/add', 'PassengerTypeController@addPost')->name('add_passenger_type_post')->middleware('admin');
Route::get('/passenger-type/edit/{type}', 'PassengerTypeController@edit')->name('edit_passenger_type')->middleware('admin');
Route::post('/passenger-type/edit/{type}', 'PassengerTypeController@editPost')->name('edit_passenger_type_post')->middleware('admin');
Route::post('/passenger-type/delete', 'PassengerTypeController@delete')->name('delete_passenger_type')->middleware('admin');

// Ferry
Route::get('/ferry/all', 'FerryController@all')->name('view_all_ferry')->middleware('company_user');
Route::get('/ferry/add', 'FerryController@add')->name('add_ferry')->middleware('company_user');
Route::post('/ferry/add', 'FerryController@addPost')->name('add_ferry_post')->middleware('company_user');
Route::get('/ferry/edit/{ferry}', 'FerryController@edit')->name('edit_ferry')->middleware('company_user');
Route::post('/ferry/edit/{ferry}', 'FerryController@editPost')->name('edit_ferry_post')->middleware('company_user');
Route::post('/ferry/delete', 'FerryController@delete')->name('delete_ferry')->middleware('company_user');

// Trip
Route::get('/trip/all', 'TripController@all')->name('view_all_trip')->middleware('company_user');
Route::get('/trip/add', 'TripController@add')->name('add_trip')->middleware('company_user');
Route::post('/trip/add', 'TripController@addPost')->name('add_trip_post')->middleware('company_user');
Route::post('/trip/delete', 'TripController@delete')->name('delete_trip')->middleware('company_user');
Route::get('/trip/edit/{trip}', 'TripController@edit')->name('edit_trip')->middleware('company_user');
Route::post('/trip/edit/{trip}', 'TripController@editPost')->name('edit_trip_post')->middleware('company_user');





Route::get('/ferry_booking_customer',['as'=>'customerWelcome',  'uses'=>'Customer\CustomerWelcomeController@WelcomePage']);
Route::get('customer_error',['as'=>'errorCustomer','uses'=>'Customer\ErrorController@ShowError']);
Route::get('passenger_details_form',['as'=>'passengerDetails','uses'=>'Customer\CustomerBookingController@PassengerDetails']);
Route::post('booking_seat_by_user',['as'=>'insertBookings',  'uses'=>'Customer\CustomerBookingController@Booking']);
Route::post('ticket_collector_information',['as'=>'ticketCollectorInfo', 'uses'=>'Customer\CustomerBookingController@TicketCollector' ]);
Route::get('payment_successful',['as'=>'successPage', 'uses'=>'Customer\CustomerBookingController@PaymentSuccessful' ]);
Route::post('payment_successful',['as'=>'ticketPrint', 'uses'=>'Customer\CustomerBookingController@TicketPrint' ]);


//JR Routes...

Route::post('/booking/ticket_store', 'TicketBookingController@storeTicket')->name('ticketStore');
Route::get('/booking/success', 'TicketBookingController@storeTicket')->name('success');
Route::post('/booking/print', 'TicketBookingController@ticketPrint')->name('ticketPrint');

Route::get('/ticket/all', 'TicketObserveController@getAllTicket')->name('all_ticket')->middleware('company_user');
Route::get('/ticket/view_order/{ticket}', 'TicketObserveController@viewOrder')->name('view_order')->middleware('company_user');
Route::get('/ticket/edit/{ticket}', 'TicketObserveController@editGet')->name('edit_ticket')->middleware('company_user');
Route::post('/ticket/edit/{ticket}', 'TicketObserveController@editGet')->name('edit_ticket_post')->middleware('company_user');
Route::post('/ticket/delete', 'TicketObserveController@delete')->name('delete_ticket')->middleware('company_user');

Route::get('/order/all', 'OrderController@allOrder')->name('all_order')->middleware('company_user');
Route::post('/order/delete', 'OrderController@delete')->name('delete_order')->middleware('admin');
Route::get('/order/view_ticket/{order}', 'TicketObserveController@getTicketForOrder')->name('view_ticket')->middleware('admin');
Route::get('/order/print/{order}', 'OrderController@orderPrint')->name('order_print');

Route::get('/trip/view_order/{trip}', 'OrderController@viewTripOrder')->name('view_order')->middleware('admin');