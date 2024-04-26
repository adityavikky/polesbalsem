<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Spipu\Html2Pdf\Html2Pdf;
use Illuminate\Support\Facades\Validator;

class PendaftaranOnlineController extends Controller
{

    public function myCaptcha()
    {
        return view('myCaptcha');
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function myCaptchaPost(Request $request)
    {
        request()->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required|captcha'
        ],
        ['captcha.captcha'=>'Invalid captcha code.']);
        dd("You are here :) .");
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function refreshCaptcha()
    {
        return response()->json(
            [
                'captcha'=> captcha_img()
            ]
        );
    }
    public function pendaftaranOnline()
    {
        return view('form_pendaftaran_online_1');
    }

    public function pendaftaranOnline2()
    {
        return view('form_pendaftaran_online_2');
    }

    public function pendaftaranOnlineBaru()
    {
        return view('form_pendaftaran_online_baru');
    }

    public function pendaftaranOnlineLama()
    {
        return view('form_pendaftaran_online_lama');
    }

    public function cariPasienLama(Request $request)
    {
        
        $response = Http::withHeaders(
            [
                // 'x-token'   => request()->header('x-token'),
                // 'x-username'=> request()->header('x-username'),
                'Accept'    => 'application/json '
            ]
        )
        ->post(
            //'https://tes.balkesmassmg.id/api/v1/cariPasien',
            'https://balkesmassmg.id/api/v1/cariPasien',
            // 'http://balkesmas.test/api/v1/cariPasien',
            [
                'cari_nik'          => $request->cari_nik,
                'cari_tanggal_lahir'=> date('Y-m-d', strtotime($request->cari_tanggal_lahir))
            ]
        );

        $result = json_decode($response, true);
        if ($result['metadata']['code']==200) {
            $data['pasien'] = $result['response'];
            return view('form_pendaftaran_online_preview', $data);
        }

        return "<h2>" . $result['metadata']['message'] . "</h2><br><button type='button' class='btn btn-info' onclick='window.location.reload(true);'>Kembali</button>";
    }

    public function simpanPendaftaranPasienBaru(Request $request)
    {
        $resultValidation = Validator::make(
            $request->all(),
            [
                'nik_pasien'   => 'required',
                'nama_pasien' => 'required',
                'tanggal_lahir_pasien' => 'required',
                'jenis_kelamin_pasien' => 'required',
                'telepon_pasien' => 'required',
                'tanggal_kunjungan' => 'required',
            ]
        );

        if ($resultValidation->fails()) {
            echo "gagal";
        }else{
            $data = $request->except('_token');
            if($data['tanggal_kunjungan'] > date('Y-m-d') || ($data['tanggal_kunjungan'] == date('Y-m-d') && date('H') < 11)){
                $tgl = explode('-',$request->tanggal_lahir_pasien);
                $data['tanggal_lahir_pasien'] = $tgl[0]."-".$tgl[1]."-".$tgl[2];
                
                $json = json_encode($data);
                //$url = 'https://tes.balkesmassmg.id/api/v1/postPasienBaru';
                $url = 'https://balkesmassmg.id/api/v1/postPasienBaru';
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Access-Control-Allow-Origin: *',
                    'Content-Length: ' . strlen($json)
                ));
                
                $response = curl_exec($ch);
                if(curl_errno($ch)) {
                    echo 'Error: ' . curl_error($ch);
                } else {
                    echo $response;
                }
                curl_close($ch);
                
                
                //Aku
                /*$json = json_encode($data);
                $response = Http::withHeaders(
                [
                    'Accept'    => 'application/json '
                ]
                )
                ->post(
                    'https://demo.balkesmassmg.id/api/v1/postPasienBaru',
                    // 'http://balkesmas.test/api/v1/ambilAntreanOnlineLama',
                    $json
                );
        
                $result = json_decode($response, true);
                $data['antrian'] = $result;
                echo $result;
                */
                //
            }else{
                echo "tutup";
            }
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        /*$response = Http::withHeaders(
            [
                'Accept'    => 'application/json '
            ]
        )
        ->post(
            'https://demo.balkesmassmg.id/api/v1/postPasienBaru',
            // 'http://balkesmas.test/api/v1/ambilAntreanOnlineLama',
            [
                'nik_pasien'        => $request->nik_pasien,
                'nama_lengkap'      => $request->nik_pasien,
                'tanggal_lahir'     => date('Y-m-d', strtotime($request->tanggal_lahir_pasien)),
                'jenis_kelamin'     => $request->nik_pasien,
                'alamat_lengkap'    => $request->nik_pasien,
                'telepon'           => $request->nik_pasien,
                'tanggal_kunjungan' => date('Y-m-d', strtotime($request->tanggal_kunjungan)),
                'id_unit'           => $request->id_unit
            ]
        );
        
        dd($response);*/
        
        /*$response = Http::withHeaders(
            [
                'Accept'    => 'application/json '
            ]
        )
        ->post(
            'https://demo.balkesmassmg.id/api/v1/ambilAntreanOnlineBaru',
            // 'http://balkesmas.test/api/v1/ambilAntreanOnlineBaru',
            [
                'nik_pasien'        => $request->id_pasien,
                'nama_lengkap'      => $request->kode_pasien,
                'tanggal_lahir'     => date('Y-m-d', strtotime($request->tanggal_lahir)),
                'jenis_kelamin'     => $request->nik_pasien,
                'alamat_lengkap'    => $request->nik_pasien,
                'telepon'           => $request->nik_pasien,
                'tanggal_kunjungan' => date('Y-m-d', strtotime($request->tanggal_kunjungan)),
                'id_unit'           => $request->id_unit
            ]
        );

        $result = json_decode($response, true);
        $data['antrian'] = $result;
        
        return view('form_pendaftaran_online_preview_antrian', $data);*/
    }

    public function simpanPendaftaranPasienLama(Request $request)
    {
        $tglkun = date('Y-m-d', strtotime($request->tanggal_kunjungan));
        if($tglkun > date('Y-m-d') || ($tglkun == date('Y-m-d') && date('H') < 11)){
            $response = Http::withHeaders(
            [
                'Accept'    => 'application/json '
            ]
            )
            ->post(
                //'https://tes.balkesmassmg.id/api/v1/ambilAntreanOnlineLama',
                'https://balkesmassmg.id/api/v1/ambilAntreanOnlineLama',
                // 'http://balkesmas.test/api/v1/ambilAntreanOnlineLama',
                [
                    'id_pasien'         => $request->id_pasien,
                    'kode_pasien'       => $request->kode_pasien,
                    'nik_pasien'        => $request->nik_pasien,
                    //'id_unit'           => $request->id_unit,
                    'id_unit'           => '0',
                    'tipe_pasien'       => 'UMUM',
                    'asal_pasien'       => 'Datang Sendiri',
                    'tanggal_kunjungan' => date('Y-m-d', strtotime($request->tanggal_kunjungan))
                ]
            );
    
            $result = json_decode($response, true);
            $data['antrian'] = $result;
            return $result;
            //return view('form_pendaftaran_online_preview_antrian', $data);
        }else{
            $data['metadata']['message'] = "<center style='font-size:22px;'><br><b style='color:red;'>Gagal!</b><br>Layanan Maximal<br>Jam 11 untuk dihari yang sama<br></center>";
            $data['response']['nomor_antrian'] = "";
            $data['response']['nomorantrean'] = "";
            return $data;
        }
        
    }

    public function printAntrian($idAntrian)
    {
        $response = Http::withHeaders(
            [
                'Accept'    => 'application/json '
            ]
        )
        ->get(
            //'https://tes.balkesmassmg.id/api/v1/getDataAntrian',
            'https://balkesmassmg.id/api/v1/getDataAntrian',
            // 'http://balkesmas.test/api/v1/getDataAntrian',
            [
                'id_antrian'         => $idAntrian,
            ]
        );

        $result = json_decode($response, true);
        $data['antrian']= $result;
        //dd($data);
        $filename       = $result['response']['nomorantrean']. '.pdf';
        $content        = view('print_antrian_online', $data)->render();
        $html2pdf       = new Html2Pdf('L', array(80, 53), 'en',  false, 'UTF-8', array(4, 2, 4, 2));
        $html2pdf->writeHTML($content);
        $html2pdf->output($filename);
        die;
    }
}

