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

Route::get('/test', function (){
    return 666;
});

Route::namespace('Test')->group(function (){
    Route::get('swoole','TestController@Swoole')->name('swoole');
    Route::post('task','TestController@postTask')->name('task');
});
