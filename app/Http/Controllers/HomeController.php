<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AntreanRepository;
use App\Services\AntreanTaskService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('pendaftaranOnline', 'pendaftaranOnline2', 'pendaftaranOnlineBaru', 'pendaftaranOnlineLama');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function check(AntreanRepository $antreanRepository)
    {
        $poli = 'UMU';
        $dokter = 224485;
        $getData = $antreanRepository->antrianCalculate($poli, $dokter);
        dd($getData);
        return view('home');
    }

    // public function check(AntreanTaskService $antreanTaskService)
    // {
    //     $getData = $antreanTaskService->update(198, 3);
    // }

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
}
