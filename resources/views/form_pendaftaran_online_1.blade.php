<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>


  <!-- Bootstrap CSS -->
  <!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet"> -->
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('plugin/sweetalert/dist/sweetalert.css') }}"/>
  <link rel="stylesheet" href="{{ asset('plugin/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugin/fontawesome_5.12.0/css/all.css') }}">
  <link rel="stylesheet" href="{{ asset('plugin/parsleyjs/src/parsley.css') }}">
  <style>
    .hidden {
        display: none !important;
    }

    table.dataTable {
        padding-top: 16px;
        padding-bottom: 16px;
    }

    table.dataTable thead th, table.dataTable thead td {
        border-bottom: 1px solid #bdb5b5;
        border-top: 1px solid #bdb5b5;
    }

    table.dataTable td {
        border-bottom: 1px solid #bdb5b5;
    }
    table.dataTable.no-footer {
        border-bottom: none;
    }

    .paginate_button {
      border: solid 1px #ebebebc7 !important;
    }

    ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
      color: #d1d1d1 !important;
      opacity: 1; /* Firefox */
    }

    :-ms-input-placeholder { /* Internet Explorer 10-11 */
      color: #d1d1d1 !important;
    }

    ::-ms-input-placeholder { /* Microsoft Edge */
      color: #d1d1d1 !important;
    }

    .modal-open .select2-container {
      z-index: 9999;
    }

    .select2-container .select2-selection--single {
      height: 37px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: 34px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
      margin-left: -14px;
      margin-top: 2px;
    }
  </style>
</head>
<body>
    <div id="app">
      <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
          <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
          </a>
        </div>
      </nav>

      <main class="py-4">
        <div class="container">
          <div class="row">
            <div class="col-md-4 col-12 mb-3">
              <div class="form-group row">
                <label class="col-md-4 col-form-label">Pilih Unit</label>
                <div class="col-md-8">
                  <select id="id_unit" name="id_unit" class="form-control select2" style="width: 100%;">
                    <option value="">-- Pilih Unit --</option>
                  </select>
                </div>
              </div>
            </div>
            <hr>
            <div class="col-md-4 mb-3">
              <div class="card shadow" style="border: solid 1px green;" onclick="jenis_pasien = 'Baru'; $('#modal-detail').modal('show');">
                <div class="card-header text-center" style="border-bottom: solid 1px green; font-size: 20px; color: green; background: #3e8f3e40;">
                  Senin
                </div>

                <div class="card-body text-center" style="font-size: 16px;">
                  <b>dr. Dessy Andriani, Sp.PD</b><br>
                  Jam : 07:00-09:30<br>
                  <button type="button" class="btn btn-sm btn-primary">Pilih Jadwal Ini</button>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="card shadow" style="border: solid 1px green;" onclick="jenis_pasien = 'Baru'; $('#modal-detail').modal('show');">
                <div class="card-header text-center" style="border-bottom: solid 1px green; font-size: 20px; color: green; background: #3e8f3e40;">
                  Selasa
                </div>

                <div class="card-body text-center" style="font-size: 16px;">
                  <b>dr. Dessy Andriani, Sp.PD</b><br>
                  Jam : 07:00-09:30<br>
                  <button type="button" class="btn btn-sm btn-primary">Pilih Jadwal Ini</button>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="card shadow" style="border: solid 1px green;" onclick="jenis_pasien = 'Baru'; $('#modal-detail').modal('show');">
                <div class="card-header text-center" style="border-bottom: solid 1px green; font-size: 20px; color: green; background: #3e8f3e40;">
                  Rabu
                </div>

                <div class="card-body text-center" style="font-size: 16px;">
                  <b>dr. Dessy Andriani, Sp.PD</b><br>
                  Jam : 07:00-09:30<br>
                  <button type="button" class="btn btn-sm btn-primary">Pilih Jadwal Ini</button>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="card shadow" style="border: solid 1px green;" onclick="jenis_pasien = 'Baru'; $('#modal-detail').modal('show');">
                <div class="card-header text-center" style="border-bottom: solid 1px green; font-size: 20px; color: green; background: #3e8f3e40;">
                  Kamis
                </div>

                <div class="card-body text-center" style="font-size: 16px;">
                  <b>dr. Dessy Andriani, Sp.PD</b><br>
                  Jam : 07:00-09:30<br>
                  <button type="button" class="btn btn-sm btn-primary">Pilih Jadwal Ini</button>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="card shadow" style="border: solid 1px green;" onclick="jenis_pasien = 'Baru'; $('#modal-detail').modal('show');">
                <div class="card-header text-center" style="border-bottom: solid 1px green; font-size: 20px; color: green; background: #3e8f3e40;">
                  Jumat
                </div>

                <div class="card-body text-center" style="font-size: 16px;">
                  <b>dr. Dessy Andriani, Sp.PD</b><br>
                  Jam : 07:00-09:30<br>
                  <button type="button" class="btn btn-sm btn-primary">Pilih Jadwal Ini</button>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="card shadow" style="border: solid 1px green;" onclick="jenis_pasien = 'Baru'; $('#modal-detail').modal('show');">
                <div class="card-header text-center" style="border-bottom: solid 1px green; font-size: 20px; color: green; background: #3e8f3e40;">
                  Sabtu
                </div>

                <div class="card-body text-center" style="font-size: 16px;">
                  <b>dr. Dessy Andriani, Sp.PD</b><br>
                  Jam : 07:00-09:30<br>
                  <button type="button" class="btn btn-sm btn-primary">Pilih Jadwal Ini</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
    <!-- jQuery -->
    <!-- <script src="//code.jquery.com/jquery.js"></script> -->
    <script type="text/javascript" src="{{ asset('plugin/jquery/jquery-3.4.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugin/jquery/jquery.form.js') }}"></script>
    <!-- DataTables -->
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('plugin/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugin/select2/dist/js/select2.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugin/parsleyjs/dist/parsley.min.js') }}"></script>
    @yield('js')
</body>
</html>
