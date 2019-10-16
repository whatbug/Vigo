<?php namespace App\Services;

use OSS\OssClient;

Class OssUploadService {
    //oss地址
    private $aliOssUrl;
    //ossBucket
    private $bucket;
    //ossAccessID
    private $accessId;
    //ossAccessKey
    private $accessKey;

    public function __construct()
    {
        $this->aliOssUrl = env('OSS_URL');
        $this->bucket    = env('OSS_BUCKET');
        $this->accessId  = env('OSS_ID');
        $this->accessKey = env('OSS_KEY');
    }

    /**
     * 上传文件到Oss
     * @param string $fileName
     * @param $oss_dir
     * @return null
     * @throws
     */
    public function uploadFileToOss($fileName,$oss_dir){
        //验证oss_dir
        if (empty($oss_dir)){
            return false;
        }
        $ossClient = new OssClient($this->accessId,$this->accessKey, $this->aliOssUrl);
        if (!$ossClient->doesObjectExist($this->bucket,$oss_dir)){
            $ossClient->createObjectDir($this->bucket,$oss_dir);
        }
        $ext = strrchr($fileName, '.');
        $hashFileName = sha1($fileName.time().rand(0,100)).$ext;
        $hashFileNameWithPath = $oss_dir.$hashFileName;
        //随机文件名防止重复
        $result = $ossClient->uploadFile($this->bucket,$hashFileNameWithPath,$fileName);
        if (isset($result['info'])){
            $result['info']['filename'] = $hashFileName;
            $result['info']['cdnUrl'] = str_replace('http','https',$result['info']['url']);
        }
        return isset($result['info']) ? $result['info'] : false;
    }

    /**
     * 获取路径
     * @param $oss_file
     * @param $oss_dir
     * @return string
     */
    public  function getOssUploadFileUrl($oss_file,$oss_dir){
        if (empty($oss_dir) || empty($oss_file)){
            return false;
        }
        return env("OSS_ENDPOINT").$oss_dir.$oss_file;
    }
}