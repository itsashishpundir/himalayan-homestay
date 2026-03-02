/**
 * FuturaStays Layouts - JavaScript
 *
 * Mobile menu toggle, scroll behavior, announcement bar.
 */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {

        // ================================================
        // MOBILE MENU TOGGLE
        // ================================================
        const mobileMenu = document.getElementById('futura-mobile-menu');
        const mobileToggle = document.getElementById('futura-mobile-menu-toggle');
        const mobileClose = document.getElementById('futura-mobile-menu-close');
        const mobileOverlay = mobileMenu ? mobileMenu.querySelector('.futura-mobile-panel-overlay') : null;

        function openMobileMenu() {
            if (mobileMenu) {
                mobileMenu.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeMobileMenu() {
            if (mobileMenu) {
                mobileMenu.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }

        if (mobileToggle) mobileToggle.addEventListener('click', openMobileMenu);
        if (mobileClose) mobileClose.addEventListener('click', closeMobileMenu);
        if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobileMenu);

        // Close on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && mobileMenu && !mobileMenu.classList.contains('hidden')) {
                closeMobileMenu();
            }
        });

        // ================================================
        // SCROLL BEHAVIOR - Glass Nav Shadow
        // ================================================
        const glassNav = document.querySelector('.futura-glass-nav');
        const header = document.getElementById('futura-header');
        const spacer = document.querySelector('.futura-header-spacer');

        function handleScroll() {
            if (!glassNav) return;
            if (window.scrollY > 20) {
                glassNav.classList.add('scrolled');
            } else {
                glassNav.classList.remove('scrolled');
            }
        }

        window.addEventListener('scroll', handleScroll, { passive: true });
        handleScroll(); // run on load

        // Update spacer height based on actual header height
        function updateSpacer() {
            if (header && spacer) {
                spacer.style.height = header.offsetHeight + 'px';
            }
        }
        updateSpacer();
        window.addEventListener('resize', updateSpacer);

        // ================================================
        // MOBILE SEARCH TOGGLE
        // ================================================
        const searchToggle = document.getElementById('futura-mobile-search-toggle');
        if (searchToggle) {
            searchToggle.addEventListener('click', function () {
                // Open mobile menu which contains search
                openMobileMenu();
                // Focus on the search input
                setTimeout(function () {
                    const searchInput = mobileMenu ? mobileMenu.querySelector('input[type="search"]') : null;
                    if (searchInput) searchInput.focus();
                }, 350);
            });
        }

    });
})();
