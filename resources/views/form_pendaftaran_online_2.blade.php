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
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
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
                <label class="col-12 col-form-label">Tipe Pasien</label>
                <div class="col-12">
                  <label style="position: relative; top: 8px;"><input type="radio" id="pasien_baru" name="tipe_pasien" value="Baru" required="" data-parsley-errors-messages-disabled="" style="margin-left: 10px;" data-parsley-multiple="tipe_pasien" onclick="loadFormPendaftaranPasien('baru')"> PASIEN BARU </label>
                  <label style="position: relative; top: 8px;"><input type="radio" id="pasien_lama" name="tipe_pasien" value="Lama" required="" data-parsley-errors-messages-disabled="" style="margin-left: 10px;" checked="checked" data-parsley-multiple="tipe_pasien" onclick="loadFormPendaftaranPasien('lama')"> PASIEN LAMA </label>
                </div>
              </div>
            </div>
            <div class="col-md-8 col-12 mb-3">
              <div class="form-group row">
                <label class="col-12 text-right text-danger">
                    *Pasien BPJS silahkan download Aplikasi MJKN di Playstore<br>
                    *Kedatangan verifikasi pasien maksimal jam 10 pagi
                </label>
              </div>
            </div>
            <hr>
            <div id="form_area" class="row">
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
    <script type="text/javascript">
      $(document).ready(function() {
        loadFormPendaftaranPasien('lama');
      });

      function loadFormPendaftaranPasien(tipe) {
        if (tipe=="baru") {
          $.ajax({
            url: `{{ url('/pendaftaranOnlineBaru') }}`,
            type: "get",
            success: (response) => {
              $('#form_area').html(response);
            },
          });
        } else {
          $.ajax({
            url: `{{ url('/pendaftaranOnlineLama') }}`,
            type: "get",
            success: (response) => {
              $('#form_area').html(response);
            },
          })
        }
      };
    </script>
</body>
</html>
