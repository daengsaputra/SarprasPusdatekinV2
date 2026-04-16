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

                    <h5 class="text-center mb-4">Silahkan Login</h5>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

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

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label class="form-label"><strong>Email / Username</strong></label>
                            <input id="login" type="text" class="form-control dz-username @error('login') is-invalid @enderror"
                                   name="login" value="{{ old('login') }}" required autofocus placeholder="Masukkan username atau email anda">
                            @error('login')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label"><strong>Password</strong></label>
                            <div class="position-relative">
                                <input id="password" type="password" autocomplete="current-password"
                                       class="form-control dz-password @error('password') is-invalid @enderror"
                                       name="password" required placeholder="Masukkan password anda">
                                <span class="show-pass position-absolute top-50 end-0 me-2 translate-middle">
                                    <span class="show"><i class="fa fa-eye-slash"></i></span>
                                    <span class="hide"><i class="fa fa-eye"></i></span>
                                </span>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row d-flex justify-content-between mt-4 mb-2 flex-wrap">
                            <div class="form-group mb-3">
                                <div class="custom-control custom-checkbox ms-1">
                                    <input type="checkbox" class="form-check-input" name="remember" id="basic_checkbox_1" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="basic_checkbox_1">Ingat preferensi saya</label>
                                </div>
                            </div>
                            @if (Route::has('password.request'))
                                <div class="form-group">
                                    <a href="{{ route('password.request') }}">Lupa Password?</a>
                                </div>
                            @endif
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-100">Masuk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
