<?php namespace App\Console\Commands;

use App\Repositories\RecordData;
use App\Services\MessageNotifier;
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
    public function handle(RecordData $data) {
        set_time_limit(0);
        $content = shell_exec('python3 spy.py');
        if (!is_null($content)) {
            $dataNum = str_replace(',','',$content);
            $result  = [
                'values' => $dataNum,
                'type' => 1,
                'time' => time(),
            ];
            $data->fill($result)->save();
            if ($result['values'] < 10800) {
                MessageNotifier::sendMsg('18587388678',$result['values']);
            }
        }
        return true;
    }

}