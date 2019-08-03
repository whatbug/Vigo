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
use \Illuminate\Support\Facades\Cache;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function (){
    return 666;
});

Route::namespace('Test')->group(function (){
    Route::get('swoole','TestController@Swoole')->name('swoole');
    Route::get('cll','TestController@cll')->name('cll');
    Route::get('tasks','TestController@getTask')->name('task');
    Route::get('test1','TestController@postTest')->name('test1');
    Route::get('push','TestController@pushTest')->name('push');
    Route::get('cache','TestController@getCache')->name('cache');
    Route::get('fanqiang',function(){
        return view('vpn.index');
    });
    Route::get('free-ssr',function(\Illuminate\Http\Request $request){
        $ipKey = ip2long($request->getClientIp());
        if (Cache::get($ipKey)) {
            if (Cache::get($ipKey) == md5('卧槽我怎么知道'.$request->getClientIp())) {
                $ssrInfo = Cache::get('ssr_info');
                return view('vpn.ssr',['data'=>$ssrInfo]);
            }
        }
        return redirect('fanqiang');
    });
});
