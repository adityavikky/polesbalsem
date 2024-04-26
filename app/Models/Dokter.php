<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $table = 'dokter';

    protected $fillable = [
        'id_dokter',
        'kodedokter',
        'namadokter',
        'status_dokter'
    ];
}

