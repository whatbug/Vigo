<?php namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Swoole\Task\TestTask;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use Swoole\WebSocket\Server;

Class TestController extends Controller {

    public function Swoole (){
        $swoole = app('swoole');
        var_dump($swoole->stats());
    }

    public function getTask (){
        $task = new TestTask('task data');
        // $task->delay(3);// 延迟3秒投放任务
        $ret = Task::deliver($task);
        var_dump($ret);
    }

    public function postTest () {
        var_dump('1456666');
    }

    public function pushTest () {
        $server = new Server("127.0.0.0.1", 5200);

        $server->on('open', function (Server $server, $request) {
            echo "server: handshake success with fd{$request->fd}\n";
            if ($server->isEstablished($request->fd)) {
                $server->push($request->fd, 'Welcome to WebSocket Server built on LaravelS');
            }
        });

        $server->on('message', function (Server $server, $frame) {
            echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
            $server->push($frame->fd, "this is server");
        });

        $server->on('close', function ($ser, $fd) {
            echo "client {$fd} closed\n";
        });

        $server->start();
    }
}