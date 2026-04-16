@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="card p-5 shadow-lg">
                    <div class="text-center mb-3">
                        <a href="{{ route('root') }}" class="brand-logo" aria-label="SARPRAS">
                            <img src="{{ asset('evanto/assets/images/Logo Baju Pusdatin.png') }}" alt="logo" class="img-fluid" style="max-height:60px;" onerror="this.style.display='none'">
                            
                        </a>
                    </div>

                    <h5 class="text-center mb-4">Lupa Password</h5>

                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label"><strong>Email</strong></label>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autofocus placeholder="masukkan email anda">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Kirim Tautan Reset Password</button>
                        </div>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="{{ route('login') }}">Kembali ke Halaman Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
