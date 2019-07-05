<?php namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;

Class TestController extends Controller {

    public function Swoole (){
        $swoole = app('swoole');
        var_dump($swoole->stats());
    }
}