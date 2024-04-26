<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Task extends Model
{
    protected $table = 'task';

    protected $fillable = [
        'id_task',
        'keterangan_task',
        'status_task'
    ];

    protected static function booted()
    {
        static::addGlobalScope('status', function (Builder $builder) {
            $builder->where('status_task', 'Aktif');
        });
    }
}
