@extends('layouts.app2')

@section('css')
  <style>
    table.table-bordered.dataTable tbody th, table.table-bordered.dataTable tbody td {
      border-bottom-width: 0;
      font-size: 28px;
      font-weight: bold;
    }

    #scroll-container {
      border: 3px solid black;
      border-radius: 5px;
      overflow: hidden;
    }

    #scroll-text {
      /* animation properties */
      -moz-transform: translateX(100%);
      -webkit-transform: translateX(100%);
      transform: translateX(100%);

      -moz-animation: my-animation 15s linear infinite;
      -webkit-animation: my-animation 15s linear infinite;
      animation: my-animation 15s linear infinite;
    }

  /* for Firefox */
    @-moz-keyframes my-animation {
      from { -moz-transform: translateX(100%); }
      to { -moz-transform: translateX(-100%); }
    }

  /* for Chrome */
    @-webkit-keyframes my-animation {
      from { -webkit-transform: translateX(100%); }
      to { -webkit-transform: translateX(-100%); }
    }

    @keyframes my-animation {
      from {
        -moz-transform: translateX(100%);
        -webkit-transform: translateX(100%);
        transform: translateX(100%);
      }
      to {
        -moz-transform: translateX(-100%);
        -webkit-transform: translateX(-100%);
        transform: translateX(-100%);
      }
    }
  </style>
@endsection

@section('content')
<div class="row" style="margin: 0px 10px;">
  <div class="col-md-6">
    <div class="card" style="height: 85vh;">
      <div class="card-body">
        <center>
          <h1 style="font-weight: bold;">ANTREAN PENDAFTARAN</h1>
        </center>
        <div class="table-responsive">
          <table id="tabel-data" class="table table-striped table-bordered" style="width: 100%;">
            <thead>
              <th style="font-size: 32px; font-weight: bold; background-color: lightslategrey;">NO.</th>
              <th style="font-size: 32px; font-weight: bold; background-color: lightslategrey;">NO.RM</th>
              <th style="font-size: 32px; font-weight: bold; background-color: lightslategrey;">NAMA PASIEN</th>
            </thead>
            <tbody>
              <!-- value here -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card" style="height: 85vh;">
      <div class="card-body">
        <div class="col-12" style="height: 45vh;">
          <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img class="d-block w-100" src="{{ asset('/img/slide/slide-1.jpg') }}" alt="First slide" style="height: 40vh; width: auto;">
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('/img/slide/slide-2.jpg') }}" alt="Second slide" style="height: 40vh; width: auto;">
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('/img/slide/slide-3.jpg') }}" alt="Third slide" style="height: 40vh; width: auto;">
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>
        <div class="col-12" style="height: 45vh;">
          <center>
            <h1 style="font-weight: bold;">Pasien Dalam Pelayanan</h1>
            <div id="infoPelayanan"></div>
            <div class="col-12" style="border: solid 1px grey; border-radius: 10px;">
              <div class="col-12 row">
                <span id="nama_unit" class="col-6" style="text-align: left; font-size: 22px; padding: 5px 0px;">Nama Unit</span>
                <span id="nama_dokter" class="col-6" style="text-align: right; font-size: 22px; padding: 5px 0px;">Nama Dokter</span>
              </div>
              <hr>
              <div class="col-12 row">
                <span id="nama_pasien" class="col-12" style="text-align: center; font-size: 36px; font-weight: bold; padding: 5px 0px;">Nama Pasien</span>
              </div>
              <hr>
              <div class="col-12 row">
                <span id="jam_mulai" class="col-12" style="text-align: center; font-size: 22px; padding: 5px 0px;">JAM MULAI : </span>
              </div>
            </div>
          </center>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12">
    <div class="card" id="scroll-container" style="height: 8vh; margin-top: 10px;">
      <div id="scroll-text" style="font-size: 40px; font-weight: bold;">BALAI KESEHATAN MASYARAKAT WILAYAH SEMARANG - JAWA TENGAH<div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
  var tabelData = $('#tabel-data').DataTable();

  $('#tabel-data').on('click', '#btn-proses-pelayanan', function(){
    let url = '{{ url("/kasir/dataDetail") }}/' + $(this).data('id');
    window.open(url, '_SELF');
  });

  function reloadTable() {
    tabelData.ajax.reload( null, false);
    dalamPelayanan();
  }

  setInterval(reloadTable,10000);

  function panggil(a) {
    var utterance = new SpeechSynthesisUtterance("Pasien atas nama " + $(a).data("nama") + ", silahkan menuju ke kasir.");
    utterance.lang = 'id-ID';
    utterance.rate = 0.8;
    utterance.pitch = 1;
    speechSynthesis.speak(utterance);
  }

  function dalamPelayanan(){
    $.ajax({
      type:     'ajax',
      method:   'get',
      url:      '{{ url("/rekamMedis/dalamPelayanan") }}/{{ Auth::user()->id_unit }}',
      async:    true,
      dataType: 'json',
      success:  function(response){
        if(response.status) {
          $('#nama_unit').html(response.data.unit.nama_unit);
          $('#nama_dokter').html(response.data.dokter.name);
          $('#nama_pasien').html(response.data.pasien.nama_pasien);
          $('#jam_mulai').html('JAM MULAI : ' + response.data.tanggal_pelayanan);
        } else {
          $('#infoPelayanan').html('Belum ada pasien dalam pelayanan.');
        }
      }
    });
  };
</script>
@endsection

