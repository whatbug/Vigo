<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ApiResponse;
use App\Repositories\ProductData\Repositories\ProductDataRepository;
use App\Repositories\UserData\UserData;
use Illuminate\Http\Request;

Class ProductDataController extends Controller {

    use ApiResponse;

    private $dataRepository,$userData;

    public function __construct(ProductDataRepository $dataRepository,UserData $userData)
    {
        $this->dataRepository = $dataRepository;
        $this->userData       = $userData;
        $this->middleware('api.auth',[
            'except'  =>   [
                'getCallData'
            ]
        ]);
    }

    public function __call($method, $parameters)
    {
        $this->$method($parameters);
    }

    //获取流量
    public function getCallData (Request $request){
        return $this->dataRepository->doesRequest($request);
    }

    //提交手机号
    public function postMobile (Request $request) {
       if (!$request->input('value')) {
           return $this->failed('请提交正确的数值');
       }
       $resPost = $this->userData->update([
           'mobile'  => $request->input('value')
       ])->where([
           'user_id' => $this->userId()
       ]);
       if ($resPost) {
           return $this->created('提交成功');
       }
       return $this->failed('提交失败');
    }

    //微信状态变更
    public function wxChange (Request $request) {
        if (!$request->input('value')) {
            return $this->failed('请提交正确的数值');
        }
        $resPost = $this->userData->update([
            'wx_notice'  => $request->input('value')
        ])->where([
            'user_id' => $this->userId()
        ]);
        if ($resPost) {
            return $this->created('提交成功');
        }
        return $this->failed('提交失败');
    }

    //手机信息变更
    public function phoneChange (Request $request) {
        if (!$request->input('value')) {
            return $this->failed('请提交正确的数值');
        }
        $resPost = $this->userData->update([
            'phone_notice'  => $request->input('value')
        ])->where([
            'user_id' => $this->userId()
        ]);
        if ($resPost) {
            return $this->created('提交成功');
        }
        return $this->failed('提交失败');
    }
}
