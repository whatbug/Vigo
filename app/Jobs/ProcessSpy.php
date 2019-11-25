<?php

namespace App\Jobs;

use App\Repositories\HuoCollect\Repositories\RunMethod;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessSpy implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $array;

    public $timeout = 2;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($array)
    {
        $this->array = $array;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
          foreach ($this->array as $value) {
              $data = new RunMethod();
              $data->insertRedis(['values'=>$value['values'],'rmb'=>$value['rmb'],'type'=>$value['type'],'time'=>time()],constant('self::'.$value['type']));
              $data->notifyUsers(intval($value['values']),$value['type']);
          }
    }
}
