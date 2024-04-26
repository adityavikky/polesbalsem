<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class AntreanTask extends Model
{
    protected $table = 'antrean_task';
    protected $appends = ['date', 'jam'];

    protected $fillable = [
        'id_antrean_task',
        'id_antrean',
        'id_task',
        'kodebooking',
        'taskid',
        'waktu',
        'json_request',
        'json_response',
        'status_bpjs',
        'status_antrean_task'
    ];

    // protected static function booted()
    // {
    //     static::addGlobalScope('status', function (Builder $builder) {
    //         $builder->where('status_antrean_task', 'Aktif');
    //     });
    // }

    public function antrean()
    {
        return $this->belongsTo('App\Models\Antrean', 'id_antrean', 'id_antrean');
    }

    public function task()
    {
        return $this->belongsTo('App\Models\Task', 'id_task', 'id_task');
    }

    public function getDateAttribute()
    {
        return date("Y-m-d H:i:s", ($this->waktu / 1000));
    }

    public function getJamAttribute()
    {
        return date("H:i:s", ($this->waktu / 1000));
    }
}
