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
       $content = shell_exec('python3 /spy.py >/dev/null &');
       if (!is_null($content)) {
           $dataNum = explode(',',$content);
           if (sizeof($dataNum)) {
               $array = [[
                   'values' => round($dataNum[0],2),
                   'type'   => 'BTC',
               ],[
                   'values' => round($dataNum[1],2),
                   'type'   => 'EHT',
               ]];
               dispatch(new ProcessSpy($array));
           }

       }
   }

}