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
	Route::get('/', array(
		'as' => 'home',
		'uses' => 'HomeController@index'));

	Route::get('userInfo', 'UserController@userInfo');

	// Result page
	Route::get('search', ['as' => 'search', 'uses' => 'HomeController@searchResult']);

	Route::post('booking/flight', 'BookingController@redirectToBookingFlight')->middleware('checklogin');
	Route::post('booking/hotel', 'BookingController@redirectToBookingHotel')->middleware('checklogin');
	Route::post('booking/car', 'BookingController@redirectToBookingCar')->middleware('checklogin');

	Auth::routes();

	Route::post('bookingflight', 'BookingController@bookingFlight');
	Route::post('bookinghotel', 'BookingController@bookingHotel');
	Route::post('bookingcar', 'BookingController@bookingCar');

	Route::post('booking/postHotel', 'PaypalController@postHotelPayment')->middleware('checklogin');
	Route::post('booking/postFlight', 'PaypalController@postFlightPayment')->middleware('checklogin');
	Route::post('booking/postCar', 'PaypalController@postCarPayment')->middleware('checklogin');

	Route::get('report/{tourId}', 'ReportController@getReport')->middleware('checklogin');

	Route::get('payment', 'PaypalController@postFlightPayment');
	Route::get('payment_all/{tourId}', 'PaypalController@paymentAll');
	// this is after make the payment, PayPal redirect back to your site
	Route::get('payment/status/flight', array(
	    'as' => 'payment.status.flight',
	    'uses' => 'PaypalController@saveFlightPayment',
	));

	Route::get('payment/status/hotel', array(
	    'as' => 'payment.status.hotel',
	    'uses' => 'PaypalController@saveHotelPayment',
	));

	Route::get('payment/status/car', array(
	    'as' => 'payment.status.car',
	    'uses' => 'PaypalController@saveCarPayment',
	));

	Route::get('payment/status/tour', array(
	    'as' => 'payment.status.tour',
	    'uses' => 'PaypalController@saveTourPayment',
	));
});
