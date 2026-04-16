@extends('layouts.app')

@section('title', 'Informasi Profil')

@push('styles')
<style>
  body[data-theme="light"] { background:#eef2ff; }
  .profile-page { display:flex; flex-direction:column; gap:1rem; }
  .profile-hero {
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:0.8rem;
    border:1px solid rgba(148,163,184,0.16);
    border-radius:20px;
    background:#ffffff;
    box-shadow:0 12px 28px rgba(15,23,42,0.08);
    padding:1rem 1.2rem;
  }
  .profile-hero__title { font-size:1.35rem; font-weight:700; color:#0f172a; margin:0; }
  .profile-hero__subtitle { color:#64748b; margin:0.2rem 0 0; }
  .profile-back-btn { border-radius:10px; }

  .profile-card {
    border:1px solid rgba(148,163,184,0.16);
    border-radius:20px;
    background:#ffffff;
    box-shadow:0 14px 34px rgba(15,23,42,0.08);
    overflow:hidden;
  }
  .profile-card .card-header { padding:1rem 1.2rem 0.7rem; border-bottom:1px solid rgba(148,163,184,0.14); }
  .profile-card .card-body { padding:1rem 1.2rem 1.2rem; }

  .profile-main {
    display:grid;
    grid-template-columns:90px minmax(0,1fr);
    gap:0.9rem;
    align-items:center;
    margin-bottom:1rem;
  }
  .profile-avatar {
    width:90px;
    height:90px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(135deg, #2563eb, #06b6d4);
    color:#ffffff;
    font-size:2rem;
    font-weight:700;
    text-transform:uppercase;
    overflow:hidden;
  }
  .profile-avatar__img {
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
  }
  .profile-name { font-size:1.25rem; font-weight:700; color:#0f172a; margin:0 0 0.2rem; }
  .profile-role {
    display:inline-flex;
    align-items:center;
    background:rgba(59,130,246,0.12);
    color:#1d4ed8;
    border:1px solid rgba(59,130,246,0.26);
    border-radius:999px;
    padding:0.2rem 0.65rem;
    font-size:0.75rem;
    font-weight:700;
    letter-spacing:0.06em;
    text-transform:uppercase;
  }

  .profile-grid {
    display:grid;
    grid-template-columns:repeat(2, minmax(180px,1fr));
    gap:0.75rem;
  }
  .profile-item {
    border:1px solid rgba(148,163,184,0.2);
    border-radius:12px;
    background:#f8fafc;
    padding:0.75rem 0.85rem;
    min-width:0;
  }
  .profile-item__label {
    color:#64748b;
    font-size:0.78rem;
    text-transform:uppercase;
    letter-spacing:0.08em;
    margin-bottom:0.25rem;
  }
  .profile-item__value {
    color:#0f172a;
    font-weight:600;
    overflow-wrap:anywhere;
  }

  @media (max-width: 768px) {
    .profile-main { grid-template-columns:1fr; text-align:center; }
    .profile-avatar { margin:0 auto; }
    .profile-grid { grid-template-columns:1fr; }
  }
</style>
@endpush

@section('content')
<main class="content-body">
  <div class="container-fluid">
    @php($user = auth()->user())
    <div class="profile-page">
      <section class="profile-hero">
        <div>
          <h2 class="profile-hero__title">Informasi Profil</h2>
          <p class="profile-hero__subtitle">Detail akun pengguna yang sedang login.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm profile-back-btn">Kembali ke Dashboard</a>
      </section>

      <section class="card profile-card">
        <div class="card-header">
          <h4 class="mb-0">Data Pengguna</h4>
        </div>
        <div class="card-body">
          <div class="profile-main">
            <div class="profile-avatar">
              @if($user?->photo)
                <img class="profile-avatar__img" src="{{ asset('storage/'.$user->photo) }}" alt="Foto {{ $user->name }}">
              @else
                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
              @endif
            </div>
            <div>
              <p class="profile-name">{{ $user->name ?? 'User' }}</p>
              <span class="profile-role">{{ $user?->role_label ?? 'Pengguna' }}</span>
            </div>
          </div>

          <div class="profile-grid">
            <div class="profile-item">
              <div class="profile-item__label">Email</div>
              <div class="profile-item__value">{{ $user->email ?? '-' }}</div>
            </div>
            <div class="profile-item">
              <div class="profile-item__label">Role</div>
              <div class="profile-item__value">{{ $user?->role_label ?? '-' }}</div>
            </div>
            <div class="profile-item">
              <div class="profile-item__label">Bergabung Sejak</div>
              <div class="profile-item__value">{{ optional($user->created_at)->format('d M Y H:i') ?? '-' }}</div>
            </div>
            <div class="profile-item">
              <div class="profile-item__label">ID Pengguna</div>
              <div class="profile-item__value">{{ $user->id ?? '-' }}</div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</main>
@endsection
