<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BpjsVclaimService;

class BpjsVClaimController extends Controller
{
    protected $bpjsVclaimService;

    public function __construct(BpjsVclaimService $bpjsVclaimService)
    {
        $this->bpjsVclaimService = new $bpjsVclaimService;
    }

    public function getPesertaByNIK(Request $request)
    {
        $getData = $this->bpjsVclaimService->getCariNik($request->cari);
        if ($getData['code'] == 200) {
            $response = [
                "type"      => "Success",
                "status"    => true,
                "message"   => $getData['message'],
                "data"      => $getData['data']
            ];
        } else {
            $response = [
                "type"      => "Gagal",
                "status"    => false,
                "message"   => $getData['message'],
                "data"      => []
            ];
        }

        return response()->json($response);
    }

    public function getRujukanFaskesRS(Request $request)
    {
        $getDataFaskes  = $this->bpjsVclaimService->getRujukanFaskes($request->nomorkartu);
        // dd($getDataFaskes);
        if ($getDataFaskes['code']==201) {
            $dataFaskes = [];
        } else {
            $dataFaskes = array_map(
                function ($data) {
                    return [
                        'id' => $data['noKunjungan'],
                        'text' => $data['noKunjungan'],
                        'tanggal' => $data['tglKunjungan'],
                        'kodepoli' => $data['poliRujukan']['kode'],
                        'namapoli' => $data['poliRujukan']['nama'],
                        'kodeperujuk' => $data['provPerujuk']['kode'],
                        'namaperujuk' => $data['provPerujuk']['nama'],
                        'kodediagnosa' => $data['diagnosa']['kode'],
                        'namadiagnosa' => $data['diagnosa']['nama'],
                    ];
                },
                $getDataFaskes['data']['rujukan']
            );
        }

        $getDataRS      = $this->bpjsVclaimService->getRujukanRS($request->nomorkartu);

        if ($getDataRS['code']==201) {
            $dataRS = [];
        } else {
            $dataRS = array_map(
                function ($data) {
                    return [
                        'id' => $data['noKunjungan'],
                        'text' => $data['noKunjungan'],
                        'tanggal' => $data['tglKunjungan'],
                        'kodepoli' => $data['poliRujukan']['kode'],
                        'namapoli' => $data['poliRujukan']['nama'],
                        'kodeperujuk' => $data['provPerujuk']['kode'],
                        'namaperujuk' => $data['provPerujuk']['nama'],
                        'kodediagnosa' => $data['diagnosa']['kode'],
                        'namadiagnosa' => $data['diagnosa']['nama'],
                    ];
                },
                $getDataRS['data']['rujukan']
            );
        }

        $result = array_merge( $dataFaskes, $dataRS );

        return response()->json(
            array(
                'total_count' => count($result),
                'incomplete_results' => true,
                'items' => $result
            )
        );
    }
}


