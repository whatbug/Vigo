<?php namespace App\Services;

use Illuminate\Support\Facades\Cache;

Class CrazyTokenService
{
    public function __construct()
    {

    }

    //生成token
    public function setToken ($data,$ip) {
        $strToken = md5($data['open_id'].$ip.$data['user_id'].rand(1,20));
        Cache::put($strToken,$data['user_id'].','.($data['timestamp']+3600),3600);
        return $strToken;
    }

    //检查token有效性  success 返回用户ID
    public function checkTokenBackId ($token) {
        $dataStr = Cache::get($token);
        if (empty($dataStr)) {
            return false;
        }
        $splice = explode($dataStr,',');
        if (!($splice[1] - time())) {
            return false;
        }
        return $splice[0];
    }
}