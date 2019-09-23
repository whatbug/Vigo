<?php namespace App\Jobs\Timer;

use Hhxsv5\LaravelS\Swoole\Timer\CronJob;
use App\Repositories\HuoCollect\Repositories\RunMethod;

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
       \Log::info('1111');
//       $content = shell_exec('python3 /spy.py');
//       if (!is_null($content)) {
//           preg_match('/(\d+)\.(\d+)/is',$content,$dataNum);
//           $result  = [
//               'values' => $dataNum[0],
//               'type' => 1,
//               'time' => time(),
//           ];
//           $data = new RunMethod();
//           $data->insertRedis($result);
//           $data->notifyUsers(intval($result['values']),1);
//       }
   }

}