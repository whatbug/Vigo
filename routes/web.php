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
//二维码
Route::get('/app/qrcode',function() {
    if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')){
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')){
            $Ios     = 'https://itunes.apple.com/cn/app/讯都网/id1453804979';
            header("location:{$Ios}");
        }else{
            $JumpUrl = 'http://mm.eastday.com/wechatjump/sxg.jump?location=http://app.xunduwang.com/app/qrcode';
            header("location:{$JumpUrl}");
        }
    }elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')){
        $Ios     = 'https://itunes.apple.com/cn/app/讯都网/id1453804979';
        header("location:{$Ios}");
    }else{
        $resource = file_get_contents('https://android.myapp.com/myapp/searchAjax.htm?kw=%E8%AE%AF%E9%83%BD%E7%BD%91&pns=&sid=');
        $appUrl   = json_decode($resource)->obj->items[0]->appDetail->apkUrl;
        header('location:'.$appUrl);
    }
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
                return view('vpn.ssr')->with('data',$ssrInfo);
            }
        }
        return redirect('fanqiang');
    });
});
