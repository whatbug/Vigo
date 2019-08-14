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
        set_time_limit(0);
        $content = file_get_contents(base_path()."/storage/ss.txt");
        $ssrs     = base64_decode($content);
        $stBase   = explode('ssr://', str_replace("\n","",$ssrs));
        $normol   = array_splice($stBase,1);
        $dataList = array_values(array_unique($normol));
        foreach ($dataList as $key=>$value) {
            if ($key == 1)continue;
            if ($key == 16)break;
            $real_rs = base64_decode($value);
            $last_arr = explode(':', explode('/', mb_convert_encoding($real_rs, 'UTF-8', 'UTF-8'))[0]);
            $country = json_decode(file_get_contents("http://freeapi.ipip.net/{$last_arr[0]}"))[0];
            $redData[] = [
                'service'  => $last_arr[0],
                'port'     => $last_arr[1],
                'protocol' => $last_arr[2],
                'method'   => $last_arr[3],
                'obfs'     => $last_arr[4],
                'password' => base64_decode($last_arr[5]),
                'ssLink'   => 'ss://' . base64_encode($last_arr[3] . ':' . base64_decode($last_arr[5]) . '@' . $last_arr[0] . ':' . $last_arr[1]),
                'ssrLink'  => 'ssr://' . $value,
                'country'  => $country,
                'check_at' => date('H:i:s'),
            ];
            sleep(3);
        }
        return Cache::put('ssr_info',$redData,now()->addMinutes(120));
    }

}