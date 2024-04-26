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
</head>
<body style="background-image: url(/img/login.jpg); background-repeat: no-repeat; background-size: cover; height: 100vh; overflow-x: hidden;">
    <div id="app" class="d-flex flex-row-reverse">
        <main class="col-4 justify-content-center" style="background-color: rgba(0, 0, 0, 0.7); height: 100vh;">
            @yield('content')
        </main>
    </div>
</body>
</html>
