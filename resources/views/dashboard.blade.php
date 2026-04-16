@extends('layouts.app')

@push('styles')
<style>
    body[data-theme="light"] { background:#eef2ff; }
    .dashboard-shell { display:flex; flex-direction:column; gap:0.95rem; min-width:0; }
    .dashboard-shell .card { margin-bottom: 0; }
    .dashboard-stats-row,
    .dashboard-content-row,
    .dashboard-main-col .row {
        --bs-gutter-y: 0.85rem;
    }
    .dashboard-overview-row {
        --bs-gutter-y: 0.85rem;
        align-items: flex-start;
    }
    .dashboard-content-row {
        margin-top: 0 !important;
        align-items: flex-start;
    }
    .dashboard-stats-row {
        margin-top: 0 !important;
    }
    .dashboard-welcome {
        background:#ffffff;
        border:1px solid rgba(148,163,184,0.14);
        border-radius:22px;
        padding:1rem 1.2rem;
        box-shadow:0 10px 28px rgba(15,23,42,0.08);
    }
    .dashboard-welcome > [class*="col-"] {
        min-width: 0;
    }
    .dashboard-welcome__title {
        font-size:clamp(1.15rem,2.2vw,1.65rem);
        font-weight:700;
        color:#0f172a;
        margin-bottom:0.2rem;
    }
    .dashboard-welcome__subtitle { color:#475569; font-size:0.94rem; margin-bottom:0.15rem; }
    .dashboard-welcome__hint {
        display:inline-flex;
        align-items:center;
        gap:0.4rem;
        font-size:0.78rem;
        color:#1d4ed8;
        background:rgba(59,130,246,0.1);
        border:1px solid rgba(59,130,246,0.22);
        border-radius:999px;
        padding:0.3rem 0.7rem;
        margin-top:0.5rem;
    }
    .dashboard-clock {
        background: #ffffff;
        border: 1px solid rgba(148, 163, 184, 0.24);
        border-radius: 16px;
        padding: 0.9rem 1.05rem;
        width: 100%;
        max-width: 420px;
        min-width: 0;
        min-height: 96px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
    }
    .dashboard-clock__label {
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #64748b;
        margin-bottom: 0.3rem;
        font-weight: 600;
    }
    .dashboard-clock__value {
        font-size: clamp(0.9rem, 0.75vw + 0.55rem, 1.3rem);
        font-weight: 700;
        color: #0f172a;
        line-height: 1.25;
        white-space: nowrap;
        font-variant-numeric: tabular-nums;
    }
    .dashboard-shell .avtivity-card {
        border: 1px solid rgba(148,163,184,0.16);
        border-radius: 20px;
        box-shadow: 0 14px 34px rgba(15,23,42,0.08);
        background: #ffffff;
        overflow: hidden;
        min-height: 190px;
    }
    .dashboard-shell .avtivity-card .card-body {
        padding: 1.1rem 1.15rem 1rem;
    }
    .dashboard-shell .avtivity-card .media-body p {
        color: #64748b;
        font-size: 1rem;
        margin-bottom: 0.2rem;
    }
    .dashboard-shell .avtivity-card .media-body .title {
        font-size: 1.85rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.1;
    }
    .dashboard-shell .avtivity-card .progress {
        margin-top: 0.85rem;
        border-radius: 999px;
        background: #e2e8f0;
        overflow: hidden;
    }
    .dashboard-shell .avtivity-card .progress-bar {
        border-radius: 999px;
    }
    .dashboard-shell .avtivity-card .activity-icon {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(148,163,184,0.1);
    }
    .dashboard-shell .avtivity-card .activity-icon svg {
        width: 34px;
        height: 34px;
    }
    .dashboard-shell .avtivity-card .effect {
        height: 5px;
        opacity: 0.95;
    }
    .dashboard-panel {
        border: 1px solid rgba(148,163,184,0.16);
        border-radius: 20px;
        box-shadow: 0 14px 34px rgba(15,23,42,0.08);
        background: #ffffff;
        overflow: hidden;
    }
    .dashboard-side-col { display: block; }
    .dashboard-side-col .dashboard-panel {
        margin-top: 0 !important;
    }
    .dashboard-panel .card-header {
        padding: 1rem 1.15rem 0.55rem;
    }
    .dashboard-panel .card-body {
        padding: 1rem 1.15rem 1.15rem;
        line-height: 1.5;
    }
    .dashboard-panel--status .card-header {
        padding: 1.2rem 1.45rem 0.75rem;
    }
    .dashboard-panel--status .card-body {
        padding: 1.15rem 1.45rem 1.35rem;
    }
    .dashboard-panel--status {
        min-height: 355px;
    }
    .dashboard-panel--profile {
        min-height: 300px;
    }
    .dashboard-panel--members {
        height: auto;
        min-height: 0;
    }
    .dashboard-panel--members .card-body {
        overflow: hidden;
    }
    .dashboard-panel--menu {
        min-height: 355px;
    }
    .dashboard-panel--status .row {
        --bs-gutter-x: 1.15rem;
        --bs-gutter-y: 1rem;
    }
    .dashboard-panel h4,
    .dashboard-panel .card-title {
        color: #0f172a;
        font-weight: 700;
    }
    .dashboard-panel .text-muted,
    .dashboard-panel .fs-13,
    .dashboard-panel .fs-14 {
        color: #64748b !important;
    }
    .dashboard-system-item {
        background: #f8fafc;
        border: 1px solid rgba(148,163,184,0.18);
        border-radius: 12px;
        padding: 0.65rem 0.75rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.6rem;
        min-height: 74px;
    }
    .dashboard-system-item__head {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        min-width: 0;
    }
    .dashboard-system-item__icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.92rem;
        flex: 0 0 auto;
    }
    .dashboard-system-item__icon--green { background: rgba(34,197,94,0.14); color: #16a34a; }
    .dashboard-system-item__icon--blue { background: rgba(59,130,246,0.14); color: #2563eb; }
    .dashboard-system-item__icon--amber { background: rgba(245,158,11,0.14); color: #d97706; }
    .dashboard-system-item__icon--slate { background: rgba(100,116,139,0.14); color: #475569; }
    .dashboard-system-value {
        font-weight: 600;
        color: #334155;
        font-size: 0.95rem;
        white-space: nowrap;
    }
    .dashboard-system-item .badge {
        border-radius: 999px;
        padding: 0.36rem 0.62rem;
        font-size: 0.72rem;
        letter-spacing: 0.03em;
    }
    .dashboard-quick-link {
        border-radius: 12px;
        border: 1px solid rgba(148,163,184,0.22);
        background: #f8fafc;
        color: #0f172a;
        font-weight: 600;
        padding-top: 0.45rem;
        padding-bottom: 0.45rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }
    .dashboard-quick-link:hover,
    .dashboard-quick-link:focus {
        transform: translateY(-1px);
        border-color: rgba(59,130,246,0.35);
        box-shadow: 0 8px 20px rgba(59,130,246,0.16);
        color: #0f172a;
        background: #ffffff;
    }
    .dashboard-members-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.7rem;
        flex-wrap: wrap;
    }
    .dashboard-members-actions {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        flex-wrap: wrap;
    }
    .dashboard-members-nav-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 1px solid rgba(148,163,184,0.35);
        background: #ffffff;
        color: #475569;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }
    .dashboard-members-nav-btn:hover,
    .dashboard-members-nav-btn:focus {
        color: #1d4ed8;
        border-color: rgba(59,130,246,0.45);
        background: #eff6ff;
    }
    .dashboard-members-viewport {
        overflow-x: auto;
        overflow-y: hidden;
        scroll-behavior: smooth;
        scroll-snap-type: x mandatory;
        padding-bottom: 2px;
    }
    .dashboard-members-viewport::-webkit-scrollbar {
        height: 8px;
    }
    .dashboard-members-viewport::-webkit-scrollbar-thumb {
        background: rgba(148,163,184,0.45);
        border-radius: 999px;
    }
    .dashboard-members-list {
        display: flex;
        flex-wrap: nowrap;
        gap: 0.75rem;
        min-width: max-content;
    }
    .dashboard-member-item {
        border: 1px solid rgba(148,163,184,0.2);
        border-radius: 12px;
        background: #f8fafc;
        padding: 0.7rem 0.8rem;
        display: grid;
        grid-template-columns: 44px minmax(0, 1fr);
        gap: 0.65rem;
        align-items: center;
        width: 250px;
        flex: 0 0 250px;
        scroll-snap-align: start;
    }
    .dashboard-member-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb, #06b6d4);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        font-weight: 700;
        text-transform: uppercase;
        overflow: hidden;
    }
    .dashboard-member-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .dashboard-member-name {
        margin: 0;
        font-size: 0.98rem;
        color: #0f172a;
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .dashboard-member-role {
        display: inline-flex;
        font-size: 0.67rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #1d4ed8;
        background: rgba(59,130,246,0.12);
        border: 1px solid rgba(59,130,246,0.24);
        border-radius: 999px;
        padding: 0.16rem 0.45rem;
        font-weight: 700;
        margin-top: 0.15rem;
    }
    .dashboard-member-role--super { color:#1d4ed8; background:#dbeafe; border-color:#bfdbfe; }
    .dashboard-member-role--petugas { color:#0f766e; background:#ccfbf1; border-color:#99f6e4; }
    .dashboard-member-role--peminjam { color:#475569; background:#e2e8f0; border-color:#cbd5e1; }
    .dashboard-member-email {
        margin: 0.2rem 0 0;
        font-size: 0.82rem;
        color: #64748b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .dashboard-profile {
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }
    .dashboard-profile__avatar {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #2563eb, #06b6d4);
        color: #ffffff;
        font-size: 1.15rem;
        font-weight: 700;
        flex: 0 0 auto;
        text-transform: uppercase;
        overflow: hidden;
    }
    .dashboard-profile__avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .dashboard-profile__name {
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.08rem;
    }
    .dashboard-profile__role {
        display: inline-flex;
        align-items: center;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #1d4ed8;
        background: rgba(59,130,246,0.12);
        border: 1px solid rgba(59,130,246,0.26);
        border-radius: 999px;
        padding: 0.2rem 0.55rem;
        margin-bottom: 0.25rem;
    }
    .dashboard-profile__email {
        color: #64748b;
        font-size: 0.92rem;
        margin: 0;
        word-break: break-word;
    }
    .dashboard-profile-meta {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.55rem;
        margin-top: 0.1rem;
    }
    .dashboard-profile-meta__item {
        border: 1px solid rgba(148,163,184,0.2);
        border-radius: 10px;
        background: #f8fafc;
        padding: 0.45rem 0.6rem;
        min-width: 0;
    }
    .dashboard-profile-meta__label {
        margin: 0;
        font-size: 0.66rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #64748b;
    }
    .dashboard-profile-meta__value {
        margin: 0.16rem 0 0;
        font-size: 0.88rem;
        font-weight: 700;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    body[data-theme="dark"] .dashboard-welcome,
    body[data-theme-version="dark"] .dashboard-welcome,
    body.theme-dark .dashboard-welcome {
        background:#111827;
        border-color:rgba(148,163,184,0.24);
    }
    body[data-theme="dark"] .dashboard-welcome__title,
    body[data-theme-version="dark"] .dashboard-welcome__title,
    body.theme-dark .dashboard-welcome__title { color:#f8fafc; }
    body[data-theme="dark"] .dashboard-welcome__subtitle,
    body[data-theme-version="dark"] .dashboard-welcome__subtitle,
    body.theme-dark .dashboard-welcome__subtitle { color:#cbd5e1; }
    body[data-theme="dark"] .dashboard-welcome__hint,
    body[data-theme-version="dark"] .dashboard-welcome__hint,
    body.theme-dark .dashboard-welcome__hint {
        color:#bfdbfe;
        background:rgba(30,64,175,0.3);
        border-color:rgba(96,165,250,0.35);
    }
    body[data-theme="dark"] .dashboard-clock,
    body[data-theme-version="dark"] .dashboard-clock,
    body.theme-dark .dashboard-clock {
        background:#0b1220;
        border-color:rgba(148,163,184,0.35);
        box-shadow:0 10px 24px rgba(2,6,23,0.45);
    }
    body[data-theme="dark"] .dashboard-clock__label,
    body[data-theme-version="dark"] .dashboard-clock__label,
    body.theme-dark .dashboard-clock__label { color:#94a3b8; }
    body[data-theme="dark"] .dashboard-clock__value,
    body[data-theme-version="dark"] .dashboard-clock__value,
    body.theme-dark .dashboard-clock__value { color:#f8fafc; }
    body[data-theme="dark"] .dashboard-shell .avtivity-card,
    body[data-theme-version="dark"] .dashboard-shell .avtivity-card,
    body.theme-dark .dashboard-shell .avtivity-card {
        background: #0b1220;
        border-color: rgba(148,163,184,0.28);
        box-shadow: 0 14px 34px rgba(2,6,23,0.45);
    }
    body[data-theme="dark"] .dashboard-shell .avtivity-card .media-body p,
    body[data-theme-version="dark"] .dashboard-shell .avtivity-card .media-body p,
    body.theme-dark .dashboard-shell .avtivity-card .media-body p { color: #94a3b8; }
    body[data-theme="dark"] .dashboard-shell .avtivity-card .media-body .title,
    body[data-theme-version="dark"] .dashboard-shell .avtivity-card .media-body .title,
    body.theme-dark .dashboard-shell .avtivity-card .media-body .title { color: #f8fafc; }
    body[data-theme="dark"] .dashboard-shell .avtivity-card .progress,
    body[data-theme-version="dark"] .dashboard-shell .avtivity-card .progress,
    body.theme-dark .dashboard-shell .avtivity-card .progress { background: #1e293b; }
    body[data-theme="dark"] .dashboard-shell .avtivity-card .activity-icon,
    body[data-theme-version="dark"] .dashboard-shell .avtivity-card .activity-icon,
    body.theme-dark .dashboard-shell .avtivity-card .activity-icon { background: rgba(148,163,184,0.16); }
    body[data-theme="dark"] .dashboard-panel,
    body[data-theme-version="dark"] .dashboard-panel,
    body.theme-dark .dashboard-panel {
        background: #0b1220;
        border-color: rgba(148,163,184,0.28);
        box-shadow: 0 14px 34px rgba(2,6,23,0.45);
    }
    body[data-theme="dark"] .dashboard-panel h4,
    body[data-theme-version="dark"] .dashboard-panel h4,
    body.theme-dark .dashboard-panel h4,
    body[data-theme="dark"] .dashboard-panel .card-title,
    body[data-theme-version="dark"] .dashboard-panel .card-title,
    body.theme-dark .dashboard-panel .card-title { color: #f8fafc; }
    body[data-theme="dark"] .dashboard-panel .text-muted,
    body[data-theme-version="dark"] .dashboard-panel .text-muted,
    body.theme-dark .dashboard-panel .text-muted,
    body[data-theme="dark"] .dashboard-panel .fs-13,
    body[data-theme-version="dark"] .dashboard-panel .fs-13,
    body.theme-dark .dashboard-panel .fs-13,
    body[data-theme="dark"] .dashboard-panel .fs-14,
    body[data-theme-version="dark"] .dashboard-panel .fs-14,
    body.theme-dark .dashboard-panel .fs-14 { color: #94a3b8 !important; }
    body[data-theme="dark"] .dashboard-system-item,
    body[data-theme-version="dark"] .dashboard-system-item,
    body.theme-dark .dashboard-system-item {
        background: #111827;
        border-color: rgba(148,163,184,0.22);
    }
    body[data-theme="dark"] .dashboard-system-value,
    body[data-theme-version="dark"] .dashboard-system-value,
    body.theme-dark .dashboard-system-value { color: #cbd5e1; }
    body[data-theme="dark"] .dashboard-system-item__icon--green,
    body[data-theme-version="dark"] .dashboard-system-item__icon--green,
    body.theme-dark .dashboard-system-item__icon--green { background: rgba(34,197,94,0.2); color: #4ade80; }
    body[data-theme="dark"] .dashboard-system-item__icon--blue,
    body[data-theme-version="dark"] .dashboard-system-item__icon--blue,
    body.theme-dark .dashboard-system-item__icon--blue { background: rgba(59,130,246,0.2); color: #93c5fd; }
    body[data-theme="dark"] .dashboard-system-item__icon--amber,
    body[data-theme-version="dark"] .dashboard-system-item__icon--amber,
    body.theme-dark .dashboard-system-item__icon--amber { background: rgba(245,158,11,0.2); color: #fbbf24; }
    body[data-theme="dark"] .dashboard-system-item__icon--slate,
    body[data-theme-version="dark"] .dashboard-system-item__icon--slate,
    body.theme-dark .dashboard-system-item__icon--slate { background: rgba(148,163,184,0.2); color: #cbd5e1; }
    body[data-theme="dark"] .dashboard-profile__name,
    body[data-theme-version="dark"] .dashboard-profile__name,
    body.theme-dark .dashboard-profile__name { color: #f8fafc; }
    body[data-theme="dark"] .dashboard-profile__email,
    body[data-theme-version="dark"] .dashboard-profile__email,
    body.theme-dark .dashboard-profile__email { color: #94a3b8; }
    body[data-theme="dark"] .dashboard-profile-meta__item,
    body[data-theme-version="dark"] .dashboard-profile-meta__item,
    body.theme-dark .dashboard-profile-meta__item {
        background: #111827;
        border-color: rgba(148,163,184,0.24);
    }
    body[data-theme="dark"] .dashboard-profile-meta__label,
    body[data-theme-version="dark"] .dashboard-profile-meta__label,
    body.theme-dark .dashboard-profile-meta__label { color: #94a3b8; }
    body[data-theme="dark"] .dashboard-profile-meta__value,
    body[data-theme-version="dark"] .dashboard-profile-meta__value,
    body.theme-dark .dashboard-profile-meta__value { color: #f8fafc; }
    body[data-theme="dark"] .dashboard-profile__role,
    body[data-theme-version="dark"] .dashboard-profile__role,
    body.theme-dark .dashboard-profile__role {
        color: #bfdbfe;
        background: rgba(30,64,175,0.3);
        border-color: rgba(96,165,250,0.35);
    }
    body[data-theme="dark"] .dashboard-quick-link,
    body[data-theme-version="dark"] .dashboard-quick-link,
    body.theme-dark .dashboard-quick-link {
        background: #111827;
        border-color: rgba(148,163,184,0.25);
        color: #e2e8f0;
    }
    body[data-theme="dark"] .dashboard-quick-link:hover,
    body[data-theme-version="dark"] .dashboard-quick-link:hover,
    body.theme-dark .dashboard-quick-link:hover {
        color: #f8fafc;
        background: #1e293b;
    }
    body[data-theme="dark"] .dashboard-member-item,
    body[data-theme-version="dark"] .dashboard-member-item,
    body.theme-dark .dashboard-member-item {
        background: #111827;
        border-color: rgba(148,163,184,0.24);
    }
    body[data-theme="dark"] .dashboard-member-name,
    body[data-theme-version="dark"] .dashboard-member-name,
    body.theme-dark .dashboard-member-name { color: #f8fafc; }
    body[data-theme="dark"] .dashboard-member-email,
    body[data-theme-version="dark"] .dashboard-member-email,
    body.theme-dark .dashboard-member-email { color: #94a3b8; }
    body[data-theme="dark"] .dashboard-member-role,
    body[data-theme-version="dark"] .dashboard-member-role,
    body.theme-dark .dashboard-member-role {
        color: #bfdbfe;
        background: rgba(30,64,175,0.3);
        border-color: rgba(96,165,250,0.35);
    }
    body[data-theme="dark"] .dashboard-member-role--peminjam,
    body[data-theme-version="dark"] .dashboard-member-role--peminjam,
    body.theme-dark .dashboard-member-role--peminjam { color:#e2e8f0; background:#1e293b; border-color:#334155; }
    body[data-theme="dark"] .dashboard-member-role--petugas,
    body[data-theme-version="dark"] .dashboard-member-role--petugas,
    body.theme-dark .dashboard-member-role--petugas { color:#99f6e4; background:rgba(13,148,136,0.2); border-color:rgba(45,212,191,0.35); }
    body[data-theme="dark"] .dashboard-member-role--super,
    body[data-theme-version="dark"] .dashboard-member-role--super,
    body.theme-dark .dashboard-member-role--super { color:#bfdbfe; background:rgba(37,99,235,0.24); border-color:rgba(96,165,250,0.38); }
    body[data-theme="dark"] .dashboard-members-nav-btn,
    body[data-theme-version="dark"] .dashboard-members-nav-btn,
    body.theme-dark .dashboard-members-nav-btn {
        background: #111827;
        border-color: rgba(148,163,184,0.35);
        color: #cbd5e1;
    }
    body[data-theme="dark"] .dashboard-members-nav-btn:hover,
    body[data-theme-version="dark"] .dashboard-members-nav-btn:hover,
    body.theme-dark .dashboard-members-nav-btn:hover {
        color: #bfdbfe;
        background: #1e293b;
    }
    @media (max-width: 768px) {
        .dashboard-shell { gap: 0.75rem; }
        .dashboard-side-col { display: block; }
        .dashboard-panel--status {
            min-height: 0;
        }
        .dashboard-panel--profile {
            min-height: 0;
            height: auto;
        }
        .dashboard-panel--members {
            height: auto;
        }
        .dashboard-panel--members .card-body {
            overflow: visible;
        }
        .dashboard-panel--menu {
            min-height: 0;
        }
        .dashboard-clock {
            min-width: 0;
            min-height: 92px;
            width: 100%;
            max-width: none;
            display: flex;
        }
        .dashboard-shell .avtivity-card .media-body .title {
            font-size: 1.55rem;
        }
        .dashboard-shell .avtivity-card {
            min-height: 170px;
        }
        .dashboard-member-item {
            width: 220px;
            flex-basis: 220px;
        }
        .dashboard-profile-meta {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 1200px) {
        .dashboard-clock {
            min-width: 0;
            max-width: none;
            width: 100%;
            display: flex;
        }
        .dashboard-clock__value {
            font-size: clamp(0.82rem, 1vw + 0.35rem, 1.02rem);
        }
    }
    @media (min-width: 1600px) {
        .dashboard-panel--status .dashboard-status-col {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }
    .dashboard-refresh-toast {
        position: fixed;
        right: 18px;
        bottom: 18px;
        z-index: 1090;
        border-radius: 10px;
        padding: 0.6rem 0.8rem;
        font-size: 0.83rem;
        font-weight: 600;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.18);
        opacity: 0;
        transform: translateY(10px);
        pointer-events: none;
        transition: opacity 0.2s ease, transform 0.2s ease;
        max-width: min(360px, calc(100vw - 32px));
    }
    .dashboard-refresh-toast.is-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #86efac;
    }
    .dashboard-refresh-toast.is-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }
    .dashboard-refresh-toast.is-show {
        opacity: 1;
        transform: translateY(0);
    }
    body[data-theme="dark"] .dashboard-refresh-toast,
    body[data-theme-version="dark"] .dashboard-refresh-toast,
    body.theme-dark .dashboard-refresh-toast {
        box-shadow: 0 10px 24px rgba(2, 6, 23, 0.5);
    }
    body[data-theme="dark"] .dashboard-refresh-toast.is-success,
    body[data-theme-version="dark"] .dashboard-refresh-toast.is-success,
    body.theme-dark .dashboard-refresh-toast.is-success {
        background: rgba(20, 83, 45, 0.92);
        color: #bbf7d0;
        border-color: rgba(74, 222, 128, 0.5);
    }
    body[data-theme="dark"] .dashboard-refresh-toast.is-error,
    body[data-theme-version="dark"] .dashboard-refresh-toast.is-error,
    body.theme-dark .dashboard-refresh-toast.is-error {
        background: rgba(127, 29, 29, 0.92);
        color: #fecaca;
        border-color: rgba(248, 113, 113, 0.5);
    }
</style>
@endpush

@section('title', 'Dashboard')

@section('content')
@php
    $periodStart = now()->copy()->startOfMonth();
    $periodEnd = now()->copy()->endOfDay();

    $dayKeys = collect(range(0, $periodStart->diffInDays($periodEnd)))
        ->map(fn ($offset) => $periodStart->copy()->addDays($offset)->format('Y-m-d'));

    $dayLabels = $dayKeys
        ->map(function ($key) {
            try {
                return \Carbon\Carbon::createFromFormat('Y-m-d', $key)->translatedFormat('d M');
            } catch (\Throwable $e) {
                return $key;
            }
        })
        ->values();

    $petugasNames = \App\Models\User::query()
        ->where('role', \App\Models\User::ROLE_PETUGAS)
        ->pluck('name')
        ->filter(fn ($name) => !empty($name))
        ->values();

    $petugasLoanRows = \App\Models\Loan::query()
        ->selectRaw("DATE(loan_date) as day_key, borrower_name, COUNT(*) as total")
        ->whereBetween('loan_date', [$periodStart->toDateString(), $periodEnd->toDateString()])
        ->whereNotNull('borrower_name')
        ->when($petugasNames->isNotEmpty(), fn ($query) => $query->whereIn('borrower_name', $petugasNames))
        ->groupBy('day_key', 'borrower_name')
        ->get();

    $topPetugas = $petugasLoanRows
        ->groupBy('borrower_name')
        ->map(fn ($rows) => (int) $rows->sum('total'))
        ->sortDesc()
        ->keys()
        ->take(6)
        ->values();

    if ($topPetugas->isEmpty() && $petugasNames->isNotEmpty()) {
        $topPetugas = $petugasNames->take(6)->values();
    }

    $petugasMonthlySeries = $topPetugas->map(function ($petugas) use ($dayKeys, $petugasLoanRows) {
        return [
            'name' => $petugas,
            'data' => $dayKeys
                ->map(function ($dayKey) use ($petugas, $petugasLoanRows) {
                    $row = $petugasLoanRows->first(function ($item) use ($petugas, $dayKey) {
                        return $item->borrower_name === $petugas && $item->day_key === $dayKey;
                    });

                    return (int) ($row->total ?? 0);
                })
                ->values()
                ->all(),
        ];
    })->values();

    $petugasMonthlyGrandTotal = (int) $petugasLoanRows->sum('total');
@endphp
<main class="content-body">
    <div id="petugasMonthlyToast" class="dashboard-refresh-toast" aria-live="polite" role="status"></div>
    <div class="container-fluid">
        <div class="dashboard-shell">
            <div class="dashboard-welcome row g-3 align-items-center">
                <div class="col-lg-8 col-xl-8">
                    <div class="dashboard-welcome__title">Selamat Datang, {{ auth()->user()->name ?? 'User' }}!</div>
                    <div class="dashboard-welcome__subtitle">Sistem SARPRAS PUSDATEKIN BPIP</div>
                    <div class="dashboard-welcome__hint">
                        <i class="fas fa-bolt"></i>
                        Ringkasan cepat aktivitas sarpras
                    </div>
                </div>
                <div class="col-lg-4 col-xl-4">
                    <div class="dashboard-clock ms-xl-auto" aria-live="polite">
                        <div class="dashboard-clock__label">Hari & Jam</div>
                        <div class="dashboard-clock__value" id="dashboardClock">-</div>
                    </div>
                </div>
            </div>

            <!-- Overview Row -->
            <div class="row dashboard-overview-row">
                <div class="col-xl-8">
                    <div class="row dashboard-stats-row">
                        <div class="col-sm-6 col-lg-4">
                            <div class="card avtivity-card">
                                <div class="card-body">
                                    <div class="media align-items-center">
                                        <span class="activity-icon bgl-success me-md-4 me-3">
                                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="5" y="5" width="30" height="30" rx="8" stroke="#27BC48" stroke-width="3"/>
                                                <path d="M10 16H30M16 10V30M24 10V30" stroke="#27BC48" stroke-width="2.5" stroke-linecap="round"/>
                                                <rect x="11.5" y="11.5" width="3.8" height="3.8" rx="1" fill="#27BC48" opacity="0.75"/>
                                                <rect x="24.7" y="24.7" width="3.8" height="3.8" rx="1" fill="#27BC48" opacity="0.75"/>
                                            </svg>
                                        </span>
                                        <div class="media-body">
                                            <p class="fs-14 mb-2">Total Barang</p>
                                            <span class="title text-black font-w600">{{ \App\Models\Asset::count() }}</span>
                                        </div>
                                    </div>
                                    <div class="progress" style="height:5px;">
                                        <div class="progress-bar bg-success" style="width: 100%; height:5px;" role="progressbar"></div>
                                    </div>
                                </div>
                                <div class="effect bg-success"></div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="card avtivity-card">
                                <div class="card-body">
                                    <div class="media align-items-center">
                                        <span class="activity-icon bgl-secondary  me-md-4 me-3">
                                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="14" cy="16" r="5" stroke="#A02CFA" stroke-width="2.8"/>
                                                <circle cx="26" cy="15" r="4" stroke="#A02CFA" stroke-width="2.6" opacity="0.8"/>
                                                <path d="M7 30c0-4.4 3.6-8 8-8h2c4.4 0 8 3.6 8 8" stroke="#A02CFA" stroke-width="2.8" stroke-linecap="round"/>
                                                <path d="M22 29.5c.6-3.4 3.2-6 6.5-6H29c2.2 0 4.2 1.2 5.3 3.1" stroke="#A02CFA" stroke-width="2.6" stroke-linecap="round" opacity="0.8"/>
                                            </svg>
                                        </span>
                                        <div class="media-body">
                                            <p class="fs-14 mb-2">Total User</p>
                                            <span class="title text-black font-w600">{{ \App\Models\User::count() }}</span>
                                        </div>
                                    </div>
                                    <div class="progress" style="height:5px;">
                                        <div class="progress-bar bg-secondary" style="width: 100%; height:5px;" role="progressbar"></div>
                                    </div>
                                </div>
                                <div class="effect bg-secondary"></div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="card avtivity-card">
                                <div class="card-body">
                                    <div class="media align-items-center">
                                        <span class="activity-icon bgl-warning  me-md-4 me-3">
                                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="5" y="8" width="30" height="24" rx="6" stroke="#FFBC11" stroke-width="3"/>
                                                <path d="M5 16h30" stroke="#FFBC11" stroke-width="2.6"/>
                                                <path d="M13 21.5l4 4 9-9" stroke="#FFBC11" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                        <div class="media-body">
                                            <p class="fs-14 mb-2">Total Pinjaman</p>
                                            <span class="title text-black font-w600">{{ \App\Models\Loan::count() ?? 0 }}</span>
                                        </div>
                                    </div>
                                    <div class="progress" style="height:5px;">
                                        <div class="progress-bar bg-warning" style="width: 100%; height:5px;" role="progressbar"></div>
                                    </div>
                                </div>
                                <div class="effect bg-warning"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card dashboard-panel dashboard-panel--members mt-3">
                        <div class="card-header border-0 pb-0 dashboard-members-head">
                            <div>
                                <h4 class="mb-0">Daftar Anggota</h4>
                                <p class="fs-13 mb-0">Anggota terbaru yang terdaftar di sistem.</p>
                            </div>
                            <div class="dashboard-members-actions">
                                <button type="button" class="dashboard-members-nav-btn" data-members-nav="prev" aria-label="Lihat anggota sebelumnya">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button type="button" class="dashboard-members-nav-btn" data-members-nav="next" aria-label="Lihat anggota berikutnya">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                                <a href="{{ route('users.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @php($dashboardMembers = \App\Models\User::query()
                                ->orderByRaw("CASE role WHEN 'super_admin' THEN 1 WHEN 'petugas' THEN 2 WHEN 'peminjam' THEN 3 ELSE 4 END")
                                ->latest()
                                ->take(8)
                                ->get())
                            @if($dashboardMembers->isEmpty())
                                <p class="text-muted mb-0">Belum ada anggota terdaftar.</p>
                            @else
                                <div class="dashboard-members-viewport" id="dashboardMembersViewport">
                                    <div class="dashboard-members-list">
                                        @foreach($dashboardMembers as $member)
                                            <div class="dashboard-member-item">
                                                <span class="dashboard-member-avatar">
                                                    @if($member->photo)
                                                        <img src="{{ asset('storage/'.$member->photo) }}" alt="Foto {{ $member->name }}">
                                                    @else
                                                        {{ strtoupper(substr($member->name ?? 'U', 0, 1)) }}
                                                    @endif
                                                </span>
                                                <div>
                                                    <p class="dashboard-member-name">{{ $member->name }}</p>
                                                    <span class="dashboard-member-role {{ $member->role === \App\Models\User::ROLE_SUPER_ADMIN ? 'dashboard-member-role--super' : ($member->role === \App\Models\User::ROLE_PETUGAS ? 'dashboard-member-role--petugas' : 'dashboard-member-role--peminjam') }}">{{ $member->role_label }}</span>
                                                    <p class="dashboard-member-email">{{ $member->email }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card dashboard-panel dashboard-panel--profile">
                        <div class="card-header border-0 pb-0">
                            <h4 class="card-title mb-0">Informasi Profil</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-4 pb-3 border-bottom">
                                <h6 class="mb-3 font-w600">Pengguna Saat Ini</h6>
                                <div class="dashboard-profile">
                                    <span class="dashboard-profile__avatar">
                                        @if(auth()->user()?->photo)
                                            <img class="dashboard-profile__avatar-img" src="{{ asset('storage/'.auth()->user()->photo) }}" alt="Foto {{ auth()->user()->name }}">
                                        @else
                                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                        @endif
                                    </span>
                                    <div>
                                        <div class="dashboard-profile__name">{{ auth()->user()->name ?? 'User' }}</div>
                                        <div class="dashboard-profile__role">{{ auth()->user()?->role_label ?? 'Pengguna' }}</div>
                                        <p class="dashboard-profile__email">{{ auth()->user()->email ?? 'email@example.com' }}</p>
                                    </div>
                                </div>

                                <div class="dashboard-profile-meta mt-3">
                                    <div class="dashboard-profile-meta__item">
                                        <p class="dashboard-profile-meta__label">ID Pengguna</p>
                                        <p class="dashboard-profile-meta__value">#{{ auth()->id() ?? '-' }}</p>
                                    </div>
                                    <div class="dashboard-profile-meta__item">
                                        <p class="dashboard-profile-meta__label">Bergabung</p>
                                        <p class="dashboard-profile-meta__value">{{ optional(auth()->user()?->created_at)->format('d M Y') ?? '-' }}</p>
                                    </div>
                                    <div class="dashboard-profile-meta__item">
                                        <p class="dashboard-profile-meta__label">Status Akses</p>
                                        <p class="dashboard-profile-meta__value">Aktif</p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center pt-1">
                                <a href="{{ route('profile.show') }}" class="btn btn-primary btn-sm" target="_blank" rel="noopener">Lihat Profil</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->
            <div class="row dashboard-content-row">
            <div class="col-12">
                <div class="card dashboard-panel">
                    <div class="card-header d-sm-flex d-block pb-0 border-0">
                        <div class="me-auto pe-3 mb-sm-0 mb-3">
                            <h4 class="text-black fs-20 font-w600">Grafik Peminjaman Petugas (Bulan Berjalan)</h4>
                            <p class="fs-13 mb-0">Periode {{ $periodStart->translatedFormat('d M Y') }} - {{ $periodEnd->translatedFormat('d M Y') }}.</p>
                        </div>
                        <div class="mb-3 d-flex gap-2 flex-wrap">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="petugasMonthlyRefreshBtn">
                                <i class="fas fa-rotate-right me-1"></i> Refresh
                            </button>
                            <span class="badge light badge-primary" id="petugasMonthlyTotalBadge">Total: {{ number_format($petugasMonthlyGrandTotal, 0, ',', '.') }}</span>
                            <span class="badge light badge-info" id="petugasMonthlyCountBadge">Petugas tampil: {{ $petugasMonthlySeries->count() }}</span>
                            <span class="badge light badge-secondary" id="petugasMonthlyUpdatedBadge">Update: -</span>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        @if($petugasMonthlySeries->isEmpty())
                            <p class="text-muted mb-0">Belum ada data peminjaman petugas pada periode ini.</p>
                        @else
                            <div
                                id="chartPetugasMonthlyLoan"
                                data-labels='@json($dayLabels)'
                                data-series='@json($petugasMonthlySeries)'
                                data-endpoint="{{ route('dashboard.chart.petugas-monthly') }}"
                            ></div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-6 col-xxl-6 dashboard-side-col">
                <div class="card dashboard-panel dashboard-panel--menu">
                    <div class="card-header border-0 pb-0">
                        <h4 class="card-title mb-0">Menu Cepat</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <a href="{{ route('assets.index') }}" class="btn dashboard-quick-link btn-sm w-100 text-start">
                                    <i class="fas fa-box me-2"></i> Data Barang
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('loans.create', ['fresh' => 1]) }}" class="btn dashboard-quick-link btn-sm w-100 text-start">
                                    <i class="fas fa-handshake me-2"></i> Tambah Peminjaman
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('users.index') }}" class="btn dashboard-quick-link btn-sm w-100 text-start">
                                    <i class="fas fa-users me-2"></i> Manajemen User
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('settings.admin-menu') }}" class="btn dashboard-quick-link btn-sm w-100 text-start">
                                    <i class="fas fa-shield-halved me-2"></i> Pengaturan Super Admin
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-6 col-xxl-6 dashboard-main-col">
                <div class="card dashboard-panel dashboard-panel--status">
                    <div class="card-header d-sm-flex d-block pb-0 border-0">
                        <div class="me-auto pe-3 mb-sm-0 mb-3">
                            <h4 class="text-black fs-20 font-w600">Status Sistem</h4>
                            <p class="fs-13 mb-0">Informasi terkini tentang sistem SARPRAS</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3 dashboard-status-col">
                                <div class="d-flex justify-content-between align-items-center dashboard-system-item">
                                    <div class="dashboard-system-item__head">
                                        <span class="dashboard-system-item__icon dashboard-system-item__icon--green"><i class="fas fa-server"></i></span>
                                        <span class="fs-14">Server Status</span>
                                    </div>
                                    <span class="badge bg-success">Online</span>
                                </div>
                            </div>
                            <div class="col-12 mb-3 dashboard-status-col">
                                <div class="d-flex justify-content-between align-items-center dashboard-system-item">
                                    <div class="dashboard-system-item__head">
                                        <span class="dashboard-system-item__icon dashboard-system-item__icon--blue"><i class="fas fa-database"></i></span>
                                        <span class="fs-14">Database</span>
                                    </div>
                                    <span class="badge bg-success">Connected</span>
                                </div>
                            </div>
                            <div class="col-12 mb-3 dashboard-status-col">
                                <div class="d-flex justify-content-between align-items-center dashboard-system-item">
                                    <div class="dashboard-system-item__head">
                                        <span class="dashboard-system-item__icon dashboard-system-item__icon--amber"><i class="fas fa-clock"></i></span>
                                        <span class="fs-14">Last Backup</span>
                                    </div>
                                    <span class="dashboard-system-value">{{ now()->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                            <div class="col-12 mb-3 dashboard-status-col">
                                <div class="d-flex justify-content-between align-items-center dashboard-system-item">
                                    <div class="dashboard-system-item__head">
                                        <span class="dashboard-system-item__icon dashboard-system-item__icon--slate"><i class="fas fa-code-branch"></i></span>
                                        <span class="fs-14">System Version</span>
                                    </div>
                                    <span class="dashboard-system-value">v1.0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    (function () {
        const clockEl = document.getElementById('dashboardClock');
        if (!clockEl) return;

        const formatter = new Intl.DateTimeFormat('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false,
        });

        const tick = () => {
            clockEl.textContent = formatter.format(new Date()).replace('.', ':');
        };

        tick();
        setInterval(tick, 1000);
    })();

    (function () {
        const viewport = document.getElementById('dashboardMembersViewport');
        if (!viewport) return;

        const navButtons = document.querySelectorAll('[data-members-nav]');

        navButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const dir = button.getAttribute('data-members-nav') === 'next' ? 1 : -1;
                const scrollAmount = Math.max(260, Math.floor(viewport.clientWidth * 0.75));
                viewport.scrollBy({ left: dir * scrollAmount, behavior: 'smooth' });
            });
        });
    })();

    (function () {
        const chartEl = document.getElementById('chartPetugasMonthlyLoan');
        if (!chartEl || typeof ApexCharts === 'undefined') return;

        const totalBadgeEl = document.getElementById('petugasMonthlyTotalBadge');
        const countBadgeEl = document.getElementById('petugasMonthlyCountBadge');
        const updatedBadgeEl = document.getElementById('petugasMonthlyUpdatedBadge');
        const refreshBtnEl = document.getElementById('petugasMonthlyRefreshBtn');
        const refreshToastEl = document.getElementById('petugasMonthlyToast');
        const endpoint = chartEl.dataset.endpoint || '';
        const refreshIntervalMs = 30000;

        const idFormatter = new Intl.NumberFormat('id-ID');
        const updatedAtFormatter = new Intl.DateTimeFormat('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false,
        });

        let labels = [];
        let series = [];
        let refreshToastTimer = null;

        try {
            labels = JSON.parse(chartEl.dataset.labels || '[]');
            series = JSON.parse(chartEl.dataset.series || '[]');
        } catch (e) {
            labels = [];
            series = [];
        }

        if (!Array.isArray(labels) || !labels.length || !Array.isArray(series) || !series.length) return;

        chartEl.innerHTML = '';

        if (window.petugasMonthlyLoanChart && typeof window.petugasMonthlyLoanChart.destroy === 'function') {
            window.petugasMonthlyLoanChart.destroy();
        }

        window.petugasMonthlyLoanChart = new ApexCharts(chartEl, {
            series: series,
            chart: {
                type: 'bar',
                height: 330,
                stacked: false,
                toolbar: { show: false },
                zoom: { enabled: false }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '52%',
                    borderRadius: 4,
                }
            },
            dataLabels: { enabled: false },
            stroke: {
                show: true,
                width: 1,
                colors: ['transparent']
            },
            xaxis: {
                categories: labels,
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
                    formatter: function (val) {
                        return val + ' ticket';
                    }
                }
            },
            grid: {
                borderColor: '#e2e8f0',
                strokeDashArray: 4,
            }
        });

        window.petugasMonthlyLoanChart.render();

        function applyBadgeTotals(payload) {
            if (totalBadgeEl && typeof payload.grand_total === 'number') {
                totalBadgeEl.textContent = 'Total: ' + idFormatter.format(payload.grand_total);
            }

            if (countBadgeEl && typeof payload.officer_count === 'number') {
                countBadgeEl.textContent = 'Petugas tampil: ' + idFormatter.format(payload.officer_count);
            }

            if (updatedBadgeEl) {
                if (payload.generated_at) {
                    const generatedAtDate = new Date(payload.generated_at);
                    if (!Number.isNaN(generatedAtDate.getTime())) {
                        updatedBadgeEl.textContent = 'Update: ' + updatedAtFormatter.format(generatedAtDate).replace('.', ':');
                    }
                }
            }
        }

        function isValidPayload(payload) {
            return payload
                && Array.isArray(payload.labels)
                && Array.isArray(payload.series)
                && payload.labels.length > 0
                && payload.series.length > 0;
        }

        function showRefreshToast(message, type) {
            if (!refreshToastEl) return;

            refreshToastEl.textContent = message;
            refreshToastEl.classList.remove('is-success', 'is-error', 'is-show');
            refreshToastEl.classList.add(type === 'error' ? 'is-error' : 'is-success');

            requestAnimationFrame(function () {
                refreshToastEl.classList.add('is-show');
            });

            if (refreshToastTimer) {
                clearTimeout(refreshToastTimer);
            }

            refreshToastTimer = setTimeout(function () {
                refreshToastEl.classList.remove('is-show');
            }, 2600);
        }

        async function refreshChartData(options) {
            if (!endpoint) return;

            const opts = Object.assign({
                manual: false,
                notify: false,
            }, options || {});

            if (refreshBtnEl && opts.manual) {
                refreshBtnEl.disabled = true;
                refreshBtnEl.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Memuat...';
            }

            try {
                const response = await fetch(endpoint, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin',
                    cache: 'no-store'
                });

                if (!response.ok) {
                    if (opts.notify) {
                        showRefreshToast('Gagal memperbarui grafik. Coba lagi.', 'error');
                    }
                    return;
                }

                const payload = await response.json();
                if (!isValidPayload(payload)) {
                    if (opts.notify) {
                        showRefreshToast('Data grafik tidak valid.', 'error');
                    }
                    return;
                }

                if (window.petugasMonthlyLoanChart && typeof window.petugasMonthlyLoanChart.updateOptions === 'function') {
                    window.petugasMonthlyLoanChart.updateOptions({ xaxis: { categories: payload.labels } }, false, true);
                }

                if (window.petugasMonthlyLoanChart && typeof window.petugasMonthlyLoanChart.updateSeries === 'function') {
                    window.petugasMonthlyLoanChart.updateSeries(payload.series, true);
                }

                applyBadgeTotals(payload);

                if (opts.notify) {
                    showRefreshToast('Grafik berhasil diperbarui.', 'success');
                }
            } catch (e) {
                if (opts.notify) {
                    showRefreshToast('Terjadi kendala saat memperbarui grafik.', 'error');
                }
            } finally {
                if (refreshBtnEl && opts.manual) {
                    refreshBtnEl.disabled = false;
                    refreshBtnEl.innerHTML = '<i class="fas fa-rotate-right me-1"></i> Refresh';
                }
            }
        }

        let refreshTimer = null;

        function startPolling() {
            if (refreshTimer !== null) return;
            refreshTimer = setInterval(refreshChartData, refreshIntervalMs);
        }

        function stopPolling() {
            if (refreshTimer === null) return;
            clearInterval(refreshTimer);
            refreshTimer = null;
        }

        document.addEventListener('visibilitychange', function () {
            if (document.hidden) {
                stopPolling();
            } else {
                refreshChartData();
                startPolling();
            }
        });

        if (refreshBtnEl) {
            refreshBtnEl.addEventListener('click', function () {
                refreshChartData({ manual: true, notify: true });
            });
        }

        refreshChartData();
        startPolling();
    })();
</script>
@endpush
