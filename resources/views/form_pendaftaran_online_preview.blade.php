<style>
    #myModal .modal-dialog {
        -webkit-transform: translate(0,-50%);
        -o-transform: translate(0,-50%);
        transform: translate(0,-50%);
        top: 50%;
        margin: 0 auto;
    }
</style>

<form id="form-pendaftaran" method="POST" action="" data-parsley-validate>
  @csrf
  <div class="container-fluid">
  <div class="row">
    <div class="col-md-4 col-12 mb-3">
      <div class="form-group row">
        <label class="col-12 col-form-label">Nomor RM</label>
        <div class="col-12">
          <input type="hidden" name="id_pasien" class="form-control input-pasien" value="{{ $pasien['id_pasien'] }}"/>
          <input type="hidden" name="kode_pasien" class="form-control input-pasien" value="{{ $pasien['kode_pasien'] }}"/>
          <input type="hidden" name="nik_pasien" class="form-control input-pasien" value="{{ $pasien['nik_pasien'] }}"/>
          <input type="text" id="kode_pasien" name="kode_pasien" class="form-control input-pasien" value="{{ $pasien['kode_pasien'] }}" placeholder="NIK" disabled/>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-12 col-form-label">NIK</label>
        <div class="col-12">
          <input type="text" id="nik_pasien" name="nik_pasien" class="form-control input-pasien" value="{{ $pasien['nik_pasien'] }}" placeholder="NIK" disabled/>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-12 col-form-label">Nama Lengkap</label>
        <div class="col-12">
          <input type="text" id="nama_pasien" name="nama_pasien" class="form-control input-pasien" value="{{ $pasien['nama_pasien'] }}" placeholder="Nama Lengkap" disabled>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-12 col-form-label">Tanggal Lahir</label>
        <div class="col-12">
          <input type="text" id="tanggal_lahir_pasien" name="tanggal_lahir_pasien"  class="form-control input-pasien tanggal" value="{{ date('d-m-Y', strtotime($pasien['tanggal_lahir_pasien'])) }}" placeholder="Tanggal Lahir" disabled/>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-12 mb-3">
      <div class="form-group row">
        <label class="col-12 col-form-label">Jenis Kelamin</label>
        <div class="col-12">
          <input type="text" id="jenis_kelamin_pasien" name="jenis_kelamin_pasien" class="form-control input-pasien" value="{{ $pasien['jenis_kelamin_pasien'] }}" placeholder="NIK" disabled/>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-12 col-form-label">Alamat Lengkap</label>
        <div class="col-12">
          <textarea type="text" id="alamat_pasien" name="alamat_pasien" class="form-control input-pasien" value="" placeholder="Alamat Lengkap" style="height: 112px;" disabled>{{ $pasien['alamat_pasien'] }}</textarea>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-12 col-form-label">Telepon</label>
        <div class="col-12">
          <input type="text" id="telepon_pasien" name="telepon_pasien" class="form-control input-pasien" value="{{ $pasien['telepon_pasien'] }}" placeholder="NIK" disabled/>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-12 mb-3">
      <div class="form-group row">
        <label class="col-12 col-form-label">Tanggal Kunjungan</label>
        <div class="col-12">
          <input type="date" id="tanggal_kunjungan" name="tanggal_kunjungan"  class="form-control input-pasien tanggal" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" placeholder="Tanggal Kunjungan" required data-parsley-errors-messages-disabled/>
        </div>
      </div>
      <div class="form-group row" hidden>
        <label class="col-12 col-form-label">Pilih Unit</label>
        <div class="col-12">
          <select id="id_unit" name="id_unit" class="form-control select2" style="width: 100%;" required>
            <option value="">-- Pilih Unit --</option>
            <option value="4">KESEHATAN IBU & ANAK</option>
            <option value="25">KLINIK BERHENTI MEROKOK</option>
            <option value="18">KLINIK DOKTER SPESIALIS ANAK</option>
            <option value="20">KLINIK DOKTER SPESIALIS DALAM</option>
            <option value="26">KLINIK DOKTER SPESIALIS PARU</option>
            <option value="17">KLINIK DOKTER SPESIALIS PARU TB</option>
            <option value="21">KLINIK FISIOTERAPI</option>
            <option value="3">KLINIK GIZI & PENYULUHAN</option>
            <option value="13">KLINIK SANITASI</option>
            <option value="16">KLINIK TB</option>
            <option value="2">KLINIK UMUM I</option>
            <option value="14">KLINIK UMUM II</option>
            <option value="19">KLINIK UMUM ANAK</option>
            <option value="24">KLINIK UMUM ANAK LAMA</option>
            <option value="15">KLINIK VCT</option>
            <option value="8">LABORATORIUM</option>
            <option value="27">SPESIALIS REHAP MEDIK</option>
            <option value="1">UGD</option>
            <option value="7">UNIT RADIOLOGI</option>
          </select>
        </div>
      </div>
    </div>
    <hr>
    <!--<div class="col-md-4 col-12">-->
    <!--  <div class="form-group">-->
    <!--    <div class="captcha">-->
    <!--      <span>{!! captcha_img() !!}</span>-->
    <!--      <button type="button" class="btn btn-info btn-refresh">Refresh</button>-->
    <!--    </div>-->
    <!--    <input id="captcha" type="text" class="form-control col-6" placeholder="Enter Captcha" name="captcha" style="width: 200px; margin: 8px 0px;">-->
    <!--  </div>-->
    <!--</div>-->
    <div class="col-md-4 col-12 mb-3">
      <button type="button" class="btn btn-success" id="btn-simpan-lama">Simpan Pendaftaran Pasien Lama</button>
    </div>

    <div id="result-antrian">

    </div>
  </div>
  </div>
</form>

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <br>
        <center>
        <div id="jdl">Nomor Antrian Anda:</div>
        <div id="noantre" style="font-size:32px;">
            
        </div>
        <div id="tglkun">Tanggal Kunjungan</div>
        <div id="metada">
            B001
        </div>
        </center>
        <br>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal" id="cetakant" onclick="Cetak()">Cetak Antrian</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script type="text/javascript">
var pickers = document.getElementById('tanggal_kunjungan');
pickers.addEventListener('input', function(e){
  var day = new Date(this.value).getUTCDay();
  if([7,0].includes(day)){
    e.preventDefault();
    this.value = '';
    alert('Hari Minggu Libur');
  }
});

var antri="";
function Cetak(){
    var tgl=$("#tanggal_kunjungan").val().replace(/[^a-zA-Z0-9 ]/g, '');
    console.log(tgl);
    let url = '{{ url("/printAntrianPdf") }}/'+tgl + antri; //masih tgl saat ini dan belum tgl kunjungan
    window.open(url, '_blank');
}

  $(".btn-refresh").click(function(){
    $.ajax({
      type:'GET',
      url:'/refresh_captcha',
      success:function(data){
          $(".captcha span").html(data.captcha);
      }
    });
  });

  $("#btn-simpan-lama").click(function(){
    $('#form-pendaftaran').attr('action', '{{ url("/simpanPendaftaranOnlinePasienLama") }}');
    $('#form-pendaftaran').ajaxForm({
      success: 	function(response){
          var tanggal_kunjungan = document.getElementById("tanggal_kunjungan").value;
          $("#myModal").modal({backdrop: 'static', keyboard: false});
          $("#metada").html(response['metadata']['message']);
          $("#noantre").html(response['response']['nomorantrean']);
          antri = response['response']['nomorantrean'];
          $("#tglkun").html("Tanggal Kunjungan :"+"<b>"+tanggal_kunjungan+"</b>");
      },
      error: function(response){
        alert("Error System");
      }
    }).submit();
  });
</script>
