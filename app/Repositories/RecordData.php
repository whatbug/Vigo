<?php namespace App\Repositories;
use function foo\func;
use Illuminate\Database\Eloquent\Model;

Class RecordData extends Model {
    protected $table = 'record_data';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'values',
        'type',
        'time',
    ];

    //select data
    static function selData () {
        return ['value' => static::orderBy('time','DESC')->first()->values];
    }
}