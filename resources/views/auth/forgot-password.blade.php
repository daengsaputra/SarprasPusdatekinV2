@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-5 col-lg-4 mx-auto">
                <div class="card p-4 shadow" style="max-width: 400px;">
                    <div class="text-center mb-3">
                        <a href="{{ route('root') }}" class="brand-logo" aria-label="SARPRAS">
                            <img src="{{ asset('evanto/assets/images/Logo Baju Pusdatin.png') }}" alt="logo" class="img-fluid" style="max-height:60px;" onerror="this.style.display='none'">
                        </a>
                    </div>
                    <h5 class="text-center mb-4">Lupa Password</h5>
                    <p class="text-center text-muted mb-4">Masukkan email untuk menerima tautan reset password.</p>

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
                        <div class="form-group mb-3">
                            <label class="form-label"><strong>Email</strong></label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="{{ route('login') }}">Back to login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
