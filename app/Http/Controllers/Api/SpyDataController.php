<?php

namespace App\Http\Controllers\Api;

use App\Repositories\HuoCollect\Repositories\RunRecordRepositories;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class SpyDataController extends BaseController
{
    public $run_data,$record_data;
    public function __construct(RunRecordRepositories $runRecordRepositories)
    {
        $this->run_data  =  $runRecordRepositories;
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
        $data = $this->run_data->selRunData();
        if (sizeof($data)) {
            return ['code'=>200,'data'=>$data,'success'=>true];
        }
        return ['code'=>300,'success'=>false];
    }
}