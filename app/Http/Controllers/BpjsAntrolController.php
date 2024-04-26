<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\BpjsAntrolTraits;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Poli;

class BpjsAntrolController extends Controller
{
    use BpjsAntrolTraits;

    public function getReferensiJadwalDokter(Request $request)
    {
        $date       = date('Y-m-d');
        $dataPoli   = Poli::where('id_poli', $request->id_poli)->first();
        $getData    = $this->requestGetBpjs('/jadwaldokter/kodepoli/' . $dataPoli->kodepoli . '/tanggal/' . $date);
        if ($getData['code']==201) {
            return response()->json(
                array(
                    'total_count' => 0,
                    'incomplete_results' => true,
                    'items' => []
                )
            );
        } else {
            $data = array_map(
                function ($data) {
                    return [
                        'id' => $data['kodedokter'],
                        'text' => $data['namadokter'],
                        'jadwal' => $data['jadwal'],
                        'kodepoli' => $data['kodepoli'],
                        'namapoli' => $data['namapoli'],
                        'namahari' => $data['namahari'],
                    ];
                },
                $getData['data']
            );

            return response()->json(
                array(
                    'total_count' => count($getData['data']),
                    'incomplete_results' => true,
                    'items' => $data
                )
            );
        }
    }
}

