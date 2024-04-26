<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\BpjsAntrolTraits;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Loket;

class LoketController extends Controller
{
    use BpjsAntrolTraits;

    public function index()
    {
        return view('data_loket');
    }

    public function data()
    {
        $data = Loket::all();
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return '<div class="btn-group">
                            <button type="button" id="btn-status" class="btn btn-sm btn-warning"
                                data-id="'      . $data->id_loket   . '"
                                data-nama="'    . $data->nama_loket . '"
                                onclick="updateStatus(this);">
                                Edit
                            </button>
                            <button type="button" id="btn-status" class="btn btn-sm btn-danger"
                                data-id="'      . $data->id_loket   . '"
                                data-nama="'    . $data->nama_loket . '"
                                onclick="updateStatus(this);">
                                Hapus
                            </button>
                        </div>';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function syncData()
    {
        $getData = $this->requestGetBpjs('ref/poli');
        $dataLoket = $getData['data'];
        for ($i=0; $i < count($dataLoket) - 1; $i++) {
            $checkAvailable = Loket::where('kodepoli', '=', $dataLoket[$i]['kdpoli'])->first();
            if (!$checkAvailable) {
                Loket::create(
                    [
                        'kodepoli'          => $dataLoket[$i]['kdpoli'],
                        'namapoli'          => $dataLoket[$i]['nmpoli'],
                        'kodesubspesialis'  => $dataLoket[$i]['kdsubspesialis'],
                        'namasubspesialis'  => $dataLoket[$i]['nmsubspesialis'],
                        'status_poli'       => 'Aktif'
                    ]
                );
            }
        }
    }

    public function updateStatus(Request $request)
    {
        if ($request->status=='Aktif') {
            Loket::where('kodepoli', '=', $request->kode)
                ->update(
                    [
                        'status_poli' => 'Non Aktif'
                    ]
                );
        } else {
            Loket::where('kodepoli', '=', $request->kode)
                ->update(
                    [
                        'status_poli' => 'Aktif'
                    ]
                );
        }
    }
}

