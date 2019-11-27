<?php namespace App\Console\Commands;

use App\Services\BaiOrcService;
use App\Services\CurlService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

Class NewSSProcess extends Command {

    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'ssr:new';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Get this service by github';

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle() {
        set_time_limit(0);$arr = array();$insertData = array();
        if (date('H') == 2) {
            shell_exec("python3 /new.py");
            $imgUrl = file_get_contents(base_path() . "/storage/ss.txt");
            $content = (new BaiOrcService())->resRecognize($imgUrl);
            foreach ($content->words_result as $key => $val) {
                if (preg_match('/:[\S]+/', str_replace(' ', '', $val->words), $resMatch)) {
                    $arr[] = substr($resMatch[0], 1);
                } else {
                    continue;
                }
            }
            $i = 0;
            foreach ($arr as $key => $value) {
                if ($key < 6 * ($i + 1)) {
                    $country = json_decode(file_get_contents("http://freeapi.ipip.net/{$arr[6 * $i]}"));
                    $insertData[] = [
                        'service' => $arr[6 * $i],
                        'port' => $arr[6 * $i + 1],
                        'protocol' => $arr[6 * $i + 4],
                        'method' => $arr[6 * $i + 3] == 'origin' ? "RC4" : $arr[6 * $i + 3],
                        'password' => $arr[6 * $i + 2],
                        'ssLink' => 'ss://' . base64_encode((($arr[6 * $i + 3] == 'origin') ? "RC4" : $arr[6 * $i + 3]) . ':' . base64_encode($arr[6 * $i + 2]) . '@' . $arr[6 * $i] . ':' . $arr[6 * $i + 1]),
                        'ssrLink' => 'ssr://' . base64_encode("{$arr[6 * $i]}:{$arr[6 * $i +1]}:{$arr[6 * $i +4]}:" . (($arr[6 * $i + 3] == "origin") ? "RC4" : $arr[6 * $i + 3]) . ":plain:" . base64_encode($arr[6 * $i + 2]) . "/?obfsparam=&protoparam=&remarks=" . base64_encode("失效坐等" . $i) . "&group=" . base64_encode('free share for I-Song')),
                        'country' => ($country[0] != '中国') ? $country[0] : $country[0] . "({$country[1]})",
                        'check_at' => date('H:i:s'),
                    ];
                    sleep(3);
                    $i++;
                }
                if ($i == 2) break;
            }
        } else {
            $postUrl = "https://lncn.org/api/lncnG";
            $time = time();$redData = [];
            $postData= ['origin'=>'https://lncn.org'];
            $header  = array(
                "user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36",
                "referer: https://lncn.org",
                "accept: application/json, text/plain, */*",
                "origin: https://lncn.org",
                "referer: https://lncn.org",
                "cookie: _ga=GA1.2.1987760110.{$time}; _gid=GA1.2.195119797.{$time}; _gat_gtag_UA_132719745_1=1"
            );
            $resContent = json_decode((new CurlService())->_url($postUrl,$postData,$header));
            if (!is_object($resContent)) {
                return false;
            }
            $secretKey = '6512654323254321';
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
            $insertData  = array_values(array_merge($originSsr,$redData));
        }
        return Cache::put('ssr_info',$insertData,now()->addMinutes(60*24));
    }

}
