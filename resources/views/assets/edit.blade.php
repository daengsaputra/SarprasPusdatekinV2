@php($title = 'Edit Aset')
@php($categoryPresets = ['Laptop','HP','Tablet','Kamera','Drone','Proyektor','Audio','Perlengkapan Rapat','Server','Lainnya'])
@php($photoFileName = old('photo_file_name', $asset->photo ? basename($asset->photo) : 'Belum ada file dipilih'))
@php($bastDocumentFileName = old('bast_document_file_name', $asset->bast_document_path ? basename($asset->bast_document_path) : 'Belum ada file dipilih'))
@extends('layouts.app')

@push('styles')
<style>
  .asset-form-shell {
    background: linear-gradient(180deg, rgba(59,130,246,0.08), rgba(15,23,42,0.02));
    border: 1px solid rgba(148,163,184,0.35);
    border-radius: 28px;
    padding: 2rem;
    box-shadow: 0 30px 55px rgba(15,23,42,0.12);
  }
  .asset-form-card {
    background: #fff;
    border-radius: 22px;
    border: 1px solid rgba(226,232,240,0.9);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 18px 38px rgba(15,23,42,0.08);
  }
  .asset-form-card h2 {
    font-size: 1rem;
    letter-spacing: .18em;
    text-transform: uppercase;
    color: #475569;
    margin-bottom: 1rem;
  }
  .asset-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(240px,1fr));
    gap: 1rem;
  }
  .form-label { font-weight: 600; letter-spacing:.05em; }
  .form-control,
  .form-select {
    border-radius: 14px;
    border-color: rgba(148,163,184,0.6);
    padding: 0.75rem 1rem;
  }
</style>
@endpush

@section('content')
<main class="content-body">
<div class="container-fluid">
<div class="d-flex justify-content-between align-items-start mb-4">
  <div>
    <p class="text-uppercase text-muted small mb-1" style="letter-spacing:0.25em;">Perbarui Aset</p>
    <h1 class="h4 mb-0">{{ $asset->name }}</h1>
  </div>
  <a href="{{ $asset->kind === \App\Models\Asset::KIND_LOANABLE ? route('assets.loanable') : route('assets.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>

<form method="POST" action="{{ route('assets.update', $asset) }}" class="asset-form-shell" enctype="multipart/form-data">
  @csrf
  @method('PUT')
  <input type="hidden" name="kind" value="{{ old('kind', $asset->kind) }}">
  <input type="hidden" name="quantity_total" value="{{ old('quantity_total', $asset->quantity_total) }}">

  <div class="asset-form-card">
    <h2>Identitas Sarpras</h2>
    <div class="asset-grid">
      <div>
        <label class="form-label">Kode</label>
        <input type="text" name="code" value="{{ old('code', $asset->code) }}" class="form-control @error('code') is-invalid @enderror" required>
        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div>
        <label class="form-label">Nama</label>
        <input type="text" name="name" value="{{ old('name', $asset->name) }}" class="form-control @error('name') is-invalid @enderror" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div>
        <label class="form-label">Kategori</label>
        <input type="text" name="category" list="asset-category-presets" value="{{ old('category', $asset->category) }}" class="form-control @error('category') is-invalid @enderror" required>
        <datalist id="asset-category-presets">
          @foreach($categoryPresets as $preset)
            <option value="{{ $preset }}">{{ $preset }}</option>
          @endforeach
        </datalist>
        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div>
        <label class="form-label">Status</label>
        <select name="status" class="form-select @error('status') is-invalid @enderror">
          <option value="active" {{ old('status', $asset->status)==='active'?'selected':'' }}>Aktif</option>
          <option value="inactive" {{ old('status', $asset->status)==='inactive'?'selected':'' }}>Nonaktif</option>
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
    </div>
    <div class="mt-3">
      <label class="form-label">Deskripsi / Catatan</label>
      <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $asset->description) }}</textarea>
      @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
  </div>

  <div class="asset-form-card">
    <h2>Bukti & Dokumentasi</h2>
    <div class="asset-grid">
      <div>
        <label class="form-label">Foto Sarpras</label>
        <input type="file" name="photo" id="photoInput" accept="image/*" class="form-control @error('photo') is-invalid @enderror" {{ $asset->photo ? '' : 'required' }}>
        @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <input type="text" id="photoFileName" class="form-control mt-2" value="{{ $photoFileName }}" readonly>
        <div class="form-text">Format: {{ implode(', ', config('bpip.asset_photo_mimes', config('bpip.user_photo_mimes'))) }}. Maks {{ (int) config('bpip.asset_photo_max_kb', config('bpip.user_photo_max_kb')) }} KB.</div>
        @if($asset->photo_url)
          <img src="{{ $asset->photo_url }}" alt="Foto aset" class="mt-2 rounded-3 border" style="width:120px;height:120px;object-fit:cover;">
        @endif
      </div>
      <div>
        <label class="form-label">Dokumen BAST</label>
        <input type="file" name="bast_document" id="bastDocumentInput" accept=".pdf,.doc,.docx" class="form-control @error('bast_document') is-invalid @enderror" {{ $asset->bast_document_path ? '' : 'required' }}>
        @error('bast_document')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <input type="text" id="bastDocumentFileName" class="form-control mt-2" value="{{ $bastDocumentFileName }}" readonly>
        <div class="form-text">Berita acara serah terima (maks {{ (int) config('bpip.asset_bast_doc_max_kb', 5120) }} KB).</div>
        @if($asset->bast_document_path)
          <div class="mt-2 d-flex align-items-center gap-3 flex-wrap">
            <a class="btn btn-sm btn-outline-primary" target="_blank" rel="noopener" href="{{ asset('storage/'.$asset->bast_document_path) }}">Lihat dokumen</a>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" id="removeBastDoc" name="remove_bast_document">
              <label class="form-check-label" for="removeBastDoc">Hapus & ganti</label>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>

  @php($cancelRoute = $asset->kind === \App\Models\Asset::KIND_LOANABLE ? route('assets.loanable') : route('assets.index'))
  <div class="d-flex gap-2">
    <button class="btn btn-primary px-4" type="submit">Simpan</button>
    <a href="{{ $cancelRoute }}" class="btn btn-light border">Batal</a>
  </div>
</form>
</div>
</main>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const bindFileName = (inputId, targetId, fallbackValue = 'Belum ada file dipilih') => {
      const input = document.getElementById(inputId);
      const target = document.getElementById(targetId);
      if (!input || !target) return;

      const currentValue = (target.value || '').trim();
      const defaultValue = currentValue !== '' ? currentValue : fallbackValue;

      const update = () => {
        const fileName = input.files && input.files[0] ? input.files[0].name : '';
        target.value = fileName || defaultValue;
      };

      input.addEventListener('change', update);
      update();
    };

    bindFileName('photoInput', 'photoFileName');
    bindFileName('bastDocumentInput', 'bastDocumentFileName');
  });
</script>
@endpush
