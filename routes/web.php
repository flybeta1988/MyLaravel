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

Route::get('phpinfo', function () {
    return phpinfo();
});

Route::get('foo', function () {
    return view('foo');
});

Route::get('user/profile', function () {
    return 'User Profile Page !';
})->name('profile');

Route::get('news/foo', 'NewsController@foo');
Route::resource('news', 'NewsController');
Route::get('news/{id}/delete', 'NewsController@delete');
Route::get('news/{id}/update', 'NewsController@update');

Route::get('notify', 'NotifyController@index');
Route::get('notify/save', 'NotifyController@save');

Auth::routes();

Route::get('/home', 'HomeController@index');
