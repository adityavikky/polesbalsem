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
<div class="col-md-4 col-12 mb-3">
  <div class="form-group row">
    <label class="col-12 col-form-label">NIK</label>
    <div class="col-12">
      <input type="text" id="nik_pasien" name="nik_pasien" class="form-control input-pasien" value="" required placeholder="NIK"/>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-12 col-form-label">Nama Lengkap</label>
    <div class="col-12">
      <input type="text" id="nama_pasien" name="nama_pasien" class="form-control input-pasien" value="" required placeholder="Nama Lengkap" required data-parsley-errors-messages-disabled>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-12 col-form-label">Tanggal Lahir</label>
    <div class="col-12">
      <input type="date" id="tanggal_lahir_pasien" name="tanggal_lahir_pasien"  class="form-control input-pasien tanggal" required value="{{ date('d-m-Y') }}" placeholder="Tanggal Lahir" required data-parsley-errors-messages-disabled/>
    </div>
  </div>

</div>

<div class="col-md-4 col-12 mb-3">
  <div class="form-group row" style="margin-bottom: 14px;">
    <label class="col-12 col-form-label">Jenis Kelamin</label>
    <div class="col-12">
      <label style="position: relative; top: 8px;"><input type="radio" id="LAKI-LAKI" name="jenis_kelamin_pasien" required value="LAKI-LAKI" required data-parsley-errors-messages-disabled style="margin-left: 10px;" checked="checked"> LAKI-LAKI </label>
      <label style="position: relative; top: 8px;"><input type="radio" id="PEREMPUAN" name="jenis_kelamin_pasien" required value="PEREMPUAN" required data-parsley-errors-messages-disabled style="margin-left: 10px;"> PEREMPUAN </label>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-12 col-form-label">Alamat Lengkap</label>
    <div class="col-12">
      <textarea type="text" id="alamat_pasien" name="alamat_pasien" class="form-control input-pasien" value="" placeholder="Alamat Lengkap" style="height: 112px;" required data-parsley-errors-messages-disabled></textarea>
    </div>
  </div>
</div>

<div class="col-md-4 col-12 mb-3">
  <div class="form-group row">
    <label class="col-12 col-form-label">Telepon</label>
    <div class="col-12">
      <input type="text" id="telepon_pasien" name="telepon_pasien" class="form-control input-pasien" value="" required placeholder="Telepon" required data-parsley-minlength="8" data-parsley-type="digits" data-parsley-errors-messages-disabled>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-12 col-form-label">Tanggal Kunjungan</label>
    <div class="col-12">
      <input type="date" id="tanggal_kunjungan" name="tanggal_kunjungan"  class="form-control input-pasien tanggal" required value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" placeholder="Tanggal Lahir" required data-parsley-errors-messages-disabled/>
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
<!--  <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">-->
<!--        <div class="captcha">-->
<!--          <span>{!! captcha_img() !!}</span>-->
<!--          <button type="button" class="btn btn-info btn-refresh">Refresh</button>-->
<!--        </div>-->
<!--        <input id="captcha" type="text" class="form-control col-6" placeholder="Enter Captcha" name="captcha" style="width: 200px; margin: 8px 0px;">-->
<!--        @if ($errors->has('captcha'))-->
<!--            <span class="help-block">-->
<!--                <strong>{{ $errors->first('captcha') }}</strong>-->
<!--            </span>-->
<!--        @endif-->
<!--  </div>-->
<!--</div>-->

<div class="col-md-4 col-12">
  <button type="button" class="btn btn-success" id="btn-simpan-baru">Simpan Pendaftaran Pasien Baru</button>
</div>
<h1><div id="result-antrian" hidden>
</div>
</h1>
</div>
</form>

<!--<button onclick="cek()">cek</button>-->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <br>
        <center><b>BALAI KESEHATAN MASYARAKAT SEMARANG</b></center><br>
        <center>Nomor Antrian Anda :</center>
        <center>
            <b style="font-size: 40px; color:green;">
                <div id="antriannya">
                    B001
                </div>
            </b>
        </center>
        <center><div id="tgl_kun">Kunjungan Pada 12-12-2019</div></center><br>
        <br>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="Cetak()">Cetak Antrian</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
  <div class="modal fade" id="tutup" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
          <br><br>
        <center><b style="font-size: 28px; color:red;">
                Gagal!<br></b>
                <b style="font-size: 20px; color:black;" id="ann">
                Layanan Maximal<br>Jam 11 untuk dihari yang sama
                </b></center>
                <br>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>

var picker = document.getElementById('tanggal_kunjungan');
picker.addEventListener('input', function(e){
  var day = new Date(this.value).getUTCDay();
  if([7,0].includes(day)){
    e.preventDefault();
    this.value = '';
    alert('Hari Minggu Libur');
  }
});

$(document).ready(function(){
  $("#myBtn").click(function(){
    $("#myModal").modal({backdrop: 'static', keyboard: false});
  });
});

function cek(){
    $("#myModal").modal({backdrop: 'static', keyboard: false});
}

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
  
  $(".btn-cek-tes").click(function(){
      alert('cek');
    //$('#myModal').modal('show'); 
    //$("#myModal").modal({backdrop: 'static', keyboard: false});
  });
  
  $("#btn-simpan-baru").click(function(){
    var tgl = document.getElementById("tanggal_kunjungan").value;
    $('#form-pendaftaran').attr('action', 'https://polesbalsem.com/simpanPendaftaranOnlinePasienBaru');
    $('#form-pendaftaran').ajaxForm({
      success: 	function(response){
          if(response == "tutup"){
              $("#ann").html("Layanan Maximal<br>Jam 11");
              $("#tutup").modal({backdrop: 'static', keyboard: false});
          }else if(response == "gagal"){
              $("#ann").html("Lengkapi Seluruh Isian Dengan Benar");
              $("#tutup").modal({backdrop: 'static', keyboard: false});
          }else{
              $("#result-antrian").html(response);
              $("#antriannya").html(response);
              antri = response;
              $("#tgl_kun").html("Kunjungan Pada <b>"+tgl+"</b>");
              $("#myModal").modal({backdrop: 'static', keyboard: false});
          }
      },
      error: function(response){
          console.log(response);
        alert("Error System");
      }
    }).submit();
  });
  
</script>
