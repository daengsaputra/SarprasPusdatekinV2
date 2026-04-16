@php($contextKind = request('kind'))
@php($forcedKind = in_array($contextKind, [\App\Models\Asset::KIND_INVENTORY, \App\Models\Asset::KIND_LOANABLE], true) ? $contextKind : null)
@php($title = $forcedKind === \App\Models\Asset::KIND_LOANABLE ? 'Import Barang Peminjaman' : ($forcedKind === \App\Models\Asset::KIND_INVENTORY ? 'Import Aset Inventaris' : 'Import Aset'))
@php($backRoute = $forcedKind === \App\Models\Asset::KIND_LOANABLE ? route('assets.loanable') : route('assets.index'))
@extends('layouts.app')

@section('content')
<main class="content-body">
  <div class="container-fluid">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
      <h1 class="h4 mb-0">{{ $title }} dari Excel</h1>
      <a class="btn btn-outline-secondary" href="{{ $backRoute }}">Kembali</a>
    </div>

    <div class="row g-3">
      <div class="col-lg-7">
        <div class="card">
          <div class="card-body">
            <div class="alert alert-info d-flex flex-wrap align-items-center gap-2 mb-3">
              <span class="me-1">Gunakan template agar kolom sesuai.</span>
              <a class="btn btn-sm btn-outline-primary" href="{{ route('assets.template') }}">Download Template</a>
              @if($forcedKind)
                <span class="badge rounded-pill text-bg-secondary">{{ $forcedKind === \App\Models\Asset::KIND_LOANABLE ? 'Khusus barang peminjaman' : 'Khusus aset inventaris' }}</span>
              @endif
            </div>

            <form method="POST" action="{{ route('assets.import') }}" enctype="multipart/form-data" class="row g-3">
              @csrf
              @if($forcedKind)
                <input type="hidden" name="kind" value="{{ $forcedKind }}">
              @endif
              <div class="col-12">
                <label for="import_file" class="form-label">File Excel (.xlsx/.csv)</label>
                <input id="import_file" type="file" name="file" class="form-control @error('file') is-invalid @enderror" required>
                @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="col-12 d-flex flex-wrap gap-2">
                <button class="btn btn-success" type="submit">Import</button>
                <a class="btn btn-secondary" href="{{ $backRoute }}">Batal</a>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="card">
          <div class="card-body">
            <h6 class="mb-3">Catatan Import</h6>
            <ul class="mb-0 ps-3">
              <li>Kolom yang didukung: <code>code, name, category, description, quantity_total, status, kind, foto_sarpras, dokument_bast</code>.</li>
              <li>Kolom <code>foto_sarpras</code> dan <code>dokument_bast</code> diisi nama/path file (contoh: <code>assets/cam-01.jpg</code>, <code>assets/bast/cam-01.pdf</code>).</li>
              <li>Status gunakan <code>active</code> atau <code>inactive</code> (boleh juga "aktif"/"nonaktif").</li>
              <li>Jika kolom <code>kind</code> dikosongkan, data akan dianggap {{ $forcedKind === \App\Models\Asset::KIND_INVENTORY ? 'aset inventaris' : 'barang peminjaman' }}{{ $forcedKind ? '' : ' secara default (loanable)' }}.</li>
              <li>Jika <code>code</code> sudah ada: data akan diupdate, stok tersedia disesuaikan otomatis dengan pinjaman yang sedang berjalan.</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
