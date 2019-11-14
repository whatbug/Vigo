<?php namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller as BaseController;
use App\Services\CurlService;
use App\Services\MessageNotifier;
use App\Swoole\Task\TestTask;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;

Class TestController extends BaseController {
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
        MessageNotifier::sendMsg('18587388678',9000);
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
            $postUrl = "https://www.36ip.cn/?ip=172.104.73.86";
            $postData= [];
            $header  = array(
                "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36",
                "referer: https://www.36ip.cn/",
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
        $postUrl = "https://lncn.org/api/lncn";
        $time = time();$redData = [];
        $postData= ['origin'=>'https://lncn.org'];
        $header  = array(
            "user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36",
            "referer: https://lncn.org",
            "accept: application/json, text/plain, */*",
            "origin: https://lncn.org",
            "referer: https://lncn.org",
            "cookie: _ga=GA1.2.1987760110.{$time}; _gid=GA1.2.1058273580.{$time}; _gat_gtag_UA_132719745_1=1"
        );
        $resContent = json_decode((new CurlService)->_url($postUrl,$postData,$header));
        if (!is_object($resContent)) {
            return false;
        }
        $secretKey = '6512654323241236';
        $ssrData   = openssl_decrypt($resContent->ssrs, 'aes-128-ecb', $secretKey, 2 );
        preg_match_all("/(?:\[)(.*)(?:\])/i",$ssrData,$res);
        foreach (json_decode($res[0][0]) as $val) {
            $country = json_decode(file_get_contents("http://freeapi.ipip.net/{$val->ssr->ip}"));
            $redData[] = [
                'service'  => $val->ssr->ip,
                'port'     => $val->ssr->port,
                'protocol' => $val->ssr->protocol,
                'method'   => $val->ssr->method,
                'obfs'     => $val->ssr->obfs,
                'password' => $val->ssr->password,
                'ssLink'   => 'ss://' . base64_encode($val->ssr->method . ':' . $val->ssr->password . '@' . $val->ssr->ip . ':' . $val->ssr->port),
                'ssrLink'  => $val->ssrUrl,
                'country'  => ($country[0]!='中国')?$country[0]:$country[0]."({$country[1]})",
                'check_at' => date('H:i:s'),
            ];
        }
        $originSsr = Cache::get('ssr_info');
        $mergeSsr  = array_values(array_merge($originSsr,$redData));
        Cache::forget('ssr_info');
        Cache::put('ssr_info',$mergeSsr,now()->addMinutes(120));
        return $mergeSsr;
        set_time_limit(0);$i=0;
        $content = file_get_contents(base_path()."/storage/ss.txt");
        $ssrs     = base64_decode($content);
        $stBase   = explode('ssr://', str_replace("\n","",$ssrs));
        $normol   = array_splice($stBase,1);
        $dataList = array_values(array_unique($normol));
        foreach ($dataList as $key=>$value){
            if ($i*4 == 60)break;
            if ($key != $i*4 && $key != 0) {
                continue;
            } else {
                $i++;
                $real_rs = base64_decode($value);
                $last_arr = explode(':', explode('/', mb_convert_encoding($real_rs, 'UTF-8', 'UTF-8'))[0]);
//                preg_match_all("/[\x{4e00}-\x{9fa5}]+/u", json_decode(file_get_contents("https://pdf-lib.org/tools/ip?IP={$last_arr[0]}"))->CustomerAddress, $country);
                $country = json_decode(file_get_contents("http://freeapi.ipip.net/{$last_arr[0]}"))[0];
                $redData[] = [
                    'service'  => $last_arr[0],
                    'port'     => $last_arr[1],
                    'protocol' => $last_arr[2],
                    'method'   => $last_arr[3],
                    'obfs'     => $last_arr[4],
                    'password' => base64_decode($last_arr[5]),
                    'ssLink'   => 'ss://'.base64_encode($last_arr[3].':'.base64_decode($last_arr[5]).'@'.$last_arr[0].':'.$last_arr[1]),
                    'ssrLink'  => 'ssr://'.$value,
                    'country'  => $country[0][0],
                    'check_at' => date('H:i:s'),
                ];
            }
            sleep(2);
        }
        return $redData;
    }

}
