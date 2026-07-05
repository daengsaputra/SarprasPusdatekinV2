@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6 col-lg-5 mx-auto">
                <div class="card p-4 shadow" style="max-width: 480px;">
                    <div class="text-center mb-3">
                        <a href="{{ route('root') }}" class="brand-logo" aria-label="SARPRAS">
                            <img src="{{ asset('evanto/assets/images/Logo Baju Pusdatin.png') }}" alt="logo" class="img-fluid" style="max-height:60px;" onerror="this.style.display='none'">
                        </a>
                    </div>

                    <h5 class="text-center mb-2">Selamat Datang</h5>
                    <p class="text-center text-muted small mb-4">
                        Sistem peminjaman sarpras BPIP. Silakan masuk menggunakan akun SSO BPIP Anda.
                    </p>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <a href="{{ route('sso.redirect') }}" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2">
                        <i class="fa fa-shield"></i>
                        <span>Masuk dengan SSO BPIP</span>
                    </a>

                    <p class="text-center text-muted small mt-3 mb-0">
                        Mengalami kendala? Hubungi administrator Pusdatin BPIP.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
