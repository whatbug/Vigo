<?php

namespace App\Http\Controllers\Api;

use App\Repositories\HuoCollect\Repositories\Interfaces\RecordData;
use App\Repositories\HuoCollect\Repositories\RunMethod;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class SpyDataController extends BaseController
{
    public $run_data,$record_data;
    public function __construct(RunMethod $runMethod)
    {
        $this->run_data  =  $runMethod;
    }

    //用户更新提示数据
    public function changeData(Request $request) {
        $res = $this->run_data->update($request);
        if ($res) {
            return ['code'=>200,'success'=>true];
        }
        return ['code'=>300,'success'=>false];
    }

    //查询当前实时数值
    public function selData (RecordData $data) {
        $this->run_data = $data;
        $data = $this->run_data->selRunData();
        if (sizeof($data)) {
            return ['code'=>200,'data'=>$data,'success'=>true];
        }
        return ['code'=>300,'success'=>false];
    }

    //查询采集数值
    public function selSpy () {
        $data = $this->run_data->selSpyVal();
        if (sizeof($data)) {
            return ['code'=>200,'data'=>$data,'success'=>true];
        }
        return ['code'=>300,'success'=>false];
    }
}