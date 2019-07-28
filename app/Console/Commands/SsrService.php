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
        $resource = file_get_contents(base_path()."/storage/ssr.txt");$i = 0;
        preg_match_all('/align="center">([^<]+)/s',$resource,$match);
        $array = array_values(array_splice($match[1],5));
        if (sizeof($match[1])) {
            foreach ($array as $key => $Value) {
                sleep(15);
                if (($key + 1) % 6 == 0) {
                    $num = $i++;
                    $rematch = file_get_contents("https://www.36ip.cn/?ip={$array[6 * $num + 0]}");
                    preg_match_all("/([\x{4e00}-\x{9fa5}]+)/u",$rematch,$country);
                    $redData[] = [
                        'service'  => $array[6 * $num + 0],
                        'port'     => $array[6 * $num + 1],
                        'password' => $array[6 * $num + 2],
                        'method'   => $array[6 * $num + 3],
                        'protocol' => 'origin',
                        'country'  => $country,
                        'status'   => 'available',
                        'check_at' => $array[6 * $num + 4],
                    ];
                }

            }
        }
        return Cache::put('ssr_info',$redData,120);
    }

}