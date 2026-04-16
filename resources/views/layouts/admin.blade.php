<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin</title>

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="{{ asset('build_admin/css/bootstrap.main.css') }}">

    {{-- Icon --}}
    <link rel="stylesheet" href="{{ asset('build_admin/css/icon.min.css') }}">

    {{-- Main Style --}}
    <link rel="stylesheet" href="{{ asset('build_admin/css/app.main.css') }}">
</head>
<body>

    @yield('content')

    <script src="{{ asset('build_admin/js/app.js') }}"></script>
</body>
</html>