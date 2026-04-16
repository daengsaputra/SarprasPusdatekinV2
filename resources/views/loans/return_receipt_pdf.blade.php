<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 11px; color: #1f2937; }
    .header { text-align: center; border-bottom: 2px solid #1d4ed8; padding-bottom: 10px; margin-bottom: 12px; }
    .header-logo { height: 52px; width: auto; margin: 2px 0 6px; }
    .header h1 { font-size: 18px; margin: 4px 0 1px; letter-spacing: 0.04em; }
    .header h2 { font-size: 12px; margin: 0; color: #475569; font-weight: normal; }
    .summary { margin: 10px 0 12px; }
    .summary .chip { display: inline-block; border: 1px solid #bfdbfe; background: #eff6ff; color: #1e3a8a; padding: 4px 8px; margin-right: 6px; font-weight: bold; font-size: 10px; }
    table.meta-wrap { width: 100%; border-collapse: separate; border-spacing: 8px 0; margin-bottom: 10px; }
    table.meta-box { width: 100%; border-collapse: collapse; border: 1px solid #dbe2ea; }
    table.meta-box th { background: #f3f7fb; text-align: left; padding: 6px 8px; font-size: 10px; letter-spacing: 0.05em; text-transform: uppercase; color: #475569; }
    table.meta-box td { padding: 5px 8px; border-top: 1px solid #eef2f6; vertical-align: top; }
    table.meta-box td:first-child { width: 110px; color: #64748b; }
    table.items { width: 100%; border-collapse: collapse; margin-top: 8px; border: 1px solid #d7dee8; }
    table.items th { background: #f1f5f9; border: 1px solid #d7dee8; padding: 7px 8px; text-transform: uppercase; letter-spacing: 0.05em; font-size: 10px; color: #1e293b; }
    table.items td { border: 1px solid #e5e7eb; padding: 7px 8px; background: #ffffff; }
    table.items tfoot td { font-weight: bold; background: #f8fafc; border-top: 1px solid #d7dee8; }
    .align-center { text-align: center; }
    .mt-2 { margin-top: 10px; }
    .sign-row { width: 100%; margin-top: 20px; }
    .sign { width: 48%; display: inline-block; vertical-align: top; }
    .sign.right { text-align: right; float: right; }
    .sign-name { margin-top: 38px; font-weight: bold; }
    .attachments { margin-top: 18px; }
    .attachments h3 { font-size: 11px; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.08em; color: #475569; }
    .attachment-page + .attachment-page { page-break-before: always; border-top: 1px dashed #cbd5e1; padding-top: 8px; margin-top: 8px; }
    .attachment-card { border: 1px solid #d5dbe3; padding: 6px; width: 178px; text-align: center; display: inline-block; vertical-align: top; margin: 0 8px 8px 0; }
    .attachment-card strong { display: block; margin-bottom: 4px; font-size: 10px; }
    .attachment-card img { max-width: 100%; max-height: 130px; }
    .printed { font-size: 10px; color: #64748b; border-top: 1px dashed #cbd5e1; padding-top: 6px; }
    .meta-wrap, .items, .sign-row, .attachments, .attachment-grid, .attachment-card { page-break-inside: avoid; }
    .attachments h3 { page-break-after: avoid; }
  </style>
</head>
<body>
  <div class="header">
    <img class="header-logo" src="{{ public_path('evanto/assets/images/Logo Baju Pusdatin.png') }}" alt="Logo">
    <h1>BUKTI PENGEMBALIAN BARANG</h1>
    <h2>SARANA PRASARANA ASET PUSDATEKIN</h2>
  </div>

  <div class="summary">
    <span class="chip">ID Peminjaman: {{ $loan->id }}</span>
    <span class="chip">Total Unit: {{ (int) $loan->quantity }}</span>
    <span class="chip">Status: Sudah Dikembalikan</span>
  </div>

  <table class="meta-wrap">
    <tr>
      <td style="width:50%;">
        <table class="meta-box">
          <tr><th colspan="2">Informasi Peminjam</th></tr>
          <tr><td>Nama</td><td>{{ $loan->borrower_name }}</td></tr>
          <tr><td>Unit Kerja</td><td>{{ $loan->unit }}</td></tr>
          @if($loan->borrower_contact)
            <tr><td>Kontak</td><td>{{ $loan->borrower_contact }}</td></tr>
          @endif
        </table>
      </td>
      <td style="width:50%;">
        <table class="meta-box">
          <tr><th colspan="2">Informasi Transaksi</th></tr>
          <tr><td>Tgl Pinjam</td><td>{{ optional($loan->loan_date)->format('d M Y') }}</td></tr>
          <tr><td>Tgl Kembali</td><td>{{ optional($loan->return_date_actual)->format('d M Y') }}</td></tr>
          <tr><td>Petugas</td><td>{{ $officer }}</td></tr>
          <tr><td>Dicetak</td><td>{{ $printed_at->format('d M Y H:i') }}</td></tr>
        </table>
      </td>
    </tr>
  </table>

  <table class="items">
    <thead>
      <tr>
        <th style="width:40px">No</th>
        <th style="width:140px">Kode Barang</th>
        <th>Nama Barang</th>
        <th style="width:80px">Jumlah</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="align-center">1</td>
        <td>{{ $loan->asset->code }}</td>
        <td>{{ $loan->asset->name }}</td>
        <td class="align-center">{{ $loan->quantity }}</td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="3" style="text-align:right;">Total Unit</td>
        <td class="align-center">{{ $loan->quantity }}</td>
      </tr>
    </tfoot>
  </table>

  @php($returnPhotos = collect($loan->return_photo_paths ?? [])->filter())
  @if($returnPhotos->isNotEmpty())
    <div class="attachments">
      <h3>Bukti Foto Pengembalian</h3>
      @foreach($returnPhotos->values()->chunk(6) as $chunkIndex => $chunk)
        <div class="attachment-page">
          <div class="attachment-grid">
            @foreach($chunk as $index => $path)
              @php($photoNumber = ($chunkIndex * 6) + $index + 1)
              @php($absolute = $path ? storage_path('app/public/'.$path) : null)
              <div class="attachment-card">
                <strong>Foto {{ $photoNumber }}</strong>
                @if($absolute && file_exists($absolute))
                  <img src="{{ $absolute }}" alt="Foto {{ $photoNumber }}">
                @else
                  <div style="font-size:10px;color:#666">File tidak ditemukan</div>
                @endif
              </div>
            @endforeach
          </div>
        </div>
      @endforeach
    </div>
  @endif

  <div class="sign-row">
    <div class="sign">Peminjam
      <div class="sign-name">{{ $loan->borrower_name }}</div>
    </div>
    <div class="sign right">Petugas
      <div class="sign-name">{{ $officer }}</div>
    </div>
  </div>

  <div class="mt-2 printed">Dicetak: {{ $printed_at->format('Y-m-d H:i') }}</div>
</body>
</html>

