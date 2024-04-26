<?php

namespace App\Services;

use Exception;
use App\Http\Traits\BpjsAntrolTraits;
use App\BpjsSep;
use App\Models\Antrean;
use App\Models\AntreanTask;

// use App\Repositories\BpjsSepRepository;

class BpjsAntrolService
{
    use BpjsAntrolTraits;

    public function __construct()
    {

    }

    /**
     * Fungsi untuk membuat sep bpjs
     * @param mixed  $idPendaftaran menerima id pendaftaran dari log pendaftaran
     * @param string $nomorRm       nomorRekamMedis pasien
     * @param object $request       data return dari API BPJS VClaim
     * @return mixed
     */
    public function create($idAntrean)
    {
        $dataAntrean    = Antrean::where('id_antrean', '=', $idAntrean)->first();

        // POST Data Antrean
        if ($dataAntrean->status_bpjs=="Belum") {
            $requestBody = array(
                "kodebooking"       => $dataAntrean->kodebooking,
                "jenispasien"       => $dataAntrean->jenispasien,
                "nomorkartu"        => $dataAntrean->nomorkartu,
                "nik"               => $dataAntrean->nik,
                "nohp"              => $dataAntrean->nohp,
                "kodepoli"          => $dataAntrean->kodepoli,
                "namapoli"          => $dataAntrean->namapoli,
                "pasienbaru"        => $dataAntrean->pasienbaru,
                "norm"              => $dataAntrean->norm,
                "tanggalperiksa"    => $dataAntrean->tanggalperiksa,
                "kodedokter"        => $dataAntrean->kodedokter,
                "namadokter"        => $dataAntrean->namadokter,
                "jampraktek"        => $dataAntrean->jampraktek,
                "jeniskunjungan"    => $dataAntrean->jeniskunjungan,
                "nomorreferensi"    => $dataAntrean->nomorreferensi,
                "nomorantrean"      => $dataAntrean->nomorantrean,
                "angkaantrean"      => $dataAntrean->angkaantrean,
                "estimasidilayani"  => $dataAntrean->estimasidilayani,
                "sisakuotajkn"      => $dataAntrean->sisakuotajkn,
                "kuotajkn"          => $dataAntrean->kuotajkn,
                "sisakuotanonjkn"   => $dataAntrean->sisakuotanonjkn,
                "kuotanonjkn"       => $dataAntrean->kuotanonjkn,
                "keterangan"        => $dataAntrean->keterangan
            );

            $responsePost = $this->requestPostBpjs('antrean/add', $requestBody);
            $dataApi = array(
                "request" => $requestBody,
                "response" =>$responsePost
            );
            if ($responsePost['code']==200 OR $responsePost['code']==1) {
                $antreanUpdate = Antrean::where('id_antrean', '=', $idAntrean)
                    ->update(
                        [
                            "status_bpjs"   => "Sudah",
                            "json_request"  => $requestBody,
                            "json_response" => $responsePost
                        ]
                    );
                // dd($dataApi);
                // return $this->bpjsSepRepository->create($idPendaftaran, $dataApi);
            } else {
                dd($dataApi);
                throw new Exception(json_encode($dataApi), 1);
            }
        }

        // POST Data TaskId
        // dd($dataAntrean->antreanTask);
        foreach ($dataAntrean->antreanTask as $task) {
            if ($task->status_bpjs=="Belum") {
                $requestBodyTask = array(
                    "kodebooking"   => $task->kodebooking,
                    "taskid"        => $task->taskid,
                    "waktu"         => $task->waktu
                );

                $responsePostTask = $this->requestPostBpjs('antrean/updatewaktu', $requestBodyTask);
                $dataApiTask = array(
                    "request" => $requestBodyTask,
                    "response" =>$responsePostTask
                );
                if ($responsePostTask['code']==200 OR $responsePostTask['code']==1) {
                    $antreanTaskUpdate = AntreanTask::where('id_antrean_task', '=', $task->id_antrean_task)
                        ->update(
                            [
                                "status_bpjs"           => "Sudah",
                                "status_antrean_task"   => "Selesai",
                                "json_request"          => $requestBodyTask,
                                "json_response"         => $responsePostTask
                            ]
                        );

                } else {
                    $antreanTaskUpdate = AntreanTask::where('id_antrean_task', '=', $task->id_antrean_task)
                        ->update(
                            [
                                "status_bpjs"           => "Belum",
                                "status_antrean_task"   => "Selesai",
                                "json_request"          => $requestBodyTask,
                                "json_response"         => $responsePostTask
                            ]
                        );

                }
            }
        }
    }

    /**
     * Fungsi untuk mengupdate sep bpjs
     * @param object $request       data return dari API BPJS VClaim
     * @return mixed
     */
    public function update($request)
    {
        $requestBody = array(
            "request" => array(
                "t_sep" => array(
                    "noSep" => $request->noSep,
                    "klsRawat" => array(
                        "klsRawatHak" => "",
                        "klsRawatNaik" => "",
                        "pembiayaan" => "",
                        "penanggungJawab" => ""
                    ),
                    "noMR" => $request->noRM,
                    "catatan" => $request->catatan,
                    "diagAwal" => $request->diagnosa_bpjs,
                    "poli" => array(
                        "tujuan" => $request->poli_sep,
                        "eksekutif" => "0"
                    ),
                    "cob" => array(
                        "cob" => "0"
                    ),
                    "katarak" => array(
                        "katarak" => "0"
                    ),
                    "jaminan" => array(
                        "lakaLantas" => "0",
                        "penjamin" => array(
                            "tglKejadian" => "",
                            "keterangan" => "",
                            "suplesi" => array(
                                "suplesi" => "0",
                                "noSepSuplesi" => "",
                                "lokasiLaka" => array(
                                    "kdPropinsi" => "",
                                    "kdKabupaten" => "",
                                    "kdKecamatan" => ""
                                )
                            )
                        )
                    ),
                    "dpjpLayan" => $request->dpjpLayan,
                    "noTelp" => (isset($request->telepon_pasien) ? $request->telepon_pasien : ""),
                    "user" => env('BPJS_CONS_ID')
                )
            )
        );
        $updatedSep = $this->requestPutBpjs('SEP/2.0/update', $requestBody);
        if ($updatedSep['code'] == '200') {
            BpjsSep::where('noSep', $request->noSep)->update(
                [
                    'diagnosa' => $request->diagnosa_bpjs,
                    'poli' => $request->poli_sep,
                    'noMr' => $request->noRM,
                    'catatan' => $request->catatan
                ]
            );
        }
        return $updatedSep;
    }

    /**
     * Fungsi untuk membuat sep bpjs
     * @param object $request data return dari API BPJS VClaim
     * @return mixed
     */
    public function delete($request)
    {
        $requestBody = array(
            "request" => array(
                "t_sep" => array(
                    "noSep" => $request->id,
                    "user" => env('BPJS_CONS_ID')
                )
            )
        );

        $responseDelete = $this->requestDeleteBpjs('/SEP/2.0/delete', $requestBody);
        if ($responseDelete['code']==200) {
            $deleteFromDB =  $this->bpjsSepRepository->delete($request->id);
            if ($deleteFromDB) {
                return $responseDelete;
            } else {
                throw new Exception('Gagal menghapus data pada database.', 1);
            }
        } else {
            throw new Exception($responseDelete['flag'] . ' - ' . $responseDelete['message'], 1);
        }
        return $responseDelete;
    }

    /**
     * Fungsi untuk mengupdate sep bpjs
     * @param object $request       data return dari API BPJS VClaim
     * @return mixed
     */
    public function updateTanggalPulang($request)
    {
        $requestBody = array(
            "request" => array(
                "t_sep" => array(
                    "noSep" => $request->nomor_sep,
                    "statusPulang" => $request->status_pulang,
                    "noSuratMeninggal" => (isset($request->surat_meninggal) ? $request->surat_meninggal : ""),
                    "tglMeninggal" => (isset($request->tanggal_meninggal) ? date('Y-m-d', strtotime($request->tanggal_meninggal)) : ""),
                    "tglPulang" => date('Y-m-d', strtotime($request->tanggal_pulang)),
                    "noLPManual" => (isset($request->no_lp_manual) ? $request->no_lp_manual : ""),
                    "user" => env('BPJS_CONS_ID')
                )
            )
        );
        // dd($requestBody);
        $updatedSep = $this->requestPutBpjs('SEP/2.0/updtglplg', $requestBody);
        $dataApi = array(
            "request" => $requestBody,
            "response" =>$updatedSep
        );
        if ($updatedSep['code']==200) {
            return $updatedSep;
        } else {
            throw new Exception($updatedSep['flag'] . ' - ' . $updatedSep['message'], 1);
        }
    }

    /**
     * Fungsi untuk mengupdate sep bpjs
     * @param object $request       data return dari API BPJS VClaim
     * @return mixed
     */
    public function pengajuan($request)
    {
        $requestBody = array(
            "request" => array(
                "t_sep" => array(
                    "noKartu" => $request->nomor_peserta,
                    "tglSep" => date('Y-m-d', strtotime($request->pengajuan_tanggal)),
                    "jnsPelayanan" => $request->jenis_layanan,
                    "jnsPengajuan" => "1",
                    "keterangan" => $request->pengajuan_keterangan,
                    "user" => env('BPJS_CONS_ID')
                )
            )
        );
        $pengajuanSep = $this->requestPostBpjs('Sep/pengajuanSEP', $requestBody);
        $dataApi = array(
            "request" => $requestBody,
            "response" =>$pengajuanSep
        );
        if ($pengajuanSep['code']==200) {
            return $pengajuanSep;
        } else {
            // dd($dataApi);
            throw new Exception($pengajuanSep['flag'] . ' - ' . $pengajuanSep['message'], 1);
        }
    }

    public function getListSepKunjungan($request)
    {
        $akhir   = date('Y-m-d', strtotime($request->akhir));
        $getData= $this->requestGetBpjs('/Monitoring/Kunjungan/Tanggal/' . $akhir . '/JnsPelayanan/' . $request->filter);
        return $getData;
    }
}
