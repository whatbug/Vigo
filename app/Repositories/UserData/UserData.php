<?php

namespace App\Repositories\UserData;

use Illuminate\Database\Eloquent\Model;

Class UserData extends Model {

    protected $table = 'users';

    protected $primaryKey = 'user_id';

    public $timestamps = false;

    protected $fillable = [
        'nickname',
        'password',
        'open_id',
        'mobile',
        'avatar',
        'email',
        'reg_at',
    ];
}