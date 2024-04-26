<?php

namespace App\Http\Controllers;

use App\Models\Antrean;
use App\Models\AntreanOperasi;
use App\Models\Dokter;
use App\Models\Poli;
use App\Models\JadwalPraktek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use App\Services\BpjsVclaimService;
use App\Repositories\AntreanRepository;
use Illuminate\Support\Facades\Http;

class DirectController extends Controller
{

    protected $bpjsVclaimService;
    protected $antreanRepository;

    public function __construct(BpjsVclaimService $bpjsVclaimService, AntreanRepository $antreanRepository)
    {
        $this->bpjsVclaimService = new $bpjsVclaimService;
        $this->antreanRepository = new $antreanRepository;
    }

    private function validateHeaderUsername($username)
    {
        if (auth('api')->user()->email != $username) {
            $response = [
                'response' => null,
                'metadata' => [
                    'message' => 'Username Tidak Sesuai',
                    'code' => 201,
                ]
            ];

            return $response;
        }

        return false;
    }

    public function getToken()
    {
        $response = Http::withHeaders(
            [
                'x-username' => request()->header('x-username'),
                'x-password' => request()->header('x-password')
            ]
        )->get('https://balkesmassmg.id/api/v1/getToken');
        
        $updd['url'] = 'getToken';
        $updd['post'] = request()->header('x-username')."<sp>".request()->header('x-password');
        DB::table('log')->insert($updd);
        
        $result = json_decode($response, true);

        return response()->json($result);
    }

    public function getSampleData(Request $request)
    {
        $response = Http::withHeaders(
            [
                'x-username' => $request->header('x-username'),
                'x-password' => $request->header('x-password')
            ]
        )->get('https://balkesmas.test/api/v1/getToken');

        dd($response);
        // $validateHeader = $this->validateHeaderUsername($request->header('x-username'));
        // if ($validateHeader) {
        //     return response()->json($validateHeader);
        // }

        // $content = json_decode($request->getContent(), true);

        // $validation = Validator::make(
        //     $content,
        //     [
        //         'tanggalperiksa' => 'date|date_format:Y-m-d|after_or_equal:today',
        //     ]
        // );

        // if ($validation->fails()) {
        //     $response = [
        //         'response' => null,
        //         'metadata' => [
        //             'message' => $validation->getMessageBag()->first(),
        //             'code' => 201,
        //         ]
        //     ];

        //     return response()->json($response);
        // }

        // $getData = Antrean::where('tanggalperiksa', '=', $content['tanggalperiksa'])->get();

        // if ($getData) {
        //     $response = [
        //         'response' => [
        //             "list"  => $getData
        //         ],
        //         'metadata' => [
        //             'message' => 'Ok',
        //             'code' => 200,
        //         ]
        //     ];
        // } else {
        //     $response = [
        //         'response' => null,
        //         'metadata' => [
        //             'message' => 'Antrian tidak ada, data tidak ditemukan',
        //             'code' => 201,
        //         ]
        //     ];
        // }

        // return response()->json($response);
    }

    public function getSampleDataOperasi(Request $request)
    {
        $validateHeader = $this->validateHeaderUsername($request->header('x-username'));
        if ($validateHeader) {
            return response()->json($validateHeader);
        }

        $content = json_decode($request->getContent(), true);

        $validation = Validator::make(
            $content,
            [
                'tanggaloperasi' => 'date|date_format:Y-m-d|after_or_equal:today',
            ]
        );

        if ($validation->fails()) {
            $response = [
                'response' => null,
                'metadata' => [
                    'message' => $validation->getMessageBag()->first(),
                    'code' => 201,
                ]
            ];

            return response()->json($response);
        }

        $getData = AntreanOperasi::where('tanggaloperasi', '=', $content['tanggaloperasi'])->get();

        if ($getData) {
            $response = [
                'response' => [
                    "list"  => $getData
                ],
                'metadata' => [
                    'message' => 'Ok',
                    'code' => 200,
                ]
            ];
        } else {
            $response = [
                'response' => null,
                'metadata' => [
                    'message' => 'Jadwal operasi tidak ada, data tidak ditemukan',
                    'code' => 201,
                ]
            ];
        }

        return response()->json($response);
    }

    public function statusAntrean(Request $request)
    {
        $response = Http::withHeaders(
            [
                'x-token'   => request()->header('x-token'),
                'x-username'=> request()->header('x-username'),
                'Accept'    => 'application/json '
            ]
        )
        ->withBody(
            $request->getContent(), 'json'
        )
        ->post('https://balkesmassmg.id/api/v1/statusAntrean');

        $result = json_decode($response, true);
        
        $updd['url'] = 'statusAntrean';
        $updd['post'] = json_encode($request);
        DB::table('log')->insert($updd);
        
        return response()->json($result);
    }

    public function ambilAntrean(Request $request)
    {
        $response = Http::withHeaders(
            [
                'x-token'   => request()->header('x-token'),
                'x-username'=> request()->header('x-username'),
                'Accept'    => 'application/json '
            ]
        )
        ->withBody(
            $request->getContent(), 'json'
        )
        ->post('https://balkesmassmg.id/api/v1/ambilAntrean');

        $result = json_decode($response, true);
        
        $updd['url'] = 'ambilAntrean';
        $updd['post'] = json_encode($request);
        DB::table('log')->insert($updd);
        
        return response()->json($result);
    }

    public function sisaAntrean(Request $request)
    {
        $response = Http::withHeaders(
            [
                'x-token'   => request()->header('x-token'),
                'x-username'=> request()->header('x-username'),
                'Accept'    => 'application/json '
            ]
        )
        ->withBody(
            $request->getContent(), 'json'
        )
        ->post('https://balkesmassmg.id/api/v1/sisaAntrean');

        $result = json_decode($response, true);
        
        $updd['url'] = 'sisaAntrean';
        $updd['post'] = json_encode($request);
        DB::table('log')->insert($updd);
        
        return response()->json($result);
    }

    public function batalAntrean(Request $request)
    {
        $response = Http::withHeaders(
            [
                'x-token'   => request()->header('x-token'),
                'x-username'=> request()->header('x-username'),
                'Accept'    => 'application/json '
            ]
        )
        ->withBody(
            $request->getContent(), 'json'
        )
        ->post('https://balkesmassmg.id/api/v1/antrean/batal');

        $result = json_decode($response, true);
        
        $updd['url'] = 'batalAntrean';
        $updd['post'] = json_encode($request);
        DB::table('log')->insert($updd);
        
        return response()->json($result);
    }
    
    //email
    public function checkIn(Request $request)
    {
        $response = Http::withHeaders(
            [
                'x-token'   => request()->header('x-token'),
                'x-username'=> request()->header('x-username'),
                'Accept'    => 'application/json '
            ]
        )
        ->withBody(
            $request->getContent(), 'json'
        )
        ->post('https://balkesmassmg.id/api/v1/checkIn');

        $result = json_decode($response, true);
        
        $updd['url'] = 'checkIn';
        $updd['post'] = json_encode($request);
        DB::table('log')->insert($updd);
        
        return response()->json($result);
        
        
        /*$validateHeader = $this->validateHeaderUsername($request->header('x-username'));
        if ($validateHeader) {
            return response()->json($validateHeader);
        }

        $content = json_decode($request->getContent(), true);

        $validation = Validator::make(
            $content,
            [
                'kodebooking'   => 'required',
                'waktu'         => 'required'
            ]
        );
        
        if ($validation->fails()) {
            $response = [
                'response' => null,
                'metadata' => [
                    'message' => $validation->getMessageBag()->first(),
                    'code' => 201,
                ]
            ];

            return response()->json($response);
        }

        $getData = Antrean::where('kodebooking', '=', $content['kodebooking'])
            ->where('daftaronline', '=', 'Ya')
            ->first();

        if ($getData) {
            $updateData = Antrean::where('kodebooking', '=', $content['kodebooking'])
                ->update(
                    [
                        "checkin"    => now()->getTimestampMs()
                    ]
                );
            if ($updateData) {
                $response = [
                    'metadata' => [
                        'message' => 'Ok',
                        'code' => 200,
                    ]
                ];
            } else {
                $response = [
                    'metadata' => [
                        'message' => 'Batal Antrean Gagal',
                        'code' => 201,
                    ]
                ];
            }
        } else {
            $response = [
                'response' => null,
                'metadata' => [
                    'message' => 'Antrian tidak ada, data tidak ditemukan',
                    'code' => 201,
                ]
            ];
        }

        return response()->json($response);
        */
    }

    public function infoPasienBaru(Request $request)
    {
        $validateHeader = $this->validateHeaderUsername($request->header('x-username'));
        if ($validateHeader) {
            return response()->json($validateHeader);
        }

        $response = [
            'response' => null,
            'metadata' => [
                'message' => 'Fitur ini tidak tersedia, silahkan datang langsung ke Balkesmas Wilayah Semarang untuk pendaftaran pasien baru.',
                'code' => 201,
            ]
        ];

        return response()->json($response);
    }

    public function jadwalOperasiRS(Request $request)
    {
        $validateHeader = $this->validateHeaderUsername($request->header('x-username'));
        if ($validateHeader) {
            return response()->json($validateHeader);
        }

        $content = json_decode($request->getContent(), true);

        $validation = Validator::make(
            $content,
            [
                'tanggalawal'   => 'required|date_format:Y-m-d|after_or_equal:today',
                'tanggalakhir'   => 'required|date_format:Y-m-d|after_or_equal:today',
            ]
        );

        if ($validation->fails()) {
            $response = [
                'response' => null,
                'metadata' => [
                    'message' => $validation->getMessageBag()->first(),
                    'code' => 201,
                ]
            ];

            return response()->json($response);
        }

        $getData = AntreanOperasi::select('kodebooking', 'tanggaloperasi', 'jenistindakan', 'kodepoli', 'namapoli', 'terlaksana', 'nopeserta', 'lastupdate')
            ->where('tanggaloperasi', '>=', $content['tanggalawal'])
            ->where('tanggaloperasi', '<=', $content['tanggalakhir'])
            ->get();

        if ($getData) {
            $response = [
                'response' => [
                    "list"      => $getData
                ],
                'metadata' => [
                    'message' => 'Ok',
                    'code' => 200,
                ]
            ];
        } else {
            $response = [
                'response' => null,
                'metadata' => [
                    'message' => 'Antrian tidak ada, data tidak ditemukan',
                    'code' => 201,
                ]
            ];
        }
        
        $updd['url'] = 'jadwalOperasiRS';
        $updd['post'] = json_encode($request);
        DB::table('log')->insert($updd);
        
        return response()->json($response);
    }

    public function jadwalOperasiPasien(Request $request)
    {
        $validateHeader = $this->validateHeaderUsername($request->header('x-username'));
        if ($validateHeader) {
            return response()->json($validateHeader);
        }

        $content = json_decode($request->getContent(), true);

        $validation = Validator::make(
            $content,
            [
                'nopeserta'   => 'required'
            ]
        );

        if ($validation->fails()) {
            $response = [
                'response' => null,
                'metadata' => [
                    'message' => $validation->getMessageBag()->first(),
                    'code' => 201,
                ]
            ];

            return response()->json($response);
        }

        $getData = AntreanOperasi::select('kodebooking', 'tanggaloperasi', 'jenistindakan', 'kodepoli', 'namapoli', 'terlaksana')
            ->where('nopeserta', '=', $content['nopeserta'])
            ->get();

        if ($getData) {
            $response = [
                'response' => [
                    "list"      => $getData
                ],
                'metadata' => [
                    'message' => 'Ok',
                    'code' => 200,
                ]
            ];
        } else {
            $response = [
                'response' => null,
                'metadata' => [
                    'message' => 'Antrian tidak ada, data tidak ditemukan',
                    'code' => 201,
                ]
            ];
        }
        
        $updd['url'] = 'jadwalOperasiPasien';
        $updd['post'] = json_encode($request);
        DB::table('log')->insert($updd);

        return response()->json($response);
    }

    private function idBaru($jenis, $tanggal)
    {
        if ($tanggal == null) {
            $tanggal = date('Y-m-d');
        }
        switch ($jenis) {
            case 'Baru':
                $awalan = date('Ymd', strtotime($tanggal)) . "A";
                break;

            case 'Lama':
                $awalan = date('Ymd', strtotime($tanggal)) . "B";
                break;

            case 'MCU':
                $awalan = date('Ymd', strtotime($tanggal)) . "C";
                break;

            default:
                $awalan = date('Ymd', strtotime($tanggal)) . "A";
                break;
        }

        $data       = DB::table('antrean')->select(DB::raw('IFNULL(MAX(kodebooking),0) as id_max'))
                                ->where('kodebooking', 'like', '%' . $awalan . '%')
                                ->get();
        $idBaru     = $awalan . str_pad(((int)(substr($data[0]->id_max,-3))+1), 3, "0", STR_PAD_LEFT);

        return $idBaru;
    }
}


