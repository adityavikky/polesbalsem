<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Antrean extends Model
{
    protected $table = 'antrean';
    protected $appends = ['last_task_id'];

    protected $fillable = [
        'id_antrean',
        'id_loket',
        'id_poli',
        'id_dokter',
        'id_user',
        'kodebooking',
        'jenispasien',
        'nomorkartu',
        'nik',
        'nohp',
        'kodepoli',
        'namapoli',
        'pasienbaru',
        'norm',
        'tanggalperiksa',
        'kodedokter',
        'namadokter',
        'jampraktek',
        'jeniskunjungan',
        'nomorreferensi',
        'nomorantrean',
        'angkaantrean',
        'estimasidilayani',
        'sisakuotajkn',
        'kuotajkn',
        'sisakuotanonjkn',
        'kuotanonjkn',
        'keterangan',
        'json_request',
        'json_response',
        'status_bpjs',
        'status_antrean',
        'daftaronline',
        'checkin'
    ];

    protected static function booted()
    {
        static::addGlobalScope('status', function (Builder $builder) {
            $builder->where('status_antrean', 'Aktif');
        });
    }

    public function antreanTask()
    {
        return $this->hasMany('App\Models\AntreanTask', 'id_antrean', 'id_antrean');
    }

    public function antreanTaskLast()
    {
        return $this->hasOne('App\Models\AntreanTask', 'id_antrean', 'id_antrean')
            ->orderBy('taskid', 'desc');
    }

    public function getLastTaskIdAttribute()
    {
        if ($this->antreanTaskLast != null ) {
            return $this->antreanTaskLast->taskid;
        }

        return null;
    }

    public function antrean_loket_hari_ini()
    {
        return $this->belongsTo('App\Models\AntreanLoket', 'id_loket', 'id_loket')
            ->where('tanggal_antrean_loket', '=', date('Y-m-d'))
            ->where('status_antrean_loket', '=', 'Aktif');
    }
}
