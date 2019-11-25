<?php namespace App\Console\CronTab;

use App\Jobs\ProcessSpy;
use Hhxsv5\LaravelS\Swoole\Timer\CronJob;

Class SpyNotify extends CronJob
{
    protected $num = 0;

   //运行间隔 秒
   public function interval()
   {
       return 10000;
   }

   //是否等待第一次执行时间间隔  false即等待
   public function isImmediate()
   {
       return false;
   }

   public function run()
   {
       try {
           $content = shell_exec("python3 /spy.py");
           if (!is_null($content)) {
               $dataNum = explode(',',$content);
               if (sizeof($dataNum)) {
                   $array = [[
                       'values' => round($dataNum[0],2),
                       'type'   => 'BTC',
                       'rmb'    => $dataNum[1]
                   ],[
                       'values' => round($dataNum[3],2),
                       'type'   => 'EHT',
                       'rmb'    => $dataNum[4]
                   ],[
                       'values' => round($dataNum[6],2),
                       'type'   => 'EOS',
                       'rmb'    => $dataNum[7]
                   ]];
                   dispatch(new ProcessSpy($array));
               }

           }
       } catch (\Exception $e) {
           \Log::info("fuck bug*******{$e->getMessage()}");
       }
   }

}
