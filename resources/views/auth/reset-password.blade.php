@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="card p-5 shadow-lg">
                    <h4 class="text-center mb-4">Reset Password</h4>

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="form-group mb-3">
                            <label class="form-label"><strong>Email</strong></label>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email', $request->email) }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label"><strong>Password</strong></label>
                            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label"><strong>Confirm Password</strong></label>
                            <input id="password_confirmation" type="password" class="form-control form-control-lg"
                                   name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
