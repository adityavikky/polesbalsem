<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\BpjsAntrolTraits;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Dokter;

class DokterController extends Controller
{
    use BpjsAntrolTraits;

    public function index()
    {
        return view('data_dokter');
    }

    public function data()
    {
        $data = Dokter::all();
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                if ($data->status_dokter=='Aktif') {
                    return '<div class="btn-group">
                            <button type="button" id="btn-status" class="btn btn-sm btn-success"
                                data-id="'      . $data->id_dokter      . '"
                                data-kode="'    . $data->kodedokter     . '"
                                data-status="'  . $data->status_dokter  . '"
                                onclick="updateStatus(this);"
                                >Aktif</button>
                        </div>';
                }
                return '<div class="btn-group">
                            <button type="button" id="btn-status" class="btn btn-sm btn-secondary"
                                data-id="'      . $data->id_dokter      . '"
                                data-kode="'    . $data->kodedokter     . '"
                                data-status="'  . $data->status_dokter  . '"
                                onclick="updateStatus(this);"
                                >Tidak Aktif</button>
                        </div>';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function syncData()
    {
        $getData = $this->requestGetBpjs('ref/dokter');
        // dd($getData);
        $dataDokter = $getData['data'];
        for ($i=0; $i < count($dataDokter) - 1; $i++) {
            $checkAvailable = Dokter::where('kodedokter', '=', $dataDokter[$i]['kodedokter'])->first();
            if (!$checkAvailable) {
                Dokter::create(
                    [
                        'kodedokter'    => $dataDokter[$i]['kodedokter'],
                        'namadokter'    => $dataDokter[$i]['namadokter'],
                        'status_dokter'   => 'Aktif'
                    ]
                );
            }
        }
    }

    public function updateStatus(Request $request)
    {
        if ($request->status=='Aktif') {
            Dokter::where('kodedokter', '=', $request->kode)
                ->update(
                    [
                        'status_dokter' => 'Non Aktif'
                    ]
                );
        } else {
            Dokter::where('kodedokter', '=', $request->kode)
                ->update(
                    [
                        'status_dokter' => 'Aktif'
                    ]
                );
        }
    }
}


