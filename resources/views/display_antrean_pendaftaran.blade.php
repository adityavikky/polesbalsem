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
<div class="row" style="margin: 0px 30px;">
  <div class="col-12">
    <center>
      <h1 style="font-weight: bold; font-size: 56px;">ANTREAN PENDAFTARAN</h1>
    </center>
  </div>
  <div class="col-md-9">
    <div class="card" style="height: 76vh;">
      <div class="card-body">
        <video id="video1" width="100%" height="100%" controls autoplay loop>
          <source src="{{ asset('video/dahak.mp4') }}" type="video/mp4">
        </video>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="col-12" style="margin-bottom: 10px;">
      <center>
        <div class="col-12" style="border: solid 1px grey; border-radius: 10px;">
          <div class="col-12 row" style="padding: 5px;">
            <span style="font-weight: bold; font-size: 22px;">LOKET 1</h1>
          </div>
          <hr style="margin: 0px;">
          <div class="col-12 row">
            <span id="nama_pasien" class="col-12" style="text-align: center; font-size: 30px; font-weight: bold; padding: 5px 0px;">A002</span>
          </div>
        </div>
      </center>
    </div>

    <div class="col-12" style="margin-bottom: 10px;">
      <center>
        <div class="col-12" style="border: solid 1px grey; border-radius: 10px;">
          <div class="col-12 row" style="padding: 5px;">
            <span style="font-weight: bold; font-size: 22px;">LOKET 1</h1>
          </div>
          <hr style="margin: 0px;">
          <div class="col-12 row">
            <span id="nama_pasien" class="col-12" style="text-align: center; font-size: 30px; font-weight: bold; padding: 5px 0px;">A002</span>
          </div>
        </div>
      </center>
    </div>

    <div class="col-12" style="margin-bottom: 10px;">
      <center>
        <div class="col-12" style="border: solid 1px grey; border-radius: 10px;">
          <div class="col-12 row" style="padding: 5px;">
            <span style="font-weight: bold; font-size: 22px;">LOKET 1</h1>
          </div>
          <hr style="margin: 0px;">
          <div class="col-12 row">
            <span id="nama_pasien" class="col-12" style="text-align: center; font-size: 30px; font-weight: bold; padding: 5px 0px;">A002</span>
          </div>
        </div>
      </center>
    </div>

    <div class="col-12" style="margin-bottom: 10px;">
      <center>
        <div class="col-12" style="border: solid 1px grey; border-radius: 10px;">
          <div class="col-12 row" style="padding: 5px;">
            <span style="font-weight: bold; font-size: 22px;">LOKET 1</h1>
          </div>
          <hr style="margin: 0px;">
          <div class="col-12 row">
            <span id="nama_pasien" class="col-12" style="text-align: center; font-size: 30px; font-weight: bold; padding: 5px 0px;">A002</span>
          </div>
        </div>
      </center>
    </div>

    <div class="col-12" style="margin-bottom: 10px; font-weight: bold; font-size: 16px;">
      <div class="text-center">SISA ANTREAN</div>
      PASIEN BARU : 12<br>
      PASIEN LAMA : 10<br>
      PASIEN MCU  : 2
    </div>
  </div>
  <div class="col-12">
    <div class="card" id="scroll-container" style="height: 6vh; margin-top: 10px;">
      <div id="scroll-text" style="font-size: 28px; font-weight: bold; white-space: nowrap;">BALAI KESEHATAN MASYARAKAT WILAYAH SEMARANG - JAWA TENGAH<div>
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

