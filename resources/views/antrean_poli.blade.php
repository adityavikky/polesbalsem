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
          Antrean Poli
          <button type="button" id="btn-refresh" class="btn btn-dark" style="position: absolute; right: 16px; top: 5px;">Refresh Data</button>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table id="tabel-data" class="table table-hover table-striped">
                  <thead>
                    <th>No.</th>
                    <th>Jam</th>
                    <th>Jenis</th>
                    <th>Nomor</th>
                    <th>Poli</th>
                    <th>Dokter</th>
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
  </div>
</div>

<div class="modal fade" id="modal-detail" tabindex="-1" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="form-data" method="POST" action="{{ url('/antrean/updateAntreanPendaftaran') }}" data-parsley-validate>
      @csrf
        <div class="modal-header">
          <h4 class="modal-title">Data Pendaftaran Pasien</h4>
        </div>
        <div class="modal-body">
          <div class="col-12 row">
            <div class="col-md-6 col-12">
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">No. Antrean</label>
                <div class="col-md-8">
                  <input id="id_antrean" type="hidden" class="form-control" name="id_antrean" value="" required data-parsley-errors-messages-disabled>
                  <input id="nomorantrean" type="text" class="form-control readonly" name="nomorantrean" value="" required data-parsley-errors-messages-disabled>
                  <input id="taskId" type="hidden" class="form-control" name="taskId" value="5" placeholder="taskId">
                </div>
              </div>
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">Jenis Pasien</label>
                <div class="col-md-8">
                  <input id="jenispasien" type="text" class="form-control" name="jenispasien" value="" placeholder="NIK" required data-parsley-errors-messages-disabled>
                </div>
              </div>
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">NIK</label>
                <div class="col-md-8">
                  <div class="input-group">
                    <input id="nik" type="text" class="form-control" name="nik" value="" placeholder="NIK" required data-parsley-errors-messages-disabled>
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">No. RM</label>
                <div class="col-md-8">
                  <input id="norm" type="text" class="form-control" name="norm" value="" placeholder="No. RM" required data-parsley-errors-messages-disabled>
                </div>
              </div>
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">Telepon</label>
                <div class="col-md-8">
                  <input id="nohp" type="text" class="form-control" name="nohp" placeholder="Telepon" value="">
                </div>
              </div>
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">No. Peserta</label>
                <div class="col-md-8">
                  <input id="nomorkartu" type="text" class="form-control" name="nomorkartu" placeholder="Nomor Peserta (JKN)" value="">
                </div>
              </div>
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">No. Rujukan</label>
                <div class="col-md-8">
                  <input id="nomorreferensi" type="text" class="form-control" name="nomorreferensi" value="" placeholder="Nomor Rujukan (JKN)">
                </div>
              </div>
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">Poli</label>
                <div class="col-md-8">
                  <input id="namapoli" type="text" class="form-control" name="namapoli" placeholder="Poli" value="">
                </div>
              </div>
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">Dokter</label>
                <div class="col-md-8">
                  <input id="namadokter" type="text" class="form-control" name="namadokter" placeholder="Dokter" value="">
                </div>
              </div>
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">Farmasi</label>
                <div class="col-md-8">
                  <select id="farmasi" name="farmasi" class="form-select">
                      <option value="Ada">ADA</option>
                      <option value="Tidak" selected>TIDAK</option>
                  </select>
                </div>
              </div>
              <div class="row mb-2" style="display: none;">
                <label for="name" class="col-md-4 col-form-label"></label>
                <div class="col-md-8">
                  <input id="jampraktek" type="text" class="form-control" name="jampraktek" value="">
                  <input id="kodepoli" type="text" class="form-control" name="kodepoli" value="">
                  <input id="id_poli" type="text" class="form-control" name="id_poli" value="">
                </div>
              </div>
            </div>
            <div class="col-md-6 col-12">
              <table id="tabel-task" class="table table-striped">
                <thead>
                  <th>Task</th>
                  <th>Waktu</th>
                  <th>Status</th>
                </thead>
                <tbody id="table-task-body">
                  <!-- code here -->
                </tbody>
              </table>
            </div>
          </div>
          <hr class="jadwal-operasi">
          <div class="col-12 jadwal-operasi row">
            <div class="col-md-6 col-12">
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">Tgl. Operasi</label>
                <div class="col-md-8">
                  <input id="tanggaloperasi" type="date" class="form-control" name="tanggaloperasi" value="" placeholder="Tgl. Operasi" required data-parsley-errors-messages-disabled>
                </div>
              </div>
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">Jenis Tindakan</label>
                <div class="col-md-8">
                  <div class="input-group">
                    <textarea id="jenistindakan" type="text" class="form-control" name="jenistindakan" value="" placeholder="Jenis Tindakan" required data-parsley-errors-messages-disabled></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="btn-operasi-show" class="btn btn-info text-left" style="left: 12px; position: absolute;" onclick="setOperasi();">Setup Jadwal Operasi</button>
          <button type="button" id="btn-operasi-hide" class="btn btn-danger text-left" style="left: 12px; position: absolute;" onclick="hideOperasi();">Hapus Jadwal Operasi</button>
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
  hideOperasi();

  $('.readonly').attr("disabled", "disabled");
  var tabelData = $('#tabel-data').DataTable({
    destroy: true,
    paginate: true,
    info: true,
    sort: true,
    processing: true,
    serverSide: true,
    order: [
      [1, 'asc']
    ],
    ajax: {
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{ url('/antrean/data') }}",
      method: 'POST',
      data: {
        "taskId" : 4
      }
    },
    columns: [
      { data: 'DT_RowIndex',  class: 'text-center', width: '30px', orderable: false, searchable: false },
      { data: 'jam'           },
      { data: 'jenispasien'  },
      { data: 'nomorantrean'  },
      { data: 'namapoli'  },
      { data: 'namadokter'  },
      { data: 'action',       class: 'text-center', width: '70px', orderable: false,  searchable: false }
    ]
  });

  $('#btn-refresh').on('click', function(){
    tabelData.ajax.reload( null, false);
  });


  $('#tabel-data').on('click', '#btn-sound', function(){
    var idAntrean = $(this).data('id');
    $.ajax({
      type:     'ajax',
      method:   'post',
      url:      '{{ url("/antrean/panggilAntrean") }}',
      data:     {
              "_token": "{{ csrf_token() }}",
              "id_antrean": idAntrean,
              "taskId" : 4
            },
      async: 		true,
      success: 	function(response){
        setPendaftaran(idAntrean);
      }
    });
    return false;
  });

  $('#btn-save').on('click', function() {
    if ($('#form-data').parsley().validate()==true){
      $('#overlay').show();
      $('#form-data').ajaxForm({
        success: 	function(response){
          if(response.status==true){
            tabelData.ajax.reload( null, false);
            $('#form-data')[0].reset();
            $('#id_antrean_aktif').val('');
            $('#modal-detail').modal('hide');
            $('#overlay').hide();
            swal(
              response.message,
              '',
              'success'
            );
          }else{
            swal(
              response.message,
              '',
              'error'
            );
            $('#overlay').hide();
          }
        },
        error: function(response){
          swal(
            response.message,
            '',
            'error'
          );
          $('#overlay').hide();
        }
      }).submit();
    }
  });

  function setPendaftaran(idAntrean) {
    $.ajax({
      type:     'ajax',
      method:   'get',
      url:      '{{ url("/antrean/data/") }}/' + idAntrean,
      async: 		true,
      success: 	function(response){
        $('#id_antrean').val(response.id_antrean);
        $('#jenispasien').val(response.jenispasien);
        $('#nomorantrean').val(response.nomorantrean);
        $('#nik').val(response.nik);
        $('#norm').val(response.norm);
        $('#nohp').val(response.nohp);
        $('#nomorkartu').val(response.nomorkartu);
        $('#nomorreferensi').val(response.nomorreferensi);
        $('#id_poli').val(response.id_poli);
        $('#kodepoli').val(response.kodepoli);
        $('#namapoli').val(response.namapoli);
        $('#kodedokter').html('<option value="' + response.kodedokter + '">' + response.namadokter + '</option>');
        $('#kodedokter').val(response.kodedokter).trigger('change');
        $('#namadokter').val(response.namadokter);
        $('#jampraktek').val(response.jampraktek);
        $('#jenispasien').val(response.jenispasien);

        let addRowsTable = "";
        for (let countTask = 0; countTask < response.antrean_task.length; countTask++) {
          addRowsTable += '<tr>';
          addRowsTable += '<td>' + response.antrean_task[countTask].task.keterangan_task + '</td>';
          addRowsTable += '<td>' + response.antrean_task[countTask].jam + '</td>';
          addRowsTable += '<td>' + response.antrean_task[countTask].status_antrean_task + '</td>';
          addRowsTable += '</tr>';
        }
        $('#table-task-body').html(addRowsTable);
        $('#modal-detail').modal('show');
      }
    });
  };

  function setOperasi() {
    $('.jadwal-operasi').show();
    $('#btn-operasi-hide').show();
    $('#btn-operasi-show').hide();
    $('#tanggaloperasi').val(null);
    $('#jenistindakan').val(null);
  };

  function hideOperasi() {
    $('.jadwal-operasi').hide();
    $('#btn-operasi-hide').hide();
    $('#btn-operasi-show').show();
    $('#tanggaloperasi').val(null);
    $('#jenistindakan').val(null);
  };
</script>
@endsection

