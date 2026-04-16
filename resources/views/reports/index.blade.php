@php($title = 'Laporan')
@php($rows = $records ?? collect())
@php($type = $type ?? request('type', 'all'))
@php($range = request('range', 'month'))
@php($rangeLabel = $range === 'week' ? 'Seminggu' : ($range === 'year' ? 'Setahun' : 'Sebulan'))
@extends('layouts.app')

@push('styles')
<style>
  body[data-theme="light"] { background:#eef2ff; }
  .reports-shell { display:flex; flex-direction:column; gap:1.2rem; padding-bottom:2.2rem; min-width:0; }
  .reports-hero {
    display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.9rem;
    padding:1.35rem 1.6rem; border-radius:24px;
    background:linear-gradient(120deg, rgba(59,130,246,0.12), #fff 70%);
    border:1px solid rgba(148,163,184,0.1); box-shadow:0 12px 35px rgba(15,23,42,0.08);
  }
  .reports-hero__title { font-size:clamp(1.15rem,2.2vw,1.65rem); font-weight:700; color:#0f172a; margin-bottom:0.2rem; }
  .reports-hero__subtitle { color:#475569; font-size:0.9rem; }
  .reports-hero__cta { display:flex; align-items:center; gap:0.75rem; flex-wrap:wrap; margin-top:0.85rem; }
  .reports-hero__cta small { color:#64748b; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; }
  .reports-hero__stats { display:flex; flex-wrap:wrap; gap:0.75rem; }
  .reports-summary-card { background:#fff; border-radius:18px; border:1px solid rgba(148,163,184,0.16); box-shadow:0 14px 32px rgba(15,23,42,0.08); padding:0.9rem 1.2rem; min-width:160px; }
  .reports-summary-label { text-transform:uppercase; letter-spacing:0.15em; font-size:0.62rem; color:#94a3b8; }
  .reports-summary-value { font-size:1.35rem; font-weight:700; color:#0f172a; }
  .reports-filter-card, .reports-table-card {
    background:#fff; border:1px solid rgba(148,163,184,0.15); border-radius:22px;
    box-shadow:0 12px 28px rgba(15,23,42,0.08); padding:1rem 1.15rem; font-size:0.96rem; min-width:0;
  }
  .reports-filter-form { display:grid; grid-template-columns:repeat(6,minmax(110px,1fr)) auto; gap:.75rem; align-items:end; min-width:0; }
  .reports-date-field { min-width: 0; }
  .reports-date-field .input-group-text {
    border-top-left-radius: 12px;
    border-bottom-left-radius: 12px;
    background: #f8fafc;
    color: #64748b;
    flex: 0 0 auto;
  }
  .reports-date-field .form-control {
    border-top-right-radius: 12px;
    border-bottom-right-radius: 12px;
    min-width: 0;
  }
  .reports-filter-actions { display:flex; gap:.5rem; }
  .reports-stats { display:grid; grid-template-columns:repeat(auto-fit,minmax(170px,1fr)); gap:.8rem; }
  .reports-stat { background:#fff; border-radius:14px; border:1px solid rgba(148,163,184,0.18); padding:.75rem .9rem; }
  .reports-table-card table th { text-transform:uppercase; letter-spacing:.08em; font-size:.86rem; color:#64748b; }
  .reports-table-card table td { font-size:.95rem; vertical-align:middle; }
  @media (max-width: 1440px) {
    .reports-filter-form {
      grid-template-columns:repeat(4,minmax(120px,1fr));
    }
    .reports-filter-actions {
      grid-column: 1 / -1;
      justify-content: flex-end;
    }
  }
  @media (max-width: 1200px) {
    .reports-filter-form {
      grid-template-columns:repeat(2,minmax(0,1fr));
    }
    .reports-filter-card,
    .reports-table-card {
      padding:.9rem;
      border-radius:18px;
    }
    .reports-filter-actions {
      grid-column: 1 / -1;
      justify-content: stretch;
    }
    .reports-filter-actions .btn {
      flex: 1;
    }
  }
  @media (max-width: 992px) {
    .reports-filter-form { grid-template-columns:1fr; }
    .reports-filter-actions { justify-content:stretch; }
    .reports-filter-actions .btn { flex:1; }
  }
</style>
@endpush

@section('content')
<main class="content-body">
<div class="container-fluid">
<div class="reports-shell">
  <section class="reports-hero">
    <div>
      <div class="reports-hero__title">Laporan Peminjaman & Pengembalian</div>
      <div class="reports-hero__subtitle">Ringkasan transaksi sarpras dengan filter periode dan ekspor cepat.</div>
      <div class="reports-hero__cta">
        <div class="dropdown">
          <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Periode: {{ $rangeLabel }}
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('reports.index', array_merge(request()->all(), ['range' => 'week'])) }}">Seminggu</a></li>
            <li><a class="dropdown-item" href="{{ route('reports.index', array_merge(request()->all(), ['range' => 'month'])) }}">Sebulan</a></li>
            <li><a class="dropdown-item" href="{{ route('reports.index', array_merge(request()->all(), ['range' => 'year'])) }}">Setahun</a></li>
          </ul>
        </div>
        <a class="btn btn-outline-primary btn-sm" href="{{ route('reports.excel', request()->all()) }}">Export Excel</a>
        <a class="btn btn-primary btn-sm" href="{{ route('reports.pdf', request()->all()) }}">Download PDF</a>
        <small>Filter periode & unduh laporan cepat</small>
      </div>
    </div>
    <div class="reports-hero__stats">
      <div class="reports-summary-card">
        <div class="reports-summary-label">Total transaksi</div>
        <div class="reports-summary-value">{{ number_format((int) ($summary['total_transaksi'] ?? 0)) }}</div>
      </div>
      <div class="reports-summary-card">
        <div class="reports-summary-label">Total jumlah</div>
        <div class="reports-summary-value">{{ number_format((int) ($summary['total_jumlah'] ?? 0)) }}</div>
      </div>
      <div class="reports-summary-card">
        <div class="reports-summary-label">Sudah kembali</div>
        <div class="reports-summary-value">{{ number_format((int) ($summary['total_dikembalikan'] ?? 0)) }}</div>
      </div>
    </div>
  </section>

<section class="reports-filter-card">
<form method="GET" class="reports-filter-form">
  <input type="hidden" name="range" value="custom">
  <div>
    <label class="form-label">Jenis Laporan</label>
    <select name="type" class="form-select">
      <option value="all" {{ $type==='all'?'selected':'' }}>Semua</option>
      <option value="loans" {{ $type==='loans'?'selected':'' }}>Peminjaman</option>
      <option value="returns" {{ $type==='returns'?'selected':'' }}>Pengembalian</option>
    </select>
  </div>
  <div class="reports-date-field">
    <label class="form-label">Dari</label>
    <div class="input-group">
      <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
      <input type="date" name="start" id="reportStartDate" value="{{ request('start', $start->toDateString()) }}" class="form-control" lang="id">
    </div>
  </div>
  <div class="reports-date-field">
    <label class="form-label">Sampai</label>
    <div class="input-group">
      <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
      <input type="date" name="end" id="reportEndDate" value="{{ request('end', $end->toDateString()) }}" class="form-control" lang="id">
    </div>
  </div>
  <div>
    <label class="form-label">Cari</label>
    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="aset/peminjam">
  </div>
  <div>
    <label class="form-label">Unit Kerja</label>
    <select name="unit" class="form-select">
      <option value="">Semua</option>
      @foreach(($units ?? config('bpip.units')) as $u)
        <option value="{{ $u }}" {{ request('unit')===$u?'selected':'' }}>{{ $u }}</option>
      @endforeach
    </select>
  </div>
  <div>
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
      <option value="">Semua</option>
      <option value="borrowed" {{ request('status')==='borrowed'?'selected':'' }}>Dipinjam</option>
      <option value="partial" {{ request('status')==='partial'?'selected':'' }}>Sebagian</option>
      <option value="returned" {{ request('status')==='returned'?'selected':'' }}>Kembali</option>
    </select>
  </div>
  <div class="reports-filter-actions">
    <a class="btn btn-outline-secondary" href="{{ route('reports.index') }}">Reset</a>
    <button class="btn btn-primary" type="submit">Terapkan</button>
  </div>
</form>
</section>

<section class="reports-stats">
  <div class="reports-stat">
      <div class="text-muted small">Periode</div>
      <div class="fw-bold">{{ $summary['periode'] }}</div>
      <div class="small">{{ $summary['start'] }} s/d {{ $summary['end'] }}</div>
  </div>
  <div class="reports-stat">
      <div class="text-muted small">Total Transaksi</div>
      <div class="fs-4 fw-bold">{{ $summary['total_transaksi'] }}</div>
  </div>
  <div class="reports-stat">
      <div class="text-muted small">Total Jumlah Barang</div>
      <div class="fs-4 fw-bold">{{ $summary['total_jumlah'] }}</div>
  </div>
  <div class="reports-stat">
      <div class="text-muted small">Total Sudah Kembali</div>
      <div class="fs-4 fw-bold">{{ $summary['total_dikembalikan'] }}</div>
  </div>
</section>

<section class="reports-table-card">
<div class="table-responsive">
<table class="table table-striped align-middle">
  <thead>
  <tr>
    @php($sort=request('sort'))
    @php($dir=request('dir','desc'))
    @php($sortLink=function($key,$label) use($sort,$dir){
      $next = ($sort===$key && $dir==='asc') ? 'desc' : 'asc';
      $q = array_merge(request()->all(), ['sort'=>$key,'dir'=>$next]);
      $arrow = $sort===$key ? ($dir==='asc'?'↑':'↓') : '•';
      return '<a href="'.route('reports.index',$q).'" class="text-decoration-none">'.$label.' <span class="text-muted">'.$arrow.'</span></a>';
    })
    <th>{!! $sortLink('loan_date','Tanggal Pinjam') !!}</th>
    <th>{!! $sortLink('return_date_actual','Tanggal Kembali') !!}</th>
    <th>{!! $sortLink('asset','Aset') !!}</th>
    <th>{!! $sortLink('borrower_name','Peminjam') !!}</th>
    <th>{!! $sortLink('unit','Unit') !!}</th>
    <th>{!! $sortLink('quantity','Jumlah') !!}</th>
    <th>{!! $sortLink('status','Status') !!}</th>
  </tr>
  </thead>
  <tbody>
  @forelse($rows as $row)
    @php($statusMap = ['borrowed' => 'Dipinjam', 'partial' => 'Sebagian', 'returned' => 'Kembali'])
    <tr>
      <td>{{ $row->loan_date?->format('Y-m-d') ?? '-' }}</td>
      <td>{{ $row->return_date_actual?->format('Y-m-d') ?? '-' }}</td>
      <td>{{ ($row->asset->code ?? '-') }} - {{ ($row->asset->name ?? '-') }}</td>
      <td>{{ $row->borrower_name }}</td>
      <td>{{ $row->unit ?? '-' }}</td>
      <td>{{ $row->quantity }}</td>
      <td>
        @php($badge = $row->status === 'returned' ? 'text-bg-success' : ($row->status === 'partial' ? 'text-bg-info' : 'text-bg-warning'))
        <span class="badge {{ $badge }}">{{ $statusMap[$row->status] ?? $row->status }}</span>
      </td>
    </tr>
  @empty
    <tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>
  @endforelse
  </tbody>
</table>
</div>

{{ $rows->links() }}
</section>
</div>
</div>
</main>
@endsection

@push('scripts')
<script>
  (function () {
    const startInput = document.getElementById('reportStartDate');
    const endInput = document.getElementById('reportEndDate');
    if (!startInput || !endInput) {
      return;
    }

    const syncEndMin = () => {
      const startValue = startInput.value;
      if (!startValue) {
        endInput.removeAttribute('min');
        return;
      }
      endInput.min = startValue;
      if (!endInput.value || endInput.value < startValue) {
        endInput.value = startValue;
      }
    };

    startInput.addEventListener('change', syncEndMin);
    syncEndMin();

  })();
</script>
@endpush
