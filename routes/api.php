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

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

// Get live price
// api/v1/livepriceflight + params

Route::get('livePriceFlight', [
		'as' => 'liveprice',
		'uses' => 'FlightController@getLivePriceFlight'
	]);

// Get Car Hire
// api/v1/livecarhire
Route::get('livecarhire', 'CarHireController@getCarPrice');

// Get hotel Price list
// api/v1/livecarhire
Route::get('livehotelprice', 'HotelController@getHotelPrice');

Route::get('getuser', 'Auth\LoginController@getUser');

Route::get('getDataByRequestURL', 'HomeController@getDataByRequestURL');

Route::get('getlisthotel', 'GetHotelListController@getHotelList');
Route::get('gethoteldetails', 'GetHotelListController@getHotelDetails');