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

/* === Dashboard heatmap: switch between metrics (completados / asignados) === */
function initHeatmap() {
    const root = document.getElementById('heatmap');
    if (!root) return;

    const metrics = JSON.parse(root.dataset.metrics || '{}');
    const cells = root.querySelectorAll('.heatmap-cell[data-date]');
    const tabs = root.querySelectorAll('.heatmap-tab');
    const total = root.querySelector('[data-heatmap-total]');

    // Same 0-4 scale as the server-rendered default, relative to the metric's busiest day.
    const levelOf = (count, max) => (count < 1 ? 0 : Math.min(4, Math.max(1, Math.ceil((count / Math.max(max, 1)) * 4))));
    const noun = (count, meta) => (count === 1 ? meta.singular : meta.plural);

    const apply = (metric) => {
        const meta = metrics[metric];
        if (!meta) return;

        root.dataset.metric = metric;

        cells.forEach((cell) => {
            const count = Number(cell.dataset[metric]) || 0;
            cell.dataset.level = levelOf(count, meta.max);
            cell.title = `${count} ${noun(count, meta)} · ${cell.dataset.label}`;
        });

        tabs.forEach((tab) => tab.setAttribute('aria-pressed', String(tab.dataset.metric === metric)));

        if (total) total.textContent = `${meta.total} ${noun(meta.total, meta)}`;

        localStorage.setItem('kernel_heatmap_metric', metric);
    };

    tabs.forEach((tab) => tab.addEventListener('click', () => apply(tab.dataset.metric)));

    const stored = localStorage.getItem('kernel_heatmap_metric');
    apply(stored && metrics[stored] ? stored : root.dataset.metric);
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
    initHeatmap();
});
