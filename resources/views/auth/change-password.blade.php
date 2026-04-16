@php($title = 'Ganti Password')
@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6 col-lg-5">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h1 class="h4 mb-3">Ganti Password</h1>
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form method="POST" action="{{ route('password.change.post') }}" class="row gy-3">
          @csrf
          <div class="col-12">
            <label class="form-label">Password Saat Ini</label>
            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-12">
            <label class="form-label">Password Baru</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-12">
            <label class="form-label">Ulangi Password Baru</label>
            <input type="password" name="password_confirmation" class="form-control" required>
          </div>
          <div class="col-12 d-grid">
            <button class="btn btn-primary" type="submit">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

