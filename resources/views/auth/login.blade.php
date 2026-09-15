@extends('layouts.auth')

@section('title', 'Masuk Dashboard')

@push('styles')
<style>
    :root { --login-navy:#111b35; --login-muted:#6f7f9d; --login-blue:#2463eb; --login-line:#e5eaf2; }
    body {
        min-height:100vh; margin:0; color:var(--login-navy);
        background:radial-gradient(circle at 50% 0%,rgba(52,96,196,.2),transparent 42%),#0d1934;
        font-family:Inter,"Segoe UI",Arial,sans-serif;
    }
    .sso-login-page,.sso-login-page * { box-sizing:border-box; }
    .sso-login-page { min-height:100vh; display:grid; place-items:center; padding:24px 16px; }
    .sso-login-card {
        position:relative; width:min(100%,486px); overflow:hidden; background:#fff;
        border:1px solid rgba(212,220,234,.9); border-radius:26px;
        box-shadow:0 24px 70px rgba(3,12,35,.3);
    }
    .sso-login-card::before {
        position:absolute; inset:0 0 auto; height:5px; content:"";
        background:linear-gradient(90deg,#2274ed 0%,#4a4ef1 52%,#e53035 100%);
    }
    .sso-login-main { padding:43px 39px 34px; }
    .sso-login-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:31px; }
    .sso-brand { display:flex; align-items:center; gap:12px; }
    .sso-brand-mark {
        position:relative; display:grid; flex:0 0 47px; width:47px; height:47px; place-items:center;
        color:#1670ef; background:#eff6ff; border:1px solid #dceaff; border-radius:16px;
        box-shadow:0 4px 10px rgba(35,99,235,.08);
    }
    .sso-brand-mark::after {
        position:absolute; top:-2px; right:-2px; width:8px; height:8px; content:"";
        background:#f04f55; border:2px solid #fff; border-radius:50%;
    }
    .sso-brand-name-row { display:flex; align-items:center; gap:7px; line-height:1; }
    .sso-brand-name { color:#111a30; font-size:22px; font-weight:750; letter-spacing:-.6px; }
    .sso-brand-name .brand-prefix { color:#334155; font-weight:680; }
    .sso-brand-name .brand-primary { color:#1f5fe0; font-weight:780; }
    .sso-brand-badge {
        padding:5px 7px 4px; color:#346ee8; background:#eaf1ff; border-radius:6px;
        font-size:9px; font-weight:800; letter-spacing:.7px;
    }
    .sso-brand-subtitle { display:block; margin-top:5px; color:#96a3ba; font-size:11px; line-height:1; }
    .sso-close {
        display:grid; width:32px; height:32px; place-items:center; color:#8e9ab1;
        border-radius:50%; transition:background-color .2s ease,color .2s ease;
    }
    .sso-close:hover,.sso-close:focus-visible { color:var(--login-navy); background:#f2f5fa; }
    .sso-login-title {
        margin:0 0 9px; color:var(--login-navy); font-size:clamp(28px,6vw,31px);
        font-weight:750; letter-spacing:-1.2px; line-height:1.2;
    }
    .sso-login-description { margin:0; color:var(--login-muted); font-size:15px; line-height:1.55; }
    .sso-login-description strong { color:#3d4a62; font-weight:700; }
    .sso-security {
        display:flex; align-items:center; gap:12px; margin:29px 0 25px; padding:13px 14px;
        background:#f8fafc; border:1px solid var(--login-line); border-radius:13px;
    }
    .sso-security-icon {
        display:grid; flex:0 0 32px; width:32px; height:32px; place-items:center;
        color:#2563eb; background:#e8f0ff; border-radius:9px;
    }
    .sso-security-title { display:block; margin-bottom:2px; color:#263149; font-size:11px; font-weight:700; line-height:1.25; }
    .sso-security-text { display:block; color:#8491a7; font-size:9.5px; line-height:1.3; }
    .sso-alert { margin:0 0 14px; padding:11px 13px; border:1px solid transparent; border-radius:11px; font-size:12px; }
    .sso-alert-success { color:#17613a; background:#ecfdf3; border-color:#bbf0ce; }
    .sso-alert-error { color:#a52a31; background:#fff1f2; border-color:#fecdd3; }
    .sso-login-button {
        position:relative; display:flex; width:100%; min-height:52px; align-items:center; padding:0 54px;
        overflow:hidden; color:#fff; background:linear-gradient(104deg,#2463eb 0%,#2463eb 62%,#3876ee 62%,#2463eb 100%);
        border-radius:13px; box-shadow:0 9px 18px rgba(36,99,235,.22); font-size:15px;
        font-weight:700; text-decoration:none; transition:transform .2s ease,box-shadow .2s ease;
    }
    .sso-login-button:hover,.sso-login-button:focus-visible {
        color:#fff; box-shadow:0 12px 25px rgba(36,99,235,.32); transform:translateY(-1px);
    }
    .sso-login-button .key-icon { position:absolute; left:24px; }
    .sso-login-button .arrow-icon { position:absolute; right:24px; }
    .sso-local-button {
        display:flex; min-height:42px; align-items:center; justify-content:center; margin-top:10px;
        color:#53637d; background:#fff; border:1px solid #dce3ed; border-radius:11px;
        font-size:12px; font-weight:650; text-decoration:none;
    }
    .sso-local-button:hover { color:var(--login-blue); background:#f8faff; border-color:#b9caee; }
    .sso-login-links { display:flex; align-items:center; justify-content:space-between; gap:15px; margin-top:21px; font-size:11px; }
    .sso-help-link,.sso-guide-link { display:inline-flex; align-items:center; gap:6px; text-decoration:none; }
    .sso-help-link { color:#2463eb; }
    .sso-guide-link { color:#95a1b6; }
    .sso-help-link:hover,.sso-guide-link:hover { color:#174ec2; }
    .sso-login-footer {
        display:flex; align-items:center; justify-content:space-between; gap:18px; padding:18px 31px;
        color:#93a0b5; background:#f8fafc; border-top:1px solid #edf0f5; font-size:9.5px;
    }
    .sso-secure-status { display:inline-flex; align-items:center; gap:8px; }
    .sso-secure-dot { width:6px; height:6px; background:#2cc985; border-radius:50%; }
    @media (max-width:520px) {
        .sso-login-page { align-items:start; padding:10px; }
        .sso-login-card { border-radius:22px; }
        .sso-login-main { padding:36px 25px 29px; }
        .sso-login-header { margin-bottom:27px; }
        .sso-brand-mark { flex-basis:44px; width:44px; height:44px; }
        .sso-brand-name { font-size:20px; }
        .sso-login-links { align-items:flex-start; flex-direction:column; }
        .sso-login-footer { padding:17px 24px; }
    }
</style>
@endpush

@section('content')
<main class="sso-login-page">
    <section class="sso-login-card" aria-labelledby="login-title">
        <div class="sso-login-main">
            <header class="sso-login-header">
                <div class="sso-brand" aria-label="Pusdatin BPIP">
                    <span class="sso-brand-mark" aria-hidden="true">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none">
                            <path d="M4.3 9.4a11.1 11.1 0 0 1 15.4 0M7 12.2a7.2 7.2 0 0 1 10 0M9.8 15a3.2 3.2 0 0 1 4.4 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            <circle cx="12" cy="18" r="1.35" fill="currentColor"/>
                        </svg>
                    </span>
                    <span>
                        <span class="sso-brand-name-row">
                            <span class="sso-brand-name"><span class="brand-prefix">sarpras</span> <span class="brand-primary">pusdatekin</span></span>
                            <span class="sso-brand-badge">BPIP</span>
                        </span>
                        <span class="sso-brand-subtitle">Pusat Data dan Informasi</span>
                    </span>
                </div>
                <a href="{{ route('root') }}" class="sso-close" aria-label="Tutup halaman login">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="m7 7 10 10M17 7 7 17" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    </svg>
                </a>
            </header>

            <h1 id="login-title" class="sso-login-title">Masuk Dashboard</h1>
            <p class="sso-login-description">
                Silakan masuk menggunakan akun <strong>SSO BPIP Anda</strong> untuk mengakses ekosistem layanan data terpadu dan analitik.
            </p>

            <div class="sso-security">
                <span class="sso-security-icon" aria-hidden="true">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                        <path d="M12 3.4 19 6v5.1c0 4.5-2.9 7.8-7 9.5-4.1-1.7-7-5-7-9.5V6l7-2.6Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                        <path d="m9.3 11.8 1.8 1.8 3.7-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <span>
                    <span class="sso-security-title">Satu Akun Untuk Seluruh Layanan</span>
                    <span class="sso-security-text">Otentikasi tunggal terpusat sesuai standar keamanan BPIP RI.</span>
                </span>
            </div>

            @if (session('success'))
                <div class="sso-alert sso-alert-success" role="status">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="sso-alert sso-alert-error" role="alert">{{ session('error') }}</div>
            @endif

            <a href="{{ route('sso.redirect') }}" class="sso-login-button">
                <svg class="key-icon" width="19" height="19" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M14.7 9.3a5 5 0 1 0-6 6L4 20v-3h3v-3h2.2a5 5 0 0 0 5.5-4.7Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="15.5" cy="8.5" r="1" fill="currentColor"/>
                </svg>
                <span>Masuk dengan SSO BPIP</span>
                <svg class="arrow-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="m9 5 7 7-7 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>

            @if (app()->environment('local') && !config('sso.enabled'))
                <a href="{{ route('local.login') }}" class="sso-local-button">Masuk ke Dashboard Lokal</a>
            @endif

            <nav class="sso-login-links" aria-label="Bantuan login">
                <a href="mailto:{{ config('mail.from.address') }}" class="sso-help-link">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/>
                        <path d="M9.8 9.3a2.4 2.4 0 0 1 4.6 1c0 1.8-2.4 2-2.4 3.5M12 17.1h.01" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    </svg>
                    Butuh bantuan login SSO?
                </a>
                <a href="{{ route('root') }}" class="sso-guide-link">Panduan Penggunaan</a>
            </nav>
        </div>

        <footer class="sso-login-footer">
            <span class="sso-secure-status"><span class="sso-secure-dot" aria-hidden="true"></span>Koneksi Aman Terenkripsi (TLS)</span>
            <span>v2.4.0&ndash;{{ ucfirst(app()->environment()) }}</span>
        </footer>
    </section>
</main>
@endsection
