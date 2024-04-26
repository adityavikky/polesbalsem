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
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
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
