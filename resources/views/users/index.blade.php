@php($title = 'Daftar Anggota')
@extends('layouts.app')

@push('styles')
<style>
  body[data-theme="light"] { background: #f4f6ff; }
  .users-shell { display:flex; flex-direction:column; gap:1.25rem; min-width:0; }
  .users-hero {
    display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.9rem;
    padding:1.35rem 1.6rem; border-radius:24px;
    background:linear-gradient(120deg, rgba(59,130,246,0.12), #ffffff 70%);
    border:1px solid rgba(148,163,184,0.1);
    box-shadow:0 12px 35px rgba(15,23,42,0.08);
  }
  .users-hero__title { font-size:clamp(1.15rem,2.2vw,1.65rem); font-weight:700; color:#0f172a; margin-bottom:0.2rem; }
  .users-hero__subtitle { color:#475569; font-size:0.9rem; }
  .users-hero__cta { display:flex; align-items:center; gap:0.75rem; flex-wrap:wrap; margin-top:0.85rem; }
  .users-hero__cta small { color:#64748b; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; }
  .users-hero__stats { display:flex; flex-wrap:wrap; gap:0.75rem; }
  .users-add-btn {
    background: #0ea5e9;
    border-color: #0ea5e9;
    color: #fff;
    border-radius: 12px;
  }
  .users-add-btn:hover,
  .users-add-btn:focus {
    background: #0284c7;
    border-color: #0284c7;
    color: #fff;
  }
  .users-summary-card { background:#fff; border-radius:18px; border:1px solid rgba(148,163,184,0.16); box-shadow:0 14px 32px rgba(15,23,42,0.08); padding:0.9rem 1.2rem; min-width:160px; }
  .users-summary-label { text-transform:uppercase; letter-spacing:0.15em; font-size:0.62rem; color:#94a3b8; }
  .users-summary-value { font-size:1.35rem; font-weight:700; color:#0f172a; }
  .users-summary-icon {
    width:48px; height:48px; border-radius:50%;
    display:inline-flex; align-items:center; justify-content:center;
    font-size:1.15rem;
  }
  .users-shell .avtivity-card .media-body p {
    font-size:0.96rem !important;
  }
  .users-shell .avtivity-card .media-body .title {
    font-size:1.55rem !important;
    font-weight:700 !important;
  }
  .users-card-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(300px,1fr)); gap:0.9rem; min-width:0; }
  .user-card {
    background:#fafafa; border-radius:18px; border:1px solid rgba(148,163,184,0.16);
    box-shadow:0 12px 24px rgba(15,23,42,0.07); padding:0.95rem 1rem;
    display:grid;
    grid-template-columns:64px minmax(0,1fr);
    grid-template-areas:
      "avatar info"
      "actions actions";
    align-items:center;
    gap:0.75rem 0.85rem;
  }
  .user-avatar-wrap {
    grid-area: avatar;
    width:64px; height:64px; border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    border:1px solid rgba(148,163,184,0.3); background:#f8fafc; overflow:hidden;
  }
  .user-avatar { width:100%; height:100%; border-radius:50%; object-fit:cover; display:block; }
  .user-avatar--fallback {
    width:100%; height:100%; border-radius:50%;
    background:linear-gradient(135deg, #4f46e5 0%, #0ea5e9 100%);
    color:#fff; font-weight:700; letter-spacing:0.03em;
    display:flex; align-items:center; justify-content:center; font-size:1.05rem;
    text-transform:uppercase;
  }
  .user-info { grid-area: info; min-width:0; }
  .user-name {
    font-weight:700; color:#0f172a; font-size:1.08rem; line-height:1.25;
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
  }
  .user-email {
    color:#64748b; font-size:0.92rem; line-height:1.2; margin-top:0.2rem;
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
  }
  .user-role {
    display:inline-flex; align-items:center; margin-top:0.45rem;
    padding:0.25rem 0.62rem; border-radius:999px; font-size:0.8rem; font-weight:600;
    border:1px solid transparent;
  }
  .user-role--super { color:#1d4ed8; background:#dbeafe; border-color:#bfdbfe; }
  .user-role--petugas { color:#0f766e; background:#ccfbf1; border-color:#99f6e4; }
  .user-role--peminjam { color:#475569; background:#e2e8f0; border-color:#cbd5e1; }
  .user-actions {
    grid-area: actions;
    display:grid;
    grid-template-columns: repeat(3, minmax(82px, max-content));
    align-items:start;
    justify-content:start;
    gap:0.45rem;
    min-width:0;
    width: 100%;
  }
  .user-actions form { margin: 0; }
  .user-actions .btn-sm {
    padding:0.4rem 0.82rem; font-size:0.9rem; border-radius:9px;
    min-width:82px; font-weight:600;
    width: 100%;
  }
  .user-actions .btn-outline-primary {
    color:#0d6efd !important;
    border-color:#0d6efd !important;
    background:transparent !important;
  }
  .user-actions .btn-outline-primary:hover,
  .user-actions .btn-outline-primary:focus,
  .user-actions .btn-outline-primary:active {
    color:#fff !important;
    border-color:#0d6efd !important;
    background:#0d6efd !important;
  }
  .users-pagination { display:flex; justify-content:flex-end; margin-top:1rem; }
  body[data-theme="dark"] .users-hero,
  body[data-theme-version="dark"] .users-hero,
  body.theme-dark .users-hero { background:#111827; border-color:rgba(148,163,184,0.24); }
  body[data-theme="dark"] .users-hero__title,
  body[data-theme-version="dark"] .users-hero__title,
  body.theme-dark .users-hero__title { color:#f8fafc; }
  body[data-theme="dark"] .users-hero__subtitle,
  body[data-theme-version="dark"] .users-hero__subtitle,
  body.theme-dark .users-hero__subtitle { color:#94a3b8; }
  body[data-theme="dark"] .user-card,
  body[data-theme-version="dark"] .user-card,
  body.theme-dark .user-card {
    background:#0f172a;
    border-color:rgba(148,163,184,0.25);
    box-shadow:0 12px 24px rgba(2,6,23,0.45);
  }
  body[data-theme="dark"] .user-name,
  body[data-theme-version="dark"] .user-name,
  body.theme-dark .user-name { color:#f8fafc; }
  body[data-theme="dark"] .user-email,
  body[data-theme-version="dark"] .user-email,
  body.theme-dark .user-email { color:#cbd5e1; }
  body[data-theme="dark"] .user-avatar-wrap,
  body[data-theme-version="dark"] .user-avatar-wrap,
  body.theme-dark .user-avatar-wrap { background:#1e293b; border-color:#334155; }
  body[data-theme="dark"] .user-role--peminjam,
  body[data-theme-version="dark"] .user-role--peminjam,
  body.theme-dark .user-role--peminjam { color:#e2e8f0; background:#1e293b; border-color:#334155; }
  body[data-theme="dark"] .user-role--petugas,
  body[data-theme-version="dark"] .user-role--petugas,
  body.theme-dark .user-role--petugas { color:#99f6e4; background:rgba(13,148,136,0.2); border-color:rgba(45,212,191,0.35); }
  body[data-theme="dark"] .user-role--super,
  body[data-theme-version="dark"] .user-role--super,
  body.theme-dark .user-role--super { color:#bfdbfe; background:rgba(37,99,235,0.24); border-color:rgba(96,165,250,0.38); }
  body[data-theme="dark"] .user-actions .btn-outline-warning,
  body[data-theme-version="dark"] .user-actions .btn-outline-warning,
  body.theme-dark .user-actions .btn-outline-warning {
    color: #facc15;
    border-color: rgba(250,204,21,0.75);
  }
  body[data-theme="dark"] .user-actions .btn-outline-danger,
  body[data-theme-version="dark"] .user-actions .btn-outline-danger,
  body.theme-dark .user-actions .btn-outline-danger {
    color: #fb7185;
    border-color: rgba(244,63,94,0.7);
  }
  @media (max-width: 1400px) {
    .users-card-grid { grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); }
    .user-card {
      grid-template-columns:56px minmax(0,1fr);
      grid-template-areas:
        "avatar info"
        "actions actions";
      row-gap:0.7rem;
    }
    .user-avatar-wrap { width:56px; height:56px; }
    .user-actions {
      justify-content:start;
      grid-template-columns: repeat(3, minmax(78px, max-content));
    }
  }
  @media (max-width: 992px) {
    body[data-theme="light"] .app-main { margin-left:0!important; }
    .users-hero { align-items:flex-start; }
    .users-card-grid { grid-template-columns:1fr; }
  }
  @media (max-width: 640px) {
    .users-hero { padding:1rem; border-radius:16px; }
    .hero-action { width:100%; }
    .user-card {
      grid-template-columns:56px minmax(0,1fr);
      grid-template-areas:
        "avatar info"
        "actions actions";
      row-gap:0.7rem;
    }
    .user-avatar-wrap { width:56px; height:56px; }
    .user-actions {
      min-width:0;
      justify-content:start;
      grid-template-columns: repeat(3, minmax(76px, 1fr));
      width: 100%;
    }
  }
</style>
@endpush

@php($totalUsers = $users->total())
@php($peminjamCount = (int) ($roleCounts[\App\Models\User::ROLE_PEMINJAM] ?? 0))
@php($petugasCount = (int) ($roleCounts[\App\Models\User::ROLE_PETUGAS] ?? 0))
@php($superAdminCount = (int) ($roleCounts[\App\Models\User::ROLE_SUPER_ADMIN] ?? 0))
@php($totalPct = $totalUsers > 0 ? 100 : 0)
@php($peminjamPct = $totalUsers > 0 ? round(($peminjamCount / $totalUsers) * 100, 2) : 0)
@php($petugasPct = $totalUsers > 0 ? round(($petugasCount / $totalUsers) * 100, 2) : 0)
@php($superAdminPct = $totalUsers > 0 ? round(($superAdminCount / $totalUsers) * 100, 2) : 0)

@section('content')
<main class="content-body">
<div class="container-fluid">
<div class="users-shell">
  <section class="users-hero">
    <div>
      <div class="users-hero__title">Daftar Anggota</div>
      <div class="users-hero__subtitle">Kelola hak akses pengguna, reset password, dan penambahan anggota dalam satu panel yang rapi.</div>
      <div class="users-hero__cta">
        <a href="{{ route('users.create') }}" class="btn users-add-btn px-4 d-flex align-items-center gap-2">
          <span class="fs-5">+</span>
          <span>Tambah Anggota</span>
        </a>
        <small>Manajemen akun tim internal</small>
      </div>
    </div>
    <div class="users-hero__stats">
      <div class="users-summary-card">
        <div class="users-summary-label">Total akun</div>
        <div class="users-summary-value">{{ number_format($totalUsers) }}</div>
      </div>
      <div class="users-summary-card">
        <div class="users-summary-label">Pegawai</div>
        <div class="users-summary-value">{{ number_format($peminjamCount) }}</div>
      </div>
      <div class="users-summary-card">
        <div class="users-summary-label">Admin aktif</div>
        <div class="users-summary-value">{{ number_format($petugasCount + $superAdminCount) }}</div>
      </div>
    </div>
  </section>

  <section class="row g-3">
    <div class="col-sm-6 col-lg-3">
      <div class="card avtivity-card h-100">
        <div class="card-body">
          <div class="media align-items-center">
            <span class="activity-icon bgl-secondary me-md-4 me-3 users-summary-icon">
              <i class="fas fa-users text-secondary"></i>
            </span>
            <div class="media-body">
              <p class="fs-14 mb-2">Total Akun</p>
              <span class="title text-black font-w600">{{ number_format($totalUsers) }}</span>
            </div>
          </div>
          <div class="progress" style="height:5px;">
            <div class="progress-bar bg-secondary rounded" style="width: {{ $totalPct }}%; height:5px;" role="progressbar" aria-valuenow="{{ $totalPct }}" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
        <div class="effect bg-secondary"></div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="card avtivity-card h-100">
        <div class="card-body">
          <div class="media align-items-center">
            <span class="activity-icon bgl-info me-md-4 me-3 users-summary-icon">
              <i class="fas fa-user text-info"></i>
            </span>
            <div class="media-body">
              <p class="fs-14 mb-2">Pegawai</p>
              <span class="title text-black font-w600">{{ number_format($peminjamCount) }}</span>
            </div>
          </div>
          <div class="progress" style="height:5px;">
            <div class="progress-bar bg-info rounded" style="width: {{ $peminjamPct }}%; height:5px;" role="progressbar" aria-valuenow="{{ $peminjamPct }}" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
        <div class="effect bg-info"></div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="card avtivity-card h-100">
        <div class="card-body">
          <div class="media align-items-center">
            <span class="activity-icon bgl-success me-md-4 me-3 users-summary-icon">
              <i class="fas fa-user-shield text-success"></i>
            </span>
            <div class="media-body">
              <p class="fs-14 mb-2">Admin Sarpras</p>
              <span class="title text-black font-w600">{{ number_format($petugasCount) }}</span>
            </div>
          </div>
          <div class="progress" style="height:5px;">
            <div class="progress-bar bg-success rounded" style="width: {{ $petugasPct }}%; height:5px;" role="progressbar" aria-valuenow="{{ $petugasPct }}" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
        <div class="effect bg-success"></div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="card avtivity-card h-100">
        <div class="card-body">
          <div class="media align-items-center">
            <span class="activity-icon bgl-primary me-md-4 me-3 users-summary-icon">
              <i class="fas fa-crown text-primary"></i>
            </span>
            <div class="media-body">
              <p class="fs-14 mb-2">Super Admin</p>
              <span class="title text-black font-w600">{{ number_format($superAdminCount) }}</span>
            </div>
          </div>
          <div class="progress" style="height:5px;">
            <div class="progress-bar bg-primary rounded" style="width: {{ $superAdminPct }}%; height:5px;" role="progressbar" aria-valuenow="{{ $superAdminPct }}" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
        <div class="effect bg-primary"></div>
      </div>
    </div>
  </section>

  <section class="users-card-grid">
    @foreach($users as $u)
      <div class="user-card">
        <div class="user-avatar-wrap">
          @if($u->photo)
            <img class="user-avatar" src="{{ asset('storage/'.$u->photo) }}" alt="Foto {{ $u->name }}">
          @else
            @php($parts = preg_split('/\s+/', trim($u->name)))
            @php($initials = strtoupper(mb_substr($parts[0]??'',0,1).mb_substr($parts[1]??'',0,1)))
            <div class="user-avatar--fallback">{{ $initials ?: '?' }}</div>
          @endif
        </div>
        <div class="user-info">
          <div class="user-name" title="{{ $u->name }}">{{ $u->name }}</div>
          <div class="user-email" title="{{ $u->email }}">{{ $u->email }}</div>
          <span class="user-role {{ $u->role === \App\Models\User::ROLE_SUPER_ADMIN ? 'user-role--super' : ($u->role === \App\Models\User::ROLE_PETUGAS ? 'user-role--petugas' : 'user-role--peminjam') }}">{{ $u->role_label }}</span>
        </div>
        <div class="user-actions">
          <a href="{{ route('users.edit', $u) }}" class="btn btn-sm btn-outline-primary">Edit</a>
          <form method="POST" action="{{ route('users.reset', $u) }}" data-confirm-form data-confirm-message="Reset password untuk {{ $u->name }}?">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-warning">Reset</button>
          </form>
          <form method="POST" action="{{ route('users.destroy', $u) }}" data-confirm-form data-confirm-message="Hapus anggota {{ $u->name }}?">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
          </form>
        </div>
      </div>
    @endforeach
  </section>

  <div class="users-pagination">
    {{ $users->links() }}
  </div>
</div>
<x-confirm-modal />
</div>
</main>
@endsection
