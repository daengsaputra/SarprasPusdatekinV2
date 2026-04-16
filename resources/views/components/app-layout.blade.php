<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        {{-- Bisa masukkan navbar dari template Envato --}}
    </header>

    <main>
        {{ $slot }} {{-- Konten akan muncul di sini --}}
    </main>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>