<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\JadwalPraktek;
use App\Models\Poli;
use Exception;

class AntreanRepository
{
    public function sisaAntrean($tanggal=null)
    {
        if ($tanggal==null) {
            $tanggal = date('Y-m-d');
        }
        $queryString = "SELECT count(*) AS total
                        FROM antrean a
                            INNER JOIN antrean_task b ON a.id_antrean=b.id_antrean AND b.taskid=3 AND b.status_antrean_task='Aktif'
                        WHERE a.tanggalperiksa='$tanggal';";
        $getData = DB::select($queryString);
        return $getData[0]->total;
    }

    public function sisaAntreanPoliDokter($kodepoli, $kodedokter, $tanggal=null)
    {
        if ($tanggal==null) {
            $tanggal = date('Y-m-d');
        }
        $queryString = "SELECT count(*) AS total
                        FROM antrean a
                            INNER JOIN antrean_task b ON a.id_antrean=b.id_antrean AND b.taskid<=4 AND b.status_antrean_task='Aktif'
                        WHERE a.tanggalperiksa='$tanggal' AND a.kodepoli='$kodepoli' AND a.kodedokter=$kodedokter;";
        $getData = DB::select($queryString);
        return $getData[0]->total;
    }

    public function antrianCalculate($kodepoli, $kodedokter, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d');
            $hari = date('N');
        } else {
            $hari = date('N', strtotime($date));
        }

        // get estimasi pelayanan ada di tabel poli
        $getPoli = Poli::where('kodepoli', $kodepoli)->first();
        if ($getPoli == null) {
            throw new Exception("Poli tidak ditemukan.");
        }

        // get kuota poli, ada di tabel jadwal_praktek
        $getJadwal = JadwalPraktek::where('kodedokter', $kodedokter)
            ->where('kodepoli', $kodepoli)
            ->where('hari', $hari)
            ->first();
        if ($getJadwal == null) {
            throw new Exception("Jadwal Praktek tidak ditemukan.");
        }


        // get sisa antrean
        $getSemuaAntrian = DB::select(
            "SELECT
                IFNULL(count(*),0) as total,
                IFNULL(SUM(IF(a.jenispasien='JKN', 1, 0)),0) AS jkn,
                IFNULL(SUM(IF(a.jenispasien='NON JKN', 1, 0)),0) AS umum
            FROM antrean a
            WHERE a.tanggalperiksa='$date' AND a.kodepoli='$kodepoli' AND a.status_antrean!='Batal'
                AND a.kodedokter='$kodedokter';"
        );

        $getBelumDipanggil = DB::select(
            "SELECT
                a.id_antrean, a.tanggalperiksa, a.nomorantrean, a.kodepoli, a.kodedokter,
                IF(a.jenispasien='JKN', 1, 0) AS jkn,
                IF(a.jenispasien='NON JKN', 1, 0) AS umum, MAX(b.taskid)
            FROM antrean a
                LEFT JOIN antrean_task b ON a.id_antrean=b.id_antrean
            WHERE a.status_antrean!='Batal'
            GROUP BY a.id_antrean, a.tanggalperiksa, a.nomorantrean, a.kodepoli, a.kodedokter
            HAVING a.tanggalperiksa='$date' AND a.kodepoli='$kodepoli'
                AND a.kodedokter='$kodedokter' AND MAX(b.taskid)<=3;"
        );

        $getDipanggil = DB::select(
            "SELECT
                a.id_antrean, a.tanggalperiksa, a.nomorantrean, a.kodepoli, a.kodedokter,
                IF(a.jenispasien='JKN', 1, 0) AS jkn,
                IF(a.jenispasien='NON JKN', 1, 0) AS umum, MAX(b.taskid)
            FROM antrean a
                LEFT JOIN antrean_task b ON a.id_antrean=b.id_antrean
            WHERE a.status_antrean!='Batal'
            GROUP BY a.id_antrean, a.tanggalperiksa, a.nomorantrean, a.kodepoli, a.kodedokter
            HAVING a.tanggalperiksa='$date' AND a.kodepoli='$kodepoli'
                AND a.kodedokter='$kodedokter' AND MAX(b.taskid)=4;"
        );

        if (count($getDipanggil) == 0) {
            $antreanPanggil = "-";
        } else {
            $antreanPanggil = $getDipanggil[0]->nomorantrean;
        }

        $result = [
            "totalantrean"      => $getSemuaAntrian[0]->total,
            "sisaantrean"       => count($getBelumDipanggil),
            "antreanpanggil"    => $antreanPanggil,
            "kuotajkn"          => $getJadwal->pasien_jkn,
            "sisakuotajkn"      => $getJadwal->pasien_jkn - $getSemuaAntrian[0]->jkn,
            "kuotanonjkn"       => $getJadwal->pasien_umum,
            "sisakuotanonjkn"   => $getJadwal->pasien_umum - $getSemuaAntrian[0]->umum,
            "estimasipelayanan" => $getPoli->durasi_pelayanan,
            "buka"              => $date . ' ' . $getJadwal->buka . ':00',
            "tutup"             => $date . ' ' . $getJadwal->tutup . ':00',
            "buka_ms"           => (strtotime($date . ' ' . $getJadwal->buka . ':00') * 1000),
            "tutup_ms"          => (strtotime($date . ' ' . $getJadwal->tutup . ':00') * 1000)
        ];

        return $result;
    }
}
