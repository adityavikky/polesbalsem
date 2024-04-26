<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Builder;


class Poli extends Model
{
    protected $table = 'poli';

    protected $fillable = [
        'id_poli',
        'kodepoli',
        'namapoli',
        'kodesubspesialis',
        'namasubspesialis',
        'estimasi_pelayanan',
        'status_poli'
    ];

    // protected static function booted()
    // {
    //     static::addGlobalScope('status', function (Builder $builder) {
    //         $builder->where('status_poli', 'Aktif');
    //     });
    // }
}
