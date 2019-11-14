<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

Class SsrService extends Command {

    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'ssr:array';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Get this service by HongKong.';

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle() {
        set_time_limit(0);$insertData = [];
        if (date('H') == 2) {
            $content = file_get_contents(base_path() . "/storage/ss.txt");
            $ssrs = base64_decode($content);
            $stBase = explode('ssr://', str_replace("\n", "", $ssrs));
            $normol = array_splice($stBase, 1);
            $dataList = array_values(array_unique($normol));
            foreach ($dataList as $key => $value) {
                if ($key == 0) continue;
                if ($key == 16) break;
                $real_rs = base64_decode($value);
                $last_arr = explode(':', explode('/', mb_convert_encoding($real_rs, 'UTF-8', 'UTF-8'))[0]);
                $country = json_decode(file_get_contents("http://freeapi.ipip.net/{$last_arr[0]}"));
                $insertData[] = [
                    'service' => $last_arr[0],
                    'port' => $last_arr[1],
                    'protocol' => $last_arr[2],
                    'method' => $last_arr[3],
                    'obfs' => $last_arr[4],
                    'password' => base64_decode($last_arr[5]),
                    'ssLink' => 'ss://' . base64_encode($last_arr[3] . ':' . base64_decode($last_arr[5]) . '@' . $last_arr[0] . ':' . $last_arr[1]),
                    'ssrLink' => 'ssr://' . $value,
                    'country' => ($country[0] != '中国') ? $country[0] : $country[0] . "({$country[1]})",
                    'check_at' => date('H:i:s'),
                ];
                sleep(3);
            }
        }  else  {
            $postUrl = "https://lncn.org/api/lncn";$time = time();$redData = [];
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
                    'password' => base64_decode($val->ssr->password),
                    'ssLink'   => 'ss://' . base64_encode($val->ssr->method . ':' . base64_decode($val->ssr->password) . '@' . $val->ssr->ip . ':' . $val->ssr->port),
                    'ssrLink'  => $val->ssrLink,
                    'country'  => ($country[0]!='中国')?$country[0]:$country[0]."({$country[1]})",
                    'check_at' => date('H:i:s'),
                ];
            }
            $originSsr = Cache::get('ssr_info');
            $insertData  = array_values(array_merge($originSsr,$redData));
        }
        return Cache::put('ssr_info',$insertData,now()->addMinutes(120));
    }

}
