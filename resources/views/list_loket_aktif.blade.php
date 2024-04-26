@foreach($loket as $listLoket)
  <div class="card" style="margin-bottom: 20px;">
    <div class="card-header">
      <span class="card-title" style="font-size: 20px; font-weight: bold;">{{ $listLoket->nama_loket }}</span>
    </div>
    @if ($listLoket->antreanLoketHariIni)
      <div class="card-body text-center" style="padding: 1rem 1rem;">
        <span style="font-size: 28px; font-weight: bold; text-shadow: 2px 2px rgba(158, 158, 158, 0.5);">
          @if($listLoket->antreanLoketHariIni->antrean != null)
            {{ $listLoket->antreanLoketHariIni->antrean->nomorantrean }}
          @else
            ~
          @endif
        </span>
      </div>
      @if ($listLoket->antreanLoketHariIni->id_user == Auth::user()->id)
        <div class="card-footer px-2">
          <button type="button" onclick="panggilUlang();" class="btn btn-primary">Panggil Ulang</button>
          <button type="button" onclick="setPendaftaran();" class="btn btn-success">Pendaftaran</button>
          <input type="hidden" id="id_loket_aktif" value="{{ $listLoket->antreanLoketHariIni->id_loket }}">
          <input type="hidden" id="id_antrean_aktif" value="{{ isset($listLoket->antreanLoketHariIni->antrean) ? $listLoket->antreanLoketHariIni->antrean->id_antrean : '' }}">
          <input type="hidden" id="nomor_antrean_aktif" value="{{ $listLoket->antreanLoketHariIni->nomor_antrean }}">
        </div>
      @else
        <div class="card-footer px-2">
          Petugas Loket : {{ $listLoket->antreanLoketHariIni->karyawan->name }}
        </div>
      @endif
    @else
      <div class="card-body text-center" style="padding: 1rem 1rem;">
        <span style="font-size: 28px; font-weight: bold; text-shadow: 2px 2px rgba(158, 158, 158, 0.5);">~</span>
      </div>
      <div class="card-footer px-2">
        <button type="button" onClick="setAktif('{{ $listLoket->id_loket }}');" class="btn btn-success">Set Aktif</button>
      </div>
    @endif
  </div>
@endforeach
