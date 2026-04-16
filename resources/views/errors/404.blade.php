@extends('layouts.app')
@php($title = 'Halaman Tidak Ditemukan')
@section('content')
<div class="text-center py-5">
  <h1 class="display-6">404 — Halaman tidak ditemukan</h1>
  <p class="lead text-muted">Maaf, halaman yang Anda cari tidak tersedia.</p>
  <a class="btn btn-primary" href="{{ route('dashboard') }}">Ke Dashboard</a>
</div>
@endsection

