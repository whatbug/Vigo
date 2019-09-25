<?php namespace App\Console\CronTab;

use App\Jobs\ProcessSpy;
use Hhxsv5\LaravelS\Swoole\Timer\CronJob;

Class SpyNotify extends CronJob
{
    protected $num = 0;

   //运行间隔 秒
   public function interval()
   {
       return 7000;
   }

   //是否等待第一次执行时间间隔  false即等待
   public function isImmediate()
   {
       return false;
   }

   public function run()
   {
       $content = shell_exec('python3 /spy.py');
       preg_match('/(\d+)\.(\d+)/is',$content,$dataNum);
       if (!is_null($content) && is_array($dataNum)) {
           $array = [
               'values' => $dataNum[0],
               'type'   => 'BTC',
           ];
//           $array = [[
//               'values' => $dataNum[0],
//               'type'   => 'BTC',
//           ],[
//               'values' => $dataNum[3],
//               'type'   => 'EHT',
//           ]];
           dispatch(function() use($array){
               new ProcessSpy($array);
           });
       }
       return true;
   }

}