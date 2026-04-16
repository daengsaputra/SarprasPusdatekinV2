<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Authentication') | {{ config('app.name', 'SARPRAS') }}</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('evanto/assets/images/favicon.avif') }}">
    <link href="{{ asset('evanto/assets/vendor/metismenu/dist/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('evanto/assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('evanto/assets/vendor/chartist/css/chartist.min.css') }}">
    <link class="main-switcher" href="{{ asset('evanto/assets/css/switcher.css') }}" rel="stylesheet">
    <link class="main-plugins" href="{{ asset('evanto/assets/css/plugins.css') }}" rel="stylesheet">
    <link class="main-css" href="{{ asset('evanto/assets/css/style.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="vh-100">
    @yield('content')

    <script src="{{ asset('evanto/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('evanto/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('evanto/assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('evanto/assets/vendor/@yaireo/tagify/dist/tagify.js') }}"></script>
    <script src="{{ asset('evanto/assets/vendor/metismenu/dist/metisMenu.min.js') }}"></script>
    <script src="{{ asset('evanto/assets/vendor/chart-js/chart.bundle.min.js') }}"></script>
    <script src="{{ asset('evanto/assets/js/deznav-init.js') }}"></script>
    <script src="{{ asset('evanto/assets/js/custom.js') }}"></script>
    <script src="{{ asset('evanto/assets/vendor/i18n/i18n.js') }}"></script>
    <script src="{{ asset('evanto/assets/js/translator.js') }}"></script>
    @stack('scripts')
</body>
</html>
