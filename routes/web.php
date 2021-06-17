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

use Illuminate\Support\Facades\App;

Route::get('/', function () {
    return view('welcome');
});

//https://zhuanlan.zhihu.com/p/62447326
App::bind('App\Services\ServiceInterface.php', 'App\Services\OrderService.php');

//Route::resource('/course/index', 'CourseController');
Route::get('/course/index', 'CourseController@index');
