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
    function _url($postUrl, $curlPost,$header) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER,$header);
        curl_setopt($curl,CURLOPT_HEADER,0); //将头文件的信息作为数据流输出
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,0); //返回获取的输出文本流
        curl_setopt($curl, CURLOPT_URL, $postUrl);
        curl_setopt($curl, CURLOPT_PROXY, 'http://115.159.31.195:8080');
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