@php($title = 'Pengembalian Aset')
@extends('layouts.app')

@push('styles')
<style>
  .file-drop {
    border: 1px dashed rgba(148, 163, 184, 0.8);
    border-radius: 16px;
    padding: 1rem;
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
    width: 44px; height: 44px; border-radius: 12px;
    margin: 0 auto 0.5rem;
    display: flex; align-items:center; justify-content:center;
    background: rgba(16, 185, 129, 0.12); color:#047857;
  }
  .file-drop__filename { display:block; margin-top:0.3rem; color:#475569; font-size:0.9rem; }
  .file-drop__list {
    margin: 0.6rem 0 0;
    padding-left: 1rem;
    text-align: left;
    color: #475569;
    font-size: 0.82rem;
  }
  .file-drop__error {
    display: none;
    margin-top: 0.65rem;
    color: #b91c1c;
    font-size: 0.83rem;
    font-weight: 600;
  }
  .file-drop.is-invalid-size .file-drop__error { display: block; }
  .file-actions {
    display: flex;
    margin-top: 0.75rem;
    gap: 0.5rem;
    justify-content: flex-end;
    flex-wrap: wrap;
  }
  .file-actions .btn:disabled {
    opacity: 0.55;
    cursor: not-allowed;
  }
  .file-drop__preview-wrap {
    display: none;
    margin-top: 0.9rem;
    justify-content: center;
  }
  .file-drop.has-file .file-drop__preview-wrap { display: flex; }
  .file-drop__preview {
    max-width: 220px;
    max-height: 160px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    object-fit: cover;
    background: #fff;
  }
  .return-date-wrap {
    background: #f8fafc;
    border: 1px solid #dbe3ef;
    border-radius: 12px;
    padding: 0.85rem 0.85rem 0.75rem;
  }
  .return-input-wrap {
    background: #f8fafc;
    border: 1px solid #dbe3ef;
    border-radius: 12px;
    padding: 0.85rem 0.85rem 0.75rem;
  }
  .return-input-wrap .form-control {
    border-radius: 10px;
    border-color: #cbd5e1;
    font-weight: 600;
    color: #0f172a;
    background: #fff;
  }
  .return-input-wrap .form-text {
    margin-top: 0.45rem;
    color: #475569;
  }
  .return-date-wrap .form-control {
    border-radius: 10px;
    border-color: #cbd5e1;
    font-weight: 600;
    color: #0f172a;
    background: #fff;
  }
  .return-date-wrap .input-group-text {
    border-radius: 10px 0 0 10px;
    border-color: #cbd5e1;
    background: #f1f5f9;
    color: #64748b;
  }
  .return-date-wrap .input-group .form-control {
    border-left: 0;
    border-radius: 0 10px 10px 0;
  }
  .return-date-wrap .form-text {
    margin-top: 0.45rem;
    color: #475569;
  }
  .photo-max-note {
    text-decoration: underline;
    text-underline-offset: 3px;
    font-weight: 700;
    color: #0f172a;
  }
  .upload-section {
    margin-top: 0.2rem;
  }
  .upload-section .form-text {
    margin-top: 0.55rem;
  }
  .submit-actions {
    margin-top: 0.45rem;
  }
  .upload-toast {
    position: fixed;
    top: 1rem;
    right: 1rem;
    z-index: 1060;
    min-width: 260px;
    max-width: 360px;
    border-radius: 10px;
    padding: 0.75rem 0.9rem;
    color: #fff;
    background: #b91c1c;
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.25);
    opacity: 0;
    transform: translateY(-8px);
    pointer-events: none;
    transition: opacity .2s ease, transform .2s ease;
  }
  .upload-toast.is-show {
    opacity: 1;
    transform: translateY(0);
  }
</style>
@endpush

@section('content')
<main class="content-body">
<div class="container-fluid">
<h1 class="h4 mb-3">Pengembalian Aset</h1>
@php($maxPhotoKb = (int) config('bpip.loan_attachment_max_kb', 4096))
@php($maxPhotoMb = number_format($maxPhotoKb / 1024, 1))
@php($defaultReturnDate = old('return_date_actual', optional($loan->return_date_planned)->format('Y-m-d') ?: now()->format('Y-m-d')))

<div class="card mb-3">
  <div class="card-body">
    <div><strong>Aset:</strong> {{ $loan->asset->code }} - {{ $loan->asset->name }}</div>
    <div><strong>Peminjam:</strong> {{ $loan->borrower_name }} ({{ $loan->borrower_contact ?? '-' }})</div>
    <div><strong>Jumlah Dipinjam:</strong> {{ $loan->quantity }}</div>
    <div><strong>Sisa Belum Kembali:</strong> {{ $loan->quantity_remaining }}</div>
    <div><strong>Tanggal Pinjam:</strong> {{ $loan->loan_date?->format('Y-m-d') }}</div>
    <div><strong>Rencana Kembali:</strong> {{ $loan->return_date_planned?->format('Y-m-d') ?? '-' }}</div>
  </div>
  </div>

<form method="POST" action="{{ route('loans.return.update', $loan) }}" class="row g-3" enctype="multipart/form-data">
  @csrf
  @method('PUT')
  <div class="col-md-4">
    <label class="form-label">Jumlah Dikembalikan</label>
    <div class="return-input-wrap">
      <input type="number" name="return_quantity" min="1" max="{{ $loan->quantity_remaining }}" value="{{ old('return_quantity', $loan->quantity_remaining) }}" class="form-control @error('return_quantity') is-invalid @enderror" required>
      @error('return_quantity')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
      <div class="form-text">Maksimal {{ $loan->quantity_remaining }} unit.</div>
    </div>
  </div>
  <div class="col-md-4">
    <label class="form-label">Tanggal Kembali</label>
    <div class="return-date-wrap">
      <div class="input-group">
        <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
        <input type="date" name="return_date_actual" id="return_date_actual" value="{{ $defaultReturnDate }}" class="form-control @error('return_date_actual') is-invalid @enderror" lang="id" required>
      </div>
      @error('return_date_actual')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
      <div class="form-text">Default diisi dari tanggal rencana kembali pada data peminjaman.</div>
    </div>
  </div>
  <div class="col-12 upload-section" data-file-drop-section>
    <label class="form-label">Foto Pengembalian</label>
    <div class="file-drop @error('return_photo') is-invalid @enderror" data-file-drop data-preview-label="Foto Pengembalian" data-max-kb="{{ $maxPhotoKb }}" data-max-files="5">
      <input type="file" name="return_photo[]" accept=".jpg,.jpeg,.png,.webp,image/*" class="file-drop__input" required multiple>
      <div class="file-drop__body">
        <div class="file-drop__icon">📷</div>
        <strong>Tarik & lepaskan foto bukti pengembalian</strong>
        <div>atau klik untuk memilih dari komputer</div>
        <small class="file-drop__filename" data-file-drop-name>Belum ada file</small>
      </div>
      <div class="file-drop__error" data-file-drop-error></div>
      <div class="file-drop__preview-wrap" data-file-drop-preview-wrap>
        <img class="file-drop__preview" data-file-drop-preview alt="Preview foto pengembalian" />
      </div>
      <ul class="file-drop__list" data-file-drop-list></ul>
    </div>
    <div class="file-actions" data-file-drop-actions>
      <button type="button" class="btn btn-sm btn-outline-primary" data-file-drop-replace disabled>Ganti Foto</button>
      <button type="button" class="btn btn-sm btn-outline-danger" data-file-drop-clear disabled>Hapus Semua</button>
    </div>
    <div class="form-text">Tambahkan foto saat barang dikembalikan (wajib, JPG/PNG/WebP, <span class="photo-max-note">maks {{ $maxPhotoMb }} MB per file, maks 5 file</span>).</div>
    @error('return_photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
    @error('return_photo.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
  </div>
  <div class="col-12">
    <label class="form-label">Catatan</label>
    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $loan->notes) }}</textarea>
    @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-12 d-flex gap-2 submit-actions">
    <button class="btn btn-success" type="submit">Proses Pengembalian</button>
    <a href="{{ route('loans.index') }}" class="btn btn-secondary">Batal</a>
  </div>
</form>
</div>
</main>
<div class="upload-toast" id="uploadToast" role="status" aria-live="polite"></div>
@endsection

@push('scripts')
<script>
  (function initFileDropzones() {
    const toastEl = document.getElementById('uploadToast');
    let toastTimer = null;
    const showToast = (message) => {
      if (!toastEl) return;
      toastEl.textContent = message;
      toastEl.classList.add('is-show');
      if (toastTimer) {
        window.clearTimeout(toastTimer);
      }
      toastTimer = window.setTimeout(() => {
        toastEl.classList.remove('is-show');
      }, 2800);
    };

    const zones = document.querySelectorAll('[data-file-drop]');
    if (!zones.length) return;
    zones.forEach((zone) => {
      const section = zone.closest('[data-file-drop-section]') || zone.parentElement;
      const input = zone.querySelector('input[type="file"]');
      const nameEl = zone.querySelector('[data-file-drop-name]');
      const listEl = zone.querySelector('[data-file-drop-list]');
      const previewEl = zone.querySelector('[data-file-drop-preview]');
      const replaceBtn = section ? section.querySelector('[data-file-drop-replace]') : null;
      const clearBtn = section ? section.querySelector('[data-file-drop-clear]') : null;
      const errorEl = zone.querySelector('[data-file-drop-error]');
      const maxKb = Number(zone.dataset.maxKb || 0);
      const maxBytes = maxKb > 0 ? maxKb * 1024 : 0;
      const maxFiles = Number(zone.dataset.maxFiles || 1);
      let previewUrl = null;

      const setError = (message) => {
        if (!errorEl) return;
        if (message) {
          errorEl.textContent = message;
          zone.classList.add('is-invalid-size');
          return;
        }
        errorEl.textContent = '';
        zone.classList.remove('is-invalid-size');
      };

      const clearSelection = () => {
        if (!input) return;
        input.value = '';
        if (previewUrl) {
          URL.revokeObjectURL(previewUrl);
          previewUrl = null;
        }
        if (previewEl) {
          previewEl.removeAttribute('src');
        }
        if (listEl) {
          listEl.innerHTML = '';
        }
        if (nameEl) nameEl.textContent = 'Belum ada file';
        zone.classList.remove('has-file');
      };

      const validateFiles = (files) => {
        const fileList = Array.from(files || []);
        if (!fileList.length) return true;

        if (maxFiles > 0 && fileList.length > maxFiles) {
          const msg = 'Jumlah foto melebihi batas ' + maxFiles + ' file.';
          setError(msg);
          showToast(msg);
          clearSelection();
          return false;
        }

        const oversized = fileList.find((file) => maxBytes > 0 && file.size > maxBytes);
        if (oversized) {
          const maxMb = (maxBytes / (1024 * 1024)).toFixed(1);
          const msg = 'Ukuran foto melebihi batas ' + maxMb + ' MB. Silakan pilih file yang lebih kecil.';
          setError(msg);
          showToast(msg);
          clearSelection();
          return false;
        }
        setError('');
        return true;
      };

      const setFileName = () => {
        if (!input?.files?.length) {
          if (nameEl) nameEl.textContent = 'Belum ada file';
          if (previewUrl) {
            URL.revokeObjectURL(previewUrl);
            previewUrl = null;
          }
          if (previewEl) {
            previewEl.removeAttribute('src');
          }
          zone.classList.remove('has-file');
          replaceBtn && (replaceBtn.disabled = true);
          clearBtn && (clearBtn.disabled = true);
          return;
        }
        const fileList = Array.from(input.files || []);
        if (nameEl) {
          nameEl.textContent = fileList.length > 1 ? (fileList.length + ' file dipilih') : fileList[0].name;
        }
        zone.classList.add('has-file');
        replaceBtn && (replaceBtn.disabled = false);
        clearBtn && (clearBtn.disabled = false);
        if (listEl) {
          listEl.innerHTML = fileList.map((file) => '<li>' + file.name + '</li>').join('');
        }
        if (previewEl) {
          const file = fileList[0];
          if (file && file.type && file.type.startsWith('image/')) {
            if (previewUrl) {
              URL.revokeObjectURL(previewUrl);
            }
            previewUrl = URL.createObjectURL(file);
            previewEl.src = previewUrl;
          } else {
            previewEl.removeAttribute('src');
          }
        }
      };
      zone.addEventListener('click', () => input?.click());
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
        if (!input) return;
        const dt = new DataTransfer();
        if (e.dataTransfer?.files?.length) {
          const droppedFiles = Array.from(e.dataTransfer.files).slice(0, maxFiles || undefined);
          if (!validateFiles(droppedFiles)) {
            return;
          }
          droppedFiles.forEach((file) => dt.items.add(file));
        }
        input.files = dt.files;
        input.dispatchEvent(new Event('change', { bubbles: true }));
      });
      replaceBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        input?.click();
      });
      clearBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (!input) return;
        const confirmed = window.confirm('Hapus foto yang sudah dipilih?');
        if (!confirmed) return;
        clearSelection();
        setError('');
      });
      input?.addEventListener('change', () => {
        if (input?.files?.length && !validateFiles(input.files)) {
          return;
        }
        setFileName();
      });
      setFileName();
    });
  })();

  (function syncReturnDateMin() {
    const dateInput = document.getElementById('return_date_actual');
    if (!dateInput) return;
    const minDate = '{{ optional($loan->loan_date)->format('Y-m-d') }}';
    if (minDate) {
      dateInput.min = minDate;
      if (dateInput.value && dateInput.value < minDate) {
        dateInput.value = minDate;
      }
    }
  })();
</script>
@endpush
