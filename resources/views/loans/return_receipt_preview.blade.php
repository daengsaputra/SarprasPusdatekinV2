@php($title = 'Bukti Pengembalian')
@extends('layouts.app')

@push('styles')
<style>
  body {
    background: #fff;
    min-height: 100vh;
  }
  body.return-receipt-preview-mode {
    padding-top: 2rem;
    padding-bottom: 2rem;
  }
  body.return-receipt-preview-mode .header,
  body.return-receipt-preview-mode .nav-header,
  body.return-receipt-preview-mode .deznav,
  body.return-receipt-preview-mode .footer {
    display: none !important;
  }
  body.return-receipt-preview-mode #main-wrapper {
    padding-top: 0 !important;
  }
  body.return-receipt-preview-mode .content-body {
    margin-left: 0 !important;
    max-width: none;
    width: 100%;
    padding: 0 1rem;
    display: flex;
    justify-content: center;
    align-items: flex-start;
  }
  body.return-receipt-preview-mode .receipt-preview__shell {
    margin-top: 0;
  }
  @media print {
    .header, .nav-header, .deznav, .footer { display: none !important; }
    body { background: #fff; }
    .receipt-preview__shell { box-shadow: none !important; background: #fff !important; padding: 0; max-width: 100%; }
    .receipt-preview__toolbar { display: none !important; }
    .receipt-summary__item,
    .receipt-data-card,
    .receipt-table,
    .receipt-attachments,
    .receipt-attachment-card,
    .signature-panel {
      page-break-inside: avoid;
      break-inside: avoid-page;
    }
    .receipt-attachments__title {
      page-break-after: avoid;
      break-after: avoid;
    }
    .receipt-attachment-page {
      page-break-inside: avoid;
      break-inside: avoid-page;
    }
    .receipt-attachment-page + .receipt-attachment-page {
      page-break-before: always;
      break-before: page;
    }
  }
  .receipt-preview__shell {
    background: linear-gradient(180deg, #fdfefe 0%, #f3f7ff 100%);
    border-radius: 36px;
    padding: 2.3rem;
    box-shadow: 0 30px 80px rgba(15, 23, 42, 0.18);
    max-width: 920px;
    width: 100%;
    margin: 2rem auto;
    transform: scale(0.98);
    opacity: 0;
    transition: transform 0.45s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.35s ease;
  }
  .receipt-preview__shell.is-loaded {
    transform: scale(1);
    opacity: 1;
  }
  .receipt-preview__toolbar {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
  }
  .receipt-preview__toolbar-actions {
    margin-left: auto;
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
    align-items: center;
  }
  .receipt-header-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: #fff;
    border: 1px solid #dbe4f3;
    border-radius: 20px;
    padding: 1rem 1.15rem;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
  }
  .receipt-header-card img {
    height: 44px;
    width: auto;
    object-fit: contain;
  }
  .receipt-badge {
    display: inline-flex;
    padding: 0.22rem 0.7rem;
    border-radius: 999px;
    background: #e0ecff;
    color: #1d4ed8;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
  }
  .receipt-preview__title small {
    display: block;
    color: #94a3b8;
    font-size: 0.78rem;
    letter-spacing: 0.06em;
    margin-top: 0.2rem;
  }
  .receipt-preview__title h1 {
    font-size: 1.55rem;
    font-weight: 700;
    margin-bottom: 0.2rem;
    color: #111827;
    line-height: 1.25;
  }
  .receipt-preview__title span {
    color: #6b7280;
    font-size: 0.9rem;
  }
  .receipt-btn {
    border-radius: 999px;
    padding: 0.58rem 1.2rem;
    font-weight: 600;
    font-size: 0.9rem;
    min-width: 140px;
    text-align: center;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
  }
  .receipt-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
  }
  .receipt-summary__item {
    background: #fff;
    border-radius: 18px;
    padding: 1rem 1.2rem;
    border: 1px solid #e2e8f0;
    box-shadow: 0 6px 15px rgba(15, 23, 42, 0.08);
  }
  .receipt-summary__item span {
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #475569;
    font-weight: 600;
    font-size: 0.68rem;
  }
  .receipt-summary__value {
    font-size: 1.08rem;
    font-weight: 700;
    color: #111827;
    line-height: 1.35;
  }
  .receipt-meta {
    background: #fff;
    border-radius: 26px;
    padding: 1.9rem 2.2rem;
    box-shadow: 0 10px 35px rgba(15, 23, 42, 0.08);
  }
  .receipt-meta__grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
  }
  .receipt-meta__label {
    font-size: 0.66rem;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: #94a3b8;
    margin-bottom: 0.4rem;
    font-weight: 600;
  }
  .receipt-meta__value {
    display: block;
    max-width: 100%;
    white-space: normal;
    word-break: break-word;
    font-size: 0.93rem;
    color: #111827;
    font-weight: 600;
    line-height: 1.4;
  }
  .receipt-data-card {
    background: #fff;
    border-radius: 20px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    padding: 1.25rem;
    height: 100%;
  }
  .receipt-data-card__title {
    font-size: 0.7rem;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: #64748b;
    font-weight: 700;
    margin-bottom: 0.9rem;
  }
  .receipt-table {
    margin-top: 1.5rem;
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid #d7dee8;
    background: #fff;
  }
  .receipt-table table {
    margin-bottom: 0;
    width: 100%;
    border-collapse: collapse;
  }
  .receipt-table thead {
    background: #f1f5f9;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    font-size: 0.72rem;
    color: #1f2937;
  }
  .receipt-table thead th {
    border-bottom: 1px solid #d7dee8;
    color: #1e293b;
    font-weight: 700;
  }
  .receipt-table td,
  .receipt-table th {
    padding: 0.72rem 0.9rem;
    border-right: 1px solid #e5e7eb;
    font-size: 0.9rem;
  }
  .receipt-table td:last-child,
  .receipt-table th:last-child {
    border-right: 0;
  }
  .receipt-table tbody td {
    border-top: 1px solid #e5e7eb;
    background: #fff;
  }
  .receipt-table tfoot td,
  .receipt-table tfoot th {
    border-top: 1px solid #d7dee8;
    background: #f8fafc;
    font-weight: 700;
  }
  .receipt-attachments {
    margin-top: 1.5rem;
    background: #fff;
    border-radius: 24px;
    padding: 1.5rem;
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
  }
  .receipt-attachments__title {
    font-size: 0.78rem;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: #94a3b8;
    font-weight: 700;
    margin-bottom: 1rem;
  }
  .receipt-attachments__grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1rem;
  }
  .receipt-attachment-page + .receipt-attachment-page {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px dashed #cbd5e1;
  }
  .receipt-attachment-card {
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    padding: 0.75rem;
    text-align: center;
    background: linear-gradient(180deg, #f8fafc 0%, #fff 100%);
  }
  .receipt-attachment-card strong {
    display: block;
    font-size: 0.78rem;
    color: #0f172a;
    margin-bottom: 0.5rem;
  }
  .receipt-attachment-card img {
    max-width: 100%;
    border-radius: 12px;
    border: 1px solid rgba(148, 163, 184, 0.35);
    max-height: 180px;
    object-fit: cover;
  }
  .signature-panel {
    background: linear-gradient(135deg, rgba(226,232,240,0.55), rgba(191,219,254,0.5));
    border-radius: 26px;
    padding: 2rem 1.5rem;
    margin-top: 2rem;
  }
  .signature-panel__item {
    text-align: center;
  }
  .signature-panel__label {
    font-size: 0.8rem;
    color: #64748b;
  }
  .signature-line {
    min-height: 64px;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    font-weight: 600;
    font-size: 0.92rem;
    border-top: 1px dashed rgba(59, 130, 246, 0.6);
    padding-top: 0.75rem;
    margin-top: 1rem;
    color: #0f172a;
  }
  @media (max-width: 991.98px) {
    .receipt-preview__toolbar-actions {
      width: 100%;
      justify-content: flex-end;
    }
  }
  @media (max-width: 575.98px) {
    .receipt-preview__toolbar-actions {
      justify-content: stretch;
      flex-direction: column;
      align-items: stretch;
    }
    .receipt-btn {
      min-width: 0;
      width: 100%;
    }
  }
</style>
@endpush

@section('content')
<div class="receipt-preview__shell">
  <div class="receipt-preview__toolbar">
    <div class="receipt-header-card">
      <img src="{{ asset('evanto/assets/images/Logo Baju Pusdatin.png') }}" alt="Logo Pusdatin" onerror="this.style.display='none'">
      <div class="receipt-preview__title">
        <span class="receipt-badge">Dokumen Resmi</span>
        <h1>Bukti Pengembalian Barang</h1>
        <span>ID Peminjaman: <strong>{{ $loan->id }}</strong></span>
        <small>SARPRAS PUSDATEKIN BPIP</small>
      </div>
    </div>
    <div class="receipt-preview__toolbar-actions">
      <a class="btn btn-outline-primary receipt-btn" target="_blank" href="{{ route('loans.return.receipt', ['loan' => $loan, 'download' => 1]) }}">Download PDF</a>
      <button type="button" class="btn btn-primary receipt-btn" onclick="window.print()">Cetak Halaman</button>
    </div>
  </div>

  <div class="receipt-summary">
    <div class="receipt-summary__item">
      <span>Total Unit</span>
      <div class="receipt-summary__value">{{ (int) $loan->quantity }} unit</div>
    </div>
    <div class="receipt-summary__item">
      <span>Jenis Barang</span>
      <div class="receipt-summary__value">1 item</div>
    </div>
    <div class="receipt-summary__item">
      <span>Status</span>
      <div class="receipt-summary__value" style="font-size:1rem">Sudah Dikembalikan</div>
    </div>
    <div class="receipt-summary__item">
      <span>Waktu Cetak</span>
      <div class="receipt-summary__value" style="font-size:1rem">{{ $printed_at->format('d M Y H:i') }}</div>
    </div>
  </div>

  <section class="receipt-meta mb-2">
    <div class="row g-3">
      <div class="col-lg-6">
        <div class="receipt-data-card">
          <div class="receipt-data-card__title">Informasi Peminjam</div>
          <div class="receipt-meta__grid">
            <div>
              <div class="receipt-meta__label">Nama Peminjam</div>
              <div class="receipt-meta__value">{{ $loan->borrower_name }}</div>
            </div>
            <div>
              <div class="receipt-meta__label">Unit Kerja</div>
              <div class="receipt-meta__value">{{ $loan->unit }}</div>
            </div>
            @if($loan->borrower_contact)
            <div>
              <div class="receipt-meta__label">Kontak</div>
              <div class="receipt-meta__value">{{ $loan->borrower_contact }}</div>
            </div>
            @endif
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="receipt-data-card">
          <div class="receipt-data-card__title">Informasi Transaksi</div>
          <div class="receipt-meta__grid">
            <div>
              <div class="receipt-meta__label">Tanggal Pinjam</div>
              <div class="receipt-meta__value">{{ optional($loan->loan_date)->format('d M Y') }}</div>
            </div>
            <div>
              <div class="receipt-meta__label">Tanggal Kembali</div>
              <div class="receipt-meta__value">{{ optional($loan->return_date_actual)->format('d M Y') }}</div>
            </div>
            <div>
              <div class="receipt-meta__label">Petugas</div>
              <div class="receipt-meta__value">{{ $officer }}</div>
            </div>
            <div>
              <div class="receipt-meta__label">Dicetak</div>
              <div class="receipt-meta__value">{{ $printed_at->format('d M Y H:i') }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="receipt-table">
    <div class="table-responsive">
      <table class="table mb-0">
        <thead>
          <tr>
            <th style="width:140px">Kode Barang</th>
            <th>Nama Barang</th>
            <th class="text-center" style="width:100px">Jumlah</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="fw-semibold">{{ $loan->asset->code }}</td>
            <td>{{ $loan->asset->name }}</td>
            <td class="text-center fw-semibold">{{ $loan->quantity }}</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2" class="text-end">Total Unit</td>
            <td class="text-center">{{ $loan->quantity }}</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </section>

  @php($returnPhotos = collect($loan->return_photo_paths ?? [])->filter())
  @if($returnPhotos->isNotEmpty())
    <section class="receipt-attachments">
      <div class="receipt-attachments__title">Bukti Foto Pengembalian</div>
      @foreach($returnPhotos->values()->chunk(6) as $chunkIndex => $chunk)
        <div class="receipt-attachment-page">
          <div class="receipt-attachments__grid">
            @foreach($chunk as $index => $path)
              @php($photoNumber = ($chunkIndex * 6) + $index + 1)
              @php($exists = $path && \Illuminate\Support\Facades\Storage::disk('public')->exists($path))
              <div class="receipt-attachment-card">
                <strong>Foto {{ $photoNumber }}</strong>
                @if($exists)
                  <a href="{{ asset('storage/'.$path) }}" target="_blank">
                    <img src="{{ asset('storage/'.$path) }}" alt="Foto Pengembalian {{ $photoNumber }}">
                  </a>
                @else
                  <span class="text-muted small d-block">File tidak tersedia</span>
                @endif
              </div>
            @endforeach
          </div>
        </div>
      @endforeach
    </section>
  @endif

  <div class="signature-panel row g-4 mt-0">
    <div class="col-md-6 signature-panel__item">
      <div class="signature-panel__label">Peminjam</div>
      <div class="signature-line">{{ $loan->borrower_name }}</div>
    </div>
    <div class="col-md-6 signature-panel__item">
      <div class="signature-panel__label">Petugas</div>
      <div class="signature-line">{{ $officer }}</div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.body.classList.add('return-receipt-preview-mode');
    requestAnimationFrame(function(){
      var shell = document.querySelector('.receipt-preview__shell');
      if(shell){
        shell.classList.add('is-loaded');
      }
    });
  });
</script>
@endpush
