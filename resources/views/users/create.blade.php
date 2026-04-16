@php($title = 'Tambah Anggota')
@extends('layouts.app')

@section('content')
<main class="content-body">
<div class="container-fluid">
<div class="row justify-content-center">
  <div class="col-md-7 col-lg-6">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h1 class="h5 mb-3">Tambah Anggota</h1>
        <form method="POST" action="{{ route('users.store') }}" class="row gy-3" enctype="multipart/form-data">
          @csrf
          <div class="col-12">
            <label class="form-label">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-12">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label">Role</label>
            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
              <option value="{{ \App\Models\User::ROLE_PEMINJAM }}" {{ old('role', \App\Models\User::ROLE_PEMINJAM)===\App\Models\User::ROLE_PEMINJAM ? 'selected' : '' }}>{{ \App\Models\User::ROLE_LABELS[\App\Models\User::ROLE_PEMINJAM] }}</option>
              <option value="{{ \App\Models\User::ROLE_PETUGAS }}" {{ old('role')===\App\Models\User::ROLE_PETUGAS ? 'selected' : '' }}>{{ \App\Models\User::ROLE_LABELS[\App\Models\User::ROLE_PETUGAS] }}</option>
              <option value="{{ \App\Models\User::ROLE_SUPER_ADMIN }}" {{ old('role')===\App\Models\User::ROLE_SUPER_ADMIN ? 'selected' : '' }}>{{ \App\Models\User::ROLE_LABELS[\App\Models\User::ROLE_SUPER_ADMIN] }}</option>
            </select>
            @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-12 col-md-6"></div>
          <div class="col-12">
            <label class="form-label">Foto (opsional)</label>
            <input type="file" name="photo" accept="image/*" class="form-control @error('photo') is-invalid @enderror">
            @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
          </div>
          <div class="col-12 d-flex gap-2 mt-2">
            <button class="btn btn-primary" type="submit">Simpan</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
</main>
@endsection
