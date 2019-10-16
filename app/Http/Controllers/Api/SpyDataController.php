<?php

namespace App\Http\Controllers\Api;

use App\Repositories\ApiResponse;
use App\Repositories\HuoCollect\Repositories\RunMethod;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class SpyDataController extends BaseController
{
    use ApiResponse;

    public $run_data,$record_data;
    public function __construct(RunMethod $runMethod)
    {
        $this->run_data  =  $runMethod;
    }

    //用户更新提示数据
    public function changeData(Request $request) {
        $res = $this->run_data->update($request);
        if ($res) {
            return $this->success($res);
        }
        return $this->failed('update failed!');
    }

    //查询用户监控数据
    public function selData () {
        $data = $this->run_data->selRunData();
        if (sizeof($data)) {
            return $this->success($data);
        }
        return $this->failed('select failed!');
    }

    //查询采集数值
    public function selSpy (Request $request) {
        if (!$request->type) return $this->failed('params is error!');
        $data = $this->run_data->selSpyVal($request);
        if (sizeof($data)) {
            return $this->success($data);
        }
        return $this->failed('select failed!');
    }

    //查询最新数据
    public function selNews () {
        $data = $this->run_data->selNews();
        if (sizeof($data)) {
            return $this->success($data);
        }
        return $this->failed('select failed!');
    }

    //上传图片
    public function actionUpload (Request $request) {
        $fileResource = $request->file('file');
        return $fileResource;
    }
}