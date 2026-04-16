@extends('layouts.landing')

@php
    $title = 'SARPRAS PUSDATEKIN - Sarana Prasarana BPIP';
    $summaryData = $summaryData ?? ($summary ?? []);
    $availableAssets = $availableAssets ?? [];
    $activeLoans = $activeLoans ?? [];
    $landingVideoUrl = $landingVideoUrl ?? null;
    $landingVideoMime = $landingVideoMime ?? null;
    $hasHeroVideo = filled($landingVideoUrl);
    $loanGroups = collect($activeLoans)->groupBy(function ($loan) {
        return $loan->batch_code ?: ('loan-'.$loan->id);
    })->map(function ($group) {
      $activeItems = $group->filter(function ($loan) {
        return (int) ($loan->quantity_remaining ?? 0) > 0;
      });
      $first = $activeItems->first() ?? $group->first();
      $loanDate = $activeItems->min('loan_date') ?? $group->min('loan_date');
      $plannedReturn = ($activeItems->isNotEmpty() ? $activeItems : $group)
        ->filter(fn($loan) => $loan->return_date_planned)
        ->min('return_date_planned');
        $lateDays = $plannedReturn && now()->isAfter($plannedReturn)
            ? now()->diffInDays($plannedReturn)
            : 0;
      $assetsLabels = ($activeItems->isNotEmpty() ? $activeItems : $group)->map(function ($loan) {
            $name = $loan->asset->name ?? 'Sarana tidak ditemukan';
            $code = $loan->asset->code ?? null;
        $quantity = (int) ($loan->quantity_remaining ?? 0);
            $label = trim($name . ($code ? " ({$code})" : ''));
            if ($quantity > 1) {
                $label .= ' x' . $quantity;
            }
            return $label;
        })->filter();
        $assetsCount = $assetsLabels->count();
        $assetsPreview = $assetsLabels->take(2)->implode(' • ');
        if ($assetsCount > 2) {
            $assetsPreview .= ' +' . ($assetsCount - 2) . ' lainnya';
        }
        $activity = trim((string) ($first->activity_name ?? ''));
        if ($activity === '') {
            $activity = trim((string) ($first->notes ?? ''));
        }

        return (object) [
            'borrower_name' => $first->borrower_name,
            'unit' => $first->unit,
            'activity' => $activity,
          'total_quantity' => (int) ($activeItems->isNotEmpty() ? $activeItems : $group)
            ->sum(fn ($loan) => (int) ($loan->quantity_remaining ?? 0)),
            'loan_date' => $loanDate,
            'return_date_planned' => $plannedReturn,
            'late_days' => $lateDays,
            'assets_preview' => $assetsPreview ?: 'Teks aset belum tersedia',
            'assets_full' => $assetsLabels->implode(', '),
            'batch_code' => $first->batch_code,
        ];
      })->filter(fn ($loan) => (int) ($loan->total_quantity ?? 0) > 0)->values();
@endphp

@push('styles')
<style>
  body {
    font-family: "Poppins", var(--bs-body-font-family, sans-serif);
  }
.btn-sound {
    position: absolute;
    bottom: 20px;
    right: 20px;
    z-index: 10;
    background: rgba(0,0,0,0.5);
    color: #fff;
    border: none;
    padding: 8px 12px;
    border-radius: 50%;
    cursor: pointer;
}
  .hero-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2.5rem;
    align-items: center;
  }
  .hero-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: color-mix(in srgb, var(--brand-blue) 18%, transparent);
    padding: 0.6rem 1.2rem;
    border-radius: 999px;
    color: var(--brand-blue);
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    font-size: 0.75rem;
    border: 1px solid color-mix(in srgb, var(--brand-blue) 45%, transparent);
  }
  .hero-heading {
    font-size: clamp(1.9rem, 4vw, 2.7rem);
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: 0.02em;
    line-height: 1.2;
  }
  .hero-subtext {
    color: var(--text-secondary);
    max-width: 520px;
    font-size: 0.96rem;
    line-height: 1.65;
  }
  .hero-grid .btn.btn-lg {
    font-size: 0.95rem;
    padding: 0.6rem 1.15rem !important;
  }
  .hero-image {
    position: relative;
    border-radius: 28px;
    overflow: hidden;
    box-shadow: 0 25px 70px rgba(15, 23, 42, 0.35);
    border: 1px solid color-mix(in srgb, var(--brand-blue) 35%, transparent);
    min-height: 320px;
  }
  .hero-image::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(15, 23, 42, 0.05), rgba(2, 6, 23, 0.35));
    pointer-events: none;
  }
  .hero-image--has-video::after {
    background: linear-gradient(180deg, rgba(15, 23, 42, 0.08), rgba(2, 6, 23, 0.25));
  }
  .hero-video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .metrics-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 1.5rem;
  }
  .metric-card {
    background: var(--surface-2);
    border: 1px solid color-mix(in srgb, var(--text-primary) 12%, transparent);
    border-radius: 18px;
    padding: 1.6rem;
    box-shadow: 0 12px 30px color-mix(in srgb, var(--brand-blue) 14%, transparent);
  }
  .metric-label {
    text-transform: uppercase;
    letter-spacing: 0.12em;
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--text-secondary);
  }
  .metric-value {
    font-size: clamp(2.2rem, 4vw, 2.8rem);
    font-weight: 700;
    color: var(--brand-blue);
  }
  .metric-value--warn {
    color: #f59e0b;
  }
  .metric-desc {
    color: var(--text-secondary);
  }
  .badge-accent {
    background: color-mix(in srgb, var(--brand-blue) 14%, transparent);
    color: color-mix(in srgb, var(--brand-blue) 78%, #1e293b);
    border: 1px solid color-mix(in srgb, var(--brand-blue) 26%, transparent);
  }

  .section-panel {
    background: linear-gradient(160deg, color-mix(in srgb, var(--surface-2) 96%, #ffffff) 0%, color-mix(in srgb, var(--surface-3) 86%, #ffffff) 100%);
    border: 1px solid color-mix(in srgb, var(--text-primary) 10%, transparent);
    border-radius: 20px;
    padding: 1.3rem;
    box-shadow: 0 14px 32px color-mix(in srgb, var(--brand-blue) 12%, transparent);
    height: 100%;
    color: var(--text-primary);
    font-family: "Poppins", var(--bs-body-font-family, sans-serif);
  }
  .section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.8rem;
  }
  .section-header h5 {
    font-size: 1.2rem;
    font-weight: 700;
    letter-spacing: 0;
  }
  .scroll-list {
      max-height: 380px;
      overflow-y: auto;
    padding-right: 0.35rem;
  }
    .scroll-list::-webkit-scrollbar {
      width: 6px;
    }
    .scroll-list::-webkit-scrollbar-thumb {
      background: color-mix(in srgb, var(--brand-blue) 45%, transparent);
      border-radius: 8px;
    }
  .asset-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.75rem;
    padding: 0.7rem 0;
    border-bottom: 1px solid color-mix(in srgb, var(--text-secondary) 25%, transparent);
  }
  .asset-item:last-child {
    border-bottom: none;
  }
  .asset-thumb {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    border: 1px solid color-mix(in srgb, var(--text-secondary) 30%, transparent);
    background: var(--surface-3);
    color: var(--brand-cyan);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    margin-right: 0.75rem;
    overflow: hidden;
  }
  .asset-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .asset-info {
    flex: 1;
    min-width: 0;
  }
  .asset-name {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.96rem;
    line-height: 1.35;
  }
  .asset-meta {
    color: var(--text-secondary);
    font-size: 0.84rem;
    line-height: 1.45;
  }
  .asset-quantity {
    background: color-mix(in srgb, #22c55e 16%, transparent);
    color: #166534;
    border-radius: 999px;
    padding: 0.28rem 0.8rem;
    font-weight: 600;
    font-size: 0.88rem;
    white-space: nowrap;
  }

  .loan-card {
    background: linear-gradient(155deg, color-mix(in srgb, #ffffff 86%, var(--surface-2)) 0%, color-mix(in srgb, #f5f7fb 88%, var(--surface-3)) 100%);
    border: 1px solid color-mix(in srgb, var(--brand-blue) 18%, transparent);
    border-radius: 18px;
    padding: 1rem;
    box-shadow: 0 10px 26px color-mix(in srgb, var(--brand-blue) 11%, transparent);
    display: flex;
    flex-direction: column;
    gap: 0.85rem;
    position: relative;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
  }
  .loan-card:hover {
    transform: translateY(-2px);
    border-color: color-mix(in srgb, var(--brand-blue) 34%, transparent);
    box-shadow: 0 14px 30px color-mix(in srgb, var(--brand-blue) 14%, transparent);
  }
  .loan-card__header {
    display: flex;
    justify-content: space-between;
    gap: 0.9rem;
    position: relative;
    z-index: 1;
    align-items: flex-start;
  }
  .loan-card__header > div:first-child {
    min-width: 0;
  }
  .loan-card__borrower {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.65rem;
  }
  .loan-context {
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
    margin-top: 0.4rem;
  }
  .loan-label-inline {
    font-size: 0.66rem;
    text-transform: uppercase;
    letter-spacing: 0.18em;
    color: color-mix(in srgb, var(--text-secondary) 85%, transparent);
    font-weight: 700;
    margin-bottom: 0.32rem;
    display: inline-block;
  }
  .loan-title {
    font-size: clamp(1.05rem, 1.6vw, 1.2rem);
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1.3;
  }
  .loan-context-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.8rem;
    background: color-mix(in srgb, var(--brand-blue) 14%, transparent);
    color: var(--brand-blue);
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 600;
    max-width: 100%;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .loan-unit {
    background: color-mix(in srgb, var(--brand-blue) 15%, transparent);
    color: var(--brand-blue);
    border-radius: 999px;
    padding: 0.2rem 0.8rem;
    font-size: 0.74rem;
    font-weight: 600;
  }
  .loan-head-stats {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.4rem;
    flex-shrink: 0;
  }
  .loan-quantity {
    background: color-mix(in srgb, var(--brand-cyan) 22%, transparent);
    color: color-mix(in srgb, var(--brand-blue) 75%, var(--text-primary));
    border-radius: 999px;
    padding: 0.32rem 0.95rem;
    font-weight: 700;
    font-size: 0.95rem;
    white-space: nowrap;
  }
  .loan-status-chip {
    font-size: 0.76rem;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    border-radius: 999px;
    padding: 0.3rem 0.9rem;
    font-weight: 700;
    background: color-mix(in srgb, #10b981 20%, transparent);
    color: #047857;
    white-space: nowrap;
  }
  .loan-status-chip.is-overdue {
    background: rgba(248, 113, 113, 0.16);
    color: #b91c1c;
  }
  .loan-metadata-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
    gap: 0.7rem;
    position: relative;
    z-index: 1;
  }
  .loan-metadata-grid > div {
    min-width: 0;
  }
  .loan-label {
    font-size: 0.72rem;
    text-transform: uppercase;
    letter-spacing: 0.16em;
    color: color-mix(in srgb, var(--text-secondary) 80%, transparent);
    font-weight: 700;
    display: block;
    margin-bottom: 0.25rem;
  }
  .loan-value {
    color: var(--text-primary);
    font-size: 0.96rem;
    font-weight: 700;
    line-height: 1.45;
  }
  .loan-value--compact {
    font-size: 0.84rem;
    font-weight: 600;
    line-height: 1.45;
    display: block;
    white-space: normal;
    overflow-wrap: anywhere;
    word-break: break-word;
  }
  .loan-value--compact strong {
    font-family: inherit;
    font-weight: 600;
  }
  .loan-muted {
    color: color-mix(in srgb, var(--text-secondary) 65%, transparent);
  }
  .loan-alert {
    align-self: flex-start;
    padding: 0.35rem 0.95rem;
    border-radius: 999px;
    background: rgba(248, 113, 113, 0.15);
    color: #b91c1c;
    font-weight: 600;
    font-size: 0.82rem;
    position: relative;
    z-index: 1;
  }
  .loan-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    position: relative;
    z-index: 1;
  }
  .loan-proof-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.35rem;
    padding: 0.38rem 0.85rem;
    border-radius: 999px;
    border: 1px solid color-mix(in srgb, var(--brand-blue) 35%, transparent);
    background: color-mix(in srgb, var(--brand-blue) 10%, transparent);
    color: color-mix(in srgb, var(--brand-blue) 78%, #1e293b);
    font-size: 0.82rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
  }
  .loan-proof-btn:hover,
  .loan-proof-btn:focus {
    background: color-mix(in srgb, var(--brand-blue) 18%, transparent);
    border-color: color-mix(in srgb, var(--brand-blue) 50%, transparent);
    color: var(--brand-blue-dark);
    text-decoration: none;
  }
  .loan-meta-inline__dates {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    align-items: center;
    font-size: 0.8rem;
    color: var(--text-primary);
  }
  .loan-meta-inline__dates span {
    display: inline-flex;
    align-items: baseline;
    flex-wrap: wrap;
  }
  .loan-meta-inline__dates .loan-meta-sep {
    opacity: 0.45;
  }
  .feature-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
  }
  .feature-card {
    background: var(--surface-2);
    border: 1px solid color-mix(in srgb, var(--text-primary) 12%, transparent);
    border-radius: 16px;
    padding: 1.2rem;
    height: 100%;
    box-shadow: 0 16px 40px color-mix(in srgb, var(--brand-blue) 14%, transparent);
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
  }
  .feature-title {
    font-weight: 700;
    color: var(--text-primary);
    font-size: 1.02rem;
    line-height: 1.35;
  }
  .feature-desc {
    color: var(--text-secondary);
    font-size: 0.88rem;
    line-height: 1.55;
  }

  body.theme-dark .section-panel {
    background: linear-gradient(165deg, rgba(15, 23, 42, 0.94) 0%, rgba(17, 24, 39, 0.9) 100%);
    border-color: rgba(148, 163, 184, 0.26);
    box-shadow: 0 14px 34px rgba(0, 0, 0, 0.34);
  }

  body.theme-dark .section-header h5,
  body.theme-dark .asset-name,
  body.theme-dark .loan-title,
  body.theme-dark .loan-value,
  body.theme-dark .feature-title {
    color: #f8fafc;
  }

  body.theme-dark .asset-meta,
  body.theme-dark .feature-desc,
  body.theme-dark .loan-meta-inline__dates,
  body.theme-dark .loan-label,
  body.theme-dark .loan-label-inline {
    color: #94a3b8;
  }

  body.theme-dark .asset-item {
    border-bottom-color: rgba(148, 163, 184, 0.18);
  }

  body.theme-dark .loan-card {
    background: linear-gradient(155deg, rgba(15, 23, 42, 0.92) 0%, rgba(30, 41, 59, 0.86) 100%);
    border-color: rgba(125, 211, 252, 0.24);
    box-shadow: 0 12px 30px rgba(2, 6, 23, 0.42);
  }

  body.theme-dark .loan-card:hover {
    border-color: rgba(125, 211, 252, 0.38);
    box-shadow: 0 16px 34px rgba(2, 6, 23, 0.5);
  }

  body.theme-dark .loan-context-pill,
  body.theme-dark .loan-unit,
  body.theme-dark .loan-quantity,
  body.theme-dark .badge-accent {
    color: #bfdbfe;
    background: rgba(59, 130, 246, 0.2);
    border-color: rgba(96, 165, 250, 0.3);
  }

  body.theme-dark .asset-quantity {
    color: #bbf7d0;
    background: rgba(34, 197, 94, 0.22);
  }

  body.theme-dark .loan-status-chip {
    color: #bbf7d0;
    background: rgba(16, 185, 129, 0.24);
  }

  body.theme-dark .loan-status-chip.is-overdue {
    color: #fecaca;
    background: rgba(248, 113, 113, 0.24);
  }

  body.theme-dark .loan-proof-btn {
    color: #bfdbfe;
    background: rgba(59, 130, 246, 0.14);
    border-color: rgba(96, 165, 250, 0.36);
  }

  body.theme-dark .loan-proof-btn:hover,
  body.theme-dark .loan-proof-btn:focus {
    color: #dbeafe;
    background: rgba(59, 130, 246, 0.24);
    border-color: rgba(147, 197, 253, 0.44);
  }

  body.theme-dark .feature-card {
    background: rgba(15, 23, 42, 0.9);
    border-color: rgba(148, 163, 184, 0.24);
    box-shadow: 0 14px 32px rgba(2, 6, 23, 0.36);
  }

  @media (max-width: 991.98px) {
    .section-panel {
      padding: 1rem;
    }

    .loan-card {
      padding: 0.85rem;
      gap: 0.72rem;
    }

    .loan-card__header {
      flex-direction: column;
      gap: 0.55rem;
    }

    .loan-head-stats {
      align-items: flex-start;
      flex-direction: row;
      flex-wrap: wrap;
      gap: 0.45rem;
    }

    .loan-meta-inline__dates {
      font-size: 0.86rem;
    }
  }

  @media (max-width: 575.98px) {
    .loan-value--compact {
      font-size: 0.76rem;
      line-height: 1.42;
    }

    .loan-meta-inline__dates {
      font-size: 0.72rem;
      gap: 0.35rem;
    }

    .loan-label {
      font-size: 0.64rem;
      letter-spacing: 0.12em;
    }
  }

  /* Modal Login Styles */
  .modal-backdrop.show {
    backdrop-filter: blur(8px);
    background-color: rgba(15, 23, 42, 0.5);
  }
  
  .modal.fade .modal-dialog {
    transform: scale(0.7);
    opacity: 0;
    transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s ease;
  }
  
  .modal.show .modal-dialog {
    transform: scale(1);
    opacity: 1;
  }
  
  .modal-login .modal-content {
    border: none;
    border-radius: 24px;
    box-shadow: 0 20px 60px rgba(15, 23, 42, 0.3);
    background: var(--surface-1);
  }
  
  .modal-login .modal-header {
    border-bottom: 1px solid color-mix(in srgb, var(--text-primary) 12%, transparent);
    padding: 2.5rem 2rem 1.5rem;
    justify-content: center;
    align-items: center;
  }
  
  .modal-login .modal-header img {
    margin-bottom: 1rem;
    max-width: 90%;
  }
  
  .modal-login .modal-title {
    font-size: 1.35rem;
    font-weight: 700;
    color: var(--text-primary);
    text-align: center;
    margin: 0;
  }
  
  .modal-login .btn-close {
    opacity: 0.7;
    transition: opacity 0.2s ease;
  }
  
  .modal-login .btn-close:hover {
    opacity: 1;
  }
  
  .modal-login .modal-body {
    padding: 2rem;
  }
  
  .modal-login .form-label {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.6rem;
  }
  
  .modal-login .form-control {
    background: var(--surface-2);
    border: 1px solid color-mix(in srgb, var(--text-secondary) 30%, transparent);
    border-radius: 10px;
    padding: 0.75rem 1rem;
    color: var(--text-primary);
    font-size: 0.95rem;
    transition: all 0.3s ease;
  }
  
  .modal-login .form-control:focus {
    background: var(--surface-2);
    border-color: var(--brand-blue);
    box-shadow: 0 0 0 3px color-mix(in srgb, var(--brand-blue) 20%, transparent);
    color: var(--text-primary);
  }
  
  .modal-login .form-control::placeholder {
    color: color-mix(in srgb, var(--text-secondary) 70%, transparent);
  }
  
  .modal-login .btn {
    border-radius: 10px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  
  .modal-login .btn-primary {
    background: var(--brand-blue);
    border-color: var(--brand-blue);
  }
  
  .modal-login .btn-primary:hover {
    background: color-mix(in srgb, var(--brand-blue) 90%, black);
    border-color: color-mix(in srgb, var(--brand-blue) 90%, black);
    transform: translateY(-2px);
    box-shadow: 0 8px 16px color-mix(in srgb, var(--brand-blue) 35%, transparent);
  }
  
  .modal-login .alert {
    border-radius: 10px;
    border: none;
  }
  
  .show-pass {
    cursor: pointer;
    opacity: 0.7;
    transition: opacity 0.2s ease;
  }
  
  .show-pass:hover {
    opacity: 1;
  }

</style>
@endpush

@section('content')
  <div class="hero-grid mb-5">
    <div>
      <h1 class="hero-heading mt-3">Sarpras Pusdatekin BPIP</h1>
      <p class="hero-subtext mt-3">
        Kelola kebutuhan sarana prasarana dengan cepat dan terarah. Pantau ketersediaan, ajukan peminjaman,
        dan dukung setiap kegiatan dengan fasilitas yang selalu siap digunakan.
      </p>
      <div class="d-flex flex-wrap gap-3 mt-4">
        <a class="btn btn-lg btn-primary px-4" href="{{ route('assets.loanable') }}">Lihat Koleksi Sarpras</a>
        <button class="btn btn-lg btn-outline-primary px-4" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk Dashboard</button>
      </div>
    </div>
      <div class="hero-image {{ $hasHeroVideo ? 'hero-image--has-video' : '' }}">
        @if($hasHeroVideo)
          <video
            id="heroVideo"
            class="hero-video"
            autoplay
            muted
            loop
            playsinline
            preload="metadata"
          >
            <source src="{{ $landingVideoUrl }}" @if($landingVideoMime) type="{{ $landingVideoMime }}" @endif>
            Browser Anda tidak mendukung pemutaran video.
          </video>
        @else
          <div class="hero-video" aria-hidden="true"></div>
        @endif
      </div>
  </div>

  <div class="row g-4 mt-3">
    <div class="col-lg-6">
      <div class="section-panel">
        <div class="section-header">
          <h5 class="mb-0">Sarpras Tersedia</h5>
          <span class="badge badge-accent rounded-pill">{{ number_format(data_get($summaryData, 'available', 0)) }} unit</span>
        </div>
        <div class="scroll-list">
          @forelse(($availableAssets ?? []) as $asset)
            <div class="asset-item">
              <div class="d-flex align-items-center flex-grow-1 min-w-0">
                <div class="asset-thumb">
                  @if($asset->photo_url)
                    <img src="{{ $asset->photo_url }}" alt="Foto {{ $asset->name }}">
                  @else
                    {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($asset->name ?? '?', 0, 1)) }}
                  @endif
                </div>
                <div class="asset-info">
                  <div class="asset-name text-truncate">{{ $asset->name }}</div>
                  <div class="asset-meta text-truncate">{{ $asset->category ?? 'Kategori belum diatur' }}</div>
                </div>
              </div>
              @if((int) ($asset->quantity_available ?? 0) !== 1)
                <span class="asset-quantity">{{ $asset->quantity_available }} unit</span>
              @endif
            </div>
          @empty
            <p class="text-muted mb-0">Belum ada sarpras siap pinjam untuk ditampilkan.</p>
          @endforelse
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="section-panel">
        <div class="section-header">
          <h5 class="mb-0">Peminjaman Aktif</h5>
          <span class="badge rounded-pill text-bg-warning">{{ number_format(data_get($summaryData, 'in_use', 0)) }} unit</span>
        </div>
        <div class="scroll-list">
          @forelse($loanGroups as $loan)
            @php
                $loanDate = optional($loan->loan_date)->format('d M Y');
                $plannedReturn = optional($loan->return_date_planned)->format('d M Y');
                $overdue = $loan->late_days > 0;
            @endphp
            <article class="loan-card mb-4 {{ $overdue ? 'is-overdue' : '' }}">
              <div class="loan-card__header">
                <div>
                  <span class="loan-label-inline">Nama Peminjam</span>
                  <div class="loan-card__borrower">
                    <span class="loan-title text-truncate">{{ $loan->borrower_name ?? 'Peminjam' }}</span>
                    @if($loan->unit)
                      <span class="loan-unit">{{ $loan->unit }}</span>
                    @endif
                  </div>
                  @if(!empty($loan->activity))
                    <div class="loan-context">
                      <span class="loan-label-inline">Nama Kegiatan</span>
                      <span class="loan-context-pill">{{ \Illuminate\Support\Str::limit($loan->activity, 40) }}</span>
                    </div>
                  @endif
                </div>
                <div class="loan-head-stats">
                  @if((int) ($loan->total_quantity ?? 0) !== 1)
                    <span class="loan-quantity">{{ (int) ($loan->total_quantity ?? 0) }} unit</span>
                  @endif
                  <span class="loan-status-chip {{ $overdue ? 'is-overdue' : '' }}">{{ $overdue ? 'Perlu perhatian' : 'Sedang Dipinjam' }}</span>
                </div>
              </div>
              <div class="loan-metadata-grid">
                <div>
                  <span class="loan-label">Alat yang Dipinjam</span>
                  <span class="loan-value loan-value--compact" title="{{ $loan->assets_full }}"><strong>{{ \Illuminate\Support\Str::limit($loan->assets_preview, 120) }}</strong></span>
                </div>
                <div>
                  <span class="loan-label">Pinjam & Target Kembali</span>
                  <div class="loan-meta-inline__dates">
                    <span>Pinjam :&nbsp;<strong>{{ $loanDate ?? '-' }}</strong></span>
                    <span class="{{ $overdue ? 'text-danger' : '' }}">Target :&nbsp;<strong>{{ $plannedReturn ?? 'Tanpa batas' }}</strong></span>
                  </div>
                </div>
              </div>
              @if($loan->late_days > 0)
                <div class="loan-alert">Terlambat {{ $loan->late_days }} hari</div>
              @endif
              @if(!empty($loan->batch_code))
                <div class="loan-actions">
                  <a href="{{ route('loans.receipt', ['batch' => $loan->batch_code, 'preview' => 1]) }}" target="_blank" rel="noopener" class="loan-proof-btn">
                    Bukti Pinjam
                  </a>
                </div>
              @endif
            </article>
          @empty
            <p class="text-muted mb-0">Belum ada catatan peminjaman aktif.</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  <div id="fitur" class="feature-row mt-5">
    <div class="feature-card">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="36" height="36" aria-hidden="true">
        <rect x="3" y="3" width="18" height="18" rx="2.5" stroke-width="1.7"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M3 10h18M8 3v18M16 3v18"/>
        <rect x="4.5" y="4.5" width="2.5" height="2.5" rx="0.6" fill="currentColor" opacity="0.55" stroke="none"/>
        <rect x="17" y="12.5" width="2.5" height="2.5" rx="0.6" fill="currentColor" opacity="0.55" stroke="none"/>
      </svg>
      <h5 class="feature-title mb-1">Inventaris Sarpras Terpusat</h5>
      <p class="feature-desc mb-0">Seluruh perangkat tercatat rapi dan mudah dipantau dari satu sistem.</p>
    </div>
    <div class="feature-card">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="36" height="36" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M4 7h6l2 2h8v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M10 13l2 2 4-4"/>
      </svg>
      <h5 class="feature-title mb-1">Peminjaman Transparan</h5>
      <p class="feature-desc mb-0">Proses peminjaman jelas dengan pengingat otomatis jadwal pengembalian.</p>
    </div>
    <div class="feature-card">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="36" height="36" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M4 19h16"/>
        <rect x="5" y="12" width="3" height="7" rx="0.7" fill="currentColor" opacity="0.45" stroke="none"/>
        <rect x="10.5" y="9" width="3" height="10" rx="0.7" fill="currentColor" opacity="0.65" stroke="none"/>
        <rect x="16" y="6" width="3" height="13" rx="0.7" fill="currentColor" opacity="0.85" stroke="none"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M5.5 8.5l4-3 3.5 2 4.5-3"/>
      </svg>
      <h5 class="feature-title mb-1">Analitik Real-time</h5>
      <p class="feature-desc mb-0">Laporan pemakaian sarpras membantu pengambilan keputusan yang cepat.</p>
    </div>
  </div>

  <!-- Login Modal -->
  <div class="modal fade modal-login" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
      <div class="modal-content">
        <div class="modal-header border-0 position-relative text-center py-0" style="flex-direction: column;">
          <button type="button" class="btn-close position-absolute end-0 top-0" data-bs-dismiss="modal" aria-label="Close" style="margin: 1.5rem;"></button>
          <img src="{{ asset('evanto/assets/images/Logo Baju Pusdatin.png') }}" alt="SARPRAS" class="img-fluid" style="max-height:60px;" onerror="this.style.display='none'">
          <h5 class="modal-title" id="loginModalLabel">Masuk Dashboard</h5>
        </div>
        <div class="modal-body">
          @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          @if (session('status'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
              {{ session('status') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Login Gagal!</strong>
              <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <form method="POST" action="{{ route('login') }}" class="sarpras-login-form">
            @csrf

            <div class="form-group mb-3">
              <label class="form-label"><strong>Email / Username</strong></label>
              <input id="login" type="text" class="form-control dz-username @error('login') is-invalid @enderror"
                     name="login" value="{{ old('login') }}" required autofocus placeholder="Masukkan username atau email anda">
              @error('login')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group mb-3">
              <label class="form-label"><strong>Password</strong></label>
              <div class="position-relative">
                <input id="password" type="password" autocomplete="current-password"
                       class="form-control dz-password @error('password') is-invalid @enderror"
                       name="password" required placeholder="Masukkan password anda">
                <span class="show-pass position-absolute top-50 end-0 me-2 translate-middle-y" style="cursor: pointer;">
                  <span class="show"><i class="fa fa-eye-slash"></i></span>
                  <span class="hide"><i class="fa fa-eye"></i></span>
                </span>
                @error('password')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="form-group mb-4">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="form-check-input" name="remember" id="remember_modal" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember_modal">Ingat preferensi saya</label>
              </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-lg mb-2">Masuk Sekarang</button>

            @if (Route::has('password.request'))
              <div class="text-center">
                <button type="button" class="btn btn-link small" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Lupa password?</button>
              </div>
            @endif
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Forgot Password Modal -->
  <div class="modal fade modal-login" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
      <div class="modal-content">
        <div class="modal-header border-0 position-relative text-center py-0" style="flex-direction: column;">
          <button type="button" class="btn-close position-absolute end-0 top-0" data-bs-dismiss="modal" aria-label="Close" style="margin: 1.5rem;"></button>
          <img src="{{ asset('evanto/assets/images/Logo Baju Pusdatin.png') }}" alt="SARPRAS" class="img-fluid" style="max-height:60px;" onerror="this.style.display='none'">
          <h5 class="modal-title" id="forgotPasswordModalLabel">Lupa Password</h5>
        </div>
        <div class="modal-body">
          <p class="text-muted mb-4">Masukkan email untuk menerima tautan reset password.</p>
          
          @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('status') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Terjadi Kesalahan!</strong>
              <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group mb-4">
              <label class="form-label"><strong>Email</strong></label>
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                     name="email" value="{{ old('email') }}" required autofocus placeholder="Masukkan email anda">
              @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <button type="submit" class="btn btn-primary w-100 btn-lg mb-2">Kirim Tautan Reset</button>
            <div class="text-center">
              <button type="button" class="btn btn-link small" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Kembali ke login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Handle show/hide password toggle in modal
      const showPassElements = document.querySelectorAll('.show-pass');
      
      showPassElements.forEach(el => {
        el.addEventListener('click', function() {
          const passwordInput = this.closest('.position-relative').querySelector('input');
          const show = this.querySelector('.show');
          const hide = this.querySelector('.hide');
          
          if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            show.style.display = 'none';
            hide.style.display = 'inline';
          } else {
            passwordInput.type = 'password';
            show.style.display = 'inline';
            hide.style.display = 'none';
          }
        });
      });
    });
  </script>
  <script>
function toggleSound() {
    const video = document.getElementById('heroVideo');
    const btn = document.getElementById('btnSound');

    if (!video || !btn) {
        return;
    }

    video.muted = !video.muted;

    if (video.muted) {
        btn.innerHTML = '🔇';
    } else {
        btn.innerHTML = '🔊';
        video.play(); // penting biar suara aktif
    }
}
</script>


@endsection
