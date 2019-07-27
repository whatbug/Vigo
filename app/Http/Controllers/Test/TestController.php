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
        $cookie= $request->cookie;
        if ($cookie) {
            $postUrl = "https://m.ssrtool.com/tool/api/free_ssr?page=1&limit=10";
            $postData= [];
            $header  = array(
                "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36",
                "referer: https://m.raws.tk/free_ssr",
                "cookie: {$cookie}"
            );
            $result = (new CurlService)->_url($postUrl,$postData,$header);
            $resource = json_decode($result);
            foreach ($resource->data as $val) {
                $redData['list'][] = [
                    'country' => $val->country,
                    'addTime' => $val->adddate,
                    'ip'      => $val->server,
                    'port'    => $val->server_port,
                    'password'=> $val->password,
                    'method'  => $val->method,
                    'protocol'=> $val->protocol,
                    'status'  => $val->status?"正常":"无效",
                ];
            }
            $redData['count'] = 10;
            Cache::put('ssr_info',$redData,60*60*12);
        }
        $valid = array_key_exists('anhao',(array)$request);
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
        return response()->json([
            'code'   => 0,
            'msg'    => 'HIV航班祝您旅途愉快!',
            'success'=> true,
            'data'   => $ssrInfo
        ]);
    }


    public function cll (){
        $resource = file_get_contents(base_path()."/storage/ssr.txt");$i = 0;
        preg_match_all('/align="center">([^<]+)/s',$resource,$match);
        $array = array_values(array_splice($match[1],5));
        if (sizeof($match[1])) {
            foreach ($array as $key => $Value) {
                if (($key + 1) % 6 == 0) {
                    $num = $i++;
                    $rematch = file_get_contents("http://freeapi.ipip.net/{$array[6 * $num + 0]}");
                    preg_match_all("/([\x{4e00}-\x{9fa5}]+)/u",$rematch,$country);
                    $redData[] = [
                        'service'  => $array[6 * $num + 0],
                        'port'     => $array[6 * $num + 1],
                        'password' => $array[6 * $num + 2],
                        'method'   => $array[6 * $num + 3],
                        'protocol' => 'origin',
                        'country'  => ($country[0][0] == '中国')?$country[0][1]:$country[0][0],
                        'status'   => 'available',
                        'check_at' => $array[6 * $num + 4],
                    ];
                }

            }
        }
        return $redData;
    }

}