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
    return view('welcome');
});

Route::get('/course/index', 'CourseController@index');
Route::get('/course/hello', 'CourseController@hello');
Route::get('/course/reflect', 'CourseController@reflect');

Route::get('/order/add', 'OrderController@add');
Route::get('/order/index', 'OrderController@index');
