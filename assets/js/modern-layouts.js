/**
 * Modern Header & Footer Layouts JavaScript
 *
 * Handles:
 * - Sticky header behavior
 * - Mobile canvas menu (hamburger)
 * - Search overlay
 * - Announcement bar dismiss
 * - Smooth animations
 *
 * @package HimalayanMart
 */

(function() {
    'use strict';

    // DOM Ready
    document.addEventListener('DOMContentLoaded', function() {
        initModernHeader();
        initCanvasMenu();
        initSearchOverlay();
        initAnnouncementBar();
    });

    /**
     * Initialize Modern Header
     */
    function initModernHeader() {
        const header = document.querySelector('.hm-modern-header');
        if (!header) return;

        const stickyHeader = header.classList.contains('hm-sticky-header');
        if (!stickyHeader) return;

        const headerMain = header.querySelector('.hm-header-main');
        const announcementBar = header.querySelector('.hm-announcement-bar');
        const announcementOnScroll = header.dataset.announcementOnScroll === 'true';

        let headerOffset = announcementBar ? announcementBar.offsetHeight : 0;
        let announcementHeight = announcementBar ? announcementBar.offsetHeight : 0;
        let lastScroll = 0;
        let announcementDismissed = sessionStorage.getItem('hm-announcement-dismissed') === 'true';

        // Update offset on resize
        window.addEventListener('resize', debounce(function() {
            if (announcementBar && !announcementDismissed && announcementBar.style.display !== 'none') {
                headerOffset = announcementBar.offsetHeight;
                announcementHeight = announcementBar.offsetHeight;
            } else {
                headerOffset = 0;
                announcementHeight = 0;
            }
            updateBodyPadding();
        }, 100));

        // Calculate body padding based on sticky state
        function updateBodyPadding() {
            if (header.classList.contains('is-sticky')) {
                let totalHeight = headerMain.offsetHeight;
                if (announcementOnScroll && announcementBar && !announcementDismissed) {
                    totalHeight += announcementHeight;
                }
                document.body.style.paddingTop = totalHeight + 'px';
            } else {
                document.body.style.paddingTop = '0';
            }
        }

        // Update announcement bar position dynamically for scroll state
        function updateAnnouncementPosition() {
            if (!announcementBar || announcementDismissed) return;

            if (header.classList.contains('is-sticky') && announcementOnScroll) {
                // Update CSS variable for header position
                headerMain.style.top = announcementHeight + 'px';
            } else if (header.classList.contains('is-sticky')) {
                headerMain.style.top = '0';
            } else {
                headerMain.style.top = '';
            }
        }

        // Sticky on scroll
        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;

            if (currentScroll > headerOffset) {
                if (!header.classList.contains('is-sticky')) {
                    header.classList.add('is-sticky');
                    updateAnnouncementPosition();
                    updateBodyPadding();
                }
            } else {
                if (header.classList.contains('is-sticky')) {
                    header.classList.remove('is-sticky');
                    headerMain.style.top = '';
                    document.body.style.paddingTop = '0';
                }
            }

            lastScroll = currentScroll;
        }, { passive: true });

        // Listen for announcement dismiss
        if (announcementBar) {
            const closeBtn = announcementBar.querySelector('.hm-announcement-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    announcementDismissed = true;
                    headerOffset = 0;
                    announcementHeight = 0;
                    updateAnnouncementPosition();
                    updateBodyPadding();
                });
            }
        }
    }

    /**
     * Initialize Canvas Menu (Mobile)
     */
    function initCanvasMenu() {
        const hamburgerBtn = document.querySelector('.hm-hamburger-btn');
        const canvasOverlay = document.querySelector('.hm-canvas-overlay');
        const canvasPanel = document.querySelector('.hm-canvas-panel');
        const canvasClose = document.querySelector('.hm-canvas-close');

        if (!hamburgerBtn || !canvasPanel) return;

        // Open canvas
        hamburgerBtn.addEventListener('click', function() {
            openCanvas();
        });

        // Close canvas on overlay click
        if (canvasOverlay) {
            canvasOverlay.addEventListener('click', function() {
                closeCanvas();
            });
        }

        // Close canvas on close button click
        if (canvasClose) {
            canvasClose.addEventListener('click', function() {
                closeCanvas();
            });
        }

        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && canvasPanel.classList.contains('is-active')) {
                closeCanvas();
            }
        });

        // Handle submenu toggles in canvas
        const menuItemsWithChildren = canvasPanel.querySelectorAll('.menu-item-has-children');
        menuItemsWithChildren.forEach(function(item) {
            const link = item.querySelector('a');
            const submenu = item.querySelector('.sub-menu');

            if (link && submenu) {
                // Create toggle button
                const toggle = document.createElement('button');
                toggle.className = 'hm-submenu-toggle';
                toggle.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>';
                toggle.setAttribute('aria-expanded', 'false');
                link.parentNode.insertBefore(toggle, submenu);

                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
                    toggle.setAttribute('aria-expanded', !isExpanded);
                    submenu.style.display = isExpanded ? 'none' : 'block';
                    toggle.classList.toggle('is-open');
                });

                // Initially hide submenu
                submenu.style.display = 'none';
            }
        });

        function openCanvas() {
            canvasPanel.classList.add('is-active');
            canvasPanel.setAttribute('aria-hidden', 'false');
            if (canvasOverlay) {
                canvasOverlay.classList.add('is-active');
            }
            hamburgerBtn.setAttribute('aria-expanded', 'true');
            document.body.classList.add('hm-canvas-open');

            // Animate hamburger to X
            hamburgerBtn.classList.add('is-active');

            // Focus trap
            const focusableElements = canvasPanel.querySelectorAll('a, button, input, [tabindex]:not([tabindex="-1"])');
            if (focusableElements.length) {
                focusableElements[0].focus();
            }
        }

        function closeCanvas() {
            canvasPanel.classList.remove('is-active');
            canvasPanel.setAttribute('aria-hidden', 'true');
            if (canvasOverlay) {
                canvasOverlay.classList.remove('is-active');
            }
            hamburgerBtn.setAttribute('aria-expanded', 'false');
            document.body.classList.remove('hm-canvas-open');

            // Animate X back to hamburger
            hamburgerBtn.classList.remove('is-active');
        }
    }

    /**
     * Initialize Search Overlay
     */
    function initSearchOverlay() {
        const searchToggle = document.querySelector('.hm-search-toggle');
        const searchOverlay = document.querySelector('.hm-search-overlay');
        const searchClose = document.querySelector('.hm-search-close');
        const searchInput = document.querySelector('.hm-search-input');

        if (!searchToggle || !searchOverlay) return;

        // Open search
        searchToggle.addEventListener('click', function() {
            openSearch();
        });

        // Close search on close button
        if (searchClose) {
            searchClose.addEventListener('click', function() {
                closeSearch();
            });
        }

        // Close on overlay click (outside form)
        searchOverlay.addEventListener('click', function(e) {
            if (e.target === searchOverlay) {
                closeSearch();
            }
        });

        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && searchOverlay.classList.contains('is-active')) {
                closeSearch();
            }
        });

        function openSearch() {
            searchOverlay.classList.add('is-active');
            searchOverlay.setAttribute('aria-hidden', 'false');
            document.body.classList.add('hm-search-open');

            // Focus input
            if (searchInput) {
                setTimeout(function() {
                    searchInput.focus();
                }, 100);
            }
        }

        function closeSearch() {
            searchOverlay.classList.remove('is-active');
            searchOverlay.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('hm-search-open');
        }
    }

    /**
     * Initialize Announcement Bar
     */
    function initAnnouncementBar() {
        const announcementBar = document.querySelector('.hm-announcement-bar');
        const closeBtn = document.querySelector('.hm-announcement-close');

        if (!announcementBar || !closeBtn) return;

        // Check if already dismissed
        const isDismissed = sessionStorage.getItem('hm-announcement-dismissed');
        if (isDismissed === 'true') {
            announcementBar.style.display = 'none';
            return;
        }

        closeBtn.addEventListener('click', function() {
            announcementBar.style.display = 'none';
            sessionStorage.setItem('hm-announcement-dismissed', 'true');

            // Update sticky header offset
            const header = document.querySelector('.hm-modern-header');
            if (header && header.classList.contains('is-sticky')) {
                document.body.style.paddingTop = '0';
            }
        });
    }

    /**
     * Debounce helper function
     */
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    /**
     * Hamburger Animation Styles (injected dynamically)
     */
    const hamburgerStyles = `
        .hm-hamburger-btn.is-active .hm-hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }
        .hm-hamburger-btn.is-active .hm-hamburger-line:nth-child(2) {
            opacity: 0;
        }
        .hm-hamburger-btn.is-active .hm-hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -5px);
        }
        .hm-submenu-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: rgba(0,0,0,0.05);
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-left: auto;
            transition: all 0.2s;
        }
        .hm-submenu-toggle:hover {
            background: rgba(0,0,0,0.1);
        }
        .hm-submenu-toggle.is-open svg {
            transform: rotate(180deg);
        }
        .hm-canvas-menu > li {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }
        .hm-canvas-menu > li > a {
            flex: 1;
        }
        .hm-canvas-menu .sub-menu {
            width: 100%;
            padding-left: 16px;
            margin-top: 8px;
        }
    `;

    // Inject hamburger styles
    const styleSheet = document.createElement('style');
    styleSheet.textContent = hamburgerStyles;
    document.head.appendChild(styleSheet);

})();
