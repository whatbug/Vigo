<?php namespace App\Repositories\HuoCollect;
use Illuminate\Database\Eloquent\Model;

Class RunData extends Model {
    protected $table = 'run_data';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'run_user',
        'max_value',
        'run_value',
        'mobile',
        'run_type',
        'run_time',
        'update_at',
    ];

    /*
     * 检查数据状态
     */
    public function checkStatus($class) {
        return self::whereId($class->id)->value('status');
    }

    /**
     * 执行更新操作
     */
    public function updates($id,$array) {
        return self::whereId($id)->update($array);
    }
}