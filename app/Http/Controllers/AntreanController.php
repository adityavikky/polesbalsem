<?php

namespace App\Http\Controllers;

use Exception;

use Illuminate\Http\Request;
use App\Models\Antrean;
use App\Models\Loket;
use App\Models\AntreanLoket;
use App\Models\Poli;
use App\Models\AntreanOperasi;
use App\Models\AntreanTask;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use Spipu\Html2Pdf\Html2Pdf;

use App\Http\Traits\BpjsAntrolTraits;
use App\Models\JadwalPraktek;
use App\Services\BpjsAntrolService;

use App\Repositories\JadwalPraktekRepository;
use App\Repositories\AntreanRepository;

class AntreanController extends Controller
{
    use BpjsAntrolTraits;
    protected $bpjsAntrolService;
    protected $jadwalPraktekRepository;

    public function __construct(BpjsAntrolService $bpjsAntrolService)
    {
        $this->bpjsAntrolService = new $bpjsAntrolService;
    }

    public function antreanPendaftaran()
    {
        $data['loket']  = Loket::where('status_loket', '=', 'Aktif')
            ->where('type_loket', '=', 'Pendaftaran')
            ->orderBy('nama_loket', 'ASC')
            ->get();
        $data['poli']  = Poli::where('status_poli', '=', 'Aktif')
            ->orderBy('namapoli', 'ASC')
            ->get();
        return view('antrean_pendaftaran', $data);
    }

    public function antreanPoli()
    {
        $data['loket']  = Loket::where('status_loket', '=', 'Aktif')
            ->orderBy('nama_loket', 'ASC')
            ->get();
        $data['poli']  = Poli::where('status_poli', '=', 'Aktif')
            ->orderBy('namapoli', 'ASC')
            ->get();
        return view('antrean_poli', $data);
    }

    public function antreanFarmasi()
    {
        $data['loket']  = Loket::where('status_loket', '=', 'Aktif')
            ->where('type_loket', '=', 'Farmasi')
            ->orderBy('nama_loket', 'ASC')
            ->get();
        $data['poli']  = Poli::where('status_poli', '=', 'Aktif')
            ->orderBy('namapoli', 'ASC')
            ->get();
        return view('antrean_farmasi', $data);
    }

    public function create(Request $request)
    {
        $idBaru = $this->idBaru($request->jenis_pasien);
        $antreanCreated = Antrean::create([
            'id_poli'           => $request->id_poli,
            'id_dokter'         => $request->id_dokter,
            'kodebooking'       => $idBaru,
            'jenispasien'       => $request->type_pasien,
            'nomorkartu'        => $request->nomorkartu,
            'nik'               => $request->nik,
            'nohp'              => $request->nik,
            'kodepoli'          => $request->kodepoli,
            'namapoli'          => $request->namapoli,
            'pasienbaru'        => ($request->jenis_pasien== "Baru" ? 1 : 0 ),
            'norm'              => $request->norm,
            'tanggalperiksa'    => date('Y-m-d'),
            'kodedokter'        => $request->kodedokter,
            'namadokter'        => $request->namadokter,
            'jampraktek'        => $request->jampraktek,
            'jeniskunjungan'    => 1, // {1 (Rujukan FKTP), 2 (Rujukan Internal), 3 (Kontrol), 4 (Rujukan Antar RS)},
            'nomorreferensi'    => $request->norujukan,
            'nomorantrean'      => substr($idBaru, -4),
            'angkaantrean'      => intval(substr($idBaru, -3)),
            'estimasidilayani'  => 0,
            'sisakuotajkn'      => 0,
            'kuotajkn'          => 0,
            'sisakuotanonjkn'   => 0,
            'kuotanonjkn'       => 0,
            'keterangan'        => "",
            'json_request'      => "",
            'json_response'     => "",
            'status_bpjs'       => "Belum",
            'status_antrean'    => "Aktif"
        ]);

        if ($request->jenis_pasien== "Baru") {
            AntreanTask::create(
                [
                    'id_antrean'            => $antreanCreated->id,
                    'id_task'               => 1,
                    'kodebooking'           => $antreanCreated->kodebooking,
                    'taskid'                => 1,
                    'waktu'                 => now()->getTimestampMs(),
                    'json_request'          => "",
                    'json_response'         => "",
                    'status_bpjs'           => "Belum",
                    'status_antrean_task'   => "Aktif",
                ]
            );

            AntreanTask::create(
                [
                    'id_antrean'            => $antreanCreated->id,
                    'id_task'               => 2,
                    'kodebooking'           => $antreanCreated->kodebooking,
                    'taskid'                => 2,
                    'waktu'                 => now()->getTimestampMs(),
                    'json_request'          => "",
                    'json_response'         => "",
                    'status_bpjs'           => "Belum",
                    'status_antrean_task'   => "Aktif",
                ]
            );

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
        } else {
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
        }

        if ($antreanCreated) {
            $response   = array(
                'status'    => true,
                'message'   => 'Simpan data sukses.',
                'data'      => $antreanCreated
            );
        } else {
            $response   = array(
                'status'    => false,
                'message'   => 'Simpan data gagal',
                'data'      => ''
            );
        }

        return response()->json($response);
    }

    public function updatePendaftaran(Request $request, JadwalPraktekRepository $jadwalPraktekRepository, AntreanRepository $antreanRepository)
    {
        $data           = Antrean::where('id_antrean', $request->id_antrean)->first();
        if ($request->taskId==3) {

            // Hitung sisa antrian poli
            $getJadwal      = $jadwalPraktekRepository->getJadwalPraktek($request->kodepoli, $request->kodedokter);
            if ($getJadwal!=null) {
                $getSisaAntreanPoliDokter = $antreanRepository->sisaAntreanPoliDokter($request->kodepoli, $request->kodedokter);
                // dd($getSisaAntreanPoliDokter);
            }
            $antreanUpdated = Antrean::where('id_antrean', $request->id_antrean)
                ->update(
                    [
                        'jenispasien'       => $request->jenispasien,
                        'id_poli'           => $request->id_poli,
                        'id_dokter'         => $request->id_dokter,
                        'nomorkartu'        => (isset($request->nomorkartu) ? $request->nomorkartu : ""),
                        'nik'               => $request->nik,
                        'nohp'              => $request->nohp,
                        'kodepoli'          => $request->kodepoli,
                        'namapoli'          => $request->namapoli,
                        'norm'              => $request->norm,
                        'kodedokter'        => $request->kodedokter,
                        'namadokter'        => $request->namadokter,
                        'jampraktek'        => $request->jampraktek,
                        'nomorreferensi'    => (isset($request->nomorreferensi) ? $request->nomorreferensi : ""),
                        'status_antrean'    => "Aktif",
                        'estimasidilayani'  => 0,
                        'sisakuotajkn'      => ($getJadwal!=null ? $getJadwal->pasien_jkn - ($getSisaAntreanPoliDokter + 1) : 0),
                        'kuotajkn'          => ($getJadwal!=null ? $getJadwal->pasien_jkn : 0),
                        'sisakuotanonjkn'   => 0,
                        'kuotanonjkn'       => ($getJadwal!=null ? $getJadwal->pasien_umum : 0)
                    ]
                );
        }

        $checkAntreanTask = AntreanTask::where('id_antrean', '=', $data->id_antrean)
            ->where('taskid', '=', $request->taskId)
            ->first();
        if ($checkAntreanTask == null) {
            AntreanTask::create(
                [
                    'id_antrean'            => $request->id_antrean,
                    'id_task'               => $request->taskId,
                    'kodebooking'           => $data->kodebooking,
                    'taskid'                => $request->taskId,
                    'waktu'                 => now()->getTimestampMs(),
                    'json_request'          => "",
                    'json_response'         => "",
                    'status_bpjs'           => "Belum",
                    'status_antrean_task'   => "Aktif",
                ]
            );
        }

        // Jika jadwal kosong tidak bisa push data bpjs
        if ($getJadwal!=null) {
            $this->bpjsAntrolService->create($request->id_antrean);
        }

        switch ($request->taskId) {
            case 3:
                AntreanTask::where('id_antrean', '=', $request->id_antrean)
                    ->where('kodebooking' , '=', $data->kodebooking)
                    ->where('id_task' , '=', 3)
                    ->update(
                    [
                        'waktu' => now()->getTimestampMs()
                    ]
                );

                AntreanTask::create(
                    [
                        'id_antrean'            => $request->id_antrean,
                        'id_task'               => 4,
                        'kodebooking'           => $data->kodebooking,
                        'taskid'                => 4,
                        'waktu'                 => now()->getTimestampMs(),
                        'json_request'          => "",
                        'json_response'         => "",
                        'status_bpjs'           => "Belum",
                        'status_antrean_task'   => "Aktif",
                    ]
                );
                break;

            case 5:
                if ($request->farmasi=="Ada") {
                    AntreanTask::create(
                        [
                            'id_antrean'            => $request->id_antrean,
                            'id_task'               => 6,
                            'kodebooking'           => $data->kodebooking,
                            'taskid'                => 6,
                            'waktu'                 => now()->getTimestampMs(),
                            'json_request'          => "",
                            'json_response'         => "",
                            'status_bpjs'           => "Belum",
                            'status_antrean_task'   => "Aktif",
                        ]
                    );
                }
                break;

            default:
                # code...
                break;
        }

        if (isset($request->tanggaloperasi) OR $request->tanggaloperasi != null) {
            AntreanOperasi::create(
                [
                    'id_poli'               =>$request->id_poli,
                    'kodebooking'           =>$data->kodebooking,
                    'tanggaloperasi'        =>$request->tanggaloperasi,
                    'jenistindakan'         =>$request->jenistindakan,
                    'kodepoli'              => $request->kodepoli,
                    'namapoli'              => $request->namapoli,
                    'terlaksana'            => 0,
                    'nopeserta'             => (isset($request->nomorkartu) ? $request->nomorkartu : ""),
                    'lastupdate'            =>now()->getTimestampMs(),
                    'status_antrean_operasi'=> 'Aktif'
                ]
            );
        }

        $response   = array(
            'status'    => true,
            'message'   => 'Simpan data sukses.',
            'data'      => '' //$antreanUpdated
        );

        return response()->json($response);
    }

    public function cetak($idAntrean)
    {
        $data['antrean']  = Antrean::where('id_antrean', $idAntrean)->first();
        return view('print_antrean', $data);
    }

    public function delete(Request $request)
    {
        $resultValidation = Validator::make(
            $request->all(),
            [
                'id_antrean'   => 'required'
            ]
        );

        if ($resultValidation->fails()) {
            $response   = array(
                'status'    => false,
                'message'   => 'Data tidak lengkap.',
                'note'      => $resultValidation->errors()
            );
        } else {
            try {
                Antrean::where('id_antrean', '=', $request->id_antrean)
                    ->update([
                        'status_antrean'    => 'Tidak'
                    ]
                );

                $response   = array(
                    'status'    => true,
                    'message'   => 'Hapus data sukses.'
                );
            } catch (\Exception $e) {
                $response   = array(
                    'status'    => false,
                    'message'   => $e->getMessage()
                );
            }
        }

        return response()->json($response);
    }

    public function data(Request $request)
    {
        $data   = Antrean::where('status_antrean', '=', 'Aktif')
                ->where(DB::raw('LEFT(created_at,10)'), '=', date('Y-m-d'))
                ->whereHas('antreanTaskLast', function($query) use ($request) {
                    $query->where('taskid', '=', $request->taskId);
                    $query->where('status_antrean_task', '=', 'Aktif');
                });
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                return '<div class="btn-group">
                            <button type="button" id="btn-sound" class="btn btn-sm btn-info"
                            data-id="'      . $data->id_antrean        . '"
                            data-nomor="'    . $data->nomorantrean       . '">
                                Panggil
                            </button>
                            <button type="button" id="btn-delete" class="btn btn-sm btn-danger"
                                data-id="'  .   $data->id_antrean   . '"
                                >Hapus</button>
                        </div>';
            })
            ->addColumn('jam', function ($data) {
                return date('H:i:s', strtotime($data->created_at));
            })
            ->addColumn('kosong', function () {
                return '';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function dataDetail($idAntrean)
    {
        $data = Antrean::where('id_antrean', $idAntrean)
            ->with('antreanTask', 'antreanTask.task')
            ->first();
        return $data;
    }

    public function setAktifLoket(Request $request)
    {
        AntreanLoket::where('id_user', '=', Auth::user()->id)
            ->where(DB::raw('LEFT(tanggal_antrean_loket,10)'), '=', date('Y-m-d'))
            ->update(
                [
                    'status_antrean_loket'  => 'Tidak'
                ]
            );

        $result = AntreanLoket::create([
            'id_user'               => Auth::user()->id,
            'id_loket'              => $request->id_loket,
            'tanggal_antrean_loket' => date('Y-m-d H:i:s'),
            'status_antrean_loket'  => 'Aktif'
        ]);

        if ($result) {
            $response   = array(
                'status'    => true,
                'message'   => 'Simpan data sukses.',
                'data'      => $result
            );
        } else {
            $response   = array(
                'status'    => false,
                'message'   => 'Simpan data gagal',
                'data'      => ''
            );
        }

        return response()->json($response);
    }

    public function panggilAntrean(Request $request)
    {
        $dataAntrean   = Antrean::where('id_antrean', $request->id_antrean)->first();

        AntreanLoket::where('id_antrean_loket', '=', Auth::user()->loketAktif->id_antrean_loket)
            ->where('id_user', '=', Auth::user()->id)
            ->where('status_antrean_loket', '=', 'Aktif')
            ->where('tanggal_antrean_loket', '=', date('Y-m-d'))
            ->update(
                [
                'id_antrean'    => $request->id_antrean,
                ]
            );

        $checkAntreanTask = AntreanTask::where('id_antrean', '=', $request->id_antrean)
            ->where('taskid', '>=', $request->taskId)
            ->first();
        if ($checkAntreanTask == null) {
            AntreanTask::create(
                [
                    'id_antrean'            => $request->id_antrean,
                    'id_task'               => $request->taskId,
                    'kodebooking'           => $dataAntrean->kodebooking,
                    'taskid'                => $request->taskId,
                    'waktu'                 => now()->getTimestampMs(),
                    'json_request'          => "",
                    'json_response'         => "",
                    'status_bpjs'           => "Belum",
                    'status_antrean_task'   => "Aktif",
                ]
            );
        } else {
            AntreanTask::where('id_antrean', '=', $request->id_antrean)
                ->where('taskid', '=', $request->taskId)
                ->where('status_bpjs', '=', 'Belum')
                ->update(
                [
                    'waktu'                 => now()->getTimestampMs(),
                ]
            );
        }

        $data['loket']  = Loket::where('status_loket', '=', 'Aktif')
            ->orderBy('nama_loket', 'ASC')
            ->get();
        return view('list_loket_aktif', $data);
    }

    public function listAntrean()
    {
        $data = AntreanLoket::where('status_antrean_loket', '=', 'Aktif')
            ->where('tanggal_antrean_loket', '=', date('Y-m-d'))
            ->where('id_puskesmas', '=', Auth::user()->id_puskesmas)
            ->with(['loket', 'antrean'])
            ->get();

        $response   = array(
            'status'    => true,
            'message'   => 'Data tidak lengkap.',
            'data'      => $data
        );

        return response()->json($response);
    }

    private function idBaru($jenis)
    {
        switch ($jenis) {
            case 'Baru':
                $awalan = date('Ymd') . "A";
                break;

            case 'Lama':
                $awalan = date('Ymd') . "B";
                break;

            case 'MCU':
                $awalan = date('Ymd') . "C";
                break;

            default:
                $awalan = date('Ymd') . "A";
                break;
        }

        $data       = DB::table('antrean')->select(DB::raw('IFNULL(MAX(kodebooking),0) as id_max'))
                                ->where('kodebooking', 'like', '%' . $awalan . '%')
                                ->get();
        $idBaru     = $awalan . str_pad(((int)(substr($data[0]->id_max,-3))+1), 3, "0", STR_PAD_LEFT);

        return $idBaru;
    }
}
