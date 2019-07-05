<?php namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Swoole\Task\TestTask;
use Hhxsv5\LaravelS\Swoole\Task\Task;

Class TestController extends Controller {

    public function Swoole (){
        $swoole = app('swoole');
        var_dump($swoole->stats());
    }

    public function getTask (){
        $task = new TestTask('task data');
        // $task->delay(3);// 延迟3秒投放任务
        $ret = Task::deliver($task);
        return $ret;
    }

    public function postTest () {
        var_dump('1456666');
    }
}