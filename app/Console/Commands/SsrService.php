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
        $resource = file_get_contents(base_path()."/storage/ss.txt");$i = 0;
        preg_match_all('/<td.*?>(.*?)<\/td>/',$resource,$match);
        if (sizeof($match[1])) {
            foreach ($match[1] as $key => $Value) {
                $rate = ($key + 1) % 8;
                if ($key + 1 == 128)break;
                if ($rate == 0) {
                    $num = $i++;
                    $redData[] = [
                        'service'  => $match[1][8 * $num + 1],
                        'port'     => $match[1][8 * $num + 2],
                        'method'   => $match[1][8 * $num + 3],
                        'password' => $match[1][8 * $num + 4],
                        'protocol' => 'origin',
                        'country'  => $match[1][8 * $num + 6],
                        'status'   => 'available',
                        'check_at' => $match[1][8 * $num + 5],
                    ];
                }

            }
        }
        return Cache::put('ssr_info',$redData,now()->addMinutes(120));
    }

}