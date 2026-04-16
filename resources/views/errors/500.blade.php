@extends('layouts.app')
@php($title = 'Terjadi Kesalahan')
@section('content')
<div class="text-center py-5">
  <h1 class="display-6">Terjadi Kesalahan Internal (500)</h1>
  <p class="lead text-muted">Maaf, terjadi kendala pada server. Silakan coba beberapa saat lagi.</p>
  <a class="btn btn-primary" href="{{ url()->previous() }}">Kembali</a>
  <a class="btn btn-outline-secondary" href="{{ route('dashboard') }}">Ke Dashboard</a>
</div>
@endsection

