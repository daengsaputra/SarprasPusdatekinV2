<div class="sso-modal-main">
    <button type="button" class="sso-modal-close" data-bs-dismiss="modal" aria-label="Tutup dialog login">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="m7 7 10 10M17 7 7 17" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
        </svg>
    </button>

    <header class="sso-modal-brand" aria-label="Sarpras Pusdatekin">
        <span class="sso-modal-mark" aria-hidden="true">
            <svg width="42" height="42" viewBox="0 0 24 24" fill="none">
                <path d="M4.3 9.4a11.1 11.1 0 0 1 15.4 0M7 12.2a7.2 7.2 0 0 1 10 0M9.8 15a3.2 3.2 0 0 1 4.4 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                <circle cx="12" cy="18" r="1.35" fill="currentColor"/>
            </svg>
        </span>
        <span class="sso-modal-brand-line">
            <span class="sso-modal-brand-name"><span class="brand-prefix">sarpras</span> <strong>pusdatekin</strong></span>
        </span>
    </header>

    <h2 class="sso-modal-title">Masuk Dashboard</h2>
    <p class="sso-modal-description">Silakan masuk menggunakan akun SSO BPIP Anda.</p>

    <div class="sso-modal-alerts">
        @if (session('success'))
            <div class="sso-modal-alert sso-modal-alert-success" role="status">{{ session('success') }}</div>
        @endif
        @if (session('status'))
            <div class="sso-modal-alert sso-modal-alert-info" role="status">{{ session('status') }}</div>
        @endif
        @if (session('error') || $errors->any())
            <div class="sso-modal-alert sso-modal-alert-error" role="alert">
                {{ session('error') ?: $errors->first() }}
            </div>
        @endif
    </div>

    <a href="{{ route('sso.redirect') }}" class="sso-modal-button">
        <svg class="sso-key" width="25" height="25" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M14.7 9.3a5 5 0 1 0-6 6L4 20v-3h3v-3h2.2a5 5 0 0 0 5.5-4.7Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="15.5" cy="8.5" r="1" fill="currentColor"/>
        </svg>
        <span>Masuk dengan SSO BPIP</span>
    </a>

    @if (app()->environment('local') && !config('sso.enabled'))
        <a href="{{ route('local.login') }}" class="sso-modal-local">Masuk ke Dashboard Lokal</a>
    @endif

    <div class="sso-modal-status">
        <span class="sso-modal-dot" aria-hidden="true"></span>
        <span>Koneksi Terenkripsi TLS</span>
    </div>
</div>
