<div class="container-fluid">
    <div class="col-md-4 col-12 mb-3">
      <div class="form-group row">
        <label class="col-12 col-form-label">Nomor RM</label>
        <div class="col-12">
          <input type="text" id="cari_nik" name="cari_nik" class="form-control input-pasien" value="" placeholder="Nomor RM"/>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-12 col-form-label">Tanggal Lahir (dd-mm-yyyy)</label>
        <div class="col-12">
          <input type="text" id="cari_tanggal_lahir" name="cari_tanggal_lahir"  class="form-control input-pasien tanggal" value="{{ date('d-m-Y') }}" placeholder="Tanggal Lahir" required data-parsley-errors-messages-disabled/>
        </div>
      </div>
      <div class="form-group row mt-3">
        <div class="col-12">
          <button type="button" id="btn-cari-pasien" class="btn btn-primary">Cari Data Pasien</button>
        </div>
      </div>
    </div>
</div>

  
<script>
  $('#btn-cari-pasien').on('click', function(){
    //if({{date('H')}} >= 11){
    //    alert("Jam Maximal Pendaftaran 11");
    //}else{
        $.ajax({
          type:     'ajax',
          method:   'post',
          url:      '{{ url("/pendaftaranOnlineLamaCariPasien") }}',
          data: {
                    "_token": "{{ csrf_token() }}",
                    "cari_nik": $('#cari_nik').val(),
                    "cari_tanggal_lahir": $('#cari_tanggal_lahir').val()
          },
          async:    true,
          success:  function(response){
            $('#form_area').html(response);
          },
          error: function(){
            window.location.reload(true);
          }
        });
    //}
  });
</script>
