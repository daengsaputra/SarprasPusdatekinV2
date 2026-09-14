@php($context = $context ?? 'inventory')
@php($isLoanable = $context === 'loanable')
@php($title = $isLoanable ? 'Data Barang Peminjaman Peralatan' : 'Data Barang Aset')
@php($listRoute = $isLoanable ? 'assets.loanable' : 'assets.index')
@php($exportParams = request()->except('page'))
@php($exportParams = $isLoanable ? array_merge($exportParams, ['kind' => \App\Models\Asset::KIND_LOANABLE]) : $exportParams)
@php($exportUrl = route('assets.export', $exportParams))
@php($importUrl = $isLoanable ? route('assets.import.form', ['kind' => \App\Models\Asset::KIND_LOANABLE]) : route('assets.import.form'))
@php($createUrl = $isLoanable ? route('assets.create', ['kind' => \App\Models\Asset::KIND_LOANABLE]) : route('assets.create'))
@php($isAuthenticated = auth()->check())
@extends($isAuthenticated ? 'layouts.app' : 'layouts.landing')

@push('styles')
<style>
  body[data-theme="light"] { background: #eef2ff; }
  .asset-shell { display:flex; flex-direction:column; gap:1.5rem; padding-bottom:3rem; min-width:0; }
  .asset-hero { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.9rem; padding:1.35rem 1.6rem; border-radius:24px; background:linear-gradient(120deg, rgba(59,130,246,0.12), #ffffff 70%); border:1px solid rgba(148,163,184,0.1); box-shadow:0 12px 35px rgba(15,23,42,0.08); }
  .asset-hero__title { font-size:clamp(1.15rem,2.2vw,1.65rem); font-weight:700; color:#0f172a; margin-bottom:0.2rem; }
  .asset-hero__subtitle { color:#475569; font-size:0.9rem; }
  .asset-hero__cta { display:flex; align-items:center; gap:0.75rem; flex-wrap:wrap; margin-top:0.85rem; }
  .asset-hero__cta small { color:#64748b; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; }
  .asset-hero__stats { display:flex; flex-wrap:wrap; gap:0.75rem; }
  .asset-summary-card { background:#fff; border-radius:18px; border:1px solid rgba(148,163,184,0.16); box-shadow:0 14px 32px rgba(15,23,42,0.08); padding:0.9rem 1.2rem; min-width:160px; }
  .asset-summary-label { text-transform:uppercase; letter-spacing:0.13em; font-size:0.76rem; color:#94a3b8; }
  .asset-summary-value { font-size:1.5rem; font-weight:700; color:#0f172a; }
  .asset-add-btn {
    background: #0ea5e9;
    border-color: #0ea5e9;
    color: #fff;
    border-radius: 12px;
  }
  .asset-add-btn:hover,
  .asset-add-btn:focus {
    background: #0284c7;
    border-color: #0284c7;
    color: #fff;
  }
  .asset-filter-card { background:#fff; border-radius:20px; border:1px solid rgba(148,163,184,0.16); padding:1.15rem; box-shadow:0 12px 28px rgba(15,23,42,0.08); min-width:0; }
  .asset-filter-form {
    display:grid;
    grid-template-columns:minmax(180px,1.35fr) repeat(3,minmax(130px,1fr));
    gap:0.9rem;
    align-items:end;
    min-width:0;
  }
  .asset-filter-actions {
    grid-column: 1 / -1;
    display:flex;
    gap:0.55rem;
  }
  body[data-theme="dark"] .asset-filter-card,
  body[data-theme-version="dark"] .asset-filter-card,
  body.theme-dark .asset-filter-card { background:#111827; border-color:rgba(148,163,184,0.24); }
  body[data-theme="dark"] .asset-filter-card .form-label,
  body[data-theme-version="dark"] .asset-filter-card .form-label,
  body.theme-dark .asset-filter-card .form-label,
  body[data-theme="dark"] .asset-filter-card .form-check-label,
  body[data-theme-version="dark"] .asset-filter-card .form-check-label,
  body.theme-dark .asset-filter-card .form-check-label {
    color: #e5e7eb;
  }
  body[data-theme="dark"] .asset-filter-card .form-control,
  body[data-theme-version="dark"] .asset-filter-card .form-control,
  body.theme-dark .asset-filter-card .form-control,
  body[data-theme="dark"] .asset-filter-card .form-select,
  body[data-theme-version="dark"] .asset-filter-card .form-select,
  body.theme-dark .asset-filter-card .form-select {
    background: #0b1220;
    border-color: rgba(148,163,184,0.35);
    color: #f8fafc;
    font-size: 0.96rem;
  }
  body[data-theme="dark"] .asset-filter-card .form-control::placeholder,
  body[data-theme-version="dark"] .asset-filter-card .form-control::placeholder,
  body.theme-dark .asset-filter-card .form-control::placeholder {
    color: #94a3b8;
  }
  body[data-theme="dark"] .asset-filter-card .form-control:focus,
  body[data-theme-version="dark"] .asset-filter-card .form-control:focus,
  body.theme-dark .asset-filter-card .form-control:focus,
  body[data-theme="dark"] .asset-filter-card .form-select:focus,
  body[data-theme-version="dark"] .asset-filter-card .form-select:focus,
  body.theme-dark .asset-filter-card .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.2rem rgba(59,130,246,0.2);
  }
  body[data-theme="dark"] .asset-filter-card .form-check-input,
  body[data-theme-version="dark"] .asset-filter-card .form-check-input,
  body.theme-dark .asset-filter-card .form-check-input {
    background-color: #0b1220;
    border-color: rgba(148,163,184,0.45);
  }
  body[data-theme="dark"] .asset-filter-card .btn-outline-secondary,
  body[data-theme-version="dark"] .asset-filter-card .btn-outline-secondary,
  body.theme-dark .asset-filter-card .btn-outline-secondary {
    color: #e5e7eb;
    border-color: rgba(148,163,184,0.45);
  }
  body[data-theme="dark"] .asset-filter-card .btn-outline-secondary:hover,
  body[data-theme-version="dark"] .asset-filter-card .btn-outline-secondary:hover,
  body.theme-dark .asset-filter-card .btn-outline-secondary:hover {
    color: #0f172a;
    background: #cbd5e1;
    border-color: #cbd5e1;
  }
  .asset-table-card { background:#fff; border-radius:20px; border:1px solid rgba(148,163,184,0.16); box-shadow:0 20px 45px rgba(15,23,42,0.08); padding:1.25rem 1.35rem; min-width:0; }
  .asset-table-card table thead th,
  .asset-table-card .pagination,
  .asset-table-card .pagination a,
  .asset-table-card .pagination span {
    font-size:0.86rem;
  }
  .asset-table-card table tbody td {
    font-size:0.95rem;
  }
  .asset-table-card table thead th { text-transform:uppercase; letter-spacing:0.07em; color:#64748b; }
  .asset-table-card table tbody td { vertical-align:middle; }
  body[data-theme="dark"] .asset-table-card,
  body[data-theme-version="dark"] .asset-table-card,
  body.theme-dark .asset-table-card {
    background:#0b1220;
    border-color:rgba(148,163,184,0.28);
    box-shadow:0 20px 45px rgba(2,6,23,0.45);
  }
  body[data-theme="dark"] .asset-table-card table thead th,
  body[data-theme-version="dark"] .asset-table-card table thead th,
  body.theme-dark .asset-table-card table thead th {
    color:#cbd5e1;
  }
  body[data-theme="dark"] .asset-table-card table tbody td,
  body[data-theme-version="dark"] .asset-table-card table tbody td,
  body.theme-dark .asset-table-card table tbody td,
  body[data-theme="dark"] .asset-table-card table tbody td a,
  body[data-theme-version="dark"] .asset-table-card table tbody td a,
  body.theme-dark .asset-table-card table tbody td a {
    color:#e5e7eb;
  }
  body[data-theme="dark"] .asset-table-card .table > :not(caption) > * > *,
  body[data-theme-version="dark"] .asset-table-card .table > :not(caption) > * > *,
  body.theme-dark .asset-table-card .table > :not(caption) > * > * {
    border-color:rgba(148,163,184,0.22);
  }
  body[data-theme="dark"] .asset-table-card .pagination .page-link,
  body[data-theme-version="dark"] .asset-table-card .pagination .page-link,
  body.theme-dark .asset-table-card .pagination .page-link {
    background:#020617;
    border-color:rgba(148,163,184,0.38);
    color:#cbd5e1;
  }
  body[data-theme="dark"] .asset-table-card .pagination .page-item.active .page-link,
  body[data-theme-version="dark"] .asset-table-card .pagination .page-item.active .page-link,
  body.theme-dark .asset-table-card .pagination .page-item.active .page-link {
    background:#2563eb;
    border-color:#2563eb;
    color:#fff;
  }
  .asset-actions { display:flex; flex-wrap:wrap; gap:0.35rem; }
  .asset-actions .btn {
    border-radius: 12px;
    transition: transform 0.25s cubic-bezier(.17,.67,.45,1.32), box-shadow 0.2s ease;
    font-size: 0.92rem;
    padding: 0.35rem 0.65rem;
    line-height: 1.2;
  }
  .asset-preview-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    border: 1px solid rgba(59,130,246,0.35);
    color: #1d4ed8;
    background: rgba(59,130,246,0.07);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }
  .asset-preview-btn--bast {
    border-color: rgba(14,165,233,0.38);
    color: #0369a1;
    background: rgba(14,165,233,0.08);
  }
  .asset-preview-btn:disabled {
    border-color: rgba(148,163,184,0.35);
    color: #94a3b8;
    background: rgba(148,163,184,0.08);
    cursor: not-allowed;
    opacity: 0.78;
  }
  .asset-preview-btn__icon {
    width: 1.15rem;
    height: 1.15rem;
    border-radius: 999px;
    background: rgba(59,130,246,0.15);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
  }
  .asset-actions .btn.is-animating {
    animation: assetActionPulse 0.35s cubic-bezier(.17,.67,.45,1.32);
  }
  @keyframes assetActionPulse {
    0% { transform: scale(0.9); }
    60% { transform: scale(1.05); }
    100% { transform: scale(1); }
  }
  body.asset-photo-modal-open {
    overflow: hidden;
  }
  .asset-photo-modal {
    position: fixed;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(15, 23, 42, 0.65);
    backdrop-filter: blur(6px);
    padding: 1.5rem;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.25s ease, visibility 0.25s ease;
    z-index: 2000;
  }
  .asset-photo-modal.is-visible {
    opacity: 1;
    visibility: visible;
  }
  .asset-photo-panel {
    position: fixed;
    left: 50%;
    top: 50%;
    background: #fff;
    border-radius: 24px;
    padding: 0;
    box-shadow: 0 40px 90px rgba(15,23,42,0.35);
    transform: translate(-50%, -50%) scale(0.92);
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    max-width: min(1100px, 94vw);
    width: 100%;
    max-height: 90vh;
    height: min(850px, 90vh);
    overflow: hidden;
    display: flex;
    flex-direction: column;
  }
  .asset-photo-modal.is-visible .asset-photo-panel {
    transform: translate(-50%, -50%) scale(1);
  }
  .asset-photo-label {
    text-align: left;
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    padding: 1rem 3.5rem 1rem 1.25rem;
    border-bottom: 1px solid #e2e8f0;
  }
  .asset-preview-viewport {
    flex: 1;
    min-height: 0;
    overflow: auto;
    background: #e2e8f0;
    overscroll-behavior: contain;
  }
  .asset-preview-stage {
    position: relative;
    min-width: 100%;
    min-height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
  }
  .asset-preview-stage img,
  .asset-preview-stage iframe {
    display: block;
    border: 0;
    border-radius: 12px;
    object-fit: contain;
    background: #fff;
    box-shadow: 0 16px 40px rgba(15,23,42,0.2);
  }
  .asset-preview-stage [hidden] {
    display: none !important;
  }
  .asset-preview-stage img {
    max-width: none;
    max-height: none;
  }
  .asset-preview-status {
    position: absolute;
    inset: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    color: #475569;
    font-size: 0.95rem;
    font-weight: 600;
    text-align: center;
    pointer-events: none;
  }
  .asset-preview-status.is-error {
    color: #b91c1c;
  }
  .asset-preview-toolbar {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    border-top: 1px solid #e2e8f0;
    background: #fff;
  }
  .asset-preview-toolbar .btn {
    min-width: 42px;
    border-radius: 10px;
    font-weight: 700;
  }
  .asset-preview-zoom-value {
    min-width: 58px;
    text-align: center;
    color: #475569;
    font-size: 0.88rem;
    font-weight: 700;
  }
  .asset-photo-close {
    position: absolute;
    top: 0.65rem;
    right: 0.75rem;
    border: none;
    border-radius: 999px;
    width: 34px;
    height: 34px;
    background: #e2e8f0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    cursor: pointer;
  }
  .asset-filter-card .form-label { font-size:0.9rem; }
  .asset-filter-card .form-control,
  .asset-filter-card .form-select,
  .asset-filter-card .form-check-label { font-size:0.96rem; }
  @media (max-width: 1440px) {
    .asset-filter-form {
      grid-template-columns:minmax(170px,1.2fr) repeat(3,minmax(120px,1fr));
    }
  }
  @media (max-width: 1200px) {
    .asset-filter-card,
    .asset-table-card {
      padding: 1rem;
      border-radius: 18px;
    }
    .asset-filter-form {
      grid-template-columns:repeat(2,minmax(0,1fr));
    }
    .asset-filter-actions {
      justify-content: stretch;
    }
    .asset-filter-actions .btn {
      flex: 1;
    }
  }
  @media (max-width: 992px) {
    .asset-hero { flex-direction:column; }
    .asset-filter-form { grid-template-columns:1fr; }
    .asset-filter-actions { grid-column:auto; }
    body[data-theme="light"] main.container{margin-left:0!important;}
  }
</style>
@endpush

@section('content')
@php($statusValue = request('status', ''))
@php($assetTotal = method_exists($assets, 'total') ? $assets->total() : $assets->count())
@php($assetShown = $assets->count())
@php($assetPage = method_exists($assets, 'currentPage') ? $assets->currentPage() : 1)
@php($perPageValue = (int) request('per_page', $perPage ?? 10))
@if($isAuthenticated)
<main class="content-body">
<div class="container-fluid">
@endif
<div class="asset-shell">
  @if($isAuthenticated)
  <section class="asset-hero">
    <div>
      <div class="asset-hero__title">{{ $title }}</div>
      <div class="asset-hero__subtitle">Kelola data sarpras dengan filter cepat, ekspor-impor Excel, serta aksi edit langsung di tabel.</div>
      @auth
        <div class="asset-hero__cta">
          <a href="{{ $createUrl }}" class="btn asset-add-btn px-4 d-flex align-items-center gap-2">
            <span class="fs-5">+</span>
            <span>Tambah {{ $isLoanable ? 'Barang' : 'Aset' }}</span>
          </a>
          <a href="{{ $importUrl }}" class="btn btn-outline-primary">Import Excel</a>
          <small>{{ $isLoanable ? 'Data barang peminjaman' : 'Data aset inventaris' }}</small>
        </div>
      @endauth
    </div>
    <div class="asset-hero__stats">
      <div class="asset-summary-card">
        <div class="asset-summary-label">Total data</div>
        <div class="asset-summary-value">{{ number_format($assetTotal) }}</div>
      </div>
      <div class="asset-summary-card">
        <div class="asset-summary-label">Ditampilkan</div>
        <div class="asset-summary-value">{{ number_format($assetShown) }}</div>
      </div>
      <div class="asset-summary-card">
        <div class="asset-summary-label">Halaman</div>
        <div class="asset-summary-value">{{ number_format($assetPage) }}</div>
      </div>
    </div>
  </section>
  @endif

  <section class="asset-filter-card">
    <form method="GET" action="{{ route($listRoute) }}" class="asset-filter-form">
      <div>
        <label class="form-label">{{ $isAuthenticated ? 'Cari' : 'Cari Barang' }}</label>
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Kode / nama / deskripsi">
      </div>
      @if($isAuthenticated)
      <div>
        <label class="form-label">Kategori</label>
        <select name="category" class="form-select">
          <option value="">Semua</option>
          @foreach(($categories ?? []) as $cat)
            <option value="{{ $cat }}" {{ request('category')===$cat?'selected':'' }}>{{ $cat }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="" {{ $statusValue === '' ? 'selected' : '' }}>Semua</option>
          <option value="active" {{ $statusValue === 'active' ? 'selected' : '' }}>Aktif</option>
          <option value="inactive" {{ $statusValue === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
        </select>
      </div>
      @endif
      <div>
        <label class="form-label">Tampilkan</label>
        <select name="per_page" class="form-select">
          <option value="10" {{ $perPageValue === 10 ? 'selected' : '' }}>10</option>
          <option value="50" {{ $perPageValue === 50 ? 'selected' : '' }}>50</option>
          <option value="100" {{ $perPageValue === 100 ? 'selected' : '' }}>100</option>
        </select>
      </div>
      <div class="asset-filter-actions">
        <button class="btn btn-primary" type="submit">Terapkan</button>
        <a href="{{ route($listRoute) }}" class="btn btn-outline-secondary">Reset</a>
      </div>
    </form>
  </section>

  <section class="asset-table-card">
    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            @php($s=request('sort'))
            @php($d=request('dir','asc'))
            @php($next=function($key){ return (request('sort')===$key && request('dir','asc')==='asc')?'desc':'asc'; })
            <th>
              @php($q=array_merge(request()->all(),['sort'=>'code','dir'=>$next('code')]))
              @php($arrow=$s==='code' ? ($d==='asc'?'▲':'▼') : '•')
              <a href="{{ route($listRoute,$q) }}" class="text-decoration-none text-muted">Kode <span class="small">{{ $arrow }}</span></a>
            </th>
            <th>
              @php($q=array_merge(request()->all(),['sort'=>'name','dir'=>$next('name')]))
              @php($arrow=$s==='name' ? ($d==='asc'?'▲':'▼') : '•')
              <a href="{{ route($listRoute,$q) }}" class="text-decoration-none text-muted">Nama <span class="small">{{ $arrow }}</span></a>
            </th>
            <th>
              @php($q=array_merge(request()->all(),['sort'=>'category','dir'=>$next('category')]))
              @php($arrow=$s==='category' ? ($d==='asc'?'▲':'▼') : '•')
              <a href="{{ route($listRoute,$q) }}" class="text-decoration-none text-muted">Kategori <span class="small">{{ $arrow }}</span></a>
            </th>
            <th></th>
            <th>
              @php($q=array_merge(request()->all(),['sort'=>'status','dir'=>$next('status')]))
              @php($arrow=$s==='status' ? ($d==='asc'?'▲':'▼') : '•')
              <a href="{{ route($listRoute,$q) }}" class="text-decoration-none text-muted">Status <span class="small">{{ $arrow }}</span></a>
            </th>
            @if($isAuthenticated)
              <th>Aksi</th>
            @endif
          </tr>
        </thead>
        <tbody>
          @forelse($assets as $asset)
            <tr>
              <td>{{ $asset->code }}</td>
              <td>{{ $asset->name }}</td>
              <td>{{ $asset->category ?? '-' }}</td>
              <td></td>
              <td>
                @php($statusLabel = $asset->status === 'active' ? 'Aktif' : ($asset->status === 'inactive' ? 'Tidak aktif' : $asset->status))
                <span class="badge {{ $asset->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ $statusLabel }}</span>
              </td>
              @if($isAuthenticated)
                <td>
                  <div class="asset-actions">
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('assets.edit', ['asset' => $asset, 'kind' => $isLoanable ? \App\Models\Asset::KIND_LOANABLE : \App\Models\Asset::KIND_INVENTORY]) }}">Edit</a>
                    <form method="POST" action="{{ route('assets.destroy', $asset) }}" data-confirm-form data-confirm-message="Hapus aset {{ $asset->name }}?">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                    </form>
                    @if($asset->bast_document_path)
                      <button type="button" class="btn btn-sm asset-preview-btn asset-preview-btn--bast" data-preview-view="{{ asset('storage/'.$asset->bast_document_path) }}" data-preview-type="pdf" data-preview-label="BAST - {{ $asset->name }}">
                        <span class="asset-preview-btn__icon">&#128196;</span>
                        <span>BAST</span>
                      </button>
                    @else
                      <button type="button" class="btn btn-sm asset-preview-btn asset-preview-btn--bast" disabled title="BAST belum tersedia">
                        <span class="asset-preview-btn__icon">&#128196;</span>
                        <span>BAST</span>
                      </button>
                    @endif
                    @if($asset->photo_url)
                      <button type="button" class="btn btn-sm asset-preview-btn" data-preview-view="{{ $asset->photo_url }}" data-preview-type="image" data-preview-label="Foto - {{ $asset->name }}">
                        <span class="asset-preview-btn__icon">&#128247;</span>
                        <span>Foto</span>
                      </button>
                    @else
                      <button type="button" class="btn btn-sm asset-preview-btn" disabled title="Foto belum tersedia">
                        <span class="asset-preview-btn__icon">&#128247;</span>
                        <span>Foto</span>
                      </button>
                    @endif
                  </div>
                </td>
              @endif
            </tr>
          @empty
            <tr>
              <td colspan="{{ $isAuthenticated ? 6 : 5 }}" class="text-center text-muted py-4">
                {{ $isLoanable ? 'Belum ada peralatan peminjaman.' : 'Belum ada data aset.' }}
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="d-flex justify-content-end mt-3">
      {{ $assets->links() }}
    </div>
  </section>
</div>
@if($isAuthenticated)
  <div class="asset-photo-modal" data-photo-modal aria-hidden="true" role="dialog">
    <div class="asset-photo-panel" role="document">
      <button type="button" class="asset-photo-close" data-photo-close aria-label="Tutup preview">&times;</button>
      <div class="asset-photo-label" data-photo-label>Preview Lampiran</div>
      <div class="asset-preview-viewport" data-preview-viewport tabindex="0">
        <div class="asset-preview-stage" data-preview-stage>
          <img src="" alt="Preview foto aset" data-preview-image hidden>
          <iframe src="about:blank" title="Preview dokumen BAST" data-preview-frame hidden></iframe>
          <div class="asset-preview-status" data-preview-status hidden></div>
        </div>
      </div>
      <div class="asset-preview-toolbar" aria-label="Kontrol zoom">
        <button type="button" class="btn btn-sm btn-outline-secondary" data-preview-zoom-out aria-label="Perkecil tampilan">&minus;</button>
        <span class="asset-preview-zoom-value" data-preview-zoom-value>100%</span>
        <button type="button" class="btn btn-sm btn-outline-secondary" data-preview-zoom-in aria-label="Perbesar tampilan">+</button>
        <button type="button" class="btn btn-sm btn-outline-primary" data-preview-reset>Pas</button>
      </div>
    </div>
  </div>
  <x-confirm-modal default-message="Data aset yang dihapus tidak dapat dikembalikan." />
@endif
@if($isAuthenticated)
</div>
</main>
@endif
@endsection

@if($isAuthenticated)
@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const modal = document.querySelector('[data-photo-modal]');

    if (modal && modal.parentElement !== document.body) {
      document.body.appendChild(modal);
    }

    const closeBtn = modal?.querySelector('[data-photo-close]');
    const labelBox = modal?.querySelector('[data-photo-label]');
    const viewport = modal?.querySelector('[data-preview-viewport]');
    const stage = modal?.querySelector('[data-preview-stage]');
    const image = modal?.querySelector('[data-preview-image]');
    const frame = modal?.querySelector('[data-preview-frame]');
    const statusBox = modal?.querySelector('[data-preview-status]');
    const zoomValue = modal?.querySelector('[data-preview-zoom-value]');
    const zoomInBtn = modal?.querySelector('[data-preview-zoom-in]');
    const zoomOutBtn = modal?.querySelector('[data-preview-zoom-out]');
    const resetBtn = modal?.querySelector('[data-preview-reset]');
    let activeMedia = null;
    let zoom = 1;
    let baseWidth = 0;
    let baseHeight = 0;

    const applyZoom = () => {
      if (!activeMedia || !viewport || !stage) return;
      const width = Math.max(1, baseWidth * zoom);
      const height = Math.max(1, baseHeight * zoom);
      activeMedia.style.width = `${width}px`;
      activeMedia.style.height = `${height}px`;
      stage.style.width = `${Math.max(viewport.clientWidth, width + 32)}px`;
      stage.style.height = `${Math.max(viewport.clientHeight, height + 32)}px`;
      if (zoomValue) zoomValue.textContent = `${Math.round(zoom * 100)}%`;
      if (zoomOutBtn) zoomOutBtn.disabled = zoom <= 0.25;
      if (zoomInBtn) zoomInBtn.disabled = zoom >= 4;
    };

    const setZoom = (nextZoom) => {
      zoom = Math.min(4, Math.max(0.25, nextZoom));
      applyZoom();
    };

    const setStatus = (message = '', isError = false) => {
      if (!statusBox) return;
      statusBox.textContent = message;
      statusBox.hidden = !message;
      statusBox.classList.toggle('is-error', isError);
    };

    const setZoomControlsDisabled = (disabled) => {
      if (zoomInBtn) zoomInBtn.disabled = disabled;
      if (zoomOutBtn) zoomOutBtn.disabled = disabled;
      if (resetBtn) resetBtn.disabled = disabled;
    };

    const prepareMediaSize = () => {
      if (!activeMedia || !viewport) return;
      activeMedia.style.width = '';
      activeMedia.style.height = '';
      if (activeMedia === frame) {
        baseWidth = Math.max(320, viewport.clientWidth - 32);
        baseHeight = Math.max(420, viewport.clientHeight - 32);
      } else {
        const naturalWidth = Math.max(1, image.naturalWidth);
        const naturalHeight = Math.max(1, image.naturalHeight);
        const availableWidth = Math.max(1, viewport.clientWidth - 32);
        const availableHeight = Math.max(1, viewport.clientHeight - 32);
        const fitScale = Math.min(1, availableWidth / naturalWidth, availableHeight / naturalHeight);
        baseWidth = naturalWidth * fitScale;
        baseHeight = naturalHeight * fitScale;
      }
      zoom = 1;
      applyZoom();
      viewport.scrollTo({
        top: Math.max(0, (baseHeight - viewport.clientHeight) / 2),
        left: Math.max(0, (baseWidth - viewport.clientWidth) / 2),
      });
      setStatus();
      setZoomControlsDisabled(false);
    };

    const showPhotoModal = (src, label = '', type = 'image') => {
      if (!modal) return;
      const isPdf = type === 'pdf';
      activeMedia = isPdf ? frame : image;
      image.hidden = isPdf;
      frame.hidden = !isPdf;
      setStatus('Memuat preview...');
      setZoomControlsDisabled(true);
      if (isPdf) {
        frame.src = src || 'about:blank';
      } else {
        image.alt = label || 'Preview foto aset';
        image.src = src || '';
      }
      modal.classList.add('is-visible');
      modal.setAttribute('aria-hidden', 'false');
      document.body.classList.add('asset-photo-modal-open');
      if (labelBox) {
        labelBox.textContent = label || 'Preview Lampiran';
      }
      if (isPdf) {
        requestAnimationFrame(() => requestAnimationFrame(prepareMediaSize));
      } else if (image.complete && image.naturalWidth > 0) {
        requestAnimationFrame(prepareMediaSize);
      }
    };
    const hidePhotoModal = () => {
      if (!modal) return;
      modal.classList.remove('is-visible');
      modal.setAttribute('aria-hidden', 'true');
      document.body.classList.remove('asset-photo-modal-open');
      image.src = '';
      frame.src = 'about:blank';
      image.hidden = true;
      frame.hidden = true;
      activeMedia = null;
      zoom = 1;
      setStatus();
      setZoomControlsDisabled(true);
      if (stage) {
        stage.style.width = '';
        stage.style.height = '';
      }
      if (labelBox) {
        labelBox.textContent = 'Preview Lampiran';
      }
    };
    closeBtn?.addEventListener('click', hidePhotoModal);

    modal?.addEventListener('click', (event) => {
      if (event.target === modal) {
        hidePhotoModal();
      }
    });

    document.addEventListener('keyup', (event) => {
      if (event.key === 'Escape') {
        hidePhotoModal();
      }
    });

    zoomInBtn?.addEventListener('click', () => setZoom(zoom + 0.25));
    zoomOutBtn?.addEventListener('click', () => setZoom(zoom - 0.25));
    resetBtn?.addEventListener('click', () => {
      setZoom(1);
      viewport?.scrollTo({ top: 0, left: 0, behavior: 'smooth' });
    });
    viewport?.addEventListener('wheel', (event) => {
      if (!event.ctrlKey) return;
      event.preventDefault();
      setZoom(zoom + (event.deltaY < 0 ? 0.25 : -0.25));
    }, { passive: false });
    image?.addEventListener('load', prepareMediaSize);
    image?.addEventListener('error', () => {
      baseWidth = 0;
      baseHeight = 0;
      setZoomControlsDisabled(true);
      setStatus('Foto tidak dapat dimuat. Pastikan file foto masih tersedia.', true);
    });

    document.addEventListener('keydown', (event) => {
      if (!modal?.classList.contains('is-visible') || !activeMedia) return;
      if (event.key === '+' || event.key === '=') setZoom(zoom + 0.25);
      if (event.key === '-') setZoom(zoom - 0.25);
      if (event.key === '0') {
        setZoom(1);
        viewport?.scrollTo({ top: 0, left: 0 });
      }
    });

    document.querySelectorAll('[data-preview-view]').forEach((btn) => {
      btn.addEventListener('click', (event) => {
        event.preventDefault();
        const src = btn.getAttribute('data-preview-view');
        if (!src) {
          return;
        }
        showPhotoModal(src, btn.getAttribute('data-preview-label'), btn.getAttribute('data-preview-type'));
        btn.classList.remove('is-animating');
        void btn.offsetWidth;
        btn.classList.add('is-animating');
      });
      btn.addEventListener('animationend', () => btn.classList.remove('is-animating'));
    });
  });
</script>
@endpush
@endif
