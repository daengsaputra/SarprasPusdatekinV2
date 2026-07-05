@php($title = 'Kelola Role SSO')
@extends('layouts.app')

@section('content')
<main class="content-body">
<div class="container-fluid py-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h5 mb-0">Kelola Role SSO (NIP &rarr; Role)</h1>
  </div>

  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <div class="card mb-3">
    <div class="card-body">
      <h2 class="h6 mb-3">Tambah / Update Mapping</h2>
      <form method="POST" action="{{ route('settings.sso-roles.store') }}" class="row g-2 align-items-end">
        @csrf
        <div class="col-md-3">
          <label class="form-label">NIP</label>
          <input type="text" name="nip" class="form-control" required maxlength="32" placeholder="cth: 199803122024211001">
        </div>
        <div class="col-md-2">
          <label class="form-label">Role</label>
          <select name="role" class="form-select" required>
            @foreach ($roleLabels as $value => $label)
              <option value="{{ $value }}">{{ $label }} ({{ $value }})</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Nama (opsional)</label>
          <input type="text" name="name" class="form-control" maxlength="191">
        </div>
        <div class="col-md-3">
          <label class="form-label">Catatan (opsional)</label>
          <input type="text" name="note" class="form-control" maxlength="191">
        </div>
        <div class="col-md-1 d-grid">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
      <small class="text-muted d-block mt-2">
        Jika NIP sudah ada di tabel, role-nya akan di-update. User dengan NIP yang sama (jika sudah pernah login) akan otomatis ikut berubah rolenya.
      </small>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <form method="GET" class="mb-3">
        <div class="input-group" style="max-width:420px">
          <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="cari NIP atau nama...">
          <button type="submit" class="btn btn-outline-secondary">Cari</button>
          @if ($q !== '')
            <a href="{{ route('settings.sso-roles.index') }}" class="btn btn-outline-secondary">Reset</a>
          @endif
        </div>
      </form>

      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>NIP</th>
              <th>Nama</th>
              <th>Role</th>
              <th>Catatan</th>
              <th>Dibuat oleh</th>
              <th class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($overrides as $row)
              <tr>
                <td><code>{{ $row->nip }}</code></td>
                <td>{{ $row->name ?? '-' }}</td>
                <td>
                  <form method="POST" action="{{ route('settings.sso-roles.update', $row) }}" class="d-flex gap-1 align-items-center">
                    @csrf @method('PUT')
                    <select name="role" class="form-select form-select-sm">
                      @foreach ($roleLabels as $value => $label)
                        <option value="{{ $value }}" @selected($row->role === $value)>{{ $label }}</option>
                      @endforeach
                    </select>
                    <input type="hidden" name="name" value="{{ $row->name }}">
                    <input type="hidden" name="note" value="{{ $row->note }}">
                    <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                  </form>
                </td>
                <td>{{ $row->note ?? '-' }}</td>
                <td>{{ optional($row->creator)->name ?? '-' }}</td>
                <td class="text-end">
                  <form method="POST" action="{{ route('settings.sso-roles.destroy', $row) }}"
                        onsubmit="return confirm('Hapus mapping NIP {{ $row->nip }}?')" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="6" class="text-center text-muted">Belum ada mapping.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $overrides->links() }}
    </div>
  </div>
</div>
</main>
@endsection
