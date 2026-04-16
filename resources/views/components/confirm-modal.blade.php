@props([
  'title' => 'Apakah anda yakin?',
  'defaultMessage' => 'Data tidak dapat dikembalikan setelah aksi dijalankan.',
  'confirmText' => 'Ya',
  'cancelText' => 'Tidak',
])

@once
  @push('styles')
  <style>
    body.app-confirm-modal-open {
      overflow: hidden;
    }
    .app-confirm-modal {
      position: fixed;
      inset: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(15, 23, 42, 0.58);
      backdrop-filter: blur(7px);
      padding: 1.5rem;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.22s ease, visibility 0.22s ease;
      z-index: 2100;
    }
    .app-confirm-modal.is-visible {
      opacity: 1;
      visibility: visible;
    }
    .app-confirm-panel {
      width: min(460px, 96vw);
      background: linear-gradient(165deg, #ffffff, #f8fafc 78%);
      border: 1px solid rgba(148,163,184,0.38);
      border-radius: 22px;
      padding: 1.3rem;
      box-shadow: 0 24px 48px rgba(2, 6, 23, 0.26);
      transform: translateY(10px) scale(0.96);
      transition: transform 0.22s ease;
    }
    .app-confirm-modal.is-visible .app-confirm-panel {
      transform: translateY(0) scale(1);
    }
    .app-confirm-head {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    .app-confirm-icon {
      width: 2.2rem;
      height: 2.2rem;
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
      background: rgba(245, 158, 11, 0.16);
      color: #b45309;
      border: 1px solid rgba(245, 158, 11, 0.4);
      flex: 0 0 auto;
    }
    .app-confirm-title {
      margin: 0;
      font-size: 1.08rem;
      font-weight: 700;
      color: #0f172a;
    }
    .app-confirm-text {
      margin: 0.45rem 0 0;
      color: #475569;
      font-size: 0.93rem;
    }
    .app-confirm-actions {
      margin-top: 1rem;
      display: flex;
      justify-content: flex-end;
      gap: 0.55rem;
    }
    .app-confirm-actions .btn {
      min-width: 90px;
      border-radius: 999px;
    }
    body[data-theme="dark"] .app-confirm-panel,
    body[data-theme-version="dark"] .app-confirm-panel,
    body.theme-dark .app-confirm-panel {
      background: #0b1220;
      border-color: rgba(148,163,184,0.4);
    }
    body[data-theme="dark"] .app-confirm-title,
    body[data-theme-version="dark"] .app-confirm-title,
    body.theme-dark .app-confirm-title {
      color: #e5e7eb;
    }
    body[data-theme="dark"] .app-confirm-text,
    body[data-theme-version="dark"] .app-confirm-text,
    body.theme-dark .app-confirm-text {
      color: #cbd5e1;
    }
    body[data-theme="dark"] .app-confirm-icon,
    body[data-theme-version="dark"] .app-confirm-icon,
    body.theme-dark .app-confirm-icon {
      background: rgba(245, 158, 11, 0.24);
      color: #fcd34d;
      border-color: rgba(245, 158, 11, 0.48);
    }
  </style>
  @endpush

  @push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const modal = document.querySelector('[data-confirm-modal]');
      const titleEl = modal?.querySelector('[data-confirm-title]');
      const messageEl = modal?.querySelector('[data-confirm-message]');
      const cancelBtn = modal?.querySelector('[data-confirm-cancel]');
      const acceptBtn = modal?.querySelector('[data-confirm-accept]');
      let activeForm = null;

      if (!modal) {
        return;
      }

      if (modal.parentElement !== document.body) {
        document.body.appendChild(modal);
      }

      const showModal = (form) => {
        if (!form) {
          return;
        }
        activeForm = form;
        const title = form.getAttribute('data-confirm-title') || modal.getAttribute('data-default-title') || 'Apakah anda yakin?';
        const message = form.getAttribute('data-confirm-message') || modal.getAttribute('data-default-message') || 'Data tidak dapat dikembalikan setelah aksi dijalankan.';

        if (titleEl) {
          titleEl.textContent = title;
        }
        if (messageEl) {
          messageEl.textContent = message;
        }

        modal.classList.add('is-visible');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('app-confirm-modal-open');
        acceptBtn?.focus();
      };

      const hideModal = () => {
        modal.classList.remove('is-visible');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('app-confirm-modal-open');
        activeForm = null;
      };

      document.querySelectorAll('form[data-confirm-form]').forEach((form) => {
        form.addEventListener('submit', (event) => {
          event.preventDefault();
          showModal(form);
        });
      });

      cancelBtn?.addEventListener('click', hideModal);
      acceptBtn?.addEventListener('click', () => {
        if (!activeForm) {
          hideModal();
          return;
        }

        const formToSubmit = activeForm;
        hideModal();
        formToSubmit.submit();
      });

      modal.addEventListener('click', (event) => {
        if (event.target === modal) {
          hideModal();
        }
      });

      document.addEventListener('keyup', (event) => {
        if (event.key === 'Escape') {
          hideModal();
        }
      });
    });
  </script>
  @endpush
@endonce

<div
  class="app-confirm-modal"
  data-confirm-modal
  data-default-title="{{ $title }}"
  data-default-message="{{ $defaultMessage }}"
  aria-hidden="true"
  role="dialog"
  aria-modal="true"
  aria-label="Konfirmasi aksi"
>
  <div class="app-confirm-panel" role="document">
    <div class="app-confirm-head">
      <span class="app-confirm-icon" aria-hidden="true">!</span>
      <div>
        <p class="app-confirm-title" data-confirm-title>{{ $title }}</p>
        <p class="app-confirm-text" data-confirm-message>{{ $defaultMessage }}</p>
      </div>
    </div>
    <div class="app-confirm-actions">
      <button type="button" class="btn btn-outline-secondary" data-confirm-cancel>{{ $cancelText }}</button>
      <button type="button" class="btn btn-danger" data-confirm-accept>{{ $confirmText }}</button>
    </div>
  </div>
</div>
