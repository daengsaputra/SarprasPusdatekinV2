@php($contextKind = request('kind'))
@php($forcedKind = in_array($contextKind, [\App\Models\Asset::KIND_INVENTORY, \App\Models\Asset::KIND_LOANABLE], true) ? $contextKind : null)
@php($title = $forcedKind === \App\Models\Asset::KIND_LOANABLE ? 'Tambah Barang Peminjaman' : ($forcedKind === \App\Models\Asset::KIND_INVENTORY ? 'Tambah Aset Inventaris' : 'Tambah Aset'))
@php($cancelKind = $forcedKind ?? old('kind'))
@extends('layouts.app')

@php($categoryPresets = ['Laptop','HP','Tablet','Kamera','Drone','Proyektor','Audio','Perlengkapan Rapat','Server','Lainnya'])

@push('styles')
<style>
  .asset-form-shell {
    background: linear-gradient(180deg, rgba(99,102,241,0.06), rgba(15,23,42,0.02));
    border: 1px solid rgba(148,163,184,0.4);
    border-radius: 28px;
    padding: 2rem;
    box-shadow: 0 30px 60px rgba(15,23,42,0.12);
  }
  .asset-form-card {
    background: #fff;
    border-radius: 22px;
    border: 1px solid rgba(226,232,240,0.9);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 15px 35px rgba(15,23,42,0.07);
  }
  .asset-form-card h2 {
    font-size: 1rem;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: #64748b;
    margin-bottom: 1rem;
  }
  .asset-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(240px,1fr));
    gap: 1rem;
  }
  .form-label {
    font-weight: 600;
    letter-spacing: .05em;
    color: #0f172a;
  }
  .form-control,
  .form-select {
    border-radius: 14px;
    border-color: rgba(148,163,184,0.6);
    padding: 0.75rem 1rem;
  }
  .form-text {
    font-size: 0.8rem;
    color: #64748b;
  }
</style>
@endpush

@section('content')
<main class="content-body">
<div class="container-fluid">
<div class="d-flex justify-content-between align-items-start mb-4">
  <div>
    <p class="text-uppercase text-muted small mb-1" style="letter-spacing:0.25em;">Form Aset</p>
    <h1 class="h4 mb-0">{{ $title }}</h1>
  </div>
  <a href="{{ ($cancelKind === \App\Models\Asset::KIND_LOANABLE) ? route('assets.loanable') : route('assets.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>

<form method="POST" action="{{ route('assets.store') }}" class="asset-form-shell" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="kind" value="{{ old('kind', $forcedKind ?? \App\Models\Asset::KIND_INVENTORY) }}">
  <input type="hidden" name="quantity_total" value="1">

  <div class="asset-form-card">
    <h2>Identitas Sarpras</h2>
    <div class="asset-grid">
      <div>
        <label class="form-label">Kode</label>
        <input type="text" name="code" value="{{ old('code') }}" class="form-control @error('code') is-invalid @enderror" required>
        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div>
        <label class="form-label">Nama</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div>
        <label class="form-label">Kategori</label>
        <input type="text" name="category" list="asset-category-presets" value="{{ old('category') }}" class="form-control @error('category') is-invalid @enderror" placeholder="Pilih atau ketik kategori" required>
        <datalist id="asset-category-presets">
          @foreach($categoryPresets as $preset)
            <option value="{{ $preset }}"></option>
          @endforeach
        </datalist>
        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div>
        <label class="form-label">Status</label>
        <select name="status" class="form-select @error('status') is-invalid @enderror">
          <option value="active" {{ old('status','active')==='active'?'selected':'' }}>Aktif</option>
          <option value="inactive" {{ old('status')==='inactive'?'selected':'' }}>Nonaktif</option>
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
    </div>
    <div class="mt-3">
      <label class="form-label">Deskripsi / Catatan</label>
      <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Tuliskan kondisi, kelengkapan, atau catatan penting lainnya.">{{ old('description') }}</textarea>
      @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
  </div>

  <div class="asset-form-card">
    <h2>Bukti & Dokumentasi</h2>
    <div class="asset-grid">
      <div>
        <label class="form-label">Foto Sarpras</label>
        <input type="file" name="photo" id="photoInput" accept="image/*" class="form-control @error('photo') is-invalid @enderror" required>
        @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <input type="text" id="photoFileName" class="form-control mt-2" value="Belum ada file dipilih" readonly>
        <div class="form-text">Wajib. Format: {{ implode(', ', config('bpip.asset_photo_mimes', config('bpip.user_photo_mimes'))) }}. Maks {{ (int) config('bpip.asset_photo_max_kb', config('bpip.user_photo_max_kb')) }} KB.</div>
      </div>
      <div>
        <label class="form-label">Dokumen BAST</label>
        <input type="file" name="bast_document" id="bastDocumentInput" accept=".pdf,.doc,.docx" class="form-control @error('bast_document') is-invalid @enderror" required>
        @error('bast_document')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <input type="text" id="bastDocumentFileName" class="form-control mt-2" value="Belum ada file dipilih" readonly>
        <div class="form-text">Unggah berita acara serah terima (PDF/DOC, maks {{ (int) config('bpip.asset_bast_doc_max_kb', 5120) }} KB).</div>
      </div>
    </div>
  </div>

  @php($cancelRoute = ($cancelKind === \App\Models\Asset::KIND_LOANABLE) ? route('assets.loanable') : route('assets.index'))
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
    const bindFileName = (inputId, targetId, emptyText = 'Belum ada file dipilih') => {
      const input = document.getElementById(inputId);
      const target = document.getElementById(targetId);
      if (!input || !target) return;

      const update = () => {
        const fileName = input.files && input.files[0] ? input.files[0].name : '';
        target.value = fileName || emptyText;
      };

      input.addEventListener('change', update);
      update();
    };

    bindFileName('photoInput', 'photoFileName');
    bindFileName('bastDocumentInput', 'bastDocumentFileName');
  });
</script>
@endpush
