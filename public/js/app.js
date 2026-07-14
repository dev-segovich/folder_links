/* ============================================
   KERNEL DESIGN SYSTEM
   Consolidated JS — all inline scripts merged
   ============================================ */

(function() {
    'use strict';

    /* === ENV TOGGLE === */
    function initEnvToggle() {
        var toggle = document.getElementById('envToggle');
        if (!toggle) return;

        var storedEnv = localStorage.getItem('kernel_env');
        if (storedEnv) {
            toggle.checked = storedEnv === 'local';
            updateLinks(storedEnv === 'local');
        }

        toggle.addEventListener('change', function() {
            var isLocal = this.checked;
            localStorage.setItem('kernel_env', isLocal ? 'local' : 'prod');
            updateLinks(isLocal);
        });
    }

    /* === PROJECT LINKS === */
    function updateLinks(isLocal) {
        document.querySelectorAll('.project-link').forEach(function(link) {
            var url = isLocal ? link.dataset.localUrl : link.dataset.prodUrl;
            if (url) link.href = url;
        });

        document.querySelectorAll('.project-card').forEach(function(card) {
            var visitBtn = card.querySelector('.visit-site');
            if (visitBtn) {
                visitBtn.href = isLocal ? card.dataset.localUrl : card.dataset.prodUrl;
            }
        });
    }

    /* === PROJECT ACCORDION === */
    function toggleAccordion(cardId) {
        var body = document.getElementById(cardId + '_body');
        var chevron = document.getElementById(cardId + '_chevron');
        if (!body || !chevron) return;

        var isHidden = body.classList.contains('hidden');
        if (isHidden) {
            body.classList.remove('hidden');
            chevron.style.transform = 'rotate(180deg)';
        } else {
            body.classList.add('hidden');
            chevron.style.transform = 'rotate(0deg)';
        }
    }

    /* === INIT === */
    document.addEventListener('DOMContentLoaded', function() {
        initEnvToggle();
    });

    /* Make toggleAccordion available globally */
    window.toggleAccordion = toggleAccordion;
})();
