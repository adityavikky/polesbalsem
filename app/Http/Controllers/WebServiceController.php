<?php

namespace App\Http\Controllers;

use App\Models\Antrean;
use App\Models\AntreanOperasi;
use App\Models\Dokter;
use App\Models\Poli;
use App\Models\AntreanTask;
use App\Models\JadwalPraktek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use App\Services\BpjsVclaimService;
use App\Repositories\AntreanRepository;

class WebServiceController extends Controller
{

    protected $bpjsVclaimService;
    protected $antreanRepository;

    public function __construct(BpjsVclaimService $bpjsVclaimService, AntreanRepository $antreanRepository)
    {
        $this->bpjsVclaimService = new $bpjsVclaimService;
        $this->antreanRepository = new $antreanRepository;
    }

    public function getToken()
    {
        $username = request()->header('x-username');
        $password = request()->header('x-password');
        $credentials = [
            'email' => $username,
            'password' => $password
        ];

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json([
                "metadata" => array (
                    "message" => "Username atau Password Tidak Sesuai",
                    "code" => 201
                )
            ]);
        }

        return response()->json([
            "response" => array(
                "token" =>  $token
            ),
            "metadata" => array (
                "message" => "Ok",
                "code" => 200
            )
        ]);
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

    public function getSampleData(Request $request)
    {
        $validateHeader = $this->validateHeaderUsername($request->header('x-username'));
        if ($validateHeader) {
            return response()->json($validateHeader);
        }

        $content = json_decode($request->getContent(), true);

        $validation = Validator::make(
            $content,
            [
                'tanggalperiksa' => 'date|date_format:Y-m-d|after_or_equal:today',
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

        $getData = Antrean::where('tanggalperiksa', '=', $content['tanggalperiksa'])->get();

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
                    'message' => 'Antrian tidak ada, data tidak ditemukan',
                    'code' => 201,
                ]
            ];
        }

        return response()->json($response);
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
        $validateHeader = $this->validateHeaderUsername($request->header('x-username'));
        if ($validateHeader) {
            return response()->json($validateHeader);
        }

        $content = json_decode($request->getContent(), true);

        $validation = Validator::make(
            $content,
            [
                'kodepoli' => 'required',
                'kodedokter' => 'required|numeric',
                'tanggalperiksa' => 'date|date_format:Y-m-d|after_or_equal:today',
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

        $dayOfWeek = date('N');

        $checkPoli = Poli::where('kodepoli', '=', $content['kodepoli'])->first();
        if ($checkPoli == null) {
            $response = [
                'response' => null,
                'metadata' => [
                    'message'   => 'kodepoli tidak tersedia.',
                    'code'      => 201,
                ]
            ];

            return response()->json($response);
        }

        $checkDokter = Dokter::where('kodedokter', '=', $content['kodedokter'])->first();
        if ($checkDokter == null) {
            $response = [
                'response' => null,
                'metadata' => [
                    'message' => 'kodedokter tidak tersedia.',
                    'code' => 201,
                ]
            ];

            return response()->json($response);
        }

        $checkJadwal = JadwalPraktek::where('kodedokter', '=', $content['kodedokter'])
            ->where('kodepoli', '=', $content['kodepoli'])
            ->where('hari', '=', $dayOfWeek)
            ->first();
        if ($checkJadwal == null) {
            $response = [
                'response' => null,
                'metadata' => [
                    'message' => 'Tidak ada jadwal praktek hari ini.',
                    'code' => 201,
                ]
            ];

            return response()->json($response);
        }

        $getData = Antrean::where('kodepoli', '=', $content['kodepoli'])
            ->where('kodedokter', '=', $content['kodedokter'])
            ->where('tanggalperiksa', '=', $content['tanggalperiksa'])
            ->first();

        $getDataLast = Antrean::where('tanggalperiksa', '=', $content['tanggalperiksa'])
            ->orderBy('id_antrean', 'desc')
            ->first();

        if ($getData) {
            $getSisaAntrean = $this->antreanRepository->sisaAntrean($content['tanggalperiksa']);
            $response = [
                'response' => [
                    "namapoli"          => $getData->namapoli,
                    "namadokter"        => $getData->namadokter,
                    "totalantrean"      => intval($getDataLast->angkaantrean),
                    "sisaantrean"       => $getSisaAntrean,
                    "antreanpanggil"    => intval($getData->nomorantrean),
                    "sisakuotajkn"      => intval($getDataLast->sisakuotajkn),
                    "kuotajkn"          => intval($getDataLast->kuotajkn),
                    "sisakuotanonjkn"   => intval($getDataLast->sisakuotanonjkn),
                    "kuotanonjkn"       => intval($getDataLast->kuotanonjkn),
                    "keterangan"        => ""
                ],
                'metadata' => [
                    'message' => 'Ok',
                    'code' => 200,
                ]
            ];
        } else {
            $response = [
                'response' => [
                    "namapoli"          => $checkJadwal->namapoli,
                    "namadokter"        => $checkJadwal->namadokter,
                    "totalantrean"      => 0,
                    "sisaantrean"       => 0,
                    "antreanpanggil"    => '-',
                    "sisakuotajkn"      => intval($checkJadwal->pasien_jkn),
                    "kuotajkn"          => intval($checkJadwal->pasien_jkn),
                    "sisakuotanonjkn"   => intval($checkJadwal->pasien_umum),
                    "kuotanonjkn"       => intval($checkJadwal->pasien_umum),
                    "keterangan"        => ""
                ],
                'metadata' => [
                    'message' => 'Ok',
                    'code' => 200,
                ]
            ];
        }

        return response()->json($response);
    }

    public function ambilAntrean(Request $request)
    {
        $validateHeader = $this->validateHeaderUsername($request->header('x-username'));
        if ($validateHeader) {
            return response()->json($validateHeader);
        }

        $content = json_decode($request->getContent(), true);

        $validation = Validator::make(
            $content,
            [
                'nomorkartu'    => 'required|numeric',
                'nik'           => 'required|numeric',
                'nohp'          => 'required|numeric',
                'kodepoli'      => 'required',
                // 'norm'          => 'required',
                'jeniskunjungan'=> 'required|numeric',
                'nomorreferensi'=> 'required',
                'kodedokter'    => 'required|numeric',
                'jampraktek'    => 'required',
                'tanggalperiksa'=> 'date|date_format:Y-m-d|after_or_equal:today',
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

        $dayOfWeek = date('N');

        $checkDokter = Dokter::where('kodedokter', '=', $content['kodedokter'])->first();
        if ($checkDokter == null) {
            $response = [
                'response' => null,
                'metadata' => [
                    'message' => 'kodedokter tidak tersedia.',
                    'code' => 201,
                ]
            ];

            return response()->json($response);
        }

        $checkJadwal = JadwalPraktek::where('kodedokter', '=', $content['kodedokter'])
            ->where('kodepoli', '=', $content['kodepoli'])
            ->where('hari', '=', $dayOfWeek)
            ->first();
        if ($checkJadwal == null) {
            $response = [
                'response' => null,
                'metadata' => [
                    'message' => 'Tidak ada jadwal praktek hari ini.',
                    'code' => 201,
                ]
            ];

            return response()->json($response);
        }

        $checkPoli = Poli::where('kodepoli', '=', $content['kodepoli'])->first();
        if ($checkPoli == null) {
            $response = [
                'response' => null,
                'metadata' => [
                    'message'   => 'kodepoli tidak tersedia.',
                    'code'      => 201,
                ]
            ];

            return response()->json($response);
        }

        $getData = $this->bpjsVclaimService->getCariNik($content['nik']);
        if ($getData['code'] != 200) {
            $response = [
                'response' => null,
                'metadata' => [
                    'message'   => $getData['message'],
                    'code'      => 201,
                ]
            ];

            return response()->json($response);
        }

        Log::info($getData);
        if ($getData['data']['peserta']['noKartu']=='0001302302924') {
            $getData['data']['peserta']['mr']['noMR'] = '000024';
            Log::info($getData);
        }

        if ($getData['data']['peserta']['mr']['noMR'] == '') {
            $response = [
                'response' => null,
                'metadata' => [
                    'message'   => 'Data pasien ini tidak ditemukan, silahkan datang langsung ke Balkesmas Wilayah Semarang untuk pendaftaran pasien baru.',
                    'code'      => 201,
                ]
            ];

            return response()->json($response);
        }

        $dataPasien = $getData['data'];

        $checkAvailableAntrean = Antrean::where('nomorkartu', '=', $content['nomorkartu'])
            ->where('tanggalperiksa', '=', $content['tanggalperiksa'])
            ->first();
        if ($checkAvailableAntrean != null) {
            $response = [
                'response' => null,
                'metadata' => [
                    'message'   => 'Nomor Antrean Hanya Dapat Diambil 1 Kali Pada Tanggal Yang Sama',
                    'code'      => 201,
                ]
            ];

            return response()->json($response);
        }

        $idBaru = $this->idBaru('Lama', $content['tanggalperiksa']);

        $mulaiPelayanan    = strtotime($content['tanggalperiksa'] . ' ' . $checkJadwal->buka . ':00');
        $estimasiPelayanan = ((intval(substr($idBaru, -3)) - 1) * $checkPoli->estimasi_pelayanan);
        $antreanCreated = Antrean::create([
            'id_poli'           => $checkDokter->id_dokter,
            'id_dokter'         => $checkPoli->id_poli,
            'kodebooking'       => $idBaru,
            'jenispasien'       => "JKN",
            'nomorkartu'        => $content['nomorkartu'],
            'nik'               => $content['nik'],
            'nohp'              => $content['nohp'],
            'kodepoli'          => $checkPoli->kodepoli,
            'namapoli'          => $checkPoli->namapoli,
            'pasienbaru'        => 0,
            'norm'              => ($content['norm']=='' ? $getData['data']['peserta']['mr']['noMR'] : ''),
            'tanggalperiksa'    => $content['tanggalperiksa'],
            'kodedokter'        => $checkDokter->kodedokter,
            'namadokter'        => $checkDokter->namadokter,
            'jampraktek'        => $content['jampraktek'],
            'jeniskunjungan'    => $content['jeniskunjungan'],
            'nomorreferensi'    => $content['nomorreferensi'],
            'nomorantrean'      => substr($idBaru, -4),
            'angkaantrean'      => intval(substr($idBaru, -3)),
            'estimasidilayani'  => $estimasiPelayanan + ($mulaiPelayanan * 1000) - 25200000,
            'sisakuotajkn'      => $checkJadwal->pasien_jkn - intval(substr($idBaru, -3)),
            'kuotajkn'          => $checkJadwal->pasien_jkn,
            'sisakuotanonjkn'   => 0,
            'kuotanonjkn'       => $checkJadwal->pasien_umum,
            'keterangan'        => "",
            'json_request'      => "",
            'json_response'     => "",
            'status_bpjs'       => "Belum",
            'status_antrean'    => "Aktif",
            'daftaronline'      => "Ya"
        ]);

        AntreanTask::create(
            [
                'id_antrean'            => $antreanCreated->id,
                'id_task'               => 3,
                'kodebooking'           => $antreanCreated->kodebooking,
                'taskid'                => 3,
                'waktu'                 => now()->getTimestampMs(),
                'json_request'          => "",
                'json_response'         => "",
                'status_bpjs'           => "Belum",
                'status_antrean_task'   => "Aktif",
            ]
        );

        if ($antreanCreated) {
            $result = [
                "nomorantrean"      => $antreanCreated->nomorantrean,
                "angkaantrean"      => $antreanCreated->angkaantrean,
                "kodebooking"       => $antreanCreated->kodebooking,
                "norm"              => $antreanCreated->norm,
                "namapoli"          => $antreanCreated->namapoli,
                "namadokter"        => $antreanCreated->namadokter,
                "estimasidilayani"  => $antreanCreated->estimasidilayani,
                "sisakuotajkn"      => $antreanCreated->sisakuotajkn,
                "kuotajkn"          => $antreanCreated->kuotajkn,
                "sisakuotanonjkn"   => $antreanCreated->sisakuotanonjkn,
                "kuotanonjkn"       => $antreanCreated->kuotanonjkn,
                "keterangan"        => "Peserta harap 60 menit lebih awal guna pencatatan administrasi."
            ];

            $response = [
                'response' => $result,
                'metadata' => [
                    'message' => 'Ok',
                    'code' => 200,
                ]
            ];
        } else {
            $response = [
                'response' => null,
                'metadata' => [
                    'message' => 'Gagal',
                    'code' => 201,
                ]
            ];
        }

        return response()->json($response);
    }

    public function sisaAntrean(Request $request)
    {
        $validateHeader = $this->validateHeaderUsername($request->header('x-username'));
        if ($validateHeader) {
            return response()->json($validateHeader);
        }

        $content = json_decode($request->getContent(), true);

        $validation = Validator::make(
            $content,
            [
                'kodebooking'   => 'required'
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

        $getData = Antrean::where('kodebooking', '=', $content['kodebooking'])->first();

        if ($getData) {
            $getSisaAntrean = $this->antreanRepository->sisaAntrean($getData->tanggalperiksa);
            $response = [
                'response' => [
                    "nomorantrean"      => $getData->nomorantrean,
                    "namapoli"          => $getData->namapoli,
                    "namadokter"        => $getData->namadokter,
                    "sisaantrean"       => $getSisaAntrean,
                    "antreanpanggil"    => $getData->nomorantrean,
                    "waktutunggu"       => 0,
                    "keterangan"        => ""
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

        return response()->json($response);
    }

    public function batalAntrean(Request $request)
    {
        $validateHeader = $this->validateHeaderUsername($request->header('x-username'));
        if ($validateHeader) {
            return response()->json($validateHeader);
        }

        $content = json_decode($request->getContent(), true);

        $validation = Validator::make(
            $content,
            [
                'kodebooking'   => 'required',
                'keterangan'    => 'required'
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

        $getData = Antrean::where('kodebooking', '=', $content['kodebooking'])->first();

        if ($getData) {
            $updateData = Antrean::where('kodebooking', '=', $content['kodebooking'])
                ->update(
                    [
                        "status_antrean"=> "Batal",
                        "keterangan"    => $content['keterangan']
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
    }

    public function checkIn(Request $request)
    {
        $validateHeader = $this->validateHeaderUsername($request->header('x-username'));
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

