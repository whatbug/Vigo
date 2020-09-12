<?php

namespace App\Repositories\ProductData\Repositories;


use App\Services\CurlService;
use Illuminate\Http\Request;

Class ProductDataRepository {

    private $request,$curlService,$header;

    public function __construct(Request $request,CurlService $curlService)
    {
        $this->request = $request;
        $this->curlService = $curlService;
        $this->header = array(
            "Mozilla/5.0 (iPhone; CPU iPhone OS 5_0 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A334 Safari/7534.48.3",
        );
    }


    public function doesRequest ($request) {
        $urlRequest = "https://m.10010.com/god/AirCheckMessage/sendCaptcha";
        $postData = ['action'=>'getCallData','phoneVal'=>$request->phone,'type'=>21];
//        if ($request->captcha) {
//            $postData  = '';
//            $urlRequest = "https://m.10010.com/god/qingPiCard/flowExchange?number={$request->phone}&type=21&captcha={$request->captcha}";
//        }
        $result = $this->curlService->_url($urlRequest,json_encode($postData),$this->header);
        var_dump($result);
    }
}
