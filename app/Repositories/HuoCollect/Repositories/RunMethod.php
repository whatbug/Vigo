<?php namespace App\Repositories\HuoCollect\Repositories;

use App\Jobs\ProcessSpy;
use App\Repositories\HuoCollect\Repositories\Interfaces\RecordData;
use App\Repositories\HuoCollect\RunData;
use App\Services\MessageNotifier;
use Illuminate\Support\Facades\Cache;

Class RunMethod implements RecordData
{
    private $model,$status;

    const BTC = 'btc_record';
    const EHT = 'eht_record';
    const EOS = 'eos_record';

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
                if ($notify->is_size) {
                    if ($values <= $notify->run_value + $notify->max_value) {
                        MessageNotifier::sendMsg($notify->mobile, $values);
                        $this->model->whereId($notify->id)->update(['run_time' => time()]);
                    }
                } else {
                    if ($values >= $notify->run_value + $notify->max_value) {
                        MessageNotifier::sendMsg($notify->mobile, $values);
                        $this->model->whereId($notify->id)->update(['run_time' => time()]);
                    }
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
        return $this->model->query()->where('run_time',0)->get()->toArray();
    }

    /*
     * 采集数值查询
     */
    public function selSpyVal($request) {
        return Cache::get(constant('self::'.$request->type))?:[];
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
    public function insertRedis($array,$key_name) {
        $getData = Cache::get($key_name)?:[];
        if (sizeof($getData) > 60) $getData=array_values(array_slice($getData,0,sizeof($getData)-40));
        array_unshift($getData,$array);
        return Cache::put($key_name,$getData,10*60);
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

    /**
     * 查询最新数据
     */
    public function selNews () {
        if (!sizeof(Cache::get(self::BTC))) return array();
        return [
           'BTC' => [ 'value'=>Cache::get(self::BTC)[0]['values'],'rmb'=> Cache::get(self::BTC)[0]['rmb']],
           'EHT' => [ 'value'=>Cache::get(self::EHT)[0]['values'],'rmb'=> Cache::get(self::EHT)[0]['rmb']],
           'EOS' => [ 'value'=>Cache::get(self::EOS)[0]['values'],'rmb'=> Cache::get(self::EOS)[0]['rmb']]
        ];
    }
}
