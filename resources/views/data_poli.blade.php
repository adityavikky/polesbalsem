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
          Data Poli
          <button type="button" class="btn btn-dark" style="position: absolute; right: 16px; top: 5px;" onclick="syncData();">Sync Data BPJS</button>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="tabel-data" class="table table-hover table-striped">
              <thead>
                <th>No.</th>
                <th>Kode Poli</th>
                <th>Nama Poli</th>
                <th>Estimasi Pelayanan</th>
                <th>Status</th>
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
      url: "{{ url('/poli/data') }}",
      method: 'POST'
    },
    columns: [
      { data: 'DT_RowIndex', class: 'text-center', width: '30px', orderable: false, searchable: false },
      { data: 'kodepoli' },
      { data: 'namapoli' },
      { data: 'estimasi_pelayanan', class: 'text-center' },
      { data: 'action',  class: 'text-center', width: '70px', orderable: false,  searchable: false }
    ]
  });

  function updateStatus(a) {
    $.ajax({
      url: `{{ url('/poli/updateStatus') }}`,
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
      url: `{{ url('/poli/syncData') }}`,
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
