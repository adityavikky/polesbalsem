<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\BpjsAntrolTraits;
use Yajra\DataTables\Facades\DataTables;
use App\Models\JadwalPraktek;
use App\Models\Poli;
use Illuminate\Support\Facades\Log;

class JadwalPraktekController extends Controller
{
    use BpjsAntrolTraits;

    public function index()
    {
        return view('data_jadwal_praktek');
    }

    public function data()
    {
        $data = JadwalPraktek::all();
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return '<div class="btn-group">
                            <button type="button" id="btn-update" class="btn btn-sm btn-warning"
                                data-id="'      . $data->id_jadwal_praktek  . '">
                                Edit
                            </button>
                        </div>';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function dataDetail($idJadwalPraktek)
    {
        $data = JadwalPraktek::where('id_jadwal_praktek', $idJadwalPraktek)->first();
        return $data;
    }

    public function syncData()
    {
        // data Poli Aktif
        $result = array();
        $getPoliAktif   = Poli::where('status_poli', '=', 'Aktif')->get();
        // dd($getPoliAktif);
        // perulangan sesuai dengan jumlah poli aktif
        foreach($getPoliAktif as $poli) {
            // looping sebanyak 7x asumsi 7 hari dari tanggal sekarang
            // log::info($poli->kodepoli);
            $date1          = date('Y-m-d');
            for ($i=0; $i < 7; $i++) {
                $getData= $this->requestGetBpjs('jadwaldokter/kodepoli/' . $poli->kodepoli . '/tanggal/' . $date1);
                // code 200 jika ada datanya
                if (count($getData['data'])>0) {
                    $dataJadwalPraktek = $getData['data'];
                    $result = array_merge($result, $dataJadwalPraktek);
                    // perulangan sesuai dengan jumlah data dari respknse API BPJS
                    for ($j=0; $j < count($dataJadwalPraktek); $j++) {
                        $checkAvailable = JadwalPraktek::where('kodepoli', '=', $dataJadwalPraktek[$j]['kodepoli'])
                            ->where('kodesubspesialis', '=', $dataJadwalPraktek[$j]['kodesubspesialis'])
                            ->where('hari', '=', $dataJadwalPraktek[$j]['hari'])
                            ->where('kodedokter', '=', $dataJadwalPraktek[$j]['kodedokter'])
                            ->first();
                        if ($checkAvailable == null) {
                            // Split jadwal
                            $jadwal = (explode("-", $dataJadwalPraktek[$j]['jadwal']));
                            $jadwalCreated = JadwalPraktek::create(
                                [
                                    'id_poli'               => $poli->id_poli,
                                    'kodepoli'              => $dataJadwalPraktek[$j]['kodepoli'],
                                    'namapoli'              => $dataJadwalPraktek[$j]['namapoli'],
                                    'kodesubspesialis'      => $dataJadwalPraktek[$j]['kodesubspesialis'],
                                    'namasubspesialis'      => $dataJadwalPraktek[$j]['namasubspesialis'],
                                    'kodedokter'            => $dataJadwalPraktek[$j]['kodedokter'],
                                    'namadokter'            => $dataJadwalPraktek[$j]['namadokter'],
                                    'hari'                  => $dataJadwalPraktek[$j]['hari'],
                                    'libur'                 => $dataJadwalPraktek[$j]['libur'],
                                    'namahari'              => $dataJadwalPraktek[$j]['namahari'],
                                    'jadwal'                => $dataJadwalPraktek[$j]['jadwal'],
                                    'buka'                  => $jadwal[0],
                                    'tutup'                 => $jadwal[1],
                                    'kapasitaspasien'       => $dataJadwalPraktek[$j]['kapasitaspasien'],
                                    'pasien_jkn'            => $dataJadwalPraktek[$j]['kapasitaspasien'],
                                    'status_jadwal_praktek' => 'Aktif'
                                ]
                            );

                            log::info($jadwalCreated);
                        }
                    }
                }
                // Tambahkan 1 hari untuk sync tanggal berikutnya
                $date2  = date('Y-m-d', strtotime('+1 days', strtotime($date1)));
                $date1  = $date2;
            }
        }
        return response()->json($result);
    }
}

