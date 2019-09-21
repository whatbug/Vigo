<?php namespace App\Repositories\HuoCollect\Repositories;

use App\Repositories\HuoCollect\Repositories\Interfaces\RecordData;
use App\Repositories\HuoCollect\RunData;
use App\Services\MessageNotifier;
use Illuminate\Support\Facades\Cache;

Class RunMethod implements RecordData
{
    private $model,$status;

    public function __construct()
    {
        $this->model = new RunData();
    }

    /*
     * 通知方法实现
     */
    public function notifyUsers($values,$type) {
        $reNotifiers = $this->model->query()->where('run_type',$type)->where('run_time',0)->get();
        if (sizeof($reNotifiers)) {
            foreach ($reNotifiers as $notify) {
                if ($values <= $notify->run_value + $notify->max_value) {
                    MessageNotifier::sendMsg($notify->mobile, $values);
                    $this->model->whereId($notify->id)->update(['run_time'=>time()]);
                }
            }
        }
        return true;
    }

    /*
     * 数据查询
     */
    public function selRunData()
    {
        return $this->model->query()->whereStatus(0)->get()->toArray();
    }


    /*
     * 更新数据
     */
    public function update($array)
    {
        return $this->checkStatus($array)->updates($array);
    }

    /*
     * 存入Redis
     */
    public function insertRedis($array) {
        $getData = Cache::get('btc_record')?:[];
        if (sizeof($getData) > 60) $getData=array_values(array_slice($getData,sizeof($getData)-40,sizeof($getData)-1));
        array_unshift($getData,$array);
        return Cache::put('btc_record',$getData,10*60);
    }

    /**
     * 判断数据状态
     */
    public function checkStatus($id) {
        $this->status = $this->model->checkStatus($id);
        return $this;
    }

    /**
     * 更新数据
     */
    public function updates ($array) {
        if ($this->status) {
            return $this->model->update($array);
        }
        return false;
    }
}