<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPraktek extends Model
{
    protected $table    = 'jadwal_praktek';

    protected $fillable = [
        'id_jadwal_praktek',
        'id_poli',
        'kodepoli',
        'namapoli',
        'kodesubspesialis',
        'namasubspesialis',
        'kodedokter',
        'namadokter',
        'hari',
        'libur',
        'namahari',
        'jadwal',
        'buka',
        'tutup',
        'kapasitaspasien',
        'pasien_jkn',
        'pasien_umum',
        'status_jadwal_praktek'
    ];

    protected $hidden = [];

    public function poli()
    {
        return $this->belongsTo('App\Models\Poli', 'id_poli', 'id_poli');
    }

    public function dokter()
    {
        return $this->belongsTo('App\Models\Dokter', 'id_dokter', 'id_dokter');
    }
}


