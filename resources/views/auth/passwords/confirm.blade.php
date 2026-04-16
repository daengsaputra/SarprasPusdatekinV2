@extends('layouts.auth')

@section('title', 'Confirm Password')

@section('content')
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="card p-5 shadow-lg">
                    <h4 class="text-center mb-4">Confirm Password</h4>
                    <p class="text-center text-muted mb-4">Please confirm your password before continuing.</p>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label"><strong>Password</strong></label>
                            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">Confirm Password</button>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="btn btn-link w-100 mt-2">Forgot Your Password?</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
