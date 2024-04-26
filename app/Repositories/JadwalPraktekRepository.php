<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\JadwalPraktek;

class JadwalPraktekRepository
{
    public function getJadwalPraktek($kodePoli, $kodeDokter, $hari = null)
    {
        if ($hari==null) {
            $hari = date('N');
        }
        return JadwalPraktek::where('kodepoli', $kodePoli)
            ->where('kodedokter', $kodeDokter)
            ->where('hari', $hari)
            ->first();
    }
}
