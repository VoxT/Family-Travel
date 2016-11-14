<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
// Home page
Route::group(['middleware' => ['web']], function () {
	Route::get('/', 'HomeController@index');

	// Result page
	Route::get('search', ['as' => 'search', 'uses' => 'HomeController@searchResult']);

	Route::post('booking/flight', 'BookingController@redirectToBookingFlight')->middleware('checklogin');
	Route::post('booking/hotel', 'BookingController@redirectToBookingHotel')->middleware('checklogin');

	Auth::routes();
});
