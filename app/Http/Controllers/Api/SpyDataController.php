<?php

namespace App\Http\Controllers\Api;

use App\Repositories\RecordData;
use App\Repositories\RunData;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class SpyDataController extends BaseController
{
    public $run_data,$record_data;
    public function __construct(RunData $run_data,RecordData $record_data)
    {
        $this->run_data    = $run_data;
        $this->record_data = $record_data;
    }

    //用户更新提示数据
    public function changeData(Request $request) {
        $res = $this->run_data->setRunData($request);
        if ($res) {
            return ['code'=>200,'success'=>true];
        }
        return ['code'=>300,'success'=>false];
    }

    //查询当前实时数值
    public function selData () {
        $data = $this->record_data->selData();
        if (sizeof($data)) {
            return ['code'=>200,'data'=>$data,'success'=>true];
        }
        return ['code'=>300,'success'=>false];
    }
}