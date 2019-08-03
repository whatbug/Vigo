<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cookie;

class TestController extends BaseController
{
    //验证密码正确性
    public function vpnValidate (Request $request) {
        if ($request->anhao == '卧槽我怎么知道'){
            setcookie("anhao",md5('卧槽我怎么知道'.$request->getClientIp()), time()+3600*24);
            return 1;
        }
        return 0;
    }
}