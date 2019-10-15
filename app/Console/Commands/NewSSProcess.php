<?php namespace App\Console\Commands;

use App\Services\BaiOrcService;
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
        set_time_limit(0);$arr = array();
        shell_exec("python3 /new.py");
        $content = file_get_contents(base_path()."/storage/ss.txt");
        $content = (new BaiOrcService())->resRecognize($content);
        foreach ($content->words_result as $key => $val) {
            if (preg_match('/:[\S]+/',str_replace(' ','',$val->words),$resMatch)){
                $arr[] = substr($resMatch[0],1);
            }else {
                continue;
            }
        }
        var_dump($arr);
        $i = 0;
        foreach ($arr as $key => $value) {
            if ($key < 6 * ($i+1)) {
                $country = json_decode(file_get_contents("http://freeapi.ipip.net/{$arr[6 * $i]}"));
                $redData[] = [
                'service' => $arr[6 * $i],
                'port'    => $arr[6 * $i +1],
                'protocol'=> $arr[6 * $i +4],
                'method'  => $arr[6 * $i +3],
                'password'=> $arr[6 * $i +2],
                'ssLink'  => 'ss://' . base64_encode($arr[6 * $i +3] . ':' . base64_encode($arr[6 * $i +2]) . '@' . $arr[6 * $i] . ':' . $arr[6 * $i +1]),
                'ssrLink' => 'ssr://' . base64_encode("{$arr[6 * $i]}:{$arr[6 * $i +1]}:{$arr[6 * $i +4]}:{$arr[6 * $i +3]}:plain:".base64_encode($arr[6 * $i +2])."/?obfsparam=&protoparam=&remarks=".base64_encode("如果失效请耐心等待修复")."&group=".base64_encode('free share for I-Song')),
                'country' => ($country[0] != '中国') ? $country[0] : $country[0] . "({$country[1]})",
                'check_at'=> date('H:i:s'),
            ];
                sleep(3);
                $i++;
            }
            if($i == 2) break;
        }
        var_dump($redData);exit();
        return Cache::put('ssr_info',$redData,now()->addMinutes(60*24));
    }

}