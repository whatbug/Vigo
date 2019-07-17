<?php namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Services\CurlService;
use App\Swoole\Task\TestTask;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;

Class TestController extends Controller {
    private $curlService;
    public function __construct(CurlService $curlService)
    {
        $this->curlService = $curlService;
    }

    public function Swoole (){
        $swoole = app('swoole');
        var_dump($swoole->stats());
    }

    public function getTask (){
        $task = new TestTask('task data');
        // $task->delay(3);// 延迟3秒投放任务
        $ret = Task::deliver($task);
        var_dump($ret);
    }

    public function postTest () {
        var_dump('1456666');
    }

    public function pushTest () {
        $connections = app('swoole')->connections;
        var_dump($connections);
        foreach ($connections as $fd){
             $data = [
                 'data' => [
                     'content' => 'Push Message'
                 ]
             ];
            app('swoole')->push($fd,json_encode($data));
        }
    }

    public function getCache () {
        $id = Input::input('id');
        return Cache::get('fd_'.$id);
    }

    /**
     * @param Request array $request
     * @return bool|\Illuminate\Http\JsonResponse|string
     */
    public function getVpnInfo (Request $request) {
        $valid = array_key_exists('anhao',(array)$request);
        return get_headers('https://m.raws.tk/m/free_ssr');
        return $this->curlService->get_cookie('https://m.raws.tk/m/free_ssr');
        if (!$valid) {
            $key = '卧槽我怎么知道';
            if ($request->anhao <> $key)
            return response()->json([
                'code'    => 1,
                'msg'     => '看来兄弟非魔教中人！',
                'success' => false,
            ]);
        }
        $ssrInfo = Cache::get('ssr_info');

        return $this->curlService->get_cookie('https://m.raws.tk/m/free_ssr');
//        if (!$ssrInfo) {
//            $postUrl = "https://fanqiang.network/";
//            $postData= [];
//            $header  = array(
//                "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36",
//                "referer: https://m.raws.tk/free_ssr",
//            );
//            $result = (new CurlService)->_url($postUrl,$postData,$header);
//            preg_match_all('/align="center">([^<]+)/s',$result,$match);
//            $i = 1;
//            foreach ($match[1] as $key => $Value) {
//                if ($key < 7)continue;
//                if ($key == 60)break;
//                if ($key % 7 == 0){
//                    $num = $i++;
//                    $ssrInfo[] = [
//                        'iP'      => $match[1][6*$num + 1],
//                        'port'    => $match[1][6*$num + 2],
//                        'password'=> $match[1][6*$num + 3],
//                        'method'  => $match[1][6*$num + 4],
//                        'protocol'=> $match[1][6*$num + 5],
//                        'origin'  => $match[1][6*$num + 6],
//                    ];
//                }
//            }
//        }
        return response()->json([
            'code'   => 0,
            'msg'    => 'HIV航班祝您旅途愉快!',
            'success'=> true,
            'data'   => $ssrInfo
        ]);
    }
}