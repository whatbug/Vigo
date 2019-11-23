<?php namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

Class CrazyTokenService
{
    private $token;

    public function __construct()
    {

    }

    //设置token
    public function setToken (?string $token) : ?self
    {
        $this->token = $token;
        return $this;
    }

    //生成token
    public function hasToken ($data,$ip) {
        $strToken = strtoupper(md5($data['open_id'].$ip.$data['user_id']).$data['timestamp']).'-'.base64_encode(strrev($data['user_id']).rand(0,9));
        $this->foreverCreate($strToken,$data['user_id'].','.($data['timestamp']+60*60*6));
        return $strToken;
    }

    //检查token有效性
    public function checkToken () {
        $dataStr = Cache::get($this->token);
        if (empty($dataStr)) {
            Log::info('token not invalid');
            return false;
        }
        $splice = explode(',',$dataStr);
        if ((time() - $splice[1] < 0)) {
            return $this->token;
        }
        if ((time() - $splice[1] > 60*2)) {
            return $this->forgetToken()->refresh();
        }
        Log::info('过期时间在60*2 之间');
        return false;
    }

    //刷新token
    public function refresh () {
        $userKey  = substr((explode('-',$this->token))[1],0,-1);
        $userId   = strrev(base64_decode($userKey));
        $strToken = md5($this->token.(time() + 60*60*6)).$userKey.rand(0,9);
        $this->foreverCreate($strToken,$userId.','.(time() + 60*60*6));
        return $strToken;
    }

    //存入token
    public function foreverCreate ($key,$infoStr) {
        Cache::forever($key,$infoStr);
    }

    //删除token key
    public function forgetToken () {
        Cache::forget($this->token);
        return $this;
    }
}
