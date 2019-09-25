<?php namespace App\Repositories\HuoCollect\Repositories\Interfaces;

interface RecordData
{
    //禁止实例化
//    public function __construct();

    /*
     * 触发推送
     */
    public function notifyUsers($data,$type);

    /*
     * 查询数据
     */
    public function selRunData();

    /*
     * 更新信息
     */
    public function update($array);

    /*
     * 插入Redis
     */
    public function insertRedis($array,$key_name);
}