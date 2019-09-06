<?php namespace App\Services;

Class MessageNotifier {
    //发送语音通知
    public static function sendMsg ($mobile,$variable) {
        $host = "http://yzxyytz.market.alicloudapi.com";
        $path = "/yzx/voiceNotifySms";
        $method  = "POST";
        $appCode = "6b0c4882ddd648beb220a43a1e591b45";
        $templateId = 'TP19090518';
        $headers    = array();
        array_push($headers, "Authorization:APPCODE " . $appCode);
        $query = "phone={$mobile}&templateId={$templateId}&variable=code:{$variable}";
        $url = $host . $path . "?" . $query;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        return json_decode($curl);
    }
}