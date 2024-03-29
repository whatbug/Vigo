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

    const BTC = 'btc_record';
    const EHT = 'eht_record';
    const EOS = 'eos_record';

    public $timeout = 2;

    /**
     * Create a new job instance.
     * @param  $array array
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
              $data->insertRedis(['values'=>$value['values'],'type'=>$value['type'],'rmb'=>$value['rmb'],'time'=>time()],constant('self::'.$value['type']));
              $data->notifyUsers(intval($value['values']),$value['type']);
          }
    }
}
