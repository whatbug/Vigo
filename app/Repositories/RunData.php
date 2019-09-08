<?php namespace App\Repositories;
use App\Services\MessageNotifier;
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

    //notify everyone in right
    static public function notifyUsers ($vales,$type) {
        $reNotifiers = static::where('run_type',$type)->where('run_time',0)->get();
        if (sizeof($reNotifiers)) {
            foreach ($reNotifiers as $notify) {
                if ($vales <= $notify->run_value + $notify->max_value) {
                    MessageNotifier::sendMsg($notify->nobile, (float)$vales);
                    static::whereId($notify->id)->update(['run_time'=>time()]);
                }
            }
        }
        return true;
    }

    //update to set infos
    static public function setRunData ($data){
         return static::whereId(1)->update(['run_value'=>$data->run_value,'run_time'=>0]);
    }

}