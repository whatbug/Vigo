<?php

namespace App\Repositories\UserData\Repositories;

use App\Repositories\UserData\UserData;
use App\Services\CrazyTokenService;
use App\Services\CurlService;

Class UserDataRepository {

    private $appId,$secret,$curlService,$header,$token,$user;
    //获取openId地址
    private $openUrl="https://api.weixin.qq.com/sns/jscode2session";

    public function __construct(CurlService $curlService,CrazyTokenService $tokenService,UserData $user)
    {
        $this->appId = env('MINI_APP_ID');
        $this->secret= env('MINI_APP_SECRET');
        $this->curlService = $curlService;
        $this->header = array(
            "Mozilla/5.0 (iPhone; CPU iPhone OS 5_0 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A334 Safari/7534.48.3",
        );
        $this->token = $tokenService;
        $this->user  = $user;
    }

    //用户表模型
    public function model () {
        return $this->user;
    }

    //获取openId token
    public function getOpenId ($code) {
        $this->openUrl = "{$this->openUrl}?appid=".trim($this->appId)."&secret=".trim($this->secret)."&js_code={$code}&grant_type=authorization_code";
        $wxRes = $this->curlService->_url($this->openUrl,'',$this->header);
        return json_decode($wxRes,true);
    }

    //用户登录  未注册触发注册动作
    public function loginOrRegAction ($request,$ip)
    {
        $backInfo = $this->getOpenId($request->code);
        if (!array_key_exists('openid', $backInfo)){
            return false;
        }
        $regRes   = $this->model()->where('open_id',$backInfo['openid'])->first();
        //如果存在 使用token生成token
        if ($regRes) {
            $data = array(
                'open_id'   => $backInfo['openid'],
                'timestamp' => time(),
                'user_id'   => $regRes['user_id']
            );
            return $data;
            return $this->token->setToken($data,$ip);
        } else {
            $baseData = [
                'open_id'=> $backInfo['openid'],
                'nickname'=>$request->nickname,
                'password'=>md5(123456),
                'avatar'  =>$request->avatar,
                'reg_at'  =>date('Y-m-d H:i:s'),
                ];
            $regRes = $this->user->fill($baseData)->save();
            return $this->token->setToken(['open_id'=>$backInfo['openid'],'timestamp'=>time(),'user_id'=>$regRes['user_id']],$ip);
        }
    }


/**
 * 检验数据的真实性，并且获取解密后的明文.
 * @param $encryptedData string 加密的用户数据
 * @param $iv string 与用户数据一同返回的初始向量
 * @param $data string 解密后的原文
 *
 * @return int 成功0，失败返回对应的错误码
 */
    private function decryptData( $appid,$sessionKey,$encryptedData, $iv, &$res )
    {
        if (strlen($sessionKey) != 24) {
            return -41001;
        }
        $aesKey=base64_decode($sessionKey);


        if (strlen($iv) != 24) {
            return -41002;
        }
        $aesIV=base64_decode($iv);

        $aesCipher=base64_decode($encryptedData);

        $result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

        $dataObj=json_decode( $result );
        if( $dataObj  == NULL )
        {
            return false;
        }
        if( $dataObj->watermark->appid != $appid )
        {
            return false;
        }
        $res = $dataObj;
        return 0;
    }

}