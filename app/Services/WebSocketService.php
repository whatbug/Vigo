<?php namespace App\Services;

use Hhxsv5\LaravelS\Swoole\WebSocketHandlerInterface;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Swoole\Http\Request;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

class WebSocketService extends Controller implements WebSocketHandlerInterface
{
    public function __construct()
    {
        $this->middleware('api.token');
    }

    // 连接建立时触发
    public function onOpen(Server $server, Request $request)
    {
        // 在触发 WebSocket 连接建立事件之前，Laravel 应用初始化的生命周期已经结束，你可以在这里获取 Laravel 请求和会话数据
        // 调用 push 方法向客户端推送数据，fd 是客户端连接标识字段
        Log::info('WebSocket 连接建立');
        if ($server->isEstablished($request->fd)) {
            Cache::put('fd_'.$request->fd,$request->fd,60*60);
            $server->push($request->fd, 'hello,dear '.$request->fd.'!');
        }
    }

    // 收到消息时触发
    public function onMessage(Server $server, Frame $frame)
    {
        $fdInfo = json_decode($frame->data);
        if ($fdInfo) {
            if ($fdInfo->chatObj == $frame->fd) {
                $server->push($frame->fd, json_encode(['success'=>false,'msg'=>'你玩呐？自己给自己发！']));return;
            }
            //收到消息就更新
            Cache::put('fd_'.$frame->fd,$frame->fd,60*60);
            // 调用 push 方法向接收客户端推送数据
            $checkRev = Cache::get('fd_'.$fdInfo->chatObj);
            if ($checkRev) {
                $server->push($fdInfo->chatObj, $fdInfo->content);
            }
            // 调用 push 方法向发起客户端推送数据
            $infos = [
                'success' => $checkRev?true:false,
                'msg' => $checkRev?'发送成功':'对方已经下线',
            ];
            $server->push($frame->fd, json_encode($infos));
        } else {
            $server->push($frame->fd, '我们有缘无份哈哈哈');
        }
    }

    // 关闭连接时触发
    public function onClose(Server $server, $fd, $reactorId)
    {
        Cache::forget('fd_'.$fd);
        Log::info('WebSocket 连接关闭');
    }
}