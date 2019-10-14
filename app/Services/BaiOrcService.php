<?php namespace App\Services;

class BaiOrcService
{
    //普通识别URL
    private $generalBasicUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/accurate';

    //获取tokenURL
    private $getTokenUrl = 'https://aip.baidubce.com/oauth/2.0/token';

    //获取token
    public function getToken () {
        $header = array(
            "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36",
        );
        $post_data['grant_type'] = 'client_credentials';
        $post_data['client_id'] = 'oXQXwQAXjLcfnreYPY6WfMfc';
        $post_data['client_secret'] = 'eZGoWUGj5ulO0cdQ3jHqLbVtFPtTncm6';
        $o = "";
        foreach ($post_data as $k => $v)
        {
            $o .= "$k=" . urlencode($v). "&";
        }
        $post_data = substr($o, 0, -1);
        $res = json_decode((new CurlService)->_url($this->getTokenUrl, $post_data,$header));
        return $res->access_token;
    }

    /**
     * 获取识别结果
     * @param $imgurl
     * @666
     */
    public function resRecognize ($imgUrl) {
        $api = "{$this->generalBasicUrl}?access_token={$this->getToken()}";
        $header = ['Content-Type: application/x-www-form-urlencoded'];
        $post = [
            'image' => base64_encode(file_get_contents($imgUrl)),// 网络图片url
        ];
        $res = json_decode((new CurlService())->_url($api, $post, $header));
        return $res;
    }

}