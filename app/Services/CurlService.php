<?php namespace App\Services;

use Illuminate\Support\Facades\Cache;

Class CurlService {

    //模拟终端获取网页 cookie
    function get_cookie($url_,$params_ =''){
        $header = array(
            "Content-type:application/json;charset=utf-8",
            "Accept:application/json",
            "upgrade-insecure-requests: 1",
            "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36",
        );
        $ch = curl_init($url_); //初始化
        curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
        curl_setopt($ch,CURLOPT_HEADER,1); //将头文件的信息作为数据流输出
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); //返回获取的输出文本流
        curl_setopt($ch,CURLOPT_POSTFIELDS,$params_); //发送POST数据
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        $content = curl_exec($ch); //执行curl并赋值给$content
        preg_match('/Set-Cookie:(.*);/iU',$content,$str); //正则匹配
        $cookie  = substr($str[1],1);
        curl_close($ch);
        Cache::put('vpn_cookie',$cookie,120);
        return $cookie;
    }

    //模拟终端抓取数据 curl
    function _url($postUrl, $curlPost, $cookie, $valid='') {
        $time    = time();$round = round(100000000,999999999);
        $valid_  = "; _ga=GA1.2.1{$round}.{$time}; _gid=GA1.2.1{$round}.{$time}; _gat_gtag_UA_114706424_1=1";
        $cookie  = $valid?$cookie.$valid_:$cookie;
        $header  = array(
            "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36",
            "cookie: JSESSIONID=D1B896EE86F66EF26ACCA39D601F5574",
            ":authority: m.raws.tk",
            "upgrade-insecure-requests: 1",
            "referer: https://m.raws.tk/free_ssr",
            ":path: /tool/api/checkValid",
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER,$header);
        curl_setopt($curl,CURLOPT_HEADER,0); //将头文件的信息作为数据流输出
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,0); //返回获取的输出文本流
        curl_setopt($curl, CURLOPT_URL, $postUrl);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (sizeof($curlPost)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}