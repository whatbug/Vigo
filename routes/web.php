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
//    Route::get('swoole','TestController@Swoole')->name('swoole');
    Route::get('tasks','TestController@getTask')->name('task');
    Route::post('test1','TestController@postTest')->name('test1');
});
