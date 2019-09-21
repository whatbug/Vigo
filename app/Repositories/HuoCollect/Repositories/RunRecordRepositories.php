<?php namespace App\Repositories\HuoCollect\Repositories;

use App\Repositories\HuoCollect\Repositories\Interfaces\RecordData;

Class RunRecordRepositories
{
    private $model;
    /**
     * RunRecordRepositories constructor
     * @param
     */
    public function __construct(RecordData $recordData)
    {
        $this->model = $recordData;
    }

    /**
     * send action notice users
     * @param $values
     * @param $type
     * @return bool
     */
    public function notifyUsers ($values,$type) : bool
    {
        $reNotifiers = $this->model->notifyUsers($values,$type);
        if ($reNotifiers) return true;
        return false;
    }

    /**
     * @param RunRecordRepositories $order
     * @return mixed
     */
    public function findProducts(RunRecordRepositories $order)
    {
        return 'TODO';
    }

    /**
     * create new record into mysql
     * @param array $params
     * @return bool
     */
    public function createRecord(array $params) : bool
    {
        // TODO
        return false;
    }

    /**
     * create news into redis
     */
    public function insertRedis ($list)
    {
        return $this->model->insertRedis($list);
    }

    /**
     * update exist data
     * @param $data
     * @return mixed
     */
    public function setRunData ($data){
        return $this->model->update($data);
    }

    /*
     * 查询未执行数据
     */
    public function selRunData() {
        return 11;
        return $this->model->selRunData();
    }


}