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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('plugin/sweetalert/dist/sweetalert.css') }}"/>
    <link rel="stylesheet" href="{{ asset('plugin/select2/dist/css/select2.min.css') }}">

    <style>
      ::placeholder {
        color: blue !important;
      }
    </style>
    @yield('css')
</head>
<body>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <!-- jQuery -->
    <script src="//code.jquery.com/jquery.js"></script>
    <script type="text/javascript" src="{{ asset('plugin/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugin/select2/dist/js/select2.full.min.js') }}"></script>
    @yield('js')
</body>
</html>
