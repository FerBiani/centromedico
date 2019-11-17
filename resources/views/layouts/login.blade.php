<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Centro Médico') }}</title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font/fontawesome/css/all.css') }}" rel="stylesheet" />
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{url('/')}}">Centro Médico</a>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">

                @if(Session::get('success'))
                <div class="alert alert-success" role="alert">
                    <p>{{Session::get('success')}}</p>
                </div>
                @endif

                @if(Session::get('warning'))
                <div class="alert alert-warning" role="alert">
                    <p>{{Session::get('warning')}}</p>
                </div>
                @endif

                @if(Session::get('error'))
                <div class="alert alert-error" role="alert">
                    <p>{{Session::get('error')}}</p>
                </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
    <script type="text/javascript" src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-validator/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-validator/localization/messages_pt_BR.min.js') }}"></script>
    <script> var main_url="{{url('')}}"; </script>
    @yield('js')
</body>
</html>