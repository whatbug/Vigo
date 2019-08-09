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
                preg_match_all("/[\x{4e00}-\x{9fa5}]+/u", json_decode(file_get_contents("https://pdf-lib.org/tools/ip?IP={$last_arr[0]}"))->CustomerAddress, $country);
                $redData[] = [
                    'service'  => $last_arr[0],
                    'port'     => $last_arr[1],
                    'protocol' => $last_arr[2],
                    'method'   => $last_arr[3],
                    'obfs'     => $last_arr[4],
                    'password' => base64_decode($last_arr[5]),
                    'ssrLink'  => 'ssr://:'.base64_encode($last_arr[2].':'.base64_decode($last_arr[5]).'@'.$last_arr[0].':'.$last_arr[1]),
                    'country'  => $country[0][0],
                    'check_at' => date('H:i:s', time()+$key*30),
                ];
            }
        }
        return Cache::put('ssr_info',$redData,now()->addMinutes(120));
    }

}