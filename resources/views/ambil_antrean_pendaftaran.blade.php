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
            <div class="card shadow" style="border: solid 3px green; cursor: pointer;" onclick="jenis_pasien = 'Baru'; $('#modal-detail').modal('show');">
                <div class="card-header text-center" style="border-bottom: solid 3px green; font-size: 26px; color: green; background: #3e8f3e40;">
                    Pasien Baru
                </div>

                <div class="card-body text-center" style="font-size: 18px;">
                    Jika anda belum pernah terdaftar di sebagai pasien Balkesmas
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow" style="border: solid 3px blue; cursor: pointer;" onclick="jenis_pasien = 'Lama'; $('#modal-detail').modal('show');">
                <div class="card-header text-center" style="border-bottom: solid 3px blue; font-size: 26px; color: blue; background: #3e628f40;">
                    Pasien Lama
                </div>

                <div class="card-body text-center" style="font-size: 18px;">
                    Jika anda belum pernah pernah terdaftar sebagai pasien Balkesmas
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow" style="border: solid 3px #b7b714; cursor: pointer;" onclick="pasienMcu();">
                <div class="card-header text-center" style="border-bottom: solid 3px #b7b714; font-size: 26px; color: #b7b714; background: #7f8f3e40;">
                    Medical Check-Up
                </div>

                <div class="card-body text-center" style="font-size: 18px;">
                    Khusus untuk pasien yang ingin melakukan Medical Check-Up
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-detail" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-body">
            <div class="row justify-content-center my-4">
              <div class="col-md-6">
                  <div class="card shadow" style="border: solid 3px green; cursor: pointer;" onclick="ambilAntrean('JKN'); $('#modal-detail').modal('hide');">
                      <div class="card-header text-center" style="border-bottom: solid 3px green; font-size: 26px; color: green; background: #3e8f3e40;">
                          JKN
                      </div>

                      <div class="card-body text-center" style="font-size: 18px;">
                          Pasien terdaftar sebagai peserta BPJS Kesehatan
                      </div>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="card shadow" style="border: solid 3px blue; cursor: pointer;" onclick="ambilAntrean('NON JKN'); $('#modal-detail').modal('hide');">
                      <div class="card-header text-center" style="border-bottom: solid 3px blue; font-size: 26px; color: blue; background: #3e628f40;">
                          NON JKN
                      </div>

                      <div class="card-body text-center" style="font-size: 18px;">
                          Pasien menggunakan pembayaran pribadi/umum
                      </div>
                  </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="btn-group">
              <button type="button" class="btn btn-secondary" onclick="$('#modal-detail').modal('hide');">Batal</button>
            </div>
        </div>
      </div>
    </div>
</div>
@endsection

@section('js')
<script>
  var jenis_pasien = 'Baru';
  function ambilAntrean(tipe) {
    $.ajax({
      type:       'ajax',
      method:     'post',
      url:        '{{ url("/antrean/createAntrean") }}',
      data:       {
                    "_token": "{{ csrf_token() }}",
                    "jenis_pasien": jenis_pasien,
                    "type_pasien": tipe
                  },
      async:      true,
      dataType:   'json',
      success:    function(response){
        let url = '{{ url("/antrean/cetakAntrean") }}/' + response['data'].id;
        window.open(url, '_blank');
      },
      error: function(response){
        alert("Terjadi Kesalahan Aplikasi : " + response.message);
      }
    });
  };

  function pasienMcu() {
    $.ajax({
      type:       'ajax',
      method:     'post',
      url:        '{{ url("/antrean/createAntrean") }}',
      data:       {
                    "_token": "{{ csrf_token() }}",
                    "jenis_pasien": "MCU",
                    "type_pasien": "NON JKN"
                  },
      async:      true,
      dataType:   'json',
      success:    function(response){
        let url = '{{ url("/antrean/cetakAntrean") }}/' + response['data'].id;
        window.open(url, '_blank');
      },
      error: function(response){
        alert("Terjadi Kesalahan Aplikasi : " + response.message);
      }
    });
  };
</script>
@endsection
