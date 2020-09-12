<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ApiResponse;
use App\Repositories\UserData\Repositories\UserDataRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

Class UserDataController extends Controller {

    use ApiResponse;

    private $userRepository;

    public function __construct(UserDataRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    //魔术方法  导航至指定方法
    public function __call($method, $parameters)
    {
       $this->$method($parameters);
    }

    //小程序用户注册
    public function userRegOrLogin (Request $request) {
        $GrantData = $request->header('X-API-TOKEN');
        $GrantKey  = Cache::get($GrantData);
        if (!$GrantKey) {
            $GrantData = $this->userRepository->loginOrRegAction($request,$request->getClientIp());
        }
        return $this->success(['api_token'=>$GrantData]);
    }

    //用户数据
    public function dataList () {

    }


    //生日提醒提交
    public function birthTransport (Request $request) {
        $postRes = $this->userRepository->postBirthInfo($request,$this->userId());
        if ($postRes) {
            return $this->success(['message'=>'success']);
        }
        return $this->failed('提交失败');
    }
}
