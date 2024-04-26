<?php

namespace App\Services;

use App\Http\Traits\BpjsVclaimTraits;

class BpjsVclaimService
{
    use BpjsVclaimTraits;

    public function getCariNik($param)
    {
        $getData = $this->requestGetBpjs('Peserta/nik/' . $param . '/tglSEP/' . date('Y-m-d'));
        return $getData;
    }

    public function getCariKartuBpjs($param)
    {
        $getSep = $this->requestGetBpjs('Peserta/nokartu/' . $param . '/tglSEP/' . date('Y-m-d'));
        dd($getSep);
        return response()->json($getSep);
    }

    public function getRujukanFaskes($param)
    {
        $getSep = $this->requestGetBpjs('/Rujukan/List/Peserta/' . $param);
        return $getSep;
    }

    public function getRujukanRS($param)
    {
        $getSep = $this->requestGetBpjs('/Rujukan/RS/List/Peserta/' . $param);
        return $getSep;
    }
}
