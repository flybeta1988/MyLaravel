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

Route::get('/', function () {
    $laravel = app();
    return view('welcome')->with('version', $laravel::VERSION);
});

Route::get('foo', function () {
    return view('foo');
});

Route::get('news/foo', 'NewsController@foo');
Route::resource('news', 'NewsController');