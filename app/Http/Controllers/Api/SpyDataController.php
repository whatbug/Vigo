<?php

namespace App\Http\Controllers\Api;

use App\Repositories\RunData;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class SpyDataController extends BaseController
{
    public $run_data;
    public function __construct(RunData $run_data)
    {
        $this->run_data = $run_data;
    }

    //用户更新提示数据
    public function changeData(Request $request) {
        $res = $this->run_data->setRunData($request);
        if ($res) {
            return ['code'=>200,'success'=>true];
        }
        return ['code'=>300,'success'=>false];
    }
}