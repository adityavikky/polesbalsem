<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntreanLoket extends Model
{
    protected $table    = 'antrean_loket';

    protected $fillable = [
        'id_antrean_loket',
        'id_loket',
        'id_user',
        'id_antrean',
        'tanggal_antrean_loket',
        'status_antrean_loket'
    ];

    protected $hidden = [

    ];

    public function loket()
    {
        return $this->belongsTo('App\Models\Loket', 'id_loket', 'id_loket');
    }

    public function antrean()
    {
        return $this->belongsTo('App\Models\Antrean', 'id_antrean', 'id_antrean');
    }

    public function karyawan()
    {
        return $this->belongsTo('App\Models\User', 'id_user', 'id');
    }
}

