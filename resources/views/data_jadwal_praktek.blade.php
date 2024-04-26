@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-2">
      @include('sidebar')
    </div>
    <div class="col-md-10">
      <div class="card" style="box-shadow: -4px 4px #888888;">
        <div class="card-header" style="height: 48px; font-size: 22px; text-shadow: -2px 2px #0000002e;">
          Data Jadwal Praktek
          <button type="button" class="btn btn-dark" style="position: absolute; right: 16px; top: 5px;" onclick="syncData();">Sync Data BPJS</button>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="tabel-data" class="table table-hover table-striped">
              <thead>
                <th>No.</th>
                <th class="hidden">Hari</th>
                <th>Hari</th>
                <th>Poli</th>
                <th>Dokter</th>
                <th>Jadwal</th>
                <th>Umum</th>
                <th>JKN</th>
                <th>Action</th>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-detail" tabindex="-1" >
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="form-data" method="POST" action="{{ url('/antrean/updateAntreanPendaftaran') }}" data-parsley-validate>
      @csrf
        <div class="modal-header">
          <h4 class="modal-title">Data Jadwal Praktek Detail</h4>
        </div>
        <div class="modal-body">
          <div class="col-12 row">
            <div class="col-12">
              <div class="row mb-2 hidden">
                <label for="name" class="col-md-4 col-form-label">Hari</label>
                <div class="col-md-8">
                  <input id="id_jadwal_praktek" type="hidden" class="form-control" name="id_jadwal_praktek" value="" required data-parsley-errors-messages-disabled>
                  <input id="hari" type="hidden" class="form-control" name="hari" value="" required data-parsley-errors-messages-disabled>
                </div>
              </div>
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">Hari</label>
                <div class="col-md-8">
                  <input id="namahari" type="text" class="form-control" name="namahari" value="" placeholder="Poli" disabled>
                </div>
              </div>
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">Poli</label>
                <div class="col-md-8">
                  <input id="namapoli" type="text" class="form-control" name="namapoli" value="" placeholder="Poli" disabled>
                </div>
              </div>
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">Dokter</label>
                <div class="col-md-8">
                  <div class="input-group">
                    <input id="namadokter" type="text" class="form-control" name="namadokter" value="" placeholder="Dokter" disabled>
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">Buka</label>
                <div class="col-md-8">
                  <input id="buka" type="time" class="form-control" name="buka" value="" placeholder="Buka" required data-parsley-errors-messages-disabled>
                </div>
              </div>
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">Tutup</label>
                <div class="col-md-8">
                  <input id="tutup" type="time" class="form-control" name="tutup" value="" placeholder="Tutup" required data-parsley-errors-messages-disabled>
                </div>
              </div>
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">Pasien Umum</label>
                <div class="col-md-8">
                  <input id="pasien_umum" type="number" class="form-control" name="pasien_umum" placeholder="Pasien Umum" value="">
                </div>
              </div>
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">Pasien JKN</label>
                <div class="col-md-8">
                  <input id="pasien_jkn" type="number" class="form-control" name="pasien_jkn" placeholder="Pasien JKN" value="">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="btn-group">
            <button type="button" class="btn btn-secondary" onclick="$('#modal-detail').modal('hide');">Batal</button>
            <button type="button" id="btn-save" class="btn btn-success">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
  var tabelData = $('#tabel-data').DataTable({
    destroy: true,
    paginate: true,
    info: true,
    sort: true,
    processing: true,
    serverSide: true,
    order: [
      [1, 'asc'],
    ],
    ajax: {
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{ url('/jadwalPraktek/data') }}",
      method: 'POST'
    },
    columns: [
      { data: 'DT_RowIndex', class: 'text-center', width: '30px', orderable: false, searchable: false},
      { data: 'hari', class: 'hidden' },
      { data: 'namahari' },
      { data: 'namapoli' },
      { data: 'namadokter' },
      { data: 'jadwal',class: 'text-center' },
      { data: 'pasien_umum', class: 'text-center' },
      { data: 'pasien_jkn', class: 'text-center' },
      { data: 'action',  class: 'text-center', width: '50px', orderable: false,  searchable: false }
    ]
  });

  $('#tabel-data').on('click', '#btn-update', function(){
    var idJadwalPraktek = $(this).data('id');
    $.ajax({
      type:     'ajax',
      method:   'get',
      url:      '{{ url("/jadwalPraktek/data") }}/' + idJadwalPraktek,
      async: 		true,
      success: 	function(response){
        $('#id_jadwal_praktek').val(response.id_jadwal_praktek);
        $('#hari').val(response.hari);
        $('#namahari').val(response.namahari);
        $('#namapoli').val(response.namapoli);
        $('#namadokter').val(response.namadokter);
        $('#buka').val(response.buka);
        $('#tutup').val(response.tutup);
        $('#pasien_umum').val(response.pasien_umum);
        $('#pasien_jkn').val(response.pasien_jkn);
        $('#modal-detail').modal('show');
      }
    });
    return false;
  });

  function syncData() {
    $.ajax({
      url: `{{ url('/jadwalPraktek/syncData') }}`,
      type: "post",
      data: {
        "_token": "{{ csrf_token() }}",
      },
      complete: () => {
        tabelData.ajax.reload(null, false);
      },
    })
  };
</script>
@endsection
