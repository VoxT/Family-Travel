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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'test@welcome');

Route::get('/test', 'test@GetLiveFlightPrice');

// Route::post('/search/{origin}/{destination}', 'test@map');

Route::get('search', ['as' => 'search', 'uses' => 'test@map']);