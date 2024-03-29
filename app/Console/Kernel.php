<?php

namespace App\Console;

use App\Console\Commands\NewSSProcess;
use App\Console\Commands\SsrService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //SSR 服务
        SsrService::class,
        NewSSProcess::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //每天更新一次
        $schedule->command('ssr:new')->dailyAt(2);
        //每天7点更新
        $schedule->command('ssr:new')->dailyAt(7);
        //每1小时更新一次数据
//         $schedule->command('ssr:array')->hourly();
        //每分钟监控一次 被秒级取代
        //$schedule->command('spy:notify')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
