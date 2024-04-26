<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\LoketController;
use App\Http\Controllers\AntreanController;
use App\Http\Controllers\BpjsAntrolController;
use App\Http\Controllers\BpjsVClaimController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalPraktekController;

use App\Models\AntreanTaskService;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('doMigration', function() {
    Artisan::call('migrate');
    dd("Migrated!");
});

Route::get('my-captcha', [App\Http\Controllers\PendaftaranOnlineController::class, 'myCaptcha'])->name('myCaptcha');
Route::post('my-captcha', [App\Http\Controllers\PendaftaranOnlineController::class, 'myCaptchaPost'])->name('myCaptcha.post');
Route::get('refresh_captcha', [App\Http\Controllers\PendaftaranOnlineController::class, 'refreshCaptcha'])->name('refresh_captcha');

Route::get('/pendaftaranOnline', [App\Http\Controllers\PendaftaranOnlineController::class, 'pendaftaranOnline']);
Route::get('/pendaftaranOnline2', [App\Http\Controllers\PendaftaranOnlineController::class, 'pendaftaranOnline2']);
Route::get('/pendaftaranOnlineBaru', [App\Http\Controllers\PendaftaranOnlineController::class, 'pendaftaranOnlineBaru']);
Route::get('/pendaftaranOnlineLama', [App\Http\Controllers\PendaftaranOnlineController::class, 'pendaftaranOnlineLama']);
Route::post('/pendaftaranOnlineLamaCariPasien', [App\Http\Controllers\PendaftaranOnlineController::class, 'cariPasienLama']);
Route::post('/simpanPendaftaranOnlinePasienBaru', [App\Http\Controllers\PendaftaranOnlineController::class, 'simpanPendaftaranPasienBaru']);
Route::post('/simpanPendaftaranOnlinePasienLama', [App\Http\Controllers\PendaftaranOnlineController::class, 'simpanPendaftaranPasienLama']);
Route::get('printAntrianPdf/{idAntrian}', [App\Http\Controllers\PendaftaranOnlineController::class, 'printAntrian']);

Route::get('/', [App\Http\Controllers\PendaftaranOnlineController::class, 'pendaftaranOnline2']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/check', [App\Http\Controllers\HomeController::class, 'check']);

Route::group(
    ['middleware' => ['auth']],
    function () {
        Route::view('/ambilAntreanPendaftaran', 'ambil_antrean_pendaftaran');
        // Route::get('/ambilAntrean', [App\Http\Controllers\HomeController::class, 'index']);

        // Route::prefix('users')->group(
        //     function () {
        //         Route::get('/', [UsersController::class, 'index']);
        //         Route::get('/list', [UsersController::class, 'getList']);
        //         Route::post('/', [UsersController::class, 'store']);
        //         Route::put('/update/{user?}', [UsersController::class, 'update']);
        //         Route::delete('/delete/{user?}', [UsersController::class, 'destroy']);
        //     }
        // );

        // Route::prefix('loket')->group(
        //     function () {
        //         Route::get('/', [LoketController::class, 'getLoketList']);
        //         Route::get('/panggil', [LoketController::class, 'getLoketPanggilPendaftaran']);
        //         Route::get('/list', [LoketController::class, 'index']);
        //         Route::post('/', [LoketController::class, 'store']);
        //         Route::put('/update/{loket?}', [LoketController::class, 'update']);
        //         Route::delete('/delete/{loket?}', [LoketController::class, 'destroy']);
        //     }
        // );

        Route::prefix('antrean')->group(
            function () {
                Route::post('/createAntrean', [AntreanController::class, 'create']);
                Route::post('/updateAntreanPendaftaran', [AntreanController::class, 'updatePendaftaran']);
                Route::get('/cetakAntrean/{idAntrean}', [AntreanController::class, 'cetak']);
                // Route::view('/previewAntrean', 'preview_antrean');
                Route::view('/previewAntreanPendaftaran', 'display_antrean_pendaftaran');
                Route::get('/antreanPendaftaran', [AntreanController::class, 'antreanPendaftaran']);
                Route::get('/antreanPoli', [AntreanController::class, 'antreanPoli']);
                Route::get('/antreanFarmasi', [AntreanController::class, 'antreanFarmasi']);
                Route::post('/data', [AntreanController::class, 'data']);
                Route::get('/data/{idAntrean}', [AntreanController::class, 'dataDetail']);
                Route::post('/setAktifLoket', [AntreanController::class, 'setAktifLoket']);
                Route::view('/antreanPoli', 'display_antrean_poli_single');
                // Route::view('/antreanFarmasi', 'display_antrean_pendaftaran');
                Route::post('/panggilAntrean', [AntreanController::class, 'panggilAntrean']);
            }
        );


        Route::prefix('poli')->group(
            function () {
                Route::get('/', [PoliController::class, 'index']);
                Route::post('/data', [PoliController::class, 'data']);
                Route::post('/syncData', [PoliController::class, 'syncData']);
                Route::post('/updateStatus', [PoliController::class, 'updateStatus']);
            }
        );

        Route::prefix('dokter')->group(
            function () {
                Route::get('/', [DokterController::class, 'index']);
                Route::post('/data', [DokterController::class, 'data']);
                Route::post('/syncData', [DokterController::class, 'syncData']);
                Route::post('/updateStatus', [DokterController::class, 'updateStatus']);
            }
        );

        Route::prefix('jadwalPraktek')->group(
            function () {
                Route::get('/', [JadwalPraktekController::class, 'index']);
                Route::post('/data', [JadwalPraktekController::class, 'data']);
                Route::get('/data/{idJawalPraktek}', [JadwalPraktekController::class, 'dataDetail']);
                Route::post('/syncData', [JadwalPraktekController::class, 'syncData']);
                Route::post('/updateStatus', [JadwalPraktekController::class, 'updateStatus']);
            }
        );

        Route::prefix('loket')->group(
            function () {
                Route::get('/', [LoketController::class, 'index']);
                Route::post('/data', [LoketController::class, 'data']);
                Route::post('/syncData', [LoketController::class, 'syncData']);
                Route::post('/updateStatus', [LoketController::class, 'updateStatus']);
            }
        );

        Route::prefix('bpjsAntrol')->group(
            function () {
                Route::get('/getReferensiJadwalDokter', [BpjsAntrolController::class, 'getReferensiJadwalDokter']);
                // Route::post('/data', [LoketController::class, 'data']);
                // Route::post('/syncData', [LoketController::class, 'syncData']);
                // Route::post('/updateStatus', [LoketController::class, 'updateStatus']);
            }
        );

        Route::prefix('bpjsVclaim')->group(
            function () {
                Route::get('/getPesertaByNIK', [BpjsVClaimController::class, 'getPesertaByNIK']);
                Route::get('/getRujukanFaskesRS', [BpjsVClaimController::class, 'getRujukanFaskesRS']);
                // Route::post('/syncData', [LoketController::class, 'syncData']);
                // Route::post('/updateStatus', [LoketController::class, 'updateStatus']);
            }
        );
    }
);
