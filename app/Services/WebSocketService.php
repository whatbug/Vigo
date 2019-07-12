<?php namespace App\Services;

use Hhxsv5\LaravelS\Swoole\WebSocketHandlerInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Swoole\Http\Request;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

class WebSocketService implements WebSocketHandlerInterface
{
    public function __construct()
    {

    }

    // 连接建立时触发
    public function onOpen(Server $server, Request $request)
    {
        // 在触发 WebSocket 连接建立事件之前，Laravel 应用初始化的生命周期已经结束，你可以在这里获取 Laravel 请求和会话数据
        // 调用 push 方法向客户端推送数据，fd 是客户端连接标识字段
        Log::info('WebSocket 连接建立');
        if ($server->isEstablished($request->fd)) {
            Cache::put('fd_'.$request->fd,'在线',2);
            $server->push($request->fd, 'hello,dear '.$request->fd.'!');
        }
    }

    // 收到消息时触发
    public function onMessage(Server $server, Frame $frame)
    {
        $fdInfo = json_decode($frame->data);
        $checkOnline = Cache::get('fd_'.$fdInfo->chatObj);
        Cache::put('fd_'.$frame->fd,'在线',2);//更新在线机制
        $msg = $fdInfo->content;
        if (!$checkOnline) {
            $msg = '对方已下线，下次上线将接收到信息！';
        }
        // 调用 push 方法向客户端推送数据
        $server->push($frame->fd, $fdInfo->$msg);
    }

    // 关闭连接时触发
    public function onClose(Server $server, $fd, $reactorId)
    {
        Cache::forget('fd_'.$fd);
        $server->push($fd,'注销成功！bye！');
        Log::info('WebSocket 连接关闭');
    }
}