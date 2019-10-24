<?php namespace App\Services;

use Illuminate\Support\Facades\Cache;

Class CrazyTokenService
{
    private $token;

    public function __construct()
    {

    }

    //设置token
    public function setToken ($token) {
        $this->token = $token;
        return $this;
    }

    //生成token
    public function hasToken ($data,$ip) {
        $strToken = strtoupper(md5($data['open_id'].$ip.$data['user_id']).$data['timestamp']).'-'.substr(base64_encode(strrev($data['user_id']).rand(0,9)),0,-2);
        Cache::put(strtoupper($strToken),$data['user_id'].','.($data['timestamp']+60*60*6),60*60*24);
        return strtoupper($strToken);
    }

    //检查token有效性
    public function checkToken () {
        $dataStr = Cache::get($this->token);
        if (empty($dataStr)) {
            return false;
        }
        $splice = explode(',',$dataStr);
        if ((time() - $splice[1] < 0)) {
            return $this->token;
        }
        if ((time() - $splice[1] > 60*2)) {
            return $this->refresh();
        }
        return false;
    }

    //刷新token
    public function refresh () {
        $userKey  = substr((explode('-',$this->token))[1],0,-1);
        $userId   = strrev(base64_decode($userKey));
        $strToken = md5($this->token.(time() + 60*60*6)).$userKey.rand(0,9);
        Cache::put($strToken,$userId.','.(time() + 60*60*6),60*60*24);
        return $strToken;
    }
}