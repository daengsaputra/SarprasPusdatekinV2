@extends('layouts.auth')

@section('title', 'Verify Email')

@section('content')
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-7">
                <div class="card p-5 shadow-lg">
                    <h4 class="text-center mb-3">Verify Your Email Address</h4>
                    <p class="text-muted text-center mb-4">Before proceeding, please check your email for a verification link.</p>

                    @if (session('resent'))
                        <div class="alert alert-success">A fresh verification link has been sent to your email address.</div>
                    @endif

                    @if (Route::has('verification.resend'))
                        <form method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">Request Another Link</button>
                        </form>
                    @elseif (Route::has('verification.send'))
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">Request Another Link</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
