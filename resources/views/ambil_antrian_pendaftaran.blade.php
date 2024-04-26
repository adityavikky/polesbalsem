@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="margin-top: 30px;">
        <div class="col-md-12">
            <div class="row justify-content-center text-center">
                <img src="{{ asset('/img/logojateng320.png') }}" style="height: 160px; width: 180px;">
                <h1 style="font-weight: bold;">
                Balkesmas Wilayah Semarang
                </h1>
                <h3>
                    Jl. Kh Ahmad Dahlan No.39, Karangkidul, Kec. Semarang Tengah<br>
                    Kota Semarang, Jawa Tengah 50241
                </h3>
            </div>
        </div>
    </div>
    <div class="row justify-content-center my-4">
        <div class="col-md-4">
            <div class="card shadow" style="border: solid 3px green; cursor: pointer;">
                <div class="card-header text-center" style="border-bottom: solid 3px green; font-size: 26px; color: green; background: #3e8f3e40;">
                    Pasien Baru
                </div>

                <div class="card-body text-center" style="font-size: 18px;">
                    Jika anda belum pernah terdaftar di sebagai pasien Balkesmas
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow" style="border: solid 3px blue; cursor: pointer;">
                <div class="card-header text-center" style="border-bottom: solid 3px blue; font-size: 26px; color: blue; background: #3e628f40;">
                    Pasien Lama
                </div>

                <div class="card-body text-center" style="font-size: 18px;">
                    Jika anda belum pernah pernah terdaftar sebagai pasien Balkesmas
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow" style="border: solid 3px #b7b714; cursor: pointer;">
                <div class="card-header text-center" style="border-bottom: solid 3px #b7b714; font-size: 26px; color: #b7b714; background: #7f8f3e40;">
                    Medical Check-Up
                </div>

                <div class="card-body text-center" style="font-size: 18px;">
                    Khusus untuk pasien yang ingin melakukan Medical Check-Up
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
