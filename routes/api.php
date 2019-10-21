<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('validate','TestController@vpnValidate');

//微信小程序
Route::Group(['prefix'=>'mini'], function() {

    Route::Group(['prefix'=>'index'], function() {
        //修改用户监控数值
        Route::get('setData.do','SpyDataController@changeData');
        //查询用户提醒数据
        Route::get('selData.do','SpyDataController@selData');
        //查询采集数值
        Route::get('selSpy.do','SpyDataController@selSpy');
        //查询最新值
        Route::get('selNews.do','SpyDataController@selNews');
    });

    Route::group(['prefix'=>'profile'], function() {
        //用户数据
        Route::get('dataList.do','UserDataController@dataList');
        //用户登录
        Route::post('userLogin.do','UserDataController@UserRegister');
    });
});
