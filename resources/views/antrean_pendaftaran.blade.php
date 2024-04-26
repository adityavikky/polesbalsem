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
          Antrean Pendaftaran
          <button type="button" id="btn-refresh" class="btn btn-dark" style="position: absolute; right: 16px; top: 5px;">Refresh Data</button>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4 col-12" id="list_loket">
              @include('list_loket_aktif')
            </div>
            <div class="col-md-8 col-12">
              <div class="table-responsive">
                <table id="tabel-data" class="table table-hover table-striped">
                  <thead>
                    <th>No.</th>
                    <th>Jam</th>
                    <th>Jenis</th>
                    <th>Nomor</th>
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
                  <input id="taskId" type="hidden" class="form-control" name="taskId" value="3" placeholder="taskId">
                </div>
              </div>
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">Jenis Pasien</label>
                <div class="col-md-8">
                  <select id="jenispasien" name="jenispasien" class="form-select">
                      <option value="NON JKN" selected>NON JKN</option>
                      <option value="JKN">JKN</option>
                  </select>
                </div>
              </div>
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">NIK</label>
                <div class="col-md-8">
                  <div class="input-group">
                    <input type="text" id="nik" name="nik" class="form-control" placeholder="NIK">
                    <div class="input-group-append">
                      <button type="button" id="btn-cari-nik" class="btn btn btn-secondary" type="button" style="border-top-left-radius: 0px; border-bottom-left-radius: 0px;">Cari</button>
                    </div>
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
                  <select id="nomorreferensi" name="nomorreferensi" class="form-select" style="width: 100%;">
                  </select>
                  <!-- <input id="nomorreferensi" type="text" class="form-control" name="nomorreferensi" value="" placeholder="Nomor Rujukan (JKN)"> -->
                </div>
              </div>
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">Poli</label>
                <div class="col-md-8">
                  <select id="id_poli" name="id_poli" class="form-select select2">
                    @foreach($poli as $dataPoli)
                      <option value="{{ $dataPoli->id_poli }}">{{ $dataPoli->namapoli }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="row mb-2">
                <label for="name" class="col-md-4 col-form-label">Dokter</label>
                <div class="col-md-8">
                  <select id="kodedokter" name="kodedokter" class="form-select" style="width: 100%;">
                  </select>
                </div>
              </div>
              <div class="row mb-2" style="display: none;">
                <label for="name" class="col-md-4 col-form-label"></label>
                <div class="col-md-8">
                  <input id="jampraktek" type="text" class="form-control" name="jampraktek" value="">
                  <input id="kodepoli" type="text" class="form-control" name="kodepoli" value="">
                  <input id="namapoli" type="text" class="form-control" name="namapoli" value="">
                  <input id="namadokter" type="text" class="form-control" name="namadokter" value="">
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
        "taskId" : 3
      }
    },
    columns: [
      { data: 'DT_RowIndex',  class: 'text-center', width: '30px', orderable: false, searchable: false },
      { data: 'jam'           },
      { data: 'jenispasien'  },
      { data: 'nomorantrean'  },
      { data: 'action',       class: 'text-center', width: '70px', orderable: false,  searchable: false }
    ]
  });

  $('#btn-refresh').on('click', function(){
    tabelData.ajax.reload( null, false);
  });

  $('#btn-cari-nik').on('click', function(){
    $.ajax({
      type:     'ajax',
      method:   'get',
      url:      '{{ url("/bpjsVclaim/getPesertaByNIK") }}',
      data: {
        'cari' : $('#nik').val()
      },
      async: 		true,
      success: 	function(response){
        $('#nomorkartu').val(response.data.peserta.noKartu);
        $('#norm').val(response.data.peserta.mr.noMR);
        $('#nohp').val(response.data.peserta.mr.noTelepon);
      }
    });
  });

  $('#nomorreferensi').select2({
    ajax: {
      url: '{{ url("/bpjsVclaim/getRujukanFaskesRS") }}',
      dataType: 'json',
      delay: 1000,
      data: function (params) {
        return {
          q: params.term,
          page: 50,
          nomorkartu : $('#nomorkartu').val()
        };
      },
      processResults: function (data) {
        return {
          results: data.items
        };
      },
      cache: true
    },
    placeholder: '-- Cari Rujukan --',
    minimumInputLength: 0,
    templateResult: templateRujukan,
    escapeMarkup: function(m) {
        return m;
    }
  }).on('select2:select', function (e) {
    var data = e.params.data;
    $('#idpoli').val(data.namapoli).trigger('change');
    $('#namapoli').val(data.namapoli).trigger('change');
    $('#kodepoli').val(data.kodepoli).trigger('change');
  });

  function templateRujukan(data) {
    return '<b>' + data.text + '</b><br>' +
      'Tanggal SEP : ' + data.tanggal + '<br>' +
      'Poli : ' + data.kodepoli + ' - ' + data.namapoli + '<br>' +
      'Diagnosa : ' + data.kodediagnosa + ' - ' + data.namadiagnosa;
  };

  $('#kodedokter').select2({
    ajax: {
      url: '{{ url("/bpjsAntrol/getReferensiJadwalDokter") }}',
      dataType: 'json',
      delay: 1000,
      data: function (params) {
        return {
          q: params.term,
          page: 50,
          id_poli : $('#id_poli').val()
        };
      },
      processResults: function (data) {
        return {
          results: data.items
        };
      },
      cache: true
    },
    placeholder: '-- Cari Dokter --',
    minimumInputLength: 0,
    templateResult: template,
    escapeMarkup: function(m) {
        return m;
    }
  }).on('select2:select', function (e) {
    var data = e.params.data;
    $('#jampraktek').val(data.jadwal);
    $('#namapoli').val(data.namapoli);
    $('#kodepoli').val(data.kodepoli);
    $('#namadokter').val(data.text);
  });

  function template(data) {
    return '<b>' + data.text + '</b><br>' +
      'Jadwal : ' + data.namahari + ' - ' + data.jadwal + '<br>' +
      'Poli : ' + data.kodepoli + ' - ' + data.namapoli;
  };

  $('#tabel-data').on('click', '#btn-sound', function(){
    let checkObject = $('#id_loket_aktif').val();
    if (checkObject == undefined) {
      swal('Loket Tidak Aktif', 'Silahkan aktifkan loket terlebih dahulu!', 'warning');
    } else {
      openSound($(this).data('id'), $(this).data('nomor'), $('#id_loket_aktif').val());
    }
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

  function panggilUlang() {
    openSound( $('#id_antrean_aktif').val(), $('#nomor_antrean_aktif').val(), $('#id_loket_aktif').val());
  }

  function openSound(idAntrean, nomorAntrean, loket) {
    $.ajax({
      type:     'ajax',
      method:   'post',
      url:      '{{ url("/antrean/panggilAntrean") }}',
      data:     {
              "_token": "{{ csrf_token() }}",
              "id_antrean": idAntrean,
              "taskId" : 2
            },
      async: 		true,
      success: 	function(response){
        $('#list_loket').html(response);
        setPendaftaran(idAntrean);
      }
    });

    return false;
  }

  function setAktif(idLoket) {
    swal({
      title: "Aktifkan Loket?",
      text: "",
      type: "info",
      showCancelButton: true,
      confirmButtonColor: "#218838",
      confirmButtonText: "Aktifkan",
      cancelButtonText: "Batal",
      closeOnConfirm: false,
      showLoaderOnConfirm: true,
    },
    function(){
      $.ajax({
        type: 'ajax',
        method: 'post',
        url: '{{ url("antrean/setAktifLoket") }}',
        data: {
          "_token": "{{ csrf_token() }}",
          "id_loket": idLoket
        },
        async: true,
        dataType: 'json',
        success: function(response){
          window.location.reload();
        },
        error: function(response){
          swal({
            title: response.message,
            type: 'error',
            icon: 'error'
          });
        }
      });
    });
  };

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
  }
</script>
@endsection

