<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\BpjsAntrolTraits;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Poli;

class PoliController extends Controller
{
    use BpjsAntrolTraits;

    public function index()
    {
        return view('data_poli');
    }

    public function data()
    {
        $data = Poli::all();
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                if ($data->status_poli=='Aktif') {
                    return '<div class="btn-group">
                            <button type="button" id="btn-status" class="btn btn-sm btn-success"
                                data-id="'      . $data->id_poli        . '"
                                data-kode="'    . $data->kodepoli       . '"
                                data-status="'  . $data->status_poli    . '"
                                onclick="updateStatus(this);"
                                >Aktif</button>
                        </div>';
                }
                return '<div class="btn-group">
                            <button type="button" id="btn-status" class="btn btn-sm btn-secondary"
                                data-id="'      . $data->id_poli        . '"
                                data-kode="'    . $data->kodepoli       . '"
                                data-status="'  . $data->status_poli    . '"
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
        $getData = $this->requestGetBpjs('ref/poli');
        $dataPoli = $getData['data'];
        for ($i=0; $i < count($dataPoli) - 1; $i++) {
            $checkAvailable = Poli::where('kodepoli', '=', $dataPoli[$i]['kdpoli'])->first();
            if (!$checkAvailable) {
                Poli::create(
                    [
                        'kodepoli'          => $dataPoli[$i]['kdpoli'],
                        'namapoli'          => $dataPoli[$i]['nmpoli'],
                        'kodesubspesialis'  => $dataPoli[$i]['kdsubspesialis'],
                        'namasubspesialis'  => $dataPoli[$i]['nmsubspesialis'],
                        'status_poli'       => 'Aktif'
                    ]
                );
            }
        }
    }

    public function updateStatus(Request $request)
    {
        if ($request->status=='Aktif') {
            Poli::where('kodepoli', '=', $request->kode)
                ->update(
                    [
                        'status_poli' => 'Non Aktif'
                    ]
                );
        } else {
            Poli::where('kodepoli', '=', $request->kode)
                ->update(
                    [
                        'status_poli' => 'Aktif'
                    ]
                );
        }
    }
}

