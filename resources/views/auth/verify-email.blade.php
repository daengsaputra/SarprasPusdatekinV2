@extends('layouts.auth')

@section('title', 'Verify Email')

@section('content')
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-7">
                <div class="card p-5 shadow-lg">
                    <h4 class="text-center mb-3">Verify Your Email Address</h4>
                    <p class="text-muted text-center mb-4">Please check your inbox and click the verification link.</p>

                    @if (session('status') == 'verification-link-sent' || session('resent'))
                        <div class="alert alert-success">
                            A fresh verification link has been sent to your email address.
                        </div>
                    @endif

                    @if (Route::has('verification.send'))
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">Resend Verification Email</button>
                        </form>
                    @elseif (Route::has('verification.resend'))
                        <form method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">Resend Verification Email</button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary w-100">Log Out</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
