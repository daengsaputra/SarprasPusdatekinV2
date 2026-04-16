@extends('layouts.app')
@section('title', 'Pengaturan Super Admin')

@php
  $defaults = \App\Models\SiteSetting::defaultPageToggles();
  $current = array_merge($defaults, $pageToggles ?? []);
  $roleDefaults = \App\Models\SiteSetting::defaultRolePageAccess();
  $roleAccessCurrent = array_replace_recursive($roleDefaults, $rolePageAccessMap ?? []);
  $roleLabels = $roleLabels ?? \App\Models\User::ROLE_LABELS;
  $items = $menuItems ?? [
    'assets_loanable' => ['label' => 'Data Barang', 'desc' => 'Menu publik daftar barang yang bisa dipinjam.'],
    'assets_inventory' => ['label' => 'Data Aset', 'desc' => 'Manajemen inventaris internal.'],
    'loans' => ['label' => 'Peminjaman', 'desc' => 'Form dan proses transaksi peminjaman.'],
    'reports' => ['label' => 'Laporan', 'desc' => 'Halaman laporan ringkasan dan ekspor.'],
    'users' => ['label' => 'Daftar Anggota', 'desc' => 'Administrasi akun pengguna.'],
  ];
  $hasVideo = filled($videoUrl ?? null);
  $selectedHeroVariant = old('hero_variant', $currentHeroVariant ?? 'ocean');
@endphp

@push('styles')
<style>
  .super-admin-shell { display:flex; flex-direction:column; gap:1rem; }
  .super-admin-page {
    --sa-surface:#ffffff;
    --sa-surface-soft:#f8fafc;
  }
  .super-admin-card {
    background:#fff;
    border:1px solid rgba(148,163,184,0.18);
    border-radius:18px;
    box-shadow:0 12px 30px rgba(15,23,42,0.08);
  }
  .super-admin-card .card-body { padding:1.1rem 1.2rem; }
  .toggle-grid {
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:0.7rem;
  }
  .toggle-item {
    border:1px solid rgba(148,163,184,0.25);
    border-radius:12px;
    padding:0.7rem 0.8rem;
    background:#f8fafc;
  }
  .idea-list {
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:0.6rem;
  }
  .idea-item {
    border:1px dashed rgba(59,130,246,0.35);
    background:rgba(239,246,255,0.7);
    border-radius:12px;
    padding:0.65rem 0.75rem;
    color:#1e3a8a;
    font-size:0.88rem;
  }
  .audit-item {
    border:1px solid rgba(148,163,184,0.2);
    background:#f8fafc;
    border-radius:12px;
    padding:0.65rem 0.75rem;
  }
  .audit-table-wrap {
    border:1px solid rgba(148,163,184,0.22);
    border-radius:12px;
    overflow:hidden;
  }
  .audit-table {
    margin:0;
    font-size:0.84rem;
  }
  .audit-table thead th {
    background:#f1f5f9;
    color:#334155;
    font-size:0.76rem;
    letter-spacing:0.04em;
    text-transform:uppercase;
    vertical-align:middle;
    white-space:nowrap;
  }
  .audit-table td {
    vertical-align:top;
    color:#334155;
  }
  .audit-list-inline {
    display:flex;
    flex-direction:column;
    gap:0.2rem;
  }
  .role-access-wrap {
    border:1px solid rgba(148,163,184,0.24);
    border-radius:12px;
    overflow:auto;
    background:#fff;
  }
  .role-access-table {
    min-width:680px;
    margin:0;
  }
  .role-access-table thead th {
    background:#f8fafc;
    font-size:0.78rem;
    text-transform:uppercase;
    letter-spacing:0.04em;
    color:#475569;
    white-space:nowrap;
  }
  .role-access-table td {
    vertical-align:middle;
  }
  .landing-preview {
    border-radius: 12px;
    border: 1px solid rgba(148,163,184,0.3);
    overflow: hidden;
    background: #0f172a;
    max-width: 380px;
  }
  .landing-preview video {
    width: 100%;
    height: auto;
    display: block;
  }
  .hero-variant-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 0.65rem;
  }
  .hero-variant-option {
    border: 1px solid rgba(148,163,184,0.3);
    border-radius: 12px;
    padding: 0.7rem 0.8rem;
    background: #f8fafc;
    display: flex;
    align-items: center;
    gap: 0.65rem;
    cursor: pointer;
  }
  .hero-variant-option.selected {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
    background: #fff;
  }
  .hero-variant-swatch {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    border: 1px solid rgba(148,163,184,0.3);
    flex-shrink: 0;
  }
  .hero-variant-swatch.is-ocean { background: linear-gradient(125deg, #2563eb, #e0f2fe 68%); }
  .hero-variant-swatch.is-slate { background: linear-gradient(125deg, #475569, #f1f5f9 68%); }
  body[data-theme="dark"] .super-admin-page,
  body[data-theme-version="dark"] .super-admin-page,
  body.theme-dark .super-admin-page {
    --sa-surface:rgba(15, 23, 42, 0.88);
    --sa-surface-soft:rgba(15, 23, 42, 0.64);
  }
  body[data-theme="dark"] .super-admin-card,
  body[data-theme-version="dark"] .super-admin-card,
  body.theme-dark .super-admin-card {
    background:var(--sa-surface);
    border-color:rgba(71, 85, 105, 0.55);
    box-shadow:0 18px 38px rgba(2, 6, 23, 0.42);
  }
  body[data-theme="dark"] .super-admin-card h4,
  body[data-theme-version="dark"] .super-admin-card h4,
  body.theme-dark .super-admin-card h4,
  body[data-theme="dark"] .super-admin-card h5,
  body[data-theme-version="dark"] .super-admin-card h5,
  body.theme-dark .super-admin-card h5,
  body[data-theme="dark"] .super-admin-card .form-label,
  body[data-theme-version="dark"] .super-admin-card .form-label,
  body.theme-dark .super-admin-card .form-label,
  body[data-theme="dark"] .super-admin-card .fw-semibold,
  body[data-theme-version="dark"] .super-admin-card .fw-semibold,
  body.theme-dark .super-admin-card .fw-semibold,
  body[data-theme="dark"] .role-access-table thead th,
  body[data-theme-version="dark"] .role-access-table thead th,
  body.theme-dark .role-access-table thead th,
  body[data-theme="dark"] .role-access-table tbody td,
  body[data-theme-version="dark"] .role-access-table tbody td,
  body.theme-dark .role-access-table tbody td {
    color:#e2e8f0 !important;
  }
  body[data-theme="dark"] .super-admin-card .text-muted,
  body[data-theme-version="dark"] .super-admin-card .text-muted,
  body.theme-dark .super-admin-card .text-muted,
  body[data-theme="dark"] .super-admin-card .form-text,
  body[data-theme-version="dark"] .super-admin-card .form-text,
  body.theme-dark .super-admin-card .form-text,
  body[data-theme="dark"] .super-admin-card .small,
  body[data-theme-version="dark"] .super-admin-card .small,
  body.theme-dark .super-admin-card .small {
    color:#94a3b8 !important;
  }
  body[data-theme="dark"] .toggle-item,
  body[data-theme-version="dark"] .toggle-item,
  body.theme-dark .toggle-item,
  body[data-theme="dark"] .hero-variant-option,
  body[data-theme-version="dark"] .hero-variant-option,
  body.theme-dark .hero-variant-option,
  body[data-theme="dark"] .role-access-wrap,
  body[data-theme-version="dark"] .role-access-wrap,
  body.theme-dark .role-access-wrap,
  body[data-theme="dark"] .landing-preview,
  body[data-theme-version="dark"] .landing-preview,
  body.theme-dark .landing-preview {
    background:var(--sa-surface-soft);
    border-color:rgba(71, 85, 105, 0.55);
  }
  body[data-theme="dark"] .hero-variant-option.selected,
  body[data-theme-version="dark"] .hero-variant-option.selected,
  body.theme-dark .hero-variant-option.selected {
    background:rgba(30, 41, 59, 0.95);
    box-shadow:0 0 0 3px rgba(59, 130, 246, 0.22);
  }
  body[data-theme="dark"] .role-access-table thead th,
  body[data-theme-version="dark"] .role-access-table thead th,
  body.theme-dark .role-access-table thead th {
    background:rgba(30, 41, 59, 0.96);
    border-bottom-color:rgba(71, 85, 105, 0.5);
  }
  body[data-theme="dark"] .role-access-table tbody td,
  body[data-theme-version="dark"] .role-access-table tbody td,
  body.theme-dark .role-access-table tbody td {
    background:transparent;
    border-color:rgba(51, 65, 85, 0.85);
  }
  body[data-theme="dark"] .super-admin-card .form-control,
  body[data-theme-version="dark"] .super-admin-card .form-control,
  body.theme-dark .super-admin-card .form-control {
    background:rgba(2, 6, 23, 0.55);
    border-color:rgba(71, 85, 105, 0.65);
    color:#e2e8f0;
  }
  body[data-theme="dark"] .super-admin-card .form-control::placeholder,
  body[data-theme-version="dark"] .super-admin-card .form-control::placeholder,
  body.theme-dark .super-admin-card .form-control::placeholder {
    color:#64748b;
  }
  body[data-theme="dark"] .super-admin-card hr,
  body[data-theme-version="dark"] .super-admin-card hr,
  body.theme-dark .super-admin-card hr {
    border-color:rgba(51, 65, 85, 0.85);
  }
</style>
@endpush

@section('content')
<main class="content-body">
  <div class="container-fluid">
    <div class="super-admin-shell super-admin-page">
      @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      <div class="super-admin-card card">
        <div class="card-body">
          <h4 class="mb-1">Kontrol Halaman Utama</h4>
          <p class="text-muted mb-3">Aktifkan/nonaktifkan halaman utama dari menu. Super Admin tetap bisa mengakses semua halaman untuk manajemen.</p>

          <div class="d-flex flex-wrap gap-2 mb-3">
            <form method="POST" action="{{ route('settings.admin-menu.update') }}" class="d-inline">
              @csrf
              <input type="hidden" name="preset_mode" value="normal">
              <button type="submit" class="btn btn-sm btn-outline-success">Preset Normal</button>
            </form>
            <form method="POST" action="{{ route('settings.admin-menu.update') }}" class="d-inline" data-confirm-form data-confirm-title="Aktifkan Maintenance?" data-confirm-message="Semua halaman operasional akan dinonaktifkan untuk non-super-admin. Lanjutkan?">
              @csrf
              <input type="hidden" name="preset_mode" value="maintenance">
              <button type="submit" class="btn btn-sm btn-outline-danger">Preset Maintenance</button>
            </form>
            <form method="POST" action="{{ route('settings.admin-menu.update') }}" class="d-inline">
              @csrf
              <input type="hidden" name="preset_mode" value="operasional">
              <button type="submit" class="btn btn-sm btn-outline-primary">Preset Operasional</button>
            </form>
          </div>

          <form method="POST" action="{{ route('settings.admin-menu.update') }}" enctype="multipart/form-data">
            @csrf

            @php
              $toggleItems = $menuItems ?? $items ?? [
                'assets_loanable' => ['label' => 'Data Barang', 'desc' => 'Menu publik daftar barang yang bisa dipinjam.'],
                'assets_inventory' => ['label' => 'Data Aset', 'desc' => 'Manajemen inventaris internal.'],
                'loans' => ['label' => 'Peminjaman', 'desc' => 'Form dan proses transaksi peminjaman.'],
                'reports' => ['label' => 'Laporan', 'desc' => 'Halaman laporan ringkasan dan ekspor.'],
                'users' => ['label' => 'Daftar Anggota', 'desc' => 'Administrasi akun pengguna.'],
              ];
            @endphp

            <div class="toggle-grid mb-3">
              @foreach($toggleItems as $key => $meta)
                <label class="toggle-item">
                  <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" role="switch" id="toggle_{{ $key }}" name="{{ $key }}" value="1" {{ old($key, $current[$key] ?? true) ? 'checked' : '' }}>
                    <span class="fw-semibold ms-2">{{ $meta['label'] }}</span>
                  </div>
                  <div class="small text-muted">{{ $meta['desc'] }}</div>
                </label>
              @endforeach
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold mb-2">Whitelist Akses per Role</label>
              <div class="form-text mb-2">Atur role mana yang boleh membuka halaman tertentu. Super Admin tetap memiliki akses penuh.</div>
              <div class="role-access-wrap">
                <table class="table table-sm role-access-table mb-0">
                  <thead>
                    <tr>
                      <th style="min-width:220px;">Halaman</th>
                      <th>Toggle Global</th>
                      @foreach($roleLabels as $roleKey => $roleLabel)
                        <th>{{ $roleLabel }}</th>
                      @endforeach
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($toggleItems as $pageKey => $meta)
                      <tr>
                        <td>
                          <div class="fw-semibold">{{ $meta['label'] }}</div>
                          <div class="text-muted small">{{ $meta['desc'] }}</div>
                        </td>
                        <td>
                          <span class="badge {{ old($pageKey, $current[$pageKey] ?? true) ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }}">
                            {{ old($pageKey, $current[$pageKey] ?? true) ? 'Aktif' : 'Nonaktif' }}
                          </span>
                        </td>
                        @foreach($roleLabels as $roleKey => $roleLabel)
                          @php
                            $isSuperAdminRole = $roleKey === \App\Models\User::ROLE_SUPER_ADMIN;
                            $checked = old("role_access.$pageKey.$roleKey", $roleAccessCurrent[$pageKey][$roleKey] ?? false);
                          @endphp
                          <td>
                            <input
                              class="form-check-input"
                              type="checkbox"
                              role="switch"
                              name="role_access[{{ $pageKey }}][{{ $roleKey }}]"
                              value="1"
                              {{ $checked ? 'checked' : '' }}
                              @if($isSuperAdminRole) checked disabled @endif
                            >
                            @if($isSuperAdminRole)
                              <input type="hidden" name="role_access[{{ $pageKey }}][{{ $roleKey }}]" value="1">
                            @endif
                          </td>
                        @endforeach
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold" for="broadcast_message">Pesan Broadcast Internal</label>
              <textarea id="broadcast_message" name="broadcast_message" class="form-control @error('broadcast_message') is-invalid @enderror" rows="3" placeholder="Contoh: Sistem maintenance modul laporan pukul 17:00.">{{ old('broadcast_message', $broadcastMessage) }}</textarea>
              <div class="form-text">Pesan akan tampil di semua halaman internal aplikasi.</div>
              @error('broadcast_message')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <hr class="my-3">

            <div class="mb-3">
              <h5 class="mb-1">Pengaturan Landing (Terintegrasi)</h5>
              <p class="text-muted mb-3">Konfigurasi video hero dan varian header landing dipusatkan di halaman Super Admin ini.</p>

              <div class="mb-3">
                <label class="form-label">Unggah Video Landing</label>
                <input type="file" name="landing_video" accept="video/mp4,video/webm,video/ogg" class="form-control @error('landing_video') is-invalid @enderror">
                <div class="form-text">
                  @php($maxMb = number_format((int) config('bpip.landing_video_max_kb', 71680) / 1024, 1))
                  Format yang didukung: MP4, WebM, OGG. Ukuran maksimal {{ $maxMb }} MB.
                </div>
                @error('landing_video')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              @if($hasVideo)
                <div class="mb-3">
                  <label class="form-label">Preview Video Saat Ini</label>
                  <div class="landing-preview mb-2">
                    <video controls preload="metadata">
                      <source src="{{ $videoUrl }}" @if($videoMime) type="{{ $videoMime }}" @endif>
                      Browser Anda tidak mendukung pemutaran video.
                    </video>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" name="remove_video" value="1" class="form-check-input" id="removeVideo">
                    <label class="form-check-label" for="removeVideo">Hapus video saat ini</label>
                  </div>
                </div>
              @endif

              <div class="mb-2">
                <label class="form-label d-block">Varian Header Halaman</label>
                <div class="hero-variant-grid">
                  <label class="hero-variant-option {{ $selectedHeroVariant === 'ocean' ? 'selected' : '' }}">
                    <input class="form-check-input" type="radio" name="hero_variant" value="ocean" {{ $selectedHeroVariant === 'ocean' ? 'checked' : '' }}>
                    <div class="hero-variant-swatch is-ocean"></div>
                    <div>
                      <div class="fw-semibold">Ocean</div>
                      <div class="text-muted small">Nuansa biru cerah.</div>
                    </div>
                  </label>
                  <label class="hero-variant-option {{ $selectedHeroVariant === 'slate' ? 'selected' : '' }}">
                    <input class="form-check-input" type="radio" name="hero_variant" value="slate" {{ $selectedHeroVariant === 'slate' ? 'checked' : '' }}>
                    <div class="hero-variant-swatch is-slate"></div>
                    <div>
                      <div class="fw-semibold">Slate</div>
                      <div class="text-muted small">Nuansa abu modern.</div>
                    </div>
                  </label>
                </div>
                @error('hero_variant')
                  <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="d-flex flex-wrap gap-2">
              <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
              <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Kembali ke Dashboard</a>
            </div>
          </form>
        </div>
      </div>

      <div class="super-admin-card card">
        <div class="card-body">
          <h5 class="mb-2">Ide Fitur Lanjutan Super Admin</h5>
          <div class="idea-list">
            <div class="idea-item">Jadwal auto-nonaktif halaman tertentu berdasarkan jam kerja.</div>
            <div class="idea-item">Whitelist akses halaman per role (mis. petugas boleh laporan, peminjam tidak).</div>
            <div class="idea-item">Audit log perubahan setting (siapa, kapan, apa yang diubah).</div>
            <div class="idea-item">Preset mode cepat: Normal, Maintenance, Operasional saja.</div>
          </div>
        </div>
      </div>

      <div class="super-admin-card card">
        <div class="card-body">
          <h5 class="mb-2">Audit Log Pengaturan</h5>
          <form method="GET" action="{{ route('settings.admin-menu') }}" class="row g-2 mb-3 align-items-end">
            <div class="col-sm-4 col-md-3">
              <label class="form-label mb-1">Filter Tanggal</label>
              <input type="date" name="log_date" value="{{ $selectedLogDate }}" class="form-control form-control-sm">
            </div>
            <div class="col-sm-8 col-md-9 d-flex gap-2 flex-wrap">
              <button type="submit" class="btn btn-sm btn-outline-primary">Terapkan</button>
              <a href="{{ route('settings.admin-menu') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
              <a href="{{ route('settings.admin-menu.logs.export', array_filter(['log_date' => $selectedLogDate])) }}" class="btn btn-sm btn-outline-success">Export CSV</a>
            </div>
          </form>
          <form method="POST" action="{{ route('settings.admin-menu.logs.clear') }}" class="mb-3" data-confirm-form data-confirm-title="Hapus Audit Log?" data-confirm-message="Seluruh riwayat audit akan dihapus permanen. Lanjutkan?">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus Riwayat</button>
          </form>

          @if(($auditLogs ?? collect())->count() > 0)
            <div class="table-responsive audit-table-wrap">
              <table class="table table-sm table-hover audit-table mb-0 align-middle">
                <thead>
                  <tr>
                    <th style="min-width:150px;">Aktor</th>
                    <th style="min-width:150px;">Waktu</th>
                    <th style="min-width:110px;">Mode</th>
                    <th style="min-width:170px;">Perubahan</th>
                    <th style="min-width:220px;">Sebelum</th>
                    <th style="min-width:220px;">Sesudah</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($auditLogs as $log)
                    <tr>
                      <td>
                        <div class="fw-semibold">{{ $log['actor'] ?? 'unknown' }}</div>
                        <div class="text-muted small">{{ $log['actor_email'] ?? '-' }}</div>
                      </td>
                      <td>{{ $log['at'] ?? '-' }}</td>
                      <td>
                        <span class="badge bg-light text-dark border">{{ $log['preset'] ? ucfirst((string) $log['preset']) : 'Manual' }}</span>
                      </td>
                      <td>
                        <div class="audit-list-inline">
                          @if(!empty($log['changed_keys']))
                            <span><strong>Toggle:</strong> {{ implode(', ', $log['changed_keys']) }}</span>
                          @endif
                          @if(!empty($log['role_access_changed']))
                            @foreach($log['role_access_changed'] as $change)
                              <span><strong>Role:</strong> {{ $change }}</span>
                            @endforeach
                          @endif
                          @if(empty($log['changed_keys']) && empty($log['role_access_changed']))
                            <span>Tidak ada</span>
                          @endif
                        </div>
                      </td>
                      <td>
                        <div class="audit-list-inline">
                          @if(!empty($log['toggles_before']))
                            @foreach($log['toggles_before'] as $k => $v)
                              <span>{{ $k }}: <strong>{{ $v ? 'on' : 'off' }}</strong></span>
                            @endforeach
                          @else
                            <span>-</span>
                          @endif
                        </div>
                      </td>
                      <td>
                        <div class="audit-list-inline">
                          @if(!empty($log['toggles_after']))
                            @foreach($log['toggles_after'] as $k => $v)
                              <span>{{ $k }}: <strong>{{ $v ? 'on' : 'off' }}</strong></span>
                            @endforeach
                          @else
                            <span>-</span>
                          @endif
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <p class="text-muted mb-0">Belum ada riwayat perubahan.</p>
          @endif

          @if(method_exists($auditLogs, 'links'))
            <div class="mt-3">{{ $auditLogs->links() }}</div>
          @endif
        </div>
      </div>
    </div>
  </div>
</main>
<x-confirm-modal />
@endsection
