<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ApiResponse;
use App\Repositories\UserData\Repositories\UserDataRepository;
use Illuminate\Http\Request;

Class UserDataController extends Controller {

    use ApiResponse;

    private $repository;

    public function __construct(UserDataRepository $repository)
    {
        $this->repository = $repository;
    }

    //魔术方法  导航至指定方法
    public function __call($method, $parameters)
    {
       $this->$method($parameters);
    }

    //小程序用户注册
    public function userRegOrLogin (Request $request) {
        $GrantData = $request->header('X-API-TOKEN');
        if (!$GrantData) {
            $GrantData = $this->repository->loginOrRegAction($request,$request->getClientIp());
        }
        return $this->success(['api_token'=>$GrantData]);
    }

    //用户数据
    public function dataList () {

    }


    //生日提醒提交
    public function birthTransport (Request $request) {
        $postRes = $this->repository->postBirthInfo($request);
        if ($postRes) {
            return $this->success(['message'=>'success']);
        }
        return $this->failed('提交失败');
    }
}