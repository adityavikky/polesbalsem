<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Loket extends Model
{
    protected $table = 'loket';

    protected $fillable = [
        'id_loket',
        'type_loket',
        'nama_loket',
        'status_loket'
    ];

    protected static function booted()
    {
        static::addGlobalScope('status', function (Builder $builder) {
            $builder->where('status_loket', 'Aktif');
        });
    }

    public function antreanLoketHariIni()
    {
        return $this->belongsTo('App\Models\AntreanLoket', 'id_loket', 'id_loket')
            ->where('tanggal_antrean_loket', '=', date('Y-m-d'))
            ->where('status_antrean_loket', '=', 'Aktif');
    }
}
