@extends('layouts.app')

@section('title', 'Barang Peminjaman')

@section('content')
<main class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header border-0 pb-0">
                        <h4 class="card-title">Barang Peminjaman</h4>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">Halaman ini sudah diarahkan ke daftar aset peminjaman.</p>
                        <a href="{{ route('assets.loanable') }}" class="btn btn-primary">Buka Daftar Barang Peminjaman</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
