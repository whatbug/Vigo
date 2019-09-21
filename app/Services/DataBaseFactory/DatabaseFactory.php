<?php namespace App\Services\DatabaseFactory;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

Class DatabaseFactory
{
    //redis 存储方式
    public function Redis() {
        return Cache::class;
    }

    public function Mysql() {
        return DB::class;
    }
}