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
                $rate = ($key + 1) % 6;
                if ($key + 1 == 90)break;
                if ($rate == 0) {
                    $num = $i++;
                    $redData[] = [
                        'service'  => $array[6 * $num + 0],
                        'port'     => $array[6 * $num + 1],
                        'password' => $array[6 * $num + 2],
                        'method'   => $array[6 * $num + 3],
                        'protocol' => 'origin',
                        'country'  => $array[6 * $num + 5],
                        'status'   => 'available',
                        'check_at' => $array[6 * $num + 4],
                    ];
                }

            }
        }
        return Cache::put('ssr_info',$redData,now()->addMinutes(120));
    }

}