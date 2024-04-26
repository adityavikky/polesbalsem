<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Http;
use Exception;
trait BpjsAntrolTraits
{
    public function requestGetBpjs($suburl)
    {
        try{
            $xTimestamp = $this->craeteTimestamp();
            $res = Http::withHeaders([
                'X-cons-id' => env('BPJS_ANTROL_CONS_ID'),
                'X-timestamp' => $xTimestamp,
                'X-signature' => $this->createSign($xTimestamp, env('BPJS_ANTROL_CONS_ID')),
                'user_key' => env('BPJS_ANTROL_USER_KEY'),
            ])->get(env('BPJS_ANTROL_BASE_URL').$suburl);
            return $this->responseDataBpjs($res->json(), $xTimestamp);
        } catch (\Exception $e) {
            $statusError['flag'] = 'RSUD Middleware Webservice';
            $statusError['result'] = 'Communication Errors With BPJS Kesehatan Webservice';
            $statusError['data'] = $e;
            return response()->json($statusError, 400);
        }
    }

    public function requestPostBpjs($suburl, $request)
    {
        try{
            $xTimestamp = $this->craeteTimestamp();
            $res = Http::accept('application/json')->withHeaders([
                'X-cons-id' => env('BPJS_ANTROL_CONS_ID'),
                'X-timestamp' => $xTimestamp,
                'X-signature' => $this->createSign($xTimestamp, env('BPJS_ANTROL_CONS_ID')),
                'user_key' => env('BPJS_ANTROL_USER_KEY'),
            ])
            ->withBody(json_encode($request), 'Application/x-www-form-urlencoded')
            ->post(env('BPJS_ANTROL_BASE_URL').$suburl);
            // dd($res);
            return $this->responseDataBpjs($res->json(), $xTimestamp);
        } catch (\Exception $e) {
            $statusError['flag']    = 'RSUD Middleware Webservice';
            $statusError['result']  = 'Communication Errors With BPJS Kesehatan Webservice';
            $statusError['data']    = $e;
            return response()->json($statusError, 400);
        }
    }

    public function requestPutBpjs($suburl, $request)
    {
        try{
            $xTimestamp = $this->craeteTimestamp();
            $res = Http::accept('application/json')->withHeaders([
                'X-cons-id' => env('BPJS_ANTROL_CONS_ID'),
                'X-timestamp' => $xTimestamp,
                'X-signature' => $this->createSign($xTimestamp, env('BPJS_ANTROL_CONS_ID')),
                'user_key' => env('BPJS_ANTROL_USER_KEY'),
            ])->withBody(json_encode($request), 'json')->put(env('BPJS_ANTROL_BASE_URL').$suburl);
            //return $res;
            return $this->responseDataBpjs($res->json(), $xTimestamp);
        } catch (\Exception $e) {
            $statusError['flag'] = 'RSUD Middleware Webservice';
            $statusError['result'] = 'Communication Errors With BPJS Kesehatan Webservice';
            $statusError['data'] = $e;
            $statusError['code'] = "";

            return response()->json($statusError, 400);
        }
    }

    public function requestDeleteBpjs($suburl, $request)
    {
        try{
            $xTimestamp = $this->craeteTimestamp();
            $res = Http::accept('application/json')->withHeaders(
                [
                    'X-cons-id' => env('BPJS_ANTROL_CONS_ID'),
                    'X-timestamp' => $xTimestamp,
                    'X-signature' => $this->createSign($xTimestamp, env('BPJS_ANTROL_CONS_ID')),
                    'user_key' => env('BPJS_ANTROL_USER_KEY'),
                ]
            )->withBody(json_encode($request), 'json')->delete(env('BPJS_ANTROL_BASE_URL').$suburl, 'json');
            return $this->responseDataBpjs($res->json(), $xTimestamp);
        } catch (\Exception $e) {
            $statusError['flag'] = 'RSUD Middleware Webservice';
            $statusError['result'] = 'Communication Errors With BPJS Kesehatan Webservice';
            $statusError['data'] = $e;
            return response()->json($statusError, 400);
        }
    }

    private function responseDataBpjs($res, $xTimestamp)
    {
        $statusResponse['flag'] = 'BPJS Kesehatan Webservice';
        $statusResponse['code'] = $res['metadata']['code'];
        $statusResponse['message'] = $res['metadata']['message'];
        $check = isset($res['response']);
        if ($check) {
            $statusResponse['data'] = ($res['response'] == null) ? $res['response']  : $this->decodeResponse($res['response'], $this->createKeyForDecode($xTimestamp));
        }
        return $statusResponse;
    }

    private function craeteTimestamp()
    {
        date_default_timezone_set('UTC');
        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        return $tStamp;
    }

    private function createSign($tStamp, $dataPar)
    {
        $data = $dataPar;
        $secretKey = env('BPJS_ANTROL_CONS_PWD');

        $signature = hash_hmac('sha256', $data."&".$tStamp, $secretKey, true);
        // base64 encode�
        $encodedSignature = base64_encode($signature);
        return $encodedSignature;
    }

    private function createKeyForDecode($tStamp)
    {
        $consid = env('BPJS_ANTROL_CONS_ID');
        $conspwd = env('BPJS_ANTROL_CONS_PWD');
        return $consid.$conspwd.$tStamp;
    }

    private function decodeResponse($value, $key)
    {
        $data = $this->stringDecrypt($key, $value);
        $data = $this->decompress($data);
        return json_decode($data, true);
    }

    private function stringDecrypt($key, $string)
    {
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
        return $output;
    }

    private function decompress($string){
        return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
    }
}
