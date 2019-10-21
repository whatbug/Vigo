<?php

namespace App\Repositories\UserData\Repositories;

use App\Repositories\UserData\UserData;
use App\Services\CurlService;

Class UserDataRepository {

    private $appId,$secret,$curlService,$header;
    //获取openId地址
    private $openUrl="https://api.weixin.qq.com/sns/jscode2session";

    public function __construct(CurlService $curlService)
    {
        $this->appId = env('MINI_APP_ID');
        $this->secret= env('MINI_APP_SECRET');
        $this->curlService = $curlService;
        $this->header = array(
            "Mozilla/5.0 (iPhone; CPU iPhone OS 5_0 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A334 Safari/7534.48.3",
        );
    }

    //用户表模型
    public function model () {
        return UserData::class;
    }

    //获取openId token
    public function getOpenId ($code) {
        $this->openUrl = "{$this->openUrl}?appid=".trim($this->appId)."&secret=".trim($this->secret)."&js_code={$code}&grant_type=authorization_code";
        $wxRes = $this->curlService->_url($this->openUrl,'',$this->header);
        return json_decode($wxRes);
    }

    //用户登录  未登录触发注册动作
    public function loginOrRegAction ($code) {
        $backInfo = $this->getOpenId($code);
        return $backInfo;
        $regRes   = $this->model()->where('open_id',$backInfo['openid'])->first();
        //如果存在 使用token生成token
        if ($regRes) {
            //TODO
        } else {
            //TODO
        }
    }


}