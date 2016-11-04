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
Route::get('/', 'HomeController@index');

// Result page
Route::get('search', ['as' => 'search', 'uses' => 'SearchResultController@searchResult']);


Auth::routes();

// Route::get('/home', 'HomeController@index');
