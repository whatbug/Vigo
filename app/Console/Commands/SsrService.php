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
        $resource = file_get_contents(base_path()."/storage/ssr.txt");$i = 1;
        preg_match_all('/align="center">([^<]+)/s',$resource,$match);
        if (sizeof($match[1])) {
            foreach ($match[1] as $key => $Value) {
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
        return Cache::put('ssr_info',$redData,60*1.5);
    }

}