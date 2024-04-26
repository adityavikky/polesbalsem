<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AntreanLoketDetail extends Model
{
    protected $table    = 'antrean_loket_detail';

    protected $fillable = [
        'id_antrean_loket_detail',
        'id_antrean_loket',
        'id_puskesmas',
        'id_loket',
        'tanggal_panggil',
        'qty_panggil',
        'status_antrean_loket_detail',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [

    ];

    public function loket()
    {
        return $this->belongsTo('App\Models\Loket', 'id_loket', 'id_loket');
    }

    public function antreanLoket()
    {
        return $this->belongsTo('App\Models\AntreanLoket', 'id_antrean_loket', 'id_antrean_loket');
    }
}
