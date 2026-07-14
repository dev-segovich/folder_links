/* ============================================================
   Kernel — front-end behaviors
   Loaded through Vite (@vite in the layouts).
   ============================================================ */

/* === Mobile sidebar (layouts/app) === */
function initSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const openBtn = document.getElementById('sidebarToggle');
    const closeBtn = document.getElementById('sidebarClose');
    if (!sidebar) return;

    const open = () => {
        sidebar.classList.remove('-translate-x-full');
        overlay?.classList.remove('hidden');
    };
    const close = () => {
        sidebar.classList.add('-translate-x-full');
        overlay?.classList.add('hidden');
    };

    openBtn?.addEventListener('click', open);
    closeBtn?.addEventListener('click', close);
    overlay?.addEventListener('click', close);
}

/* === PROD / LOCAL environment toggle === */
function initEnvToggle() {
    const toggle = document.getElementById('envToggle');
    if (!toggle) return;

    const apply = (isLocal) => {
        document.querySelectorAll('.project-link').forEach((link) => {
            const url = isLocal ? link.dataset.localUrl : link.dataset.prodUrl;
            if (url) link.href = url;
        });
        document.querySelectorAll('[data-env-label]').forEach((el) => {
            const on = el.dataset.envLabel === (isLocal ? 'local' : 'prod');
            el.classList.toggle('text-brand', on);
            el.classList.toggle('text-faint', !on);
        });
    };

    const stored = localStorage.getItem('kernel_env');
    if (stored) {
        toggle.checked = stored === 'local';
    }
    apply(toggle.checked);

    toggle.addEventListener('change', function () {
        localStorage.setItem('kernel_env', this.checked ? 'local' : 'prod');
        apply(this.checked);
    });
}

/* === Project accordion (directory cards) === */
function toggleAccordion(cardId) {
    const body = document.getElementById(cardId + '_body');
    const chevron = document.getElementById(cardId + '_chevron');
    const trigger = document.getElementById(cardId + '_trigger');
    if (!body) return;

    const isHidden = body.classList.toggle('hidden');
    if (chevron) chevron.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(180deg)';
    trigger?.setAttribute('aria-expanded', String(!isHidden));
}
window.toggleAccordion = toggleAccordion;

document.addEventListener('DOMContentLoaded', function () {
    initSidebar();
    initEnvToggle();
});
