<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\UserData\Repositories\UserDataRepository;
use Illuminate\Http\Request;

Class UserDataController extends Controller {

    private $repository;

    public function __construct(UserDataRepository $repository)
    {
        $this->repository = $repository;
    }

    //小程序用户注册
    public function UserRegister (Request $request) {
        $GrantData = $this->repository->loginOrRegAction($request->code);
        var_dump($GrantData);
    }

    //用户数据
    public function dataList () {

    }
}