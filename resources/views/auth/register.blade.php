@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="card p-5 shadow-lg">
                    <h4 class="text-center mb-4">Create Account</h4>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label class="form-label"><strong>Name</strong></label>
                            <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label"><strong>Email</strong></label>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label"><strong>Password</strong></label>
                            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                                   name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label"><strong>Confirm Password</strong></label>
                            <input id="password-confirm" type="password" class="form-control form-control-lg"
                                   name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">Register</button>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="{{ route('login') }}">Already have account? Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
