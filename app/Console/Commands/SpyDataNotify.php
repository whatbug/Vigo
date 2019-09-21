<?php namespace App\Console\Commands;

use App\Repositories\HuoCollect\Repositories\Interfaces\RecordData;
use App\Repositories\HuoCollect\Repositories\RunMethod;
use App\Repositories\HuoCollect\Repositories\RunRecordRepositories;
use App\Repositories\RunData;
use Illuminate\Console\Command;

Class SpyDataNotify extends Command {

    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'spy:notify';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Get this service by BTC';

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle(RunMethod $data) {
        set_time_limit(0);
        $content = shell_exec('python3 /spy.py');
        if (!is_null($content)) {
            preg_match('/(\d+)\.(\d+)/is',$content,$dataNum);
            $result  = [
                'values' => $dataNum[0],
                'type' => 1,
                'time' => time(),
            ];
            $data->insertRedis($result);
            $data->notifyUsers(intval($result['values']),1);
        }
        return true;
    }

}