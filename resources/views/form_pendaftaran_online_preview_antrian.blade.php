@if($antrian['metadata']['code']==201)
  <span class="text-danger"><b>{{ $antrian['metadata']['message'] }}</b></span>
@endif

@if($antrian['metadata']['code']==200)
  <span class="text-success"><b>{{ $antrian['metadata']['message'] }}</b></span>
@endif
<div class="col-md-4 mb-3 mt-3">
  <div class="card shadow" style="border: solid 1px green;">
    <div class="card-header text-center" style="border-bottom: solid 1px green; font-size: 20px; color: green; background: #3e8f3e40;">
      Nomor Antrian Anda : {{ $antrian['response']['nomorantrean'] }}
    </div>

    <div class="card-body text-center" style="font-size: 16px;">
      <b>Tanggal Kunjungan : {{ date('d-m-Y', strtotime($antrian['response']['tanggalperiksa'])) }}</b><br><br>
      <button type="button" class="btn btn-primary" data-id="{{ $antrian['response']['id_antrian'] }}" onclick="cetakAntrianPdf(this);">Cetak Antrian</button>
    </div>
  </div>
</div>

<script>
  function cetakAntrianPdf(a) {
    let url = '{{ url("/printAntrianPdf") }}/' + $(a).data('id');
    window.open(url, '_blank');
  };
</script>
