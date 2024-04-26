<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntreanOperasi extends Model
{
    protected $table    = 'antrean_operasi';

    protected $fillable = [
        'id_antrean_operasi',
        'id_poli',
        'kodebooking',
        'tanggaloperasi',
        'jenistindakan',
        'kodepoli',
        'namapoli',
        'terlaksana',
        'nopeserta',
        'lastupdate',
        'status_antrean_operasi'
    ];

    protected $hidden = [];

    public function poli()
    {
        return $this->belongsTo('App\Models\Poli', 'id_poli', 'id_poli');
    }

    public function antrean()
    {
        return $this->belongsTo('App\Models\Antrean', 'kodebooking', 'kodebooking');
    }
}


