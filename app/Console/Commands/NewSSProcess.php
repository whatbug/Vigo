<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BaiOrcService;
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
        $content = file_get_contents(base_path()."/storage/newss.txt");
        $content = (new BaiOrcService)->resRecognize('http://icon.qiantucdn.com/20191010/0a2b382dbed019497c2f996282c80b8f2');
        foreach ($content->words_result as $key => $val) {
            if (preg_match('/:[\S]+/',$val->words,$resMatch)){
                $arr[] = substr($resMatch[0],1);
            }else {
                continue;
            }
        }
        $i = 0;
        foreach ($arr as $key => $value) {
            if ($key < 5 * ($i+1)) {
                $country = json_decode(file_get_contents("http://freeapi.ipip.net/{$arr[5 * $i]}"));
                $redData[] = [
                'service' => $arr[5 * $i],
                'port'    => $arr[5 * $i +1],
                'protocol'=> 'origin',
                'method'  => $arr[5 * $i +3],
                'password'=> $arr[5 * $i +2],
                'ssLink'  => 'ss://' . base64_encode($arr[5 * $i +3] . ':' . base64_encode($arr[5 * $i +2]) . '@' . $arr[5 * $i] . ':' . $arr[5 * $i +1]),
                'ssrLink' => 'ssr://' . "{$arr[5 * $i]}:{$arr[5 * $i +1]}:origin:{$arr[5 * $i +3]}:plain:".base64_encode($arr[5 * $i +2])."/?obfsparam=&protoparam=&remarks=".base64_encode('如果失效请耐心等待修复')."&group=".base64_encode('free share for I-Song'),
                'country' => ($country[0] != '中国') ? $country[0] : $country[0] . "({$country[1]})",
                'check_at'=> date('H:i:s'),
            ];
                sleep(3);
                $i++;
            }
            if($i == 2) break;
        }
        return Cache::put('ssr_info',$redData,now()->addMinutes(60*24));
    }

}