<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | {{ config('app.name', 'SARPRAS') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('evanto/assets/images/favicon.avif') }}">

    @include('layouts.head-css')
    <style>
        .admin-broadcast {
            margin: 1rem 1rem 0;
            border: 1px solid rgba(245, 158, 11, 0.45);
            background: rgba(254, 243, 199, 0.85);
            color: #92400e;
            border-radius: 12px;
            padding: 0.65rem 0.85rem;
            font-size: 0.9rem;
        }
        body[data-theme-version="dark"] .admin-broadcast,
        body[data-theme="dark"] .admin-broadcast,
        body.theme-dark .admin-broadcast {
            background: rgba(120, 53, 15, 0.28);
            border-color: rgba(251, 191, 36, 0.45);
            color: #fcd34d;
        }
    </style>
    @stack('styles')
</head>
@php($heroVariant = $activeHeroVariant ?? 'ocean')
<body data-theme-version="light" data-layout="vertical" data-nav-headerbg="color_1" data-headerbg="color_1" data-sidebar-style="full" data-sidebarbg="color_1" data-sidebar-position="fixed" data-header-position="fixed" data-container="wide" direction="ltr" data-hero-variant="{{ $heroVariant }}">
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>

    <div id="main-wrapper">
        @include('layouts.topbar')
        @include('layouts.sidebar')

        @if(!empty($adminBroadcastMessage))
            <div class="admin-broadcast" role="status" aria-live="polite">
                <strong>Info Admin:</strong> {{ $adminBroadcastMessage }}
            </div>
        @endif

        @yield('content')

        @include('layouts.footer')
    </div>

    @include('layouts.vendor-scripts')
    @stack('scripts')
    @stack('script')
    <script>
        (function () {
            const LANDING_THEME_KEY = 'sarpras-landing-theme';

            const setCookie = (name, value) => {
                document.cookie = `${name}=${value}; path=/`;
            };

            const syncTheme = () => {
                const current = document.body.getAttribute('data-theme-version') === 'dark' ? 'dark' : 'light';
                setCookie('version', current);
                try {
                    localStorage.setItem(LANDING_THEME_KEY, current);
                } catch (e) {
                    // ignore storage failures
                }
            };

            syncTheme();

            const observer = new MutationObserver((mutations) => {
                for (const mutation of mutations) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'data-theme-version') {
                        syncTheme();
                        break;
                    }
                }
            });

            observer.observe(document.body, { attributes: true });
        })();
    </script>
</body>
</html>
