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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//验证用户是否有效
Route::post('/validate','TestController@vpnValidate');
//修改用户监控数值
Route::get('setData.do','SpyDataController@changeData');
//查询当前比特币数值
Route::get('selData.do','SpyDataController@SelData');