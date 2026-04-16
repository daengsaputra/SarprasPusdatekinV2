@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    .dashboard-welcome-card {
        border: 1px solid rgba(148, 163, 184, 0.28);
        border-radius: 14px;
        background: #ffffff;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
        padding: 0.85rem 1rem;
    }
    .dashboard-welcome-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.1rem;
    }
    .dashboard-welcome-sub {
        font-size: 0.84rem;
        color: #64748b;
    }
    .dashboard-clock {
        border: 1px solid rgba(148, 163, 184, 0.28);
        border-radius: 14px;
        background: #ffffff;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
        padding: 0.85rem 1rem;
    }
    .dashboard-clock__label {
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #64748b;
        margin-bottom: 0.15rem;
        font-weight: 600;
    }
    .dashboard-clock__value {
        font-size: 1rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.25;
    }
</style>
@endpush

@section('content')
<main class="content-body">
    <div class="container-fluid">
        <div class="row g-3 mb-3 align-items-stretch">
            <div class="col-lg-8">
                <div class="dashboard-welcome-card h-100">
                    <div class="dashboard-welcome-title">Selamat Datang di Sarpras Pusdatekin</div>
                    <div class="dashboard-welcome-sub">Halo, {{ auth()->user()->name ?? 'User' }}. Pantau ringkasan sarpras dari dashboard ini.</div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="dashboard-clock h-100" aria-live="polite">
                    <div class="dashboard-clock__label">Hari & Jam</div>
                    <div class="dashboard-clock__value" id="dashboardClock">-</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card overflow-hidden avtivity-card">
                            <div class="card-body">
                                <div class="d-flex gap-md-4 gap-3 align-items-center">
                                    <span class="avatar avatar-lg avatar-success rounded-circle border-0">
                                        <img src="{{ asset('evanto/assets/images/card/1.avif') }}" alt="progress">
                                    </span>
                                    <div>
                                        <p class="fs-16 mb-2 fw-semibold text-black">Total Barang</p>
                                        <span class="title text-black fs-32 fw-bold">{{ number_format($totalBarang, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="progress position-absolute bottom-0 start-0 w-100" style="height:5px;">
                                    <div class="progress-bar bg-success rounded" style="width: {{ $totalBarang > 0 ? 100 : 0 }}%; height:5px;"></div>
                                </div>
                            </div>
                            <div class="effect bg-success"></div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="card overflow-hidden avtivity-card">
                            <div class="card-body">
                                <div class="d-flex gap-md-4 gap-3 align-items-center">
                                    <span class="avatar avatar-lg avatar-secondary rounded-circle border-0">
                                        <img src="{{ asset('evanto/assets/images/card/2.avif') }}" alt="running">
                                    </span>
                                    <div>
                                        <p class="fs-16 mb-2 fw-semibold text-black">Total Barang Aset</p>
                                        <span class="title text-black fs-32 fw-bold">{{ number_format($totalBarangAset, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="progress position-absolute bottom-0 start-0 w-100" style="height:5px;">
                                    <div class="progress-bar bg-secondary rounded" style="width: {{ $asetPercent }}%; height:5px;"></div>
                                </div>
                            </div>
                            <div class="effect bg-secondary"></div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="card overflow-hidden avtivity-card">
                            <div class="card-body">
                                <div class="d-flex gap-md-4 gap-3 align-items-center">
                                    <span class="avatar avatar-lg avatar-danger rounded-circle border-0">
                                        <img src="{{ asset('evanto/assets/images/card/3.avif') }}" alt="cycling">
                                    </span>
                                    <div>
                                        <p class="fs-16 mb-2 fw-semibold text-black">Barang Dipinjam</p>
                                        <span class="title text-black fs-32 fw-bold">{{ number_format($totalBarangDipinjam, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="progress position-absolute bottom-0 start-0 w-100" style="height:5px;">
                                    <div class="progress-bar bg-danger rounded" style="width: {{ $dipinjamPercent }}%; height:5px;"></div>
                                </div>
                            </div>
                            <div class="effect bg-danger"></div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="card overflow-hidden avtivity-card">
                            <div class="card-body">
                                <div class="d-flex gap-md-4 gap-3 align-items-center">
                                    <span class="avatar avatar-lg avatar-warning rounded-circle border-0">
                                        <img src="{{ asset('evanto/assets/images/card/4.webp') }}" alt="yoga">
                                    </span>
                                    <div>
                                        <p class="fs-16 mb-2 fw-semibold text-black">Barang Kembali</p>
                                        <span class="title text-black fs-32 fw-bold">{{ number_format($totalBarangKembali, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="progress position-absolute bottom-0 start-0 w-100" style="height:5px;">
                                    <div class="progress-bar bg-warning rounded" style="width: {{ $kembaliPercent }}%; height:5px;"></div>
                                </div>
                            </div>
                            <div class="effect bg-warning"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header d-sm-flex justify-content-sm-between d-block pb-0 border-0">
                        <div class="pb-3 pb-sm-0">
                            <h4 class="card-title">Daftar Anggota</h4>
                            <p class="fs-13 mb-0">Anggota terbaru sistem SARPRAS.</p>
                        </div>
                        <div class="mb-3 d-flex gap-2 flex-wrap">
                            <span class="badge light badge-primary">Total: {{ number_format($totalMembers, 0, ',', '.') }} akun</span>
                            <a href="{{ route('users.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
                            <a href="{{ route('users.create') }}" class="btn btn-outline-success btn-sm">Tambah Anggota</a>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <div class="row g-3">
                            @forelse($dashboardMembers as $member)
                                <div class="col-md-6 col-xl-4 col-xxl-3">
                                    <div class="border rounded-3 p-3 h-100 d-flex align-items-center gap-3">
                                        <div class="avatar avatar-lg rounded-circle overflow-hidden flex-shrink-0">
                                            @if($member->photo)
                                                <img src="{{ asset('storage/' . $member->photo) }}" alt="Foto {{ $member->name }}" class="w-100 h-100" style="object-fit: cover;">
                                            @else
                                                <span class="avatar-title rounded-circle bg-primary-subtle text-primary fw-semibold w-100 h-100 d-flex align-items-center justify-content-center">
                                                    {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($member->name ?? '?', 0, 1)) }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <h6 class="mb-1 text-truncate"><a href="{{ route('users.index') }}" class="text-black">{{ $member->name }}</a></h6>
                                            <div class="fs-13 text-muted text-truncate">{{ $member->email }}</div>
                                            <span class="badge light badge-info mt-2">{{ $member->role_label }}</span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-muted mb-0">Belum ada data anggota.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header d-sm-flex justify-content-sm-between d-block pb-0 border-0">
                        <div class="pb-3 pb-sm-0">
                            <h4 class="card-title">Tren Peminjaman &amp; Pengembalian</h4>
                            <p class="fs-13 mb-0">Ringkasan transaksi minggu ini (Min-Sab).</p>
                        </div>
                        <div class="mb-3 d-flex gap-2 flex-wrap">
                            <span class="badge light badge-primary">Peminjaman: {{ number_format($weeklyLoanTotal, 0, ',', '.') }}</span>
                            <span class="badge light badge-success">Pengembalian: {{ number_format($weeklyReturnTotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="card-body pt-0 pb-0">
                        <div
                            id="chartLoanReturn"
                            data-labels='@json($weeklyLabels)'
                            data-loans='@json($weeklyLoanSeries)'
                            data-returns='@json($weeklyReturnSeries)'
                        ></div>
                        <div id="chartBar" class="d-none" aria-hidden="true"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('script')
<script src="{{ asset('evanto/assets/js/dashboard/dashboard-1.js') }}"></script>
<script>
    (function () {
        var clockEl = document.getElementById('dashboardClock');
        if (!clockEl) return;

        var formatter = new Intl.DateTimeFormat('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false,
        });

        function tick() {
            clockEl.textContent = formatter.format(new Date()).replace('.', ':');
        }

        tick();
        setInterval(tick, 1000);
    })();
</script>
<script>
  (function () {
    function renderLoanReturnChart() {
      var chartEl = document.querySelector('#chartLoanReturn');
      if (!chartEl || typeof ApexCharts === 'undefined') {
        return;
      }

      var labels = [];
      var loans = [];
      var returns = [];
      try {
        labels = JSON.parse(chartEl.dataset.labels || '[]');
        loans = JSON.parse(chartEl.dataset.loans || '[]');
        returns = JSON.parse(chartEl.dataset.returns || '[]');
      } catch (e) {
        labels = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        loans = [0, 0, 0, 0, 0, 0, 0];
        returns = [0, 0, 0, 0, 0, 0, 0];
      }

      chartEl.innerHTML = '';
      if (window.loanReturnChart && typeof window.loanReturnChart.destroy === 'function') {
        window.loanReturnChart.destroy();
      }

      window.loanReturnChart = new ApexCharts(chartEl, {
        series: [
          { name: 'Peminjaman', data: loans },
          { name: 'Pengembalian', data: returns }
        ],
        chart: {
          type: 'line',
          height: 300,
          toolbar: { show: false },
          zoom: { enabled: false }
        },
        stroke: {
          width: [3, 3],
          curve: 'smooth'
        },
        colors: ['#3b5cf6', '#22c55e'],
        markers: {
          size: 4,
          strokeWidth: 2
        },
        grid: {
          borderColor: '#e5e7eb',
          strokeDashArray: 4
        },
        dataLabels: {
          enabled: false
        },
        xaxis: {
          categories: labels,
          labels: { style: { fontSize: '12px' } }
        },
        yaxis: {
          min: 0,
          forceNiceScale: true,
          labels: {
            formatter: function (val) { return Math.round(val); }
          }
        },
        legend: {
          position: 'top',
          horizontalAlign: 'left'
        },
        tooltip: {
          y: {
            formatter: function (val) { return val + ' transaksi'; }
          }
        }
      });

      window.loanReturnChart.render();
    }

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', renderLoanReturnChart);
    } else {
      renderLoanReturnChart();
    }

    // Override chart template script if it renders late
    setTimeout(renderLoanReturnChart, 350);
  })();
</script>
@endpush
