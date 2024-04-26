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
         Data Loket
          <button type="button" class="btn btn-success" style="position: absolute; right: 16px; top: 5px;" onclick="syncData();">Tambah Data</button>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="tabel-data" class="table table-hover table-striped">
              <thead>
                <th>No.</th>
                <th>Tipe Loket</th>
                <th>Nama Loket</th>
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
      [2, 'asc']
    ],
    ajax: {
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{ url('/loket/data') }}",
      method: 'POST'
    },
    columns: [
      { data: 'DT_RowIndex', class: 'text-center', width: '30px', orderable: false, searchable: false },
      { data: 'type_loket' },
      { data: 'nama_loket' },
      { data: 'action',  class: 'text-center', width: '70px', orderable: false,  searchable: false }
    ]
  });

  function updateStatus(a) {
    $.ajax({
      url: `{{ url('/loket/updateStatus') }}`,
      type: "post",
      data: {
        "kode": $(a).data('kode'),
        "status": $(a).data('status'),
        "_token": "{{ csrf_token() }}",
      },
      complete: () => {
        tabelData.ajax.reload(null, false);
      },
    })
  };

  function syncData() {
    $.ajax({
      url: `{{ url('/loket/syncData') }}`,
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

