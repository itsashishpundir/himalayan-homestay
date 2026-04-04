/**
 * Himalayan Homestay — Motion System
 *
 * Features:
 * - Intersection Observer scroll-reveal
 * - Hero parallax (passive scroll, RAF-throttled)
 * - Auto-stagger via [data-stagger] containers
 * - Scroll progress indicator
 * - Counter animation via [data-count]
 *
 * No external libraries. Respects prefers-reduced-motion.
 */

(function () {
    'use strict';

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ──────────────────────────────────────────────────────────
       1. SCROLL REVEAL — Intersection Observer
    ────────────────────────────────────────────────────────── */
    function initScrollReveals() {
        const selector = '.reveal, .reveal-left, .reveal-right, .reveal-scale, .reveal-fade, .hhb-section-heading';
        const els = document.querySelectorAll(selector);
        if (!els.length) return;

        const observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target); // trigger once only
                    }
                });
            },
            {
                threshold: 0.12,
                rootMargin: '0px 0px -50px 0px'
            }
        );

        els.forEach(function (el) {
            observer.observe(el);
        });
    }


    /* ──────────────────────────────────────────────────────────
       2. HERO PARALLAX — RAF-throttled, passive scroll
    ────────────────────────────────────────────────────────── */
    function initHeroParallax() {
        if (prefersReducedMotion) return;

        var heroBg = document.querySelector('.hhb-fp-hero-bg');
        if (!heroBg) return;

        var heroEl  = document.querySelector('.hhb-fp-hero');
        var ticking = false;

        window.addEventListener('scroll', function () {
            if (!ticking) {
                window.requestAnimationFrame(function () {
                    var scrolled = window.scrollY;
                    var heroH    = heroEl ? heroEl.offsetHeight : window.innerHeight;

                    // Only apply while hero is in view
                    if (scrolled < heroH) {
                        heroBg.style.transform = 'translateY(' + (scrolled * 0.28) + 'px)';
                    }
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });
    }


    /* ──────────────────────────────────────────────────────────
       3. AUTO-STAGGER — [data-stagger] containers
       Assigns .reveal + transition-delay to each direct child
    ────────────────────────────────────────────────────────── */
    function initAutoStagger() {
        document.querySelectorAll('[data-stagger]').forEach(function (container) {
            var step = parseInt(container.dataset.stagger, 10) || 80;
            Array.from(container.children).forEach(function (child, i) {
                // Only add if not already a reveal variant
                if (!child.classList.contains('reveal') &&
                    !child.classList.contains('reveal-scale') &&
                    !child.classList.contains('reveal-left')) {
                    child.classList.add('reveal');
                }
                child.style.transitionDelay = (i * step) + 'ms';
            });
        });
    }


    /* ──────────────────────────────────────────────────────────
       4. SCROLL PROGRESS BAR
    ────────────────────────────────────────────────────────── */
    function initScrollProgress() {
        if (prefersReducedMotion) return;

        // Inject bar element
        var bar = document.createElement('div');
        bar.className = 'hhb-scroll-progress';
        document.body.appendChild(bar);

        var ticking = false;
        window.addEventListener('scroll', function () {
            if (!ticking) {
                window.requestAnimationFrame(function () {
                    var scrollTop  = window.scrollY || document.documentElement.scrollTop;
                    var docH       = document.documentElement.scrollHeight - window.innerHeight;
                    var progress   = docH > 0 ? (scrollTop / docH) * 100 : 0;
                    bar.style.width = progress + '%';
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });
    }


    /* ──────────────────────────────────────────────────────────
       5. COUNTER ANIMATION — [data-count="N"]
       Counts up from 0 to N when element enters viewport
    ────────────────────────────────────────────────────────── */
    function initCounters() {
        if (prefersReducedMotion) return;

        var counters = document.querySelectorAll('[data-count]');
        if (!counters.length) return;

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                var el     = entry.target;
                var target = parseInt(el.dataset.count, 10);
                var dur    = 1400;
                var start  = performance.now();

                function update(now) {
                    var progress = Math.min((now - start) / dur, 1);
                    // ease-out-cubic
                    var eased = 1 - Math.pow(1 - progress, 3);
                    el.textContent = Math.round(eased * target).toLocaleString();
                    if (progress < 1) requestAnimationFrame(update);
                }
                requestAnimationFrame(update);
                observer.unobserve(el);
            });
        }, { threshold: 0.5 });

        counters.forEach(function (el) {
            observer.observe(el);
        });
    }


    /* ──────────────────────────────────────────────────────────
       6. SECTION HEADER SPLIT — Wraps section headings
       in reveal-left / reveal-right pairs if present
    ────────────────────────────────────────────────────────── */
    function initSectionSplits() {
        // Already handled via PHP classes — no extra DOM manipulation needed
    }


    /* ──────────────────────────────────────────────────────────
       INIT
    ────────────────────────────────────────────────────────── */
    document.addEventListener('DOMContentLoaded', function () {
        initAutoStagger();   // Must run before initScrollReveals
        initScrollReveals();
        initScrollProgress();
        initCounters();

        if (!prefersReducedMotion) {
            initHeroParallax();
        }
    });

})();
