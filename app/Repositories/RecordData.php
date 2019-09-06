<?php namespace App\Repositories;
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
}