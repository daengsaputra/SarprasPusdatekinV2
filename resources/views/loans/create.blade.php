@php($title = 'Pinjam Aset')
@extends('layouts.app')

@push('styles')
<style>
  body[data-theme="light"] { background:#eef2ff; }
  .loan-create-shell { position: relative; }
  .loan-create-shell .card {
    border-radius: 22px;
    border: 1px solid rgba(148,163,184,0.16);
    box-shadow: 0 14px 34px rgba(15,23,42,0.08);
  }
  .loan-create-shell .card-body {
    padding: 1rem 1.1rem;
  }
  .list-aset { max-height: 480px; overflow:auto; }
  .status-dot { width:10px;height:10px;border-radius:50%;display:inline-block;margin-right:6px }
  .dot-green{ background:#10b981 }
  .dot-red{ background:#ef4444 }
  .cart-item input[type=number]{ width:90px }
  .file-drop {
    border: 1px dashed rgba(148, 163, 184, 0.8);
    border-radius: 16px;
    padding: 1.25rem;
    text-align: center;
    background: rgba(248, 250, 252, 0.85);
    transition: border-color .2s ease, background .2s ease, box-shadow .2s ease;
    cursor: pointer;
  }
  .file-drop:hover { border-color: rgba(59, 130, 246, 0.8); }
  .file-drop.is-dragover {
    border-color: #2563eb;
    background: rgba(37, 99, 235, 0.06);
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.08) inset;
  }
  .file-drop.is-invalid { border-color: #dc3545; }
  .file-drop__input { display: none; }
  .file-drop__icon {
    width: 48px; height: 48px; border-radius: 12px;
    margin: 0 auto 0.75rem;
    display: flex; align-items:center; justify-content:center;
    background: rgba(37,99,235,0.12); color:#2563eb;
  }
  .file-drop__filename { display:block; margin-top:0.3rem; color:#475569; font-size:0.9rem; }
  .file-drop__actions {
    display: flex;
    gap: .45rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: .7rem;
  }
  .file-drop__list {
    margin: .75rem 0 0;
    padding-left: 1rem;
    text-align: left;
    font-size: .86rem;
    color: #334155;
  }
  .file-drop__list li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: .5rem;
    margin-bottom: .35rem;
  }
  .date-quick-actions {
    display: flex;
    gap: .35rem;
    flex-wrap: wrap;
    margin-top: .45rem;
  }
  .date-quick-actions .btn {
    --bs-btn-padding-y: .2rem;
    --bs-btn-padding-x: .5rem;
    --bs-btn-font-size: .72rem;
  }
  .loan-form-warning {
    display: none;
    margin-top: .65rem;
    padding: .55rem .7rem;
    border-radius: 10px;
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.28);
    color: #b91c1c;
    font-size: .86rem;
    font-weight: 600;
    transform-origin: top center;
  }
  .loan-form-warning.is-visible { display: block; }
  .loan-form-warning.is-animate {
    animation: loanWarningPop .22s cubic-bezier(0.34, 1.56, 0.64, 1);
  }
  .loan-center-warning {
    position: fixed;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%) scale(.86);
    z-index: 2250;
    width: min(560px, 92vw);
    border-radius: 14px;
    padding: .85rem 1rem;
    border: 1px solid rgba(239, 68, 68, 0.35);
    background: rgba(254, 242, 242, 0.98);
    color: #991b1b;
    box-shadow: 0 24px 54px rgba(15,23,42,0.2);
    text-align: center;
    font-size: .95rem;
    font-weight: 700;
    opacity: 0;
    visibility: hidden;
    transition: opacity .18s ease, visibility .18s ease, transform .22s cubic-bezier(0.34, 1.56, 0.64, 1);
  }
  .loan-center-warning-backdrop {
    position: fixed;
    inset: 0;
    z-index: 2240;
    background: rgba(15, 23, 42, 0.22);
    backdrop-filter: blur(5px);
    opacity: 0;
    visibility: hidden;
    transition: opacity .18s ease, visibility .18s ease;
  }
  .loan-center-warning-backdrop.is-visible {
    opacity: 1;
    visibility: visible;
  }
  .loan-center-warning.is-visible {
    opacity: 1;
    visibility: visible;
    transform: translate(-50%, -50%) scale(1);
  }
  .upload-preview-warning {
    display: none;
    margin-top: .5rem;
    padding: .5rem .65rem;
    border-radius: 10px;
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.28);
    color: #b91c1c;
    font-size: .82rem;
    font-weight: 600;
    transform-origin: top center;
  }
  .upload-preview-warning.is-visible { display: block; }
  .upload-preview-warning.is-animate {
    animation: loanWarningPop .22s cubic-bezier(0.34, 1.56, 0.64, 1);
  }
  @keyframes loanWarningPop {
    0% { transform: scale(.86); opacity: .6; }
    100% { transform: scale(1); opacity: 1; }
  }
  .loan-toast {
    position: fixed;
    top: 22px;
    right: 22px;
    z-index: 2200;
    min-width: 260px;
    max-width: min(420px, 92vw);
    padding: .7rem .85rem;
    border-radius: 12px;
    border: 1px solid rgba(239, 68, 68, 0.35);
    background: rgba(254, 242, 242, 0.98);
    color: #991b1b;
    box-shadow: 0 18px 42px rgba(15,23,42,0.16);
    transform: translateY(-12px) scale(.97);
    opacity: 0;
    pointer-events: none;
    transition: transform .18s ease, opacity .18s ease;
    font-size: .88rem;
    font-weight: 600;
  }
  .loan-toast.is-visible {
    transform: translateY(0) scale(1);
    opacity: 1;
  }
  .loan-toast__title {
    font-size: .8rem;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #b91c1c;
    margin-bottom: .12rem;
  }
  @media (max-width: 576px) {
    .loan-toast { top: 14px; right: 14px; left: 14px; max-width: none; }
  }
</style>
@endpush

@section('content')
<main class="content-body">
<div class="container-fluid">
<div class="loan-create-shell">
<h1 class="h5 mb-3">Pilih barang yang akan dipinjam</h1>

<div class="row g-3">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
          <div>
            <label class="me-2">Show</label>
            <select id="pageSize" class="form-select d-inline-block" style="width:80px">
              <option>10</option><option>25</option><option>50</option>
            </select>
            <span class="ms-2">entries</span>
          </div>
          <div>
            <label class="me-2">Search:</label>
            <input type="text" id="search" class="form-control d-inline-block" style="width:220px" placeholder="cari aset...">
          </div>
        </div>

        <div class="table-responsive list-aset">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>Nama Barang</th>
                <th>ID Barang</th>
                <th>Status</th>
                <th class="text-end">Aksi</th>
              </tr>
            </thead>
            <tbody id="assetTable">
              @foreach($assets as $a)
                <tr data-name="{{ strtolower($a->name.' '.$a->code) }}">
                  <td>{{ $a->name }}</td>
                  <td>{{ $a->code }}</td>
                  <td>
                    @if($a->quantity_available>0)
                      <span class="status-dot dot-green"></span>Tersedia
                    @else
                      <span class="status-dot dot-red"></span>Terpinjam
                    @endif
                  </td>
                  <td class="text-end">
                    <button class="btn btn-sm btn-info" onclick="addToCart({ id: {{ $a->id }}, name: @js($a->name), code: @js($a->code), max: {{ $a->quantity_available }} })" {{ $a->quantity_available<=0 ? 'disabled' : '' }}>pilih</button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <strong>Daftar pinjam</strong>
          <button class="btn btn-sm btn-outline-secondary" onclick="clearCart()">Clear</button>
        </div>
        <div id="cartList" class="mb-3"></div>

        <form id="batchForm" method="POST" action="{{ route('loans.store.batch') }}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="items" id="itemsField">
          <div class="loan-form-warning mb-2" id="loanFormWarning">Wajib isi form peminjaman terlebih dahulu.</div>

          <div class="mb-2">
            <label class="form-label">Nama Peminjam</label>
            <input type="text" name="borrower_name" class="form-control @error('borrower_name') is-invalid @enderror" required>
            @error('borrower_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-2">
            <label class="form-label">Kontak Peminjam</label>
            <input type="text" name="borrower_contact" class="form-control" required>
          </div>
          <div class="mb-2">
            <label class="form-label">Unit Kerja BPIP</label>
            <select name="unit" class="form-select @error('unit') is-invalid @enderror" required>
              <option value="">-- pilih unit kerja --</option>
              @foreach(($units ?? config('bpip.units')) as $unit)
                <option value="{{ $unit }}">{{ $unit }}</option>
              @endforeach
            </select>
            @error('unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-2">
            <label class="form-label">Nama Kegiatan</label>
            <input type="text" name="activity_name" value="{{ old('activity_name') }}" class="form-control @error('activity_name') is-invalid @enderror" required>
            @error('activity_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="row g-2">
            <div class="col-6">
              <label for="loan_date" class="form-label">Tanggal Pinjam</label>
              <div class="input-group">
                <span class="input-group-text">📅</span>
                <input type="date" id="loan_date" name="loan_date" value="{{ old('loan_date', now()->format('Y-m-d')) }}" class="form-control" required>
              </div>
            </div>
            <div class="col-6">
              <label for="return_date_planned" class="form-label">Rencana Kembali</label>
              <div class="input-group">
                <span class="input-group-text">🗓️</span>
                <input type="date" id="return_date_planned" name="return_date_planned" value="{{ old('return_date_planned') }}" class="form-control" required>
              </div>
              <div class="date-quick-actions">
                <button type="button" class="btn btn-outline-secondary" data-date-preset="today">Hari ini</button>
                <button type="button" class="btn btn-outline-secondary" data-date-preset="plus1">+1 hari</button>
                <button type="button" class="btn btn-outline-secondary" data-date-preset="plus7">+7 hari</button>
              </div>
            </div>
          </div>
          <div class="mb-2 mt-2">
            <label class="form-label">Foto ND/Helpdesk Pengajuan</label>
            <div class="file-drop @error('request_photo') is-invalid @enderror" data-file-drop>
              <input type="file" name="request_photo[]" id="requestPhotoInput" accept=".jpg,.jpeg,.png,.webp,image/*" class="file-drop__input" required multiple data-max-kb="{{ (int) config('bpip.loan_attachment_max_kb', 4096) }}" data-max-files="5">
              <div class="file-drop__body">
                <div class="file-drop__icon">
                  📄
                </div>
                <strong>Tarik & lepaskan file di sini</strong>
                <div>atau klik untuk memilih dari komputer</div>
                                <small class="file-drop__filename" data-file-drop-name>Belum ada file</small>
                <div class="file-drop__actions">
                  <button type="button" class="btn btn-sm btn-outline-primary" data-file-action="append">Tambah Foto</button>
                  <button type="button" class="btn btn-sm btn-outline-secondary" data-file-action="replace">Ganti Semua</button>
                  <button type="button" class="btn btn-sm btn-outline-danger" data-file-action="clear">Hapus Semua</button>
                </div>
              </div>
            </div>
            <ul class="file-drop__list mt-2" data-file-drop-list></ul>
            <div class="upload-preview-warning" id="requestPhotoWarn">Wajib upload Foto ND/Helpdesk Pengajuan.</div>
            <div class="form-text">Unggah dokumentasi ND/helpdesk (wajib, JPG/PNG/WebP, maks {{ number_format(((int) config('bpip.loan_attachment_max_kb', 4096)) / 1024, 1) }} MB per file, maks 5 file).</div>
            @error('request_photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            @error('request_photo.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
          </div>
          <div class="mb-2">
            <label class="form-label">Foto Serah Terima (Saat Peminjaman)</label>
            <div class="file-drop @error('loan_photo') is-invalid @enderror" data-file-drop>
              <input type="file" name="loan_photo[]" id="loanPhotoInput" accept=".jpg,.jpeg,.png,.webp,image/*" class="file-drop__input" required multiple data-max-kb="{{ (int) config('bpip.loan_attachment_max_kb', 4096) }}" data-max-files="5">
              <div class="file-drop__body">
                <div class="file-drop__icon">
                  📷
                </div>
                <strong>Tarik & lepaskan foto</strong>
                <div>atau klik untuk memilih dari komputer</div>
                                <small class="file-drop__filename" data-file-drop-name>Belum ada file</small>
                <div class="file-drop__actions">
                  <button type="button" class="btn btn-sm btn-outline-primary" data-file-action="append">Tambah Foto</button>
                  <button type="button" class="btn btn-sm btn-outline-secondary" data-file-action="replace">Ganti Semua</button>
                  <button type="button" class="btn btn-sm btn-outline-danger" data-file-action="clear">Hapus Semua</button>
                </div>
              </div>
            </div>
            <ul class="file-drop__list mt-2" data-file-drop-list></ul>
            <div class="upload-preview-warning" id="loanPhotoWarn">Wajib upload Foto Serah Terima.</div>
            <div class="form-text">Gunakan foto bukti serah terima saat barang keluar (wajib, JPG/PNG/WebP, maks {{ number_format(((int) config('bpip.loan_attachment_max_kb', 4096)) / 1024, 1) }} MB per file, maks 5 file).</div>
            @error('loan_photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            @error('loan_photo.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
          </div>
          <div class="mb-2 mt-2">
            <label class="form-label">Catatan</label>
            <textarea name="notes" class="form-control" rows="2"></textarea>
          </div>
          <button class="btn btn-success w-100" id="saveLoanBtn" type="button">Pinjam</button>
          <button class="btn btn-secondary w-100 mt-2" id="cancelLoanBtn" type="button" data-cancel-href="{{ route('loans.index') }}">Batal</button>
        </form>
      </div>
    </div>
  </div>
</div>

<x-confirm-modal
  title="Konfirmasi"
  default-message="Apakah anda yakin?"
  confirm-text="Ya"
  cancel-text="Tidak"
/>
<div class="loan-toast" id="loanToast" role="status" aria-live="polite">
  <div class="loan-toast__title">Perhatian</div>
  <div id="loanToastText">Wajib isi form peminjaman.</div>
</div>
<div class="loan-center-warning-backdrop" id="loanCenterWarningBackdrop"></div>
<div class="loan-center-warning" id="loanCenterWarning">Wajib isi form peminjaman dan upload foto wajib.</div>

</div>
</div>
</main>
@endsection

@push('scripts')
<script>
  const DRAFT_KEY = 'loan_create_draft_v1';
  const cart = [];
  const cartList = document.getElementById('cartList');
  const itemsField = document.getElementById('itemsField');
  const batchForm = document.getElementById('batchForm');
  const searchInput = document.getElementById('search');
  const saveLoanBtn = document.getElementById('saveLoanBtn');
  const cancelLoanBtn = document.getElementById('cancelLoanBtn');
  const loanConfirmModal = document.querySelector('[data-confirm-modal]');
  const loanConfirmTitle = loanConfirmModal?.querySelector('[data-confirm-title]');
  const loanConfirmText = loanConfirmModal?.querySelector('[data-confirm-message]');
  const loanConfirmYes = loanConfirmModal?.querySelector('[data-confirm-accept]');
  const loanConfirmNo = loanConfirmModal?.querySelector('[data-confirm-cancel]');
  const loanFormWarning = document.getElementById('loanFormWarning');
  const requestPhotoInput = document.getElementById('requestPhotoInput');
  const loanPhotoInput = document.getElementById('loanPhotoInput');
  const requestPhotoWarn = document.getElementById('requestPhotoWarn');
  const loanPhotoWarn = document.getElementById('loanPhotoWarn');
  const loanToast = document.getElementById('loanToast');
  const loanToastText = document.getElementById('loanToastText');
  const loanCenterWarningBackdrop = document.getElementById('loanCenterWarningBackdrop');
  const loanCenterWarning = document.getElementById('loanCenterWarning');
  const params = new URLSearchParams(window.location.search);
  const forceFresh = params.get('fresh') === '1';
  let confirmAction = null;
  let submitConfirmed = false;
  let toastTimer = null;
  let centerWarningTimer = null;
  const trackedFieldNames = [
    'borrower_name',
    'borrower_contact',
    'unit',
    'activity_name',
    'loan_date',
    'return_date_planned',
    'notes',
  ];

  function saveDraft() {
    try {
      const formData = {};
      trackedFieldNames.forEach((name) => {
        const field = batchForm?.querySelector(`[name="${name}"]`);
        if (!field) return;
        formData[name] = field.value ?? '';
      });

      const payload = {
        form: formData,
        cart,
        search: searchInput?.value ?? '',
      };
      sessionStorage.setItem(DRAFT_KEY, JSON.stringify(payload));
    } catch (_) {}
  }

  function restoreDraft() {
    try {
      const raw = sessionStorage.getItem(DRAFT_KEY);
      if (!raw) return;
      const payload = JSON.parse(raw);

      if (payload?.form) {
        trackedFieldNames.forEach((name) => {
          const field = batchForm?.querySelector(`[name="${name}"]`);
          if (!field) return;
          if (field.value) return; // keep old() value from backend if exists
          field.value = payload.form[name] ?? '';
        });
      }

      if (Array.isArray(payload?.cart)) {
        payload.cart.forEach((item) => {
          if (!item || !item.id) return;
          cart.push({
            id: Number(item.id),
            name: String(item.name ?? ''),
            code: String(item.code ?? ''),
            max: Number(item.max ?? 1),
            qty: Math.max(1, Number(item.qty ?? 1)),
          });
        });
      }

      if (searchInput && typeof payload?.search === 'string') {
        searchInput.value = payload.search;
      }
    } catch (_) {}
  }

  function renderCart(){
    if(cart.length===0){
      cartList.innerHTML = '<div class="text-muted small">Belum ada item.</div>';
      itemsField.value = '';
      saveDraft();
      return;
    }
    cartList.innerHTML = cart.map((it,idx)=>`
      <div class="cart-item d-flex align-items-center justify-content-between border rounded p-2 mb-2">
        <div>
          <div class="fw-semibold">${it.code} — ${it.name}</div>
          <div class="small text-muted">Tersedia: ${it.max}</div>
        </div>
        <div class="d-flex align-items-center gap-2">
          <input type="number" min="1" max="${it.max}" value="${it.qty}" class="form-control form-control-sm" onchange="updateQty(${idx}, this.value)">
          <button class="btn btn-sm btn-outline-danger" onclick="removeItem(${idx})">Hapus</button>
        </div>
      </div>
    `).join('');
    itemsField.value = JSON.stringify(cart.map(x=>({asset_id:x.id, quantity:x.qty})));
    saveDraft();
  }
  function addToCart(obj){
    const found = cart.find(x=>x.id===obj.id);
    if(found){ found.qty = Math.min(found.qty+1, found.max); }
    else { cart.push({ id: obj.id, name: obj.name, code: obj.code, max: obj.max, qty: 1 }); }
    renderCart();
  }
  function updateQty(idx, val){ cart[idx].qty = Math.max(1, Math.min(parseInt(val||1,10), cart[idx].max)); renderCart(); }
  function removeItem(idx){ cart.splice(idx,1); renderCart(); }
  function clearCart(){ cart.length=0; renderCart(); saveDraft(); }

  // client search filter
  searchInput?.addEventListener('input', (e)=>{
    const val = e.target.value.trim().toLowerCase();
    document.querySelectorAll('#assetTable tr').forEach(tr=>{
      const ok = tr.dataset.name.includes(val);
      tr.style.display = ok? '' : 'none';
    });
    saveDraft();
  });

  function openConfirmModal({ title, message, onYes }) {
    confirmAction = typeof onYes === 'function' ? onYes : null;
    if (loanConfirmTitle) loanConfirmTitle.textContent = title || 'Konfirmasi';
    if (loanConfirmText) loanConfirmText.textContent = message || 'Apakah anda yakin?';
    loanConfirmModal?.classList.add('is-visible');
    loanConfirmModal?.setAttribute('aria-hidden', 'false');
    document.body.classList.add('app-confirm-modal-open');
    window.setTimeout(() => loanConfirmNo?.focus(), 60);
  }

  function closeConfirmModal() {
    loanConfirmModal?.classList.remove('is-visible');
    loanConfirmModal?.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('app-confirm-modal-open');
  }

  function showToast(message) {
    if (!loanToast) return;
    if (loanToastText) {
      loanToastText.textContent = message || 'Terjadi kesalahan.';
    }
    loanToast.classList.add('is-visible');
    window.clearTimeout(toastTimer);
    toastTimer = window.setTimeout(() => {
      loanToast.classList.remove('is-visible');
    }, 2600);
  }

  function showCenterWarning(message) {
    if (!loanCenterWarning) return;
    loanCenterWarning.textContent = message || 'Wajib isi form peminjaman dan upload foto wajib.';
    loanCenterWarningBackdrop?.classList.add('is-visible');
    loanCenterWarning.classList.add('is-visible');
    window.clearTimeout(centerWarningTimer);
    centerWarningTimer = window.setTimeout(() => {
      loanCenterWarningBackdrop?.classList.remove('is-visible');
      loanCenterWarning.classList.remove('is-visible');
    }, 2400);
  }

  function showFormWarning(message) {
    if (!loanFormWarning) return;
    loanFormWarning.textContent = message;
    loanFormWarning.classList.add('is-visible');
    loanFormWarning.classList.remove('is-animate');
    void loanFormWarning.offsetWidth;
    loanFormWarning.classList.add('is-animate');
  }

  function hideFormWarning() {
    loanFormWarning?.classList.remove('is-visible');
  }

  function showUploadWarning(el, message) {
    if (!el) return;
    el.textContent = message;
    el.classList.add('is-visible');
    el.classList.remove('is-animate');
    void el.offsetWidth;
    el.classList.add('is-animate');
  }

  function hideUploadWarning(el) {
    el?.classList.remove('is-visible');
  }

  function validateUploads() {
    let valid = true;
    if (!requestPhotoInput?.files?.length) {
      showUploadWarning(requestPhotoWarn, 'Wajib upload Foto ND/Helpdesk Pengajuan.');
      valid = false;
    } else {
      hideUploadWarning(requestPhotoWarn);
    }

    if (!loanPhotoInput?.files?.length) {
      showUploadWarning(loanPhotoWarn, 'Wajib upload Foto Serah Terima.');
      valid = false;
    } else {
      hideUploadWarning(loanPhotoWarn);
    }

    return valid;
  }

  loanConfirmYes?.addEventListener('click', () => {
    const action = confirmAction;
    closeConfirmModal();
    confirmAction = null;
    if (action) action();
  });
  loanConfirmNo?.addEventListener('click', () => {
    closeConfirmModal();
    confirmAction = null;
  });
  loanConfirmModal?.addEventListener('click', (e) => {
    if (e.target === loanConfirmModal) {
      closeConfirmModal();
      confirmAction = null;
    }
  });
  document.addEventListener('keyup', (e) => {
    if (e.key === 'Escape' && loanConfirmModal?.classList.contains('is-visible')) {
      closeConfirmModal();
      confirmAction = null;
    }
  });

  saveLoanBtn?.addEventListener('click', () => {
    if (!batchForm) return;
    const uploadValid = validateUploads();
    const invalidForm = !batchForm.checkValidity();
    const emptyCart = cart.length === 0;
    if (invalidForm || emptyCart || !uploadValid) {
      if (invalidForm && emptyCart && !uploadValid) {
        showFormWarning('Wajib isi form peminjaman, pilih minimal satu barang, dan upload foto wajib.');
        showToast('Lengkapi form, pilih barang, dan upload foto wajib.');
      } else if (invalidForm && emptyCart) {
        showFormWarning('Wajib isi form peminjaman dan pilih minimal satu barang');
        showToast('Lengkapi form dan pilih minimal satu barang.');
      } else if (invalidForm && !uploadValid) {
        showFormWarning('Wajib isi form peminjaman dan upload foto wajib.');
        showCenterWarning('Wajib isi form peminjaman dan upload foto wajib.');
        showToast('Lengkapi form dan upload foto wajib.');
      } else if (emptyCart && !uploadValid) {
        showFormWarning('Pilih minimal satu barang dan upload foto wajib.');
        showToast('Pilih barang dan upload foto wajib.');
      } else if (invalidForm) {
        showFormWarning('Wajib isi form peminjaman terlebih dahulu.');
        showToast('Wajib isi form peminjaman.');
      } else {
        if (emptyCart) {
          showFormWarning('Pilih minimal satu barang peminjaman terlebih dahulu.');
          showToast('Pilih minimal satu item barang.');
        } else {
          showFormWarning('Upload foto wajib belum lengkap.');
          showToast('Upload foto wajib belum lengkap.');
        }
      }
      if (invalidForm) {
        batchForm.reportValidity();
        const invalidField = batchForm.querySelector(':invalid');
        invalidField?.focus();
      }
      return;
    }
    hideFormWarning();
    batchForm.requestSubmit();
  });
  cancelLoanBtn?.addEventListener('click', () => {
    const href = cancelLoanBtn.getAttribute('data-cancel-href');
    openConfirmModal({
      title: 'Batalkan Peminjaman',
      message: 'Apakah anda yakin ingin batal dan keluar dari halaman ini?',
      onYes: () => { if (href) window.location.href = href; }
    });
  });

  // Submit transform + confirm save
  batchForm?.addEventListener('submit', (e)=>{
    if(cart.length===0){
      e.preventDefault();
      showFormWarning('Pilih minimal satu barang peminjaman terlebih dahulu.');
      showToast('Pilih minimal satu item barang.');
      return;
    }
    if (!validateUploads()) {
      e.preventDefault();
      showFormWarning('Upload foto wajib belum lengkap.');
      showToast('Upload foto wajib belum lengkap.');
      return;
    }
    if (submitConfirmed) { submitConfirmed = false; return; }
    e.preventDefault();
    openConfirmModal({
      title: 'Pinjam Barang',
      message: 'Apakah anda yakin ingin memproses peminjaman ini?',
      onYes: () => {
        submitConfirmed = true;
        batchForm.requestSubmit();
      }
    });
  });

  trackedFieldNames.forEach((name) => {
    const field = batchForm?.querySelector(`[name="${name}"]`);
    if (!field) return;
    field.addEventListener('input', saveDraft);
    field.addEventListener('change', saveDraft);
  });

  if (forceFresh) {
    try {
      sessionStorage.removeItem(DRAFT_KEY);
      params.delete('fresh');
      const cleanQuery = params.toString();
      const cleanUrl = `${window.location.pathname}${cleanQuery ? `?${cleanQuery}` : ''}`;
      window.history.replaceState({}, '', cleanUrl);
    } catch (_) {}
  } else {
    restoreDraft();
  }
  renderCart();

  initFileDropzones();
  initDateFieldFocusFix();

  function initFileDropzones() {
    const zones = document.querySelectorAll('[data-file-drop]');
    if (!zones.length) return;

    zones.forEach((zone) => {
      const zoneScope = zone.parentElement || zone;
      const input = zone.querySelector('input[type="file"]');
      const nameEl = zone.querySelector('[data-file-drop-name]');
      const listEl = zoneScope.querySelector('[data-file-drop-list]');
      const maxKb = Number(input?.dataset?.maxKb || 4096);
      const maxFiles = Number(input?.dataset?.maxFiles || 5);
      let buffer = [];

      const syncInputFiles = () => {
        if (!input) return;
        const dt = new DataTransfer();
        buffer.forEach((file) => dt.items.add(file));
        input.files = dt.files;
      };

      const setFileName = () => {
        if (!buffer.length) {
          if (nameEl) nameEl.textContent = 'Belum ada file';
          if (listEl) listEl.innerHTML = '';
          return;
        }
        if (input?.id === 'requestPhotoInput') hideUploadWarning(requestPhotoWarn);
        if (input?.id === 'loanPhotoInput') hideUploadWarning(loanPhotoWarn);
        if (nameEl) nameEl.textContent = `${buffer.length} file dipilih`;
        if (listEl) {
          listEl.innerHTML = buffer.map((file, idx) => `
            <li>
              <span>${file.name}</span>
              <div class="d-inline-flex align-items-center gap-2">
                <button type="button" class="btn btn-sm btn-link text-primary p-0" data-replace-file="${idx}">ganti</button>
                <button type="button" class="btn btn-sm btn-link text-danger p-0" data-remove-file="${idx}">hapus</button>
              </div>
            </li>
          `).join('');
        }
      };

      const clearFiles = () => {
        buffer = [];
        syncInputFiles();
        setFileName();
      };

      const appendFiles = (files, mode = 'append') => {
        if (!Array.isArray(files) || !files.length) return;
        let next = mode === 'replace' ? [] : [...buffer];

        files.forEach((file) => {
          if (!file || !file.type || !file.type.startsWith('image/')) return;
          if (file.size > maxKb * 1024) {
            alert(`File "${file.name}" melebihi batas ${(maxKb / 1024).toFixed(1)} MB.`);
            return;
          }
          next.push(file);
        });

        if (next.length > maxFiles) {
          alert(`Maksimal ${maxFiles} file per upload.`);
          next = next.slice(0, maxFiles);
        }

        buffer = next;
        syncInputFiles();
        setFileName();
      };

      const replaceFileAt = (idx, file) => {
        if (idx < 0 || idx >= buffer.length) return;
        if (!file || !file.type || !file.type.startsWith('image/')) return;
        if (file.size > maxKb * 1024) {
          alert(`File "${file.name}" melebihi batas ${(maxKb / 1024).toFixed(1)} MB.`);
          return;
        }
        buffer[idx] = file;
        syncInputFiles();
        setFileName();
      };

      const replacePicker = document.createElement('input');
      replacePicker.type = 'file';
      replacePicker.accept = '.jpg,.jpeg,.png,.webp,image/*';
      replacePicker.className = 'd-none';
      replacePicker.dataset.mode = 'single-replace';
      zone.appendChild(replacePicker);

      zone.addEventListener('click', (e) => {
        const actionEl = e.target.closest('[data-file-action]');
        const removeEl = e.target.closest('[data-remove-file]');
        const replaceEl = e.target.closest('[data-replace-file]');
        const fileInputEl = e.target.closest('input[type="file"]');
        if (actionEl || removeEl || replaceEl || fileInputEl) return;
        if (!input) return;
        input.dataset.pickMode = 'append';
        input.click();
      });
      zone.addEventListener('click', (e) => {
        const actionEl = e.target.closest('[data-file-action]');
        if (!actionEl || !input) return;
        const action = actionEl.getAttribute('data-file-action');
        if (action === 'clear') {
          clearFiles();
          return;
        }
        input.dataset.pickMode = action === 'replace' ? 'replace' : 'append';
        input.click();
      });
      zoneScope.addEventListener('click', (e) => {
        const replaceBtn = e.target.closest('[data-replace-file]');
        if (!replaceBtn) return;
        const idx = Number(replaceBtn.getAttribute('data-replace-file'));
        if (Number.isNaN(idx)) return;
        replacePicker.dataset.replaceIndex = String(idx);
        replacePicker.click();
      });
      zoneScope.addEventListener('click', (e) => {
        const removeBtn = e.target.closest('[data-remove-file]');
        if (!removeBtn) return;
        const idx = Number(removeBtn.getAttribute('data-remove-file'));
        if (Number.isNaN(idx)) return;
        buffer.splice(idx, 1);
        syncInputFiles();
        setFileName();
      });
      zone.addEventListener('dragover', (e) => {
        e.preventDefault();
        zone.classList.add('is-dragover');
      });
      zone.addEventListener('dragleave', (e) => {
        if (!zone.contains(e.relatedTarget)) {
          zone.classList.remove('is-dragover');
        }
      });
      zone.addEventListener('drop', (e) => {
        e.preventDefault();
        zone.classList.remove('is-dragover');
        appendFiles(Array.from(e.dataTransfer?.files || []), 'append');
      });
      input?.addEventListener('change', () => {
        const mode = input.dataset.pickMode === 'replace' ? 'replace' : 'append';
        appendFiles(Array.from(input.files || []), mode);
        input.dataset.pickMode = 'append';
      });
      replacePicker.addEventListener('change', () => {
        const idx = Number(replacePicker.dataset.replaceIndex);
        const file = replacePicker.files?.[0] || null;
        if (!Number.isNaN(idx) && file) {
          replaceFileAt(idx, file);
        }
        replacePicker.value = '';
        replacePicker.dataset.replaceIndex = '';
      });
      setFileName();
    });
  }

  function initDateFieldFocusFix() {
    const loanDate = document.getElementById('loan_date');
    const returnDate = document.getElementById('return_date_planned');
    if (!loanDate || !returnDate) return;

    const toIso = (dateObj) => {
      const y = dateObj.getFullYear();
      const m = String(dateObj.getMonth() + 1).padStart(2, '0');
      const d = String(dateObj.getDate()).padStart(2, '0');
      return `${y}-${m}-${d}`;
    };

    const applyMinReturnDate = () => {
      if (!loanDate.value) return;
      returnDate.min = loanDate.value;
      if (returnDate.value && returnDate.value < loanDate.value) {
        returnDate.value = loanDate.value;
      }
    };

    const setReturnByOffset = (offset) => {
      const base = loanDate.value ? new Date(`${loanDate.value}T00:00:00`) : new Date();
      if (Number.isNaN(base.getTime())) return;
      base.setDate(base.getDate() + offset);
      returnDate.value = toIso(base);
      applyMinReturnDate();
    };

    loanDate.addEventListener('change', applyMinReturnDate);
    applyMinReturnDate();

    document.querySelectorAll('[data-date-preset]').forEach((btn) => {
      btn.addEventListener('click', () => {
        const preset = btn.getAttribute('data-date-preset');
        if (preset === 'today') setReturnByOffset(0);
        if (preset === 'plus1') setReturnByOffset(1);
        if (preset === 'plus7') setReturnByOffset(7);
      });
    });
  }
</script>
@endpush



