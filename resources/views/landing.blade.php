@extends('layouts.landing')

@php
    $title = 'SARPRAS PUSDATEKIN - Sarana Prasarana BPIP';
    $summaryData = $summaryData ?? ($summary ?? []);
    $availableAssets = $availableAssets ?? [];
    $activeLoans = $activeLoans ?? [];
    $landingCategories = $landingCategories ?? collect();
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
  .landing-hero {
    display: grid;
    grid-template-columns: minmax(0, 1.2fr) minmax(320px, .8fr);
    gap: clamp(2rem, 4vw, 4rem);
    max-width: none;
    align-items: center;
    padding: 1.25rem 0 2.25rem;
  }
  .landing-hero-copy { min-width: 0; }
  .landing-hero-title {
    max-width: 680px;
    margin: 0;
    color: #081329;
    font-family: "Poppins", sans-serif;
    font-size: 44px;
    font-weight: 700;
    letter-spacing: -1.7px;
    line-height: 1.08;
  }
  .landing-hero-title .accent {
    color: #2864e8;
  }
  .landing-hero-description {
    max-width: 650px;
    margin: 1.15rem 0 0;
    color: #465570;
    font-family: "Poppins", sans-serif;
    font-size: 15px;
    font-weight: 400;
    line-height: 1.6;
  }
  .asset-search {
    display: grid;
    grid-template-columns: minmax(190px, 1.25fr) minmax(145px, .8fr) 110px;
    gap: .6rem;
    max-width: 680px;
    margin-top: 1rem;
    padding: .55rem;
    background: rgba(255,255,255,.94);
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(15,23,42,.1);
  }
  .asset-search-field {
    display: flex;
    min-width: 0;
    min-height: 46px;
    align-items: center;
    gap: .65rem;
    padding: 0 .9rem;
    color: #8290a6;
    background: #f8fafc;
    border: 1px solid transparent;
    border-radius: 11px;
    transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
  }
  .asset-search-field:focus-within {
    background: #fff;
    border-color: #93b4f8;
    box-shadow: 0 0 0 3px rgba(37,99,235,.12);
  }
  .asset-search-field svg { flex: 0 0 auto; }
  .asset-search-field input,
  .asset-search-field select {
    width: 100%;
    min-width: 0;
    color: #25324a;
    background: transparent;
    border: 0;
    outline: 0;
    font-size: .84rem;
  }
  .asset-search-field input::placeholder { color: #94a3b8; }
  .asset-search-field select { cursor: pointer; }
  .asset-search-submit {
    min-height: 46px;
    color: #fff;
    background: #2864e8;
    border: 0;
    border-radius: 11px;
    font-size: .84rem;
    font-weight: 650;
    transition: background-color .2s ease, transform .2s ease, box-shadow .2s ease;
  }
  .asset-search-submit:hover,
  .asset-search-submit:focus-visible {
    color: #fff;
    background: #1d55d2;
    box-shadow: 0 8px 18px rgba(37,99,235,.24);
    transform: translateY(-1px);
  }
  .landing-hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: .85rem;
    margin-top: 1.65rem;
  }
  .landing-hero-actions .btn {
    display: inline-flex;
    min-height: 45px;
    align-items: center;
    justify-content: center;
    gap: .65rem;
    padding: .65rem 1.25rem;
    border-radius: 11px;
    font-size: .84rem;
    font-weight: 650;
  }
  .landing-hero-actions .btn-collection {
    color: #fff;
    background: #101a31;
    border-color: #101a31;
  }
  .landing-hero-actions .btn-collection:hover { color: #fff; background: #1d2a45; border-color: #1d2a45; }
  .landing-hero-actions .btn-dashboard {
    color: #17233b;
    background: rgba(255,255,255,.72);
    border-color: #cbd5e1;
  }
  .landing-hero-actions .btn-dashboard:hover { color: #1d55d2; background: #fff; border-color: #93b4f8; }
  .hero-media {
    position: relative;
    aspect-ratio: 16 / 10;
    min-height: 0;
    overflow: hidden;
    isolation: isolate;
    background: #0b1428;
    border: 1px solid color-mix(in srgb, var(--brand-blue) 30%, transparent);
    border-radius: 24px;
    box-shadow: 0 22px 55px rgba(15,23,42,.22);
  }
  .hero-video {
    position: relative;
    z-index: 2;
    display: block;
    width: 100%;
    height: 100%;
    min-height: 0;
    object-fit: contain;
  }
  .hero-video-background {
    position: absolute;
    z-index: 0;
    inset: -8%;
    width: 116%;
    height: 116%;
    object-fit: cover;
    filter: blur(24px) brightness(.64) saturate(.9);
    transform: scale(1.08);
    pointer-events: none;
  }
  .hero-media::after {
    position: absolute;
    z-index: 1;
    inset: 0;
    content: "";
    background: rgba(7, 15, 32, .08);
    pointer-events: none;
  }
  .hero-video-fallback {
    display: grid;
    width: 100%;
    height: 100%;
    min-height: 0;
    place-items: center;
    color: #35558f;
    background: radial-gradient(circle at 25% 20%, rgba(255,255,255,.75), transparent 35%), linear-gradient(145deg,#dbeafe,#c7d2fe);
    font-size: .85rem;
    font-weight: 650;
  }
  .btn-sound {
    position: absolute;
    z-index: 3;
    right: 16px;
    bottom: 16px;
    display: grid;
    width: 42px;
    height: 42px;
    padding: 0;
    place-items: center;
    color: #fff;
    background: rgba(7,18,40,.72);
    border: 1px solid rgba(255,255,255,.24);
    border-radius: 50%;
    backdrop-filter: blur(8px);
  }
  .btn-sound:hover { background: rgba(7,18,40,.9); }
  body.theme-dark .landing-hero-title { color: #f8fafc; }
  body.theme-dark .landing-hero-description { color: #cbd5e1; }
  @media (max-width: 991px) {
    .landing-hero { grid-template-columns: 1fr; }
    .hero-media { width: min(100%, 680px); }
  }
  @media (max-width: 767px) {
    .landing-hero { padding-top: .5rem; }
    .landing-hero-title { font-size: clamp(32px, 7vw, 40px); letter-spacing: -1.5px; line-height: .98; }
    .asset-search { grid-template-columns: 1fr; }
    .asset-search-submit { min-height: 48px; }
  }
  @media (max-width: 480px) {
    .landing-hero-title { font-size: 31px; letter-spacing: -1.1px; line-height: 1; }
    .landing-hero-description { font-size: 13px; line-height: 1.65; }
    .landing-hero-actions { display: grid; grid-template-columns: 1fr; }
    .landing-hero-actions .btn { width: 100%; }
    .hero-media { min-height: 0; border-radius: 18px; }
    .hero-video,.hero-video-fallback { min-height: 0; }
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

  .available-panel {
    padding: 1.75rem;
    overflow: hidden;
    background: #fff;
    border: 1px solid #dfe6ef;
    border-radius: 20px;
    box-shadow: 0 12px 30px rgba(15, 23, 42, .07);
  }
  .available-panel-header {
    align-items: flex-start;
    margin-bottom: 1.25rem;
    padding-bottom: 1.25rem;
    border-bottom: 1px solid #e8edf3;
  }
  .available-panel-header h5 { color: #0b1730; font-size: 1.25rem; }
  .available-panel-header p { margin: 0; color: #74829a; font-size: .82rem; }
  .available-total {
    flex: 0 0 auto;
    padding: .48rem .85rem;
    color: #1558da;
    background: #eff5ff;
    border: 1px solid #cfe0ff;
    border-radius: 999px;
    font-size: .84rem;
    font-weight: 700;
  }
  .available-filters {
    display: flex;
    gap: .55rem;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    overflow-x: auto;
    border-bottom: 1px solid #edf1f5;
    scrollbar-width: none;
  }
  .available-filters::-webkit-scrollbar { display: none; }
  .available-filters button {
    flex: 0 0 auto;
    min-height: 34px;
    padding: .42rem .85rem;
    color: #334155;
    background: #f1f5f9;
    border: 1px solid transparent;
    border-radius: 9px;
    font-size: .78rem;
    font-weight: 550;
    transition: color .2s ease, background-color .2s ease, box-shadow .2s ease;
  }
  .available-filters button:hover,
  .available-filters button:focus-visible { color: #1558da; background: #eaf1ff; outline: none; }
  .available-filters button.active { color: #fff; background: #2864e8; box-shadow: 0 6px 14px rgba(37,99,235,.2); }
  .available-list { max-height: 430px; padding-right: .35rem; }
  .available-panel .asset-item {
    min-height: 82px;
    padding: .9rem 0;
    border-bottom-color: #e9eef4;
  }
  .available-panel .asset-thumb {
    flex: 0 0 48px;
    width: 48px;
    height: 48px;
    color: #334155;
    background: #f1f5f9;
    border-color: #d8e1ec;
    border-radius: 12px;
  }
  .available-panel .asset-name { color: #0d1930; font-size: .92rem; font-weight: 700; }
  .available-panel .asset-meta { color: #64748b; font-size: .76rem; }
  .available-panel .asset-meta span { color: #64748b; }
  .asset-stock { margin-top: .22rem; color: #079669; font-size: .72rem; font-weight: 650; }
  .asset-borrow-button {
    flex: 0 0 auto;
    min-width: 70px;
    padding: .5rem .8rem;
    color: #1558da;
    background: #f3f7ff;
    border: 1px solid #bcd5ff;
    border-radius: 9px;
    font-size: .8rem;
    font-weight: 550;
    text-align: center;
    text-decoration: none;
    transition: color .2s ease, background-color .2s ease, transform .2s ease;
  }
  .asset-borrow-button:hover,
  .asset-borrow-button:focus-visible { color: #fff; background: #2864e8; outline: none; transform: translateY(-1px); }
  .available-filter-empty { margin: 1.5rem 0; color: #75839a; font-size: .82rem; text-align: center; }
  .available-explore {
    display: flex;
    min-height: 52px;
    align-items: center;
    justify-content: center;
    gap: .55rem;
    margin: .35rem -1.75rem -1.75rem;
    color: #1d5de1;
    background: #fff;
    border-top: 1px solid #e8edf3;
    font-size: .8rem;
    font-weight: 600;
    text-decoration: none;
  }
  .available-explore span { font-size: 1.25rem; line-height: 1; transition: transform .2s ease; }
  .available-explore:hover { color: #174ec2; background: #f8faff; }
  .available-explore:hover span { transform: translateX(3px); }
  body.theme-dark .available-panel { background: #111c32; border-color: rgba(148,163,184,.24); }
  body.theme-dark .available-panel-header h5,
  body.theme-dark .available-panel .asset-name { color: #f8fafc; }
  body.theme-dark .available-panel-header,
  body.theme-dark .available-filters,
  body.theme-dark .available-panel .asset-item,
  body.theme-dark .available-explore { border-color: rgba(148,163,184,.18); }
  body.theme-dark .available-filters button { color: #cbd5e1; background: #1e293b; }
  body.theme-dark .available-filters button.active { color: #fff; background: #2864e8; }
  body.theme-dark .available-explore { background: #111c32; }
  @media (max-width: 575px) {
    .available-panel { padding: 1.15rem; }
    .available-panel-header { gap: .75rem; }
    .available-panel-header h5 { font-size: 1.05rem; }
    .available-total { padding: .4rem .65rem; font-size: .72rem; }
    .available-panel .asset-item { align-items: flex-start; }
    .available-panel .asset-thumb { flex-basis: 42px; width: 42px; height: 42px; margin-right: .55rem; }
    .available-panel .asset-name { font-size: .82rem; }
    .available-panel .asset-meta { white-space: normal !important; font-size: .68rem; }
    .asset-borrow-button { min-width: 58px; padding: .42rem .58rem; font-size: .72rem; }
    .available-explore { margin-right: -1.15rem; margin-bottom: -1.15rem; margin-left: -1.15rem; padding: 0 1rem; text-align: center; }
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
  .active-loans-panel {
    height: auto;
    min-height: 472px;
    padding: 1.75rem;
    background: #fff;
    border: 1px solid #dfe6ef;
    border-radius: 20px;
    box-shadow: 0 12px 30px rgba(15,23,42,.07);
  }
  .active-loans-header {
    align-items: flex-start;
    margin-bottom: 1.25rem;
    padding-bottom: 1.25rem;
    border-bottom: 1px solid #e8edf3;
  }
  .active-loans-header h5 { color: #0b1730; font-size: 1.25rem; }
  .active-loans-header p { margin: 0; color: #74829a; font-size: .82rem; }
  .active-loans-total {
    flex: 0 0 auto;
    padding: .48rem .85rem;
    color: #9a5a00;
    background: #fff1c7;
    border-radius: 999px;
    font-size: .8rem;
    font-weight: 700;
  }
  .active-loans-panel .scroll-list { max-height: 405px; }
  .active-loans-panel .loan-card {
    gap: .75rem;
    margin-bottom: 1rem !important;
    padding: 1rem 1.05rem;
    background: #fff;
    border-color: #d9e5f7;
    border-radius: 13px;
    box-shadow: none;
  }
  .active-loans-panel .loan-card:hover { border-color: #a9c7fb; box-shadow: 0 8px 20px rgba(37,99,235,.08); }
  .active-loans-panel .loan-card::before { width: 4px; background: #2864e8; }
  .active-loans-panel .loan-card:nth-child(even)::before { background: #17b985; }
  .active-loans-panel .loan-title { color: #0b1730; font-size: 1rem; font-weight: 700; }
  .active-loans-panel .loan-unit { color: #1558da; background: #e8efff; }
  .active-loans-panel .loan-status-chip { color: #087b59; background: #d9f8eb; }
  .active-loans-panel .loan-context-pill { color: #334155; background: #f1f5f9; }
  .active-loans-panel .loan-proof-btn { color: #24344e; background: #fff; border-color: #bdcada; border-radius: 9px; }
  .loan-empty-state {
    display: flex;
    min-height: 330px;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 2rem;
    color: #7d8ba1;
    text-align: center;
  }
  .loan-empty-state > span { display: grid; width: 58px; height: 58px; margin-bottom: 1rem; place-items: center; color: #2864e8; background: #edf4ff; border-radius: 16px; }
  .loan-empty-state strong { color: #24324a; font-size: .95rem; }
  .loan-empty-state p { max-width: 300px; margin: .4rem 0 0; font-size: .76rem; line-height: 1.55; }
  .loan-summary-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: .75rem;
    margin-top: 1rem;
  }
  .loan-summary-grid > div {
    display: flex;
    min-height: 76px;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: .75rem;
    background: #fff;
    border: 1px solid #dfe6ef;
    border-radius: 14px;
    box-shadow: 0 7px 18px rgba(15,23,42,.04);
  }
  .loan-summary-grid span { color: #64748b; font-size: .72rem; }
  .loan-summary-grid strong { margin-top: .22rem; color: #26354e; font-size: 1.15rem; }
  .loan-summary-grid strong.is-blue { color: #2864e8; }
  .loan-summary-grid strong.is-orange { color: #db7900; }
  body.theme-dark .active-loans-panel,
  body.theme-dark .loan-summary-grid > div { background: #111c32; border-color: rgba(148,163,184,.24); }
  body.theme-dark .active-loans-header h5,
  body.theme-dark .active-loans-panel .loan-title,
  body.theme-dark .loan-empty-state strong { color: #f8fafc; }
  body.theme-dark .active-loans-header { border-color: rgba(148,163,184,.18); }
  body.theme-dark .active-loans-panel .loan-card { background: #17233a; border-color: rgba(96,165,250,.25); }
  @media (max-width: 575px) {
    .active-loans-panel { min-height: 420px; padding: 1.15rem; }
    .active-loans-header { gap: .75rem; }
    .active-loans-header h5 { font-size: 1.05rem; }
    .active-loans-total { padding: .4rem .65rem; font-size: .7rem; }
    .loan-empty-state { min-height: 285px; padding: 1.25rem; }
    .loan-summary-grid { gap: .45rem; }
    .loan-summary-grid > div { min-height: 68px; padding: .5rem .3rem; }
    .loan-summary-grid span { font-size: .62rem; text-align: center; }
    .loan-summary-grid strong { font-size: .95rem; }
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
  .features-showcase { margin-top: 5rem; padding: 1rem 0 2.25rem; }
  .features-showcase-heading { max-width: 1100px; margin: 0 auto 3.5rem; font-family: "Poppins",sans-serif; text-align: center; }
  .features-showcase-heading > span {
    display: block; margin-bottom: .7rem; color: #2864e8;
    font-size: 14px; font-weight: 700; letter-spacing: 0;
  }
  .features-showcase-heading h2 {
    margin: 0; color: #071329; font-size: 36px;
    font-weight: 700; letter-spacing: -1.2px; line-height: 1.15;
  }
  .features-showcase .feature-row { grid-template-columns: repeat(4,minmax(0,1fr)); gap: 1.35rem; }
  .features-showcase .feature-card {
    min-height: 270px; padding: 1.75rem; gap: 0; background: #f8fafc;
    border: 1px solid #dfe6ef; border-radius: 17px; box-shadow: none;
    transition: border-color .2s ease,box-shadow .2s ease,transform .2s ease;
  }
  .features-showcase .feature-card:hover {
    border-color: #bfd1ec; box-shadow: 0 14px 28px rgba(15,23,42,.08); transform: translateY(-3px);
  }
  .features-showcase .feature-card svg {
    width: 56px; height: 56px; margin-bottom: 1.7rem; padding: 14px;
    color: #1760ed; background: #dbeafe; border-radius: 14px;
  }
  .features-showcase .feature-card:nth-child(2) svg { color: #4e54eb; background: #e3e7ff; }
  .features-showcase .feature-card:nth-child(3) svg { color: #c36a00; background: #fff1c7; }
  .features-showcase .feature-card:nth-child(4) svg { color: #078563; background: #d7f8e9; }
  .features-showcase .feature-title { margin: 0 0 .75rem !important; color: #0b1730; font-size: 1rem; font-weight: 700; }
  .features-showcase .feature-desc { color: #53627a; font-size: .8rem; line-height: 1.7; }
  body.theme-dark .features-showcase-heading h2 { color: #f8fafc; }
  body.theme-dark .features-showcase .feature-card { background: #111c32; border-color: rgba(148,163,184,.24); }
  body.theme-dark .features-showcase .feature-title { color: #f8fafc; }
  body.theme-dark .features-showcase .feature-desc { color: #b9c4d6; }
  @media (max-width: 1199px) {
    .features-showcase .feature-row { grid-template-columns: repeat(2,minmax(0,1fr)); }
    .features-showcase .feature-card { min-height: 235px; }
  }
  @media (max-width: 575px) {
    .features-showcase { margin-top: 3.5rem; }
    .features-showcase-heading { margin-bottom: 2rem; }
    .features-showcase-heading > span { font-size: 12px; }
    .features-showcase-heading h2 { font-size: 26px; letter-spacing: -.7px; }
    .features-showcase-heading h2 br { display: none; }
    .features-showcase .feature-row { grid-template-columns: 1fr; }
    .features-showcase .feature-card { min-height: 0; padding: 1.35rem; }
    .features-showcase .feature-card svg { width: 50px; height: 50px; margin-bottom: 1.2rem; padding: 12px; }
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

  /* Landing operational dashboard reverted
  body { background: #fff; }
  body > .landing-navbar,
  body > footer { display: none !important; }
  body > main.container { max-width: none; padding: 0; }
  .landing-page-shell { width: 100%; overflow: hidden; color: #0b1730; background: #fff; }
  .ops-hero {
    display: grid;
    grid-template-columns: minmax(0, 1.36fr) minmax(330px, .88fr);
    gap: clamp(2.5rem, 7vw, 7rem);
    width: min(100% - 40px, 1180px);
    align-items: center;
    margin: 0 auto;
    padding: 42px 0 62px;
  }
  .ops-hero-copy { min-width: 0; }
  .ops-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-bottom: 25px;
    padding: 6px 11px;
    color: #1e5bd8;
    background: #edf4ff;
    border: 1px solid #cfe0ff;
    border-radius: 999px;
    font-size: 10px;
    font-weight: 650;
  }
  .ops-eyebrow > span { font-size: 7px; }
  .ops-hero .landing-hero-title {
    max-width: 710px;
    color: #071329;
    font-size: clamp(2.55rem, 4.4vw, 4rem);
    line-height: .98;
  }
  .ops-hero .landing-hero-description { max-width: 650px; margin-top: 23px; font-size: .96rem; }
  .ops-hero .asset-search { max-width: 675px; margin-top: 23px; }
  .ops-hero .landing-hero-actions { margin-top: 25px; }
  .ops-status-card {
    overflow: hidden;
    background: #fff;
    border: 1px solid #cbd6e6;
    border-radius: 12px;
    box-shadow: 0 18px 42px rgba(15, 34, 72, .22);
  }
  .ops-status-top,
  .ops-status-body { background: #111f3f; }
  .ops-status-top { display: flex; align-items: center; justify-content: space-between; padding: 21px 22px 12px; }
  .ops-live {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 5px 9px;
    color: #8ef0c5;
    background: rgba(20, 184, 128, .2);
    border-radius: 999px;
    font-size: 9px;
    font-weight: 650;
  }
  .ops-live > span { width: 6px; height: 6px; background: #27d899; border-radius: 50%; box-shadow: 0 0 0 3px rgba(39,216,153,.12); }
  .ops-live-label { color: #aab7cc; font-size: 8px; font-weight: 700; letter-spacing: .17em; }
  .ops-status-body { padding: 30px 22px 25px; color: #fff; }
  .ops-kicker { display: block; margin-bottom: 7px; color: #8796b1; font-size: 9px; letter-spacing: .08em; }
  .ops-status-body h2 { margin: 0 0 9px; color: #fff; font-size: 20px; font-weight: 650; }
  .ops-status-body p { margin: 0; color: #b5c0d4; font-size: 10px; }
  .ops-status-body p span { color: #53a2ff; }
  .ops-status-metrics { display: grid; grid-template-columns: 1fr 1fr; padding: 20px 22px; border-bottom: 1px solid #e6ebf2; }
  .ops-status-metrics > div + div { padding-left: 27px; border-left: 1px solid #e6ebf2; }
  .ops-status-metrics span { display: block; margin-bottom: 6px; color: #8592a8; font-size: 10px; }
  .ops-status-metrics strong { color: #12203a; font-size: 24px; }
  .ops-status-metrics strong small { color: #65738b; font-size: 11px; font-weight: 500; }
  .ops-status-metrics strong.ready { color: #10ad76; }
  .ops-status-detail { display: grid; grid-template-columns: 38px 1fr auto; gap: 11px; align-items: center; margin: 16px 17px; padding: 12px; background: #f8fafc; border: 1px solid #e4eaf2; border-radius: 9px; }
  .ops-status-icon { display: grid; width: 38px; height: 38px; place-items: center; color: #2463eb; background: #e9f1ff; border-radius: 8px; }
  .ops-status-detail div span { display: block; color: #7e8ba1; font-size: 9px; }
  .ops-status-detail div strong { display: block; margin-top: 2px; color: #1f2c44; font-size: 10px; }
  .ops-regulation { padding: 5px 8px; color: #5f6d83; background: #fff; border: 1px solid #dbe3ee; border-radius: 6px; font-size: 9px; }
  .ops-status-footer { display: flex; justify-content: space-between; padding: 12px 18px; color: #fff; background: #2864e8; font-size: 9px; }
  .catalog-section { padding: 52px 0 62px; background: #f7f9fc; border-top: 1px solid #edf1f6; border-bottom: 1px solid #e7ecf3; }
  .catalog-heading,
  .catalog-grid { width: min(100% - 40px, 1180px); margin-right: auto !important; margin-left: auto !important; }
  .catalog-heading { display: flex; align-items: end; justify-content: space-between; gap: 24px; margin-bottom: 21px; }
  .catalog-heading h2 { margin: 0; color: #0b1730; font-size: 22px; font-weight: 720; }
  .catalog-heading p { margin: 5px 0 0; color: #8491a5; font-size: 11px; }
  .catalog-badges { display: flex; flex-wrap: wrap; justify-content: flex-end; gap: 8px; }
  .catalog-badges span { display: inline-flex; align-items: center; gap: 6px; padding: 6px 10px; border-radius: 999px; font-size: 9px; font-weight: 650; }
  .catalog-badges i { width: 6px; height: 6px; border-radius: 50%; }
  .catalog-badges .is-ready { color: #14845f; background: #dff8ed; }
  .catalog-badges .is-ready i { background: #18b67e; }
  .catalog-badges .is-loaned { color: #9b6a09; background: #fff0c8; }
  .catalog-badges .is-loaned i { background: #e5a51d; }
  .landing-page-shell .section-panel {
    height: 100%;
    padding: 22px;
    background: #fff;
    border: 1px solid #dfe6ef;
    border-radius: 13px;
    box-shadow: 0 10px 25px rgba(15,23,42,.06);
  }
  .landing-page-shell .section-header { align-items: flex-start; margin-bottom: 16px; }
  .landing-page-shell .section-header h5 { color: #0f1b32; font-size: 16px; font-weight: 700; }
  .panel-subtitle { margin: 0; color: #8a96aa; font-size: 9px; }
  .landing-page-shell .scroll-list { max-height: 440px; padding-right: 6px; }
  .landing-page-shell .asset-item { min-height: 67px; padding: 10px 0; background: transparent; border: 0; border-bottom: 1px solid #edf1f5; border-radius: 0; box-shadow: none; }
  .landing-page-shell .asset-thumb { width: 39px; height: 39px; border-radius: 8px; }
  .landing-page-shell .asset-name { color: #18243a; font-size: 11px; font-weight: 650; }
  .landing-page-shell .asset-meta { font-size: 9px; }
  .asset-row-action { display: flex; flex: 0 0 auto; align-items: center; gap: 8px; }
  .asset-borrow-btn { padding: 5px 9px; color: #2563eb; background: #edf4ff; border: 1px solid #d5e4ff; border-radius: 6px; font-size: 9px; font-weight: 650; text-decoration: none; }
  .asset-borrow-btn:hover { color: #fff; background: #2563eb; }
  .landing-page-shell .loan-card { margin-bottom: 12px !important; padding: 16px; border-radius: 9px; box-shadow: none; }
  .landing-page-shell .loan-title { font-size: 14px; }
  .benefits-section { width: min(100% - 40px, 1180px); margin: 0 auto; padding: 65px 0 58px; }
  .benefits-heading { margin-bottom: 32px; text-align: center; }
  .benefits-heading > span { color: #2864e8; font-size: 9px; font-weight: 750; letter-spacing: .12em; }
  .benefits-heading h2 { margin: 8px 0 0; color: #0a162d; font-size: 24px; font-weight: 720; line-height: 1.15; }
  .landing-page-shell .feature-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin: 0; }
  .landing-page-shell .feature-card { min-height: 190px; padding: 24px; background: #f8fafc; border: 1px solid #e3e9f1; border-radius: 12px; box-shadow: none; }
  .landing-page-shell .feature-card svg { width: 34px; height: 34px; margin-bottom: 22px; padding: 8px; color: #2864e8; background: #e7efff; border-radius: 8px; }
  .landing-page-shell .feature-card:nth-child(3) svg { color: #d98a13; background: #fff0cc; }
  .landing-page-shell .feature-card:nth-child(4) svg { color: #14966b; background: #dff8ed; }
  .landing-page-shell .feature-title { color: #17233a; font-size: 12px; font-weight: 700; }
  .landing-page-shell .feature-desc { margin-top: 9px !important; color: #78869c; font-size: 9px; line-height: 1.55; }
  .ops-footer {
    display: grid;
    grid-template-columns: 1.7fr .75fr .75fr 1fr;
    gap: 44px;
    padding: 46px max(20px, calc((100vw - 1180px) / 2));
    color: #aebbd0;
    background: #0b1730;
    font-size: 9px;
  }
  .ops-footer > div { display: flex; align-items: flex-start; flex-direction: column; gap: 7px; }
  .ops-footer strong { color: #fff; font-size: 10px; }
  .ops-footer a { color: #aebbd0; text-decoration: none; }
  .ops-footer a:hover { color: #fff; }
  .ops-footer-brand span { color: #6998ff; }
  .ops-footer-brand p { max-width: 360px; margin: 7px 0 0; line-height: 1.65; }
  .ops-footer-hours span { display: flex; width: 100%; justify-content: space-between; }
  .ops-footer-hours b { color: #fff; }
  .ops-footer-hours em { margin-top: 4px; color: #f4bd43; font-style: normal; }
  @media (max-width: 991.98px) {
    .ops-hero { grid-template-columns: 1fr; gap: 34px; }
    .ops-status-card { width: min(100%, 560px); }
    .landing-page-shell .feature-row { grid-template-columns: repeat(2, 1fr); }
    .ops-footer { grid-template-columns: 1.5fr 1fr 1fr; }
    .ops-footer-hours { grid-column: 2 / 4; }
  }
  @media (max-width: 767.98px) {
    .ops-hero { width: min(100% - 28px, 1180px); padding: 28px 0 42px; }
    .ops-hero .landing-hero-title { font-size: clamp(2.25rem, 10vw, 3.2rem); }
    .catalog-heading { align-items: flex-start; flex-direction: column; }
    .catalog-badges { justify-content: flex-start; }
    .catalog-heading,.catalog-grid,.benefits-section { width: min(100% - 28px, 1180px); }
    .landing-page-shell .feature-row { grid-template-columns: 1fr; }
    .ops-footer { grid-template-columns: 1fr 1fr; gap: 30px; }
    .ops-footer-brand { grid-column: 1 / -1; }
    .ops-footer-hours { grid-column: auto; }
  }
  @media (max-width: 480px) {
    .ops-hero .landing-hero-title { font-size: 2.2rem; }
    .ops-status-metrics { grid-template-columns: 1fr; gap: 14px; }
    .ops-status-metrics > div + div { padding: 14px 0 0; border-top: 1px solid #e6ebf2; border-left: 0; }
    .ops-status-detail { grid-template-columns: 36px 1fr; }
    .ops-regulation { display: none; }
    .benefits-heading h2 br { display: none; }
    .ops-footer { grid-template-columns: 1fr; }
    .ops-footer-hours { grid-column: auto; }
  }
  */

</style>
@endpush

@section('content')
  <section class="landing-hero mb-5" aria-labelledby="landing-hero-title">
    <div class="landing-hero-copy">
    <h1 class="landing-hero-title" id="landing-hero-title">Sarpras <span class="accent">Pusdatekin BPIP</span></h1>

    <p class="landing-hero-description">
      Kelola kebutuhan sarana prasarana dengan cepat dan terarah. Pantau ketersediaan, ajukan peminjaman,
      dan dukung setiap kegiatan dengan fasilitas yang selalu siap digunakan.
    </p>

    <form class="asset-search" method="GET" action="{{ route('assets.loanable') }}" role="search">
      <label class="asset-search-field">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
          <circle cx="11" cy="11" r="6.5" stroke="currentColor" stroke-width="1.7"/>
          <path d="m16 16 4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
        </svg>
        <span class="visually-hidden">Cari alat</span>
        <input type="search" name="q" placeholder="Cari nama alat / kode aset..." autocomplete="off">
      </label>

      <label class="asset-search-field">
        <span class="visually-hidden">Kategori alat</span>
        <select name="category" aria-label="Pilih kategori alat">
          <option value="">Semua Kategori</option>
          @foreach($landingCategories as $landingCategory)
            <option value="{{ $landingCategory }}">{{ $landingCategory }}</option>
          @endforeach
        </select>
      </label>

      <button class="asset-search-submit" type="submit">Cari Alat</button>
    </form>

    <div class="landing-hero-actions">
      <a class="btn btn-collection" href="{{ route('assets.loanable') }}">
        Lihat Koleksi Sarpras
        <span aria-hidden="true">→</span>
      </a>
      <button class="btn btn-dashboard" type="button" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk Dashboard</button>
    </div>
    </div>

    <div class="hero-media {{ $hasHeroVideo ? 'hero-media--video' : '' }}">
      @if($hasHeroVideo)
        <video class="hero-video-background" autoplay muted loop playsinline preload="metadata" aria-hidden="true" tabindex="-1">
          <source src="{{ $landingVideoUrl }}" @if($landingVideoMime) type="{{ $landingVideoMime }}" @endif>
        </video>
        <video id="heroVideo" class="hero-video" autoplay muted loop playsinline preload="metadata">
          <source src="{{ $landingVideoUrl }}" @if($landingVideoMime) type="{{ $landingVideoMime }}" @endif>
          Browser Anda tidak mendukung pemutaran video.
        </video>
        <button type="button" class="btn-sound" id="btnSound" onclick="toggleSound()" aria-label="Aktifkan atau nonaktifkan suara video">🔇</button>
      @else
        <div class="hero-video-fallback">Video landing page belum dikonfigurasi</div>
      @endif
    </div>
  </section>

  <div class="row g-4 mt-3">
    <div class="col-lg-6">
      <div class="section-panel available-panel">
        <div class="section-header available-panel-header">
          <div>
            <h5 class="mb-1">Sarpras Tersedia</h5>
            <p>Peralatan siap reservasi untuk unit kerja BPIP</p>
          </div>
          <span class="available-total">{{ number_format(data_get($summaryData, 'available', 0)) }} unit</span>
        </div>
        <div class="available-filters" aria-label="Filter kategori sarpras">
          <button type="button" class="active" data-asset-filter="all">Semua</button>
          @foreach($landingCategories->take(3) as $landingCategory)
            <button type="button" data-asset-filter="{{ Illuminate\Support\Str::lower($landingCategory) }}">{{ $landingCategory }}</button>
          @endforeach
        </div>
        <div class="scroll-list available-list">
          @forelse(($availableAssets ?? []) as $asset)
            <div class="asset-item" data-asset-item data-category="{{ Illuminate\Support\Str::lower($asset->category ?? '') }}">
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
                  <div class="asset-meta text-truncate">{{ $asset->category ?? 'Kategori belum diatur' }} @if($asset->code) <span>• Kode: {{ $asset->code }}</span> @endif</div>
                  <div class="asset-stock">{{ number_format($asset->quantity_available) }} Unit Tersedia</div>
                </div>
              </div>
              <a href="{{ route('assets.loanable', ['q' => $asset->code ?: $asset->name]) }}" class="asset-borrow-button">Pinjam</a>
            </div>
          @empty
            <p class="text-muted mb-0">Belum ada sarpras siap pinjam untuk ditampilkan.</p>
          @endforelse
          <p class="available-filter-empty" hidden>Tidak ada sarpras pada kategori ini.</p>
        </div>
        <a href="{{ route('assets.loanable') }}" class="available-explore">Eksplorasi Seluruh {{ number_format(data_get($summaryData, 'available', 0)) }} Sarpras Lengkap <span aria-hidden="true">›</span></a>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="section-panel active-loans-panel">
        <div class="section-header active-loans-header">
          <div>
            <h5 class="mb-1">Peminjaman Aktif</h5>
            <p>Monitoring real-time alokasi dan pengembalian sarana</p>
          </div>
          <span class="active-loans-total">{{ number_format(data_get($summaryData, 'in_use', 0)) }} unit aktif</span>
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
            <div class="loan-empty-state">
              <span aria-hidden="true">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                  <path d="M7 3.5h10A2.5 2.5 0 0 1 19.5 6v14H4.5V6A2.5 2.5 0 0 1 7 3.5Z" stroke="currentColor" stroke-width="1.5"/>
                  <path d="M8.5 3.5h7v3h-7zM8 11h8M8 15h5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
              <strong>Belum ada peminjaman aktif</strong>
              <p>Aktivitas peminjaman yang sedang berjalan akan ditampilkan di sini.</p>
            </div>
          @endforelse
        </div>
      </div>
      <div class="loan-summary-grid" aria-label="Ringkasan peminjaman">
        <div><span>Antrean Baru</span><strong class="is-blue">{{ number_format(data_get($summaryData, 'active_tickets', 0)) }} Tiket</strong></div>
        <div><span>Kembali Hari Ini</span><strong class="is-orange">{{ number_format(data_get($summaryData, 'due_today', 0)) }} Alat</strong></div>
        <div><span>Maintenance</span><strong>{{ number_format(data_get($summaryData, 'maintenance', 0)) }} Unit</strong></div>
      </div>
    </div>
  </div>

  <section class="features-showcase" aria-labelledby="features-title">
    <div class="features-showcase-heading">
      <span>KEUNGGULAN SISTEM PUSDATEKIN</span>
      <h2 id="features-title">Transparansi, Efisiensi, dan Tata Kelola Aset Berstandar<br>Pemerintah</h2>
    </div>
  <div id="fitur" class="feature-row">
    <div class="feature-card">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="36" height="36" aria-hidden="true">
        <rect x="3" y="3" width="18" height="18" rx="2.5" stroke-width="1.7"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M3 10h18M8 3v18M16 3v18"/>
        <rect x="4.5" y="4.5" width="2.5" height="2.5" rx="0.6" fill="currentColor" opacity="0.55" stroke="none"/>
        <rect x="17" y="12.5" width="2.5" height="2.5" rx="0.6" fill="currentColor" opacity="0.55" stroke="none"/>
      </svg>
      <h5 class="feature-title mb-1">Inventaris Sarpras Terpusat</h5>
      <p class="feature-desc mb-0">Seluruh perangkat tercatat rapi secara digital lengkap dengan kode aset BMN, spesifikasi teknis, serta pelacakan kode QR fisik.</p>
    </div>
    <div class="feature-card">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="36" height="36" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M6 3.5h9l3 3V20H6zM14.5 3.5V7H18M9 11h6M9 15h6"/>
      </svg>
      <h5 class="feature-title mb-1">Peminjaman Transparan</h5>
      <p class="feature-desc mb-0">Proses pengajuan terarah tanpa surat fisik manual. Approval penanggung jawab langsung terpantau dari notifikasi email dinas.</p>
    </div>
    <div class="feature-card">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="36" height="36" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M18 8a6 6 0 1 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/>
      </svg>
      <h5 class="feature-title mb-1">Pengingat Jadwal Otomatis</h5>
      <p class="feature-desc mb-0">Sistem berkala mengirimkan pengingat H-1 jatuh tempo pengembalian barang guna mencegah keterlambatan penggunaan lintas unit.</p>
    </div>
    <div class="feature-card">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="36" height="36" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M4 20h16M6 17v-4M11 17V8M16 17V5M20 17V10"/>
      </svg>
      <h5 class="feature-title mb-1">Analitik &amp; Audit Real-time</h5>
      <p class="feature-desc mb-0">Laporan pemakaian sarpras terintegrasi untuk membantu pimpinan Pusdatekin mengambil keputusan pemeliharaan dan pengadaan aset baru.</p>
    </div>
  </div>
  </section>

  <!-- Login Modal -->
  <div class="modal fade modal-login" id="loginModal" tabindex="-1" aria-label="Masuk Dashboard" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content sso-modal-card">
        @include('auth.partials.sso-modal-content')
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const assetFilterButtons = document.querySelectorAll('[data-asset-filter]');
      const assetItems = document.querySelectorAll('[data-asset-item]');
      const emptyFilterMessage = document.querySelector('.available-filter-empty');

      assetFilterButtons.forEach(button => {
        button.addEventListener('click', function() {
          const selectedCategory = this.dataset.assetFilter;
          let visibleItems = 0;

          assetFilterButtons.forEach(item => item.classList.toggle('active', item === this));
          assetItems.forEach(item => {
            const visible = selectedCategory === 'all' || item.dataset.category === selectedCategory;
            item.hidden = !visible;
            if (visible) visibleItems++;
          });

          if (emptyFilterMessage) emptyFilterMessage.hidden = visibleItems !== 0;
        });
      });

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
