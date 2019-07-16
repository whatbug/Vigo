<?php namespace App\Console\Commands\SSR;

use App\Services\CurlService;
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
        $postUrl = "https://fanqiang.network/";
        $postData= [];
        $header  = array(
            "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36",
            "referer: https://m.raws.tk/free_ssr",
        );
        $result = (new CurlService)->_url($postUrl,$postData,$header);
        preg_match_all('/align="center">([^<]+)/s',$result,$match);
        $i = 1;$redData = [];
        if (sizeof($match[1])) {
            foreach ($match[1] as $key => $Value) {
                if ($key < 7 ) continue;
                if ($key == 60)break;
                if ($key % 7 == 0) {
                    $num = $i++;
                    $redData[] = [
                        'iP'       => $match[1][6 * $num + 1],
                        'port'     => $match[1][6 * $num + 2],
                        'password' => $match[1][6 * $num + 3],
                        'method'   => $match[1][6 * $num + 4],
                        'protocol' => $match[1][6 * $num + 5],
                        'origin'   => $match[1][6 * $num + 6],
                    ];
                }
            }
        }
        return Cache::put('ssr_info',$redData,60*60*12);
    }
}