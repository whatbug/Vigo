<?php namespace App\Console\Commands;

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
    public function handle() {
        set_time_limit(0);
        $content = shell_exec('python3 /spy.py');
        preg_match('/(\d+)\.(\d+)/is',$content,$dataNum);
        return $content;
    }

}