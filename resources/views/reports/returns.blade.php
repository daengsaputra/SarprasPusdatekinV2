@php($title = 'Laporan Pengembalian')
@php($returns = $records ?? collect())
@extends('layouts.app')

@section('content')
<main class="content-body">
<div class="container-fluid">
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h4">Laporan Pengembalian</h1>
  <div class="d-flex align-items-center gap-2">
    <a class="btn btn-outline-secondary btn-sm" href="{{ route('reports.returns', ['range' => 'week']) }}">Seminggu</a>
    <a class="btn btn-outline-secondary btn-sm" href="{{ route('reports.returns', ['range' => 'month']) }}">Sebulan</a>
    <a class="btn btn-outline-secondary btn-sm" href="{{ route('reports.returns', ['range' => 'year']) }}">Setahun</a>
    <a class="btn btn-primary btn-sm" href="{{ route('reports.returns.pdf', request()->all()) }}">Download PDF</a>
  </div>
</div>

<form method="GET" class="row g-2 align-items-end mb-3">
  <input type="hidden" name="range" value="custom">
  <div class="col-md-3">
    <label class="form-label">Dari</label>
    <input type="date" name="start" value="{{ request('start', $start->toDateString()) }}" class="form-control">
  </div>
  <div class="col-md-3">
    <label class="form-label">Sampai</label>
    <input type="date" name="end" value="{{ request('end', $end->toDateString()) }}" class="form-control">
  </div>
  <div class="col-md-3">
    <label class="form-label">Cari</label>
    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="aset/peminjam">
  </div>
  <div class="col-md-3">
    <label class="form-label">Unit Kerja</label>
    <select name="unit" class="form-select">
      <option value="">Semua</option>
      @foreach(($units ?? config('bpip.units')) as $u)
        <option value="{{ $u }}" {{ request('unit')===$u?'selected':'' }}>{{ $u }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-2">
    <button class="btn btn-primary w-100" type="submit">Terapkan</button>
  </div>
</form>

<div class="row g-3 mb-3">
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <div class="text-muted small">Periode</div>
        <div class="fw-bold">{{ $summary['periode'] }}</div>
        <div class="small">{{ $summary['start'] }} s/d {{ $summary['end'] }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <div class="text-muted small">Total Transaksi</div>
        <div class="fs-4 fw-bold">{{ $summary['total_transaksi'] }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <div class="text-muted small">Total Jumlah Barang</div>
        <div class="fs-4 fw-bold">{{ $summary['total_jumlah'] }}</div>
      </div>
    </div>
  </div>
</div>

<div class="table-responsive">
<table class="table table-striped align-middle">
  <thead>
  <tr>
    @php($sort=request('sort'))
    @php($dir=request('dir','desc'))
    @php($link=function($key,$label) use($sort,$dir){
      $next = ($sort===$key && $dir==='asc') ? 'desc' : 'asc';
      $q = array_merge(request()->all(), ['sort'=>$key,'dir'=>$next]);
      $arrow = $sort===$key ? ($dir==='asc'?'&uarr;':'&darr;') : '&bull;';
      return '<a href="'.route('reports.returns',$q).'" class="text-decoration-none">'.$label.' <span class="text-muted">'.$arrow.'</span></a>';
    })
    <th>{!! $link('return_date_actual','Tanggal Kembali') !!}</th>
    <th>{!! $link('asset','Aset') !!}</th>
    <th>{!! $link('borrower_name','Peminjam') !!}</th>
    <th>{!! $link('quantity','Jumlah') !!}</th>
    <th>Aksi</th>
  </tr>
  </thead>
  <tbody>
  @forelse($returns as $row)
    <tr>
      <td>{{ $row->return_date_actual?->format('Y-m-d') }}</td>
      <td>{{ $row->asset->code }} - {{ $row->asset->name }}</td>
      <td>{{ $row->borrower_name }}</td>
      <td>{{ $row->quantity }}</td>
      <td>
        <span class="text-muted small">Tidak tersedia</span>
      </td>
    </tr>
  @empty
    <tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>
  @endforelse
  </tbody>
</table>
</div>

{{ $returns->links() }}
</div>
</main>
@endsection
