<!DOCTYPE html>
<html lang="id">
@php($heroVariant = $activeHeroVariant ?? 'ocean')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SARPRAS PUSDATEKIN' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --brand-blue: #2563eb;
            --brand-blue-dark: #1d4ed8;
            --brand-cyan: #38bdf8;
            --brand-ink: #020617;
            --brand-cloud: #f8fafc;
            --brand-slate: #0f172a;
            --surface-1: linear-gradient(160deg, #ffffff 0%, #eef2ff 40%, #e2e8f0 100%);
            --surface-2: rgba(241, 245, 249, 0.92);
            --surface-3: rgba(226, 232, 240, 0.78);
            --border-soft: rgba(15, 23, 42, 0.08);
            --text-primary: #0f172a;
            --text-secondary: rgba(30, 41, 59, 0.78);
            --text-muted: rgba(71, 85, 105, 0.68);
            --bs-body-bg: transparent;
            --bs-body-color: var(--text-primary);
            --bs-heading-color: var(--text-primary);
            --bs-link-color: var(--brand-blue);
            --bs-link-hover-color: var(--brand-blue-dark);
            --bs-emphasis-color: var(--text-primary);
            --bs-border-color: rgba(15, 23, 42, 0.08);
            --bs-secondary-color: rgba(71, 85, 105, 0.7);
            --bs-body-secondary-color: rgba(71, 85, 105, 0.7);
            --bs-body-tertiary-color: rgba(100, 116, 139, 0.6);
            --bs-body-secondary-bg: rgba(241, 245, 249, 0.92);
            --bs-body-tertiary-bg: rgba(226, 232, 240, 0.78);
            --bs-card-bg: var(--surface-2);
            --bs-card-border-color: var(--border-soft);
            --bs-primary: var(--brand-blue);
            --bs-primary-rgb: 37, 99, 235;
            --bs-success: #22c55e;
            --bs-success-rgb: 34, 197, 94;
            --bs-warning: #f59e0b;
            --bs-warning-rgb: 245, 158, 11;
            --bs-primary-bg-subtle: color-mix(in srgb, var(--brand-blue) 18%, transparent);
            --bs-primary-border-subtle: color-mix(in srgb, var(--brand-blue) 25%, transparent);
            --bs-primary-text-emphasis: var(--brand-blue-dark);
            --bs-success-bg-subtle: rgba(34, 197, 94, 0.12);
            --bs-success-border-subtle: rgba(34, 197, 94, 0.25);
            --bs-success-text-emphasis: #166534;
            --bs-warning-bg-subtle: rgba(250, 204, 21, 0.16);
            --bs-warning-border-subtle: rgba(250, 204, 21, 0.28);
            --bs-warning-text-emphasis: #92400e;
            --nav-bg: rgba(248, 250, 252, 0.9);
            --nav-bg-scrolled: rgba(255, 255, 255, 0.95);
            --nav-border: rgba(15, 23, 42, 0.08);
            --nav-border-scrolled: rgba(15, 23, 42, 0.14);
            --footer-bg: rgba(248, 250, 252, 0.95);
            --footer-border: rgba(15, 23, 42, 0.1);
        }
        body {
            min-height: 100vh;
            background: var(--surface-1);
            color: var(--text-primary);
            transition: background .35s ease, color .35s ease;
        }
        body.theme-dark {
            --surface-1: linear-gradient(160deg, #020617 0%, #0b1220 45%, #111827 100%);
            --surface-2: rgba(15, 23, 42, 0.92);
            --surface-3: rgba(30, 41, 59, 0.78);
            --border-soft: rgba(148, 163, 184, 0.24);
            --text-primary: #f8fafc;
            --text-secondary: rgba(226, 232, 240, 0.82);
            --text-muted: rgba(148, 163, 184, 0.82);
            --brand-cyan: #7dd3fc;
            --nav-bg: rgba(15, 23, 42, 0.86);
            --nav-bg-scrolled: rgba(2, 6, 23, 0.9);
            --nav-border: rgba(148, 163, 184, 0.22);
            --nav-border-scrolled: rgba(148, 163, 184, 0.3);
            --footer-bg: rgba(2, 6, 23, 0.88);
            --footer-border: rgba(148, 163, 184, 0.22);
        }
        body[data-hero-variant="slate"] {
            --brand-blue: #475569;
            --brand-blue-dark: #334155;
            --brand-cyan: #94a3b8;
            --surface-1: linear-gradient(160deg, #f8fafc 0%, #e2e8f0 42%, #cbd5e1 100%);
            --surface-2: rgba(248, 250, 252, 0.92);
            --surface-3: rgba(226, 232, 240, 0.82);
            --border-soft: rgba(51, 65, 85, 0.12);
            --text-primary: #0f172a;
            --text-secondary: rgba(51, 65, 85, 0.78);
            --text-muted: rgba(71, 85, 105, 0.72);
            --nav-bg: rgba(248, 250, 252, 0.9);
            --nav-bg-scrolled: rgba(255, 255, 255, 0.94);
            --nav-border: rgba(71, 85, 105, 0.12);
            --nav-border-scrolled: rgba(71, 85, 105, 0.18);
            --footer-bg: rgba(241, 245, 249, 0.95);
            --footer-border: rgba(71, 85, 105, 0.14);
        }
        body.theme-dark[data-hero-variant="slate"] {
            --brand-blue: #64748b;
            --brand-blue-dark: #475569;
            --brand-cyan: #cbd5e1;
            --surface-1: linear-gradient(160deg, #020617 0%, #111827 46%, #1f2937 100%);
            --surface-2: rgba(17, 24, 39, 0.92);
            --surface-3: rgba(31, 41, 55, 0.8);
            --border-soft: rgba(148, 163, 184, 0.22);
            --text-primary: #f8fafc;
            --text-secondary: rgba(226, 232, 240, 0.82);
            --text-muted: rgba(148, 163, 184, 0.78);
            --nav-bg: rgba(17, 24, 39, 0.88);
            --nav-bg-scrolled: rgba(2, 6, 23, 0.92);
            --nav-border: rgba(148, 163, 184, 0.2);
            --nav-border-scrolled: rgba(148, 163, 184, 0.3);
            --footer-bg: rgba(3, 7, 18, 0.9);
            --footer-border: rgba(148, 163, 184, 0.2);
        }
        .text-muted {
            color: var(--text-muted) !important;
        }
        a { color: var(--brand-cyan); }
        a:hover { color: #7dd3fc; }
        .landing-navbar {
            background: var(--nav-bg);
            backdrop-filter: blur(6px);
            border-bottom: 1px solid var(--nav-border);
            position: sticky;
            top: 0;
            z-index: 1200;
            transition: background .3s ease, border-color .3s ease, box-shadow .3s ease;
        }
        .landing-navbar.is-scrolled {
            background: var(--nav-bg-scrolled);
            border-bottom-color: var(--nav-border-scrolled);
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.18);
        }
        .navbar-brand {
            color: var(--text-primary) !important;
            letter-spacing: 0.18em;
        }
        .navbar-nav .nav-link {
            color: var(--text-secondary) !important;
            position: relative;
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 0.45rem 0.9rem !important;
            transition: color .25s ease, background-color .25s ease, transform .25s ease, padding .25s ease;
        }
        .navbar-nav .nav-link::after {
            content: "";
            position: absolute;
            left: 0.9rem;
            right: 0.9rem;
            bottom: 0.28rem;
            height: 2px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--brand-blue), var(--brand-cyan));
            transform: scaleX(0);
            transform-origin: center;
            transition: transform .25s ease;
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link:focus {
            color: var(--text-primary) !important;
            background-color: rgba(37, 99, 235, 0.08);
            transform: translateY(-1px);
        }
        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link:focus::after {
            transform: scaleX(1);
        }
        @media (min-width: 992px) {
            .navbar-nav .nav-link:hover,
            .navbar-nav .nav-link:focus {
                padding-left: 1.2rem !important;
                padding-right: 1.2rem !important;
            }
        }
        .btn-cta {
            background: linear-gradient(120deg, var(--brand-blue), var(--brand-blue-dark));
            border: none;
            color: #fff !important;
            box-shadow: 0 12px 30px rgba(30, 64, 175, 0.35);
        }
        .btn-cta:hover {
            background: linear-gradient(120deg, var(--brand-blue-dark), #1d4ed8);
        }
        .landing-theme-toggle {
            align-items: center;
            background: linear-gradient(180deg, #f9fbff 0%, #e9edf6 100%);
            border: 1px solid rgba(148, 163, 184, 0.45);
            border-radius: 999px;
            color: #111827 !important;
            display: inline-flex;
            height: 42px;
            justify-content: center;
            padding: 0 !important;
            box-shadow: 0 4px 10px rgba(15, 23, 42, 0.12), inset 0 1px 0 rgba(255, 255, 255, 0.9);
            transition: background-color .25s ease, color .25s ease, border-color .25s ease, box-shadow .25s ease;
            width: 42px;
        }
        .landing-theme-toggle::after {
            display: none !important;
        }
        .landing-theme-toggle:hover,
        .landing-theme-toggle:focus {
            background: linear-gradient(180deg, #ffffff 0%, #eef2f9 100%);
            border-color: rgba(125, 211, 252, 0.55);
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.2);
            color: #111827 !important;
            transform: none;
        }
        .landing-theme-toggle #icon-light,
        .landing-theme-toggle #icon-dark {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .landing-theme-toggle #icon-dark {
            display: none;
        }
        .landing-theme-toggle.active {
            background: linear-gradient(180deg, #1f2937 0%, #111827 100%);
            border-color: rgba(148, 163, 184, 0.3);
            box-shadow: 0 6px 14px rgba(2, 6, 23, 0.35), inset 0 1px 0 rgba(148, 163, 184, 0.2);
            color: #ffffff !important;
        }

        .landing-theme-toggle.active:hover,
        .landing-theme-toggle.active:focus {
            background: linear-gradient(180deg, #374151 0%, #1f2937 100%);
            color: #ffffff !important;
        }
        .landing-theme-toggle.active #icon-light {
            display: none;
        }
        .landing-theme-toggle.active #icon-dark {
            display: inline-flex;
        }
        .landing-theme-toggle svg {
            fill: currentColor;
            height: 18px;
            width: 18px;
        }
        .landing-nav-menu {
            column-gap: 0;
        }
        .landing-nav-item-main + .landing-nav-item-main {
            margin-inline-start: 0.1rem;
        }
        .landing-nav-item-main .nav-link {
            padding-left: 0.72rem !important;
            padding-right: 0.72rem !important;
        }
        .landing-nav-item-toggle {
            margin-inline-start: 0.3rem;
        }
        .landing-nav-item-login {
            margin-inline-start: 1.05rem;
        }
        @media (max-width: 991.98px) {
            .landing-nav-item-main + .landing-nav-item-main,
            .landing-nav-item-toggle,
            .landing-nav-item-login {
                margin-inline-start: 0;
            }
        }
        main.container {
            padding-top: 4rem;
            padding-bottom: 5rem;
        }
        footer {
            background: var(--footer-bg);
            border-top: 1px solid var(--footer-border);
            color: var(--text-muted);
        }
        .modal.fade .modal-dialog {
            transform: scale(0.7);
            opacity: 0;
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s ease;
        }
        .modal.show .modal-dialog {
            transform: scale(1);
            opacity: 1;
        }

        .modal-login .modal-content {
            background: var(--surface-2);
            border: 1px solid color-mix(in srgb, var(--text-secondary) 20%, transparent);
            border-radius: 16px;
            box-shadow: 0 20px 40px color-mix(in srgb, var(--brand-blue) 25%, transparent);
        }

        .modal-login .modal-header {
            padding: 1.5rem 2rem 1rem;
            border-bottom: 1px solid color-mix(in srgb, var(--text-secondary) 15%, transparent);
        }

        .modal-login .modal-header img {
            border-radius: 8px;
            margin-bottom: 0.5rem;
        }

        .modal-login .modal-title {
            color: var(--text-primary);
            font-weight: 700;
            font-size: 1.25rem;
            margin-top: 0.5rem;
        }

        .modal-login .btn-close {
            opacity: 0.7;
            transition: opacity 0.2s ease;
        }

        .modal-login .btn-close:hover {
            opacity: 1;
        }

        .modal-login .modal-body {
            padding: 2rem;
        }

        .modal-login .form-label {
            color: var(--text-secondary);
            font-weight: 600;
            margin-bottom: 0.6rem;
        }

        .modal-login .form-control {
            background: var(--surface-2);
            border-radius: 12px;
            border-color: color-mix(in srgb, var(--text-primary) 14%, transparent);
            background: var(--surface-3);
            color: var(--text-primary);
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .modal-login .form-control:focus {
            background: var(--surface-2);
            border-color: var(--brand-blue);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--brand-blue) 20%, transparent);
            color: var(--text-primary);
        }

        .modal-login .form-control::placeholder {
            color: var(--text-muted);
        }

        .modal-login .btn {
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .modal-login .btn-primary {
            background: var(--brand-blue);
            border-color: var(--brand-blue);
        }

        .modal-login .btn-primary:hover {
            background: color-mix(in srgb, var(--brand-blue) 90%, black);
            border-color: color-mix(in srgb, var(--brand-blue) 90%, black);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px color-mix(in srgb, var(--brand-blue) 35%, transparent);
        }

        .modal-login .alert {
            border-radius: 10px;
            border: none;
        }

        .show-pass {
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.2s ease;
        }

        .show-pass .hide {
            display: none;
        }

        .show-pass:hover {
            opacity: 1;
        }

        .modal-backdrop.show {
            backdrop-filter: blur(7px);
            background-color: rgba(15, 23, 42, 0.5);
        }
    </style>
    @stack('styles')
</head>
<body data-hero-variant="{{ $heroVariant }}">
<nav class="navbar landing-navbar navbar-expand-lg py-3">
    <div class="container">
        <a class="navbar-brand fw-semibold text-uppercase" href="{{ url('/') }}">SARPRAS PUSDATEKIN</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#landingNav" aria-controls="landingNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="landingNav">
            <ul class="navbar-nav ms-auto align-items-lg-center landing-nav-menu">
                <li class="nav-item landing-nav-item-main"><a class="nav-link" href="#fitur">Fitur</a></li>
                <li class="nav-item landing-nav-item-main"><a class="nav-link" href="{{ route('assets.loanable') }}">Data Barang</a></li>
                <li class="nav-item landing-nav-item-toggle">
                    <a class="nav-link bell dz-theme-mode landing-theme-toggle" id="landingThemeToggle" href="javascript:void(0);" aria-pressed="false" aria-label="Aktifkan mode gelap" title="Ganti mode">
                        <span id="icon-light" aria-hidden="true">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 4a1 1 0 0 1 1 1v1a1 1 0 1 1-2 0V5a1 1 0 0 1 1-1zm0 13a5 5 0 1 0 0-10 5 5 0 0 0 0 10zm8-6a1 1 0 0 1 0 2h-1a1 1 0 1 1 0-2h1zM6 12a1 1 0 0 1-1 1H4a1 1 0 1 1 0-2h1a1 1 0 0 1 1 1zm10.95-5.536a1 1 0 0 1 1.414 0l.707.707a1 1 0 0 1-1.414 1.414l-.707-.707a1 1 0 0 1 0-1.414zM5.93 17.364a1 1 0 0 1 1.414 0l.707.707A1 1 0 0 1 6.637 19.485l-.707-.707a1 1 0 0 1 0-1.414zm12.142 1.414a1 1 0 0 1-1.414 0l-.707-.707a1 1 0 0 1 1.414-1.414l.707.707a1 1 0 0 1 0 1.414zM7.344 8.586a1 1 0 1 1-1.414-1.414l.707-.707a1 1 0 1 1 1.414 1.414l-.707.707z"/>
                            </svg>
                        </span>
                        <span id="icon-dark" aria-hidden="true">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M14.53 3.54a1 1 0 0 1 .99 1.27A7.5 7.5 0 1 0 19.2 14.5a1 1 0 0 1 1.27.99A9.5 9.5 0 1 1 13.54 2.8a1 1 0 0 1 .99.74z"/>
                            </svg>
                        </span>
                    </a>
                </li>
                <li class="nav-item landing-nav-item-login"><button class="btn btn-cta px-4" type="button" data-login-trigger>Login</button></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container">
    @yield('content')
</main>

<footer class="text-center small py-4">
    &copy; {{ now()->year }} SARPRAS PUSDATEKIN &ndash; Sarana Prasarana BPIP.
</footer>

<div class="modal fade modal-login" id="loginModalFallback" tabindex="-1" aria-labelledby="loginModalFallbackLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content">
            <div class="modal-header border-0 position-relative text-center py-0" style="flex-direction: column;">
                <button type="button" class="btn-close position-absolute end-0 top-0" data-bs-dismiss="modal" aria-label="Close" style="margin: 1.5rem;"></button>
                <img src="{{ asset('evanto/assets/images/Logo Baju Pusdatin.png') }}" alt="SARPRAS" class="img-fluid" style="max-height:60px;" onerror="this.style.display='none'">
                <h5 class="modal-title" id="loginModalFallbackLabel">Masuk Dashboard</h5>
            </div>
            <form method="POST" action="{{ route('login') }}" class="sarpras-login-form">
                <div class="modal-body">
                    @csrf

                    @if (session('status'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Login Gagal!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="fallbackLogin" class="form-label"><strong>Email / Username</strong></label>
                        <input id="fallbackLogin" type="text" name="login" class="form-control dz-username" placeholder="Masukkan username atau email anda" required autocomplete="username" autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="fallbackPassword" class="form-label"><strong>Password</strong></label>
                        <div class="position-relative">
                            <input id="fallbackPassword" type="password" name="password" class="form-control dz-password" placeholder="Masukkan password anda" required autocomplete="current-password">
                            <span class="show-pass position-absolute top-50 end-0 me-2 translate-middle-y" style="cursor: pointer;">
                                <span class="show"><i class="fa fa-eye-slash"></i></span>
                                <span class="hide"><i class="fa fa-eye"></i></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="fallbackRemember">
                        <label class="form-check-label" for="fallbackRemember">Ingat preferensi saya</label>
                    </div>
                </div>
                <div class="px-4 pb-4 text-center">
                    <button type="submit" class="btn btn-primary w-100 btn-lg mb-2">Masuk Sekarang</button>
                    @if (Route::has('password.request'))
                        <button type="button" class="btn btn-link small" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#forgotPasswordModalFallback">Lupa password?</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade modal-login" id="forgotPasswordModalFallback" tabindex="-1" aria-labelledby="forgotPasswordModalFallbackLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content">
            <div class="modal-header border-0 position-relative text-center py-0" style="flex-direction: column;">
                <button type="button" class="btn-close position-absolute end-0 top-0" data-bs-dismiss="modal" aria-label="Close" style="margin: 1.5rem;"></button>
                <img src="{{ asset('evanto/assets/images/Logo Baju Pusdatin.png') }}" alt="SARPRAS" class="img-fluid" style="max-height:60px;" onerror="this.style.display='none'">
                <h5 class="modal-title" id="forgotPasswordModalFallbackLabel">Lupa Password</h5>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-4">Masukkan email untuk menerima tautan reset password.</p>

                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Terjadi Kesalahan!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group mb-4">
                        <label class="form-label"><strong>Email</strong></label>
                        <input id="fallbackEmail" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autofocus placeholder="Masukkan email anda">
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100 btn-lg mb-2">Kirim Tautan Reset</button>
                    <div class="text-center">
                        <button type="button" class="btn btn-link small" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModalFallback">Kembali ke login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function () {
        const THEME_KEY = 'sarpras-landing-theme';
        const themeToggle = document.getElementById('landingThemeToggle');

        const getCookie = (name) => {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) {
                return parts.pop().split(';').shift();
            }
            return null;
        };

        const setTheme = (theme) => {
            const isDark = theme === 'dark';
            document.body.classList.toggle('theme-dark', isDark);
            document.body.setAttribute('data-theme-version', isDark ? 'dark' : 'light');
            if (themeToggle) {
                themeToggle.setAttribute('aria-pressed', isDark ? 'true' : 'false');
                themeToggle.classList.toggle('active', isDark);
                themeToggle.setAttribute('aria-label', isDark ? 'Aktifkan mode terang' : 'Aktifkan mode gelap');
                themeToggle.setAttribute('title', isDark ? 'Mode terang' : 'Mode gelap');
            }
        };

        let initialTheme = 'light';
        try {
            initialTheme = localStorage.getItem(THEME_KEY) || null;
        } catch (e) {
            initialTheme = null;
        }
        if (!initialTheme) {
            const cookieTheme = getCookie('version');
            initialTheme = cookieTheme === 'dark' ? 'dark' : 'light';
        }
        setTheme(initialTheme);

        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                const nextTheme = document.body.classList.contains('theme-dark') ? 'light' : 'dark';
                setTheme(nextTheme);
                try {
                    localStorage.setItem(THEME_KEY, nextTheme);
                } catch (e) {
                    // ignore storage failures
                }
                document.cookie = `version=${nextTheme}; path=/`;
            });
        }

        const loginTrigger = document.querySelector('[data-login-trigger]');
        const fallbackLoginModalEl = document.getElementById('loginModalFallback');
        const fallbackModalInstance = (fallbackLoginModalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal)
            ? bootstrap.Modal.getOrCreateInstance(fallbackLoginModalEl)
            : null;

        if (loginTrigger) {
            loginTrigger.addEventListener('click', () => {
                const loginModal = document.getElementById('loginModal');
                if (loginModal && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    const modal = bootstrap.Modal.getOrCreateInstance(loginModal);
                    modal.show();
                    return;
                }
                if (fallbackModalInstance) {
                    fallbackModalInstance.show();
                }
            });
        }

        document.querySelectorAll('.show-pass').forEach((el) => {
            el.addEventListener('click', function () {
                const passwordInput = this.closest('.position-relative')?.querySelector('input');
                if (!passwordInput) {
                    return;
                }
                const show = this.querySelector('.show');
                const hide = this.querySelector('.hide');
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    if (show) show.style.display = 'none';
                    if (hide) hide.style.display = 'inline';
                } else {
                    passwordInput.type = 'password';
                    if (show) show.style.display = 'inline';
                    if (hide) hide.style.display = 'none';
                }
            });
        });

        const landingNav = document.querySelector('.landing-navbar');
        const handleScroll = () => {
            if (!landingNav) {
                return;
            }
            landingNav.classList.toggle('is-scrolled', window.scrollY > 12);
        };
        handleScroll();
        window.addEventListener('scroll', handleScroll, { passive: true });
    })();
</script>
@stack('scripts')
</body>
</html>
