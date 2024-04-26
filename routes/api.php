<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DirectController;
use App\Http\Controllers\WebServiceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(
    function () {
        Route::get('getToken', [DirectController::class, 'getToken']); // OK
        Route::post('antrean/batal', [DirectController::class, 'batalAntrean']); // FAIL
        Route::post('getSampleData', [DirectController::class, 'getSampleData']);
        Route::post('getSampleDataOperasi', [DirectController::class, 'getSampleDataOperasi']);
        Route::post('statusAntrean', [DirectController::class, 'statusAntrean']); // OK
        Route::post('ambilAntrean', [DirectController::class, 'ambilAntrean']); // OK
        Route::post('sisaAntrean', [DirectController::class, 'sisaAntrean']); // OK
        Route::post('checkIn', [DirectController::class, 'checkIn']);
        Route::post('infoPasienBaru', [DirectController::class, 'infoPasienBaru']);
        Route::post('jadwalOperasiRS', [DirectController::class, 'jadwalOperasiRS']);
        Route::post('jadwalOperasiPasien', [DirectController::class, 'jadwalOperasiPasien']);
    }
);

Route::prefix('v2')->group(
    function () {
        Route::get('getToken', [AuthController::class, 'getToken']);
        Route::middleware('auth:api')->group(
            function () {
                Route::post('antrean/batal', [WebServiceController::class, 'batalAntrean']);
                Route::post('getSampleData', [WebServiceController::class, 'getSampleData']);
                Route::post('getSampleDataOperasi', [WebServiceController::class, 'getSampleDataOperasi']);
                Route::post('statusAntrean', [WebServiceController::class, 'statusAntrean']);
                Route::post('ambilAntrean', [WebServiceController::class, 'ambilAntrean']);
                Route::post('sisaAntrean', [WebServiceController::class, 'sisaAntrean']);
                Route::post('checkIn', [WebServiceController::class, 'checkIn']);
                Route::post('infoPasienBaru', [WebServiceController::class, 'infoPasienBaru']);
                Route::post('jadwalOperasiRS', [WebServiceController::class, 'jadwalOperasiRS']);
                Route::post('jadwalOperasiPasien', [WebServiceController::class, 'jadwalOperasiPasien']);
            }
        );
    }
);
