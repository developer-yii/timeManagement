<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet" id="app-style">
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body class="loading authentication-bg" data-layout-config='{"darkMode":false}'>
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        @yield('content')
    </div>
    <!-- end page -->

    <footer class="footer footer-alt">
        2018 - <script>document.write(new Date().getFullYear())</script> © Hyper - Coderthemes.com
    </footer>

    <!-- bundle -->
    <script src="{{ asset('js/vendor.min.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script type="text/javascript">       
        
        function show_toast(toast_message,toast_type) {
            $.NotificationApp.send("Hello!", toast_message, "top-right", "rgba(0,0,0,0.2)", toast_type);
        }

    </script>
    @yield('pagejs')
</body>
</html>
