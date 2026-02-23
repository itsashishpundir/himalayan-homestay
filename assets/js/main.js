(function ($) {
    'use strict';

    const HimalayanMart = {
        init: function () {
            this.bindEvents();
        },

        bindEvents: function () {
            // Mobile Menu Toggle - using correct class
            const $toggle = $('.hm-mobile-toggle');
            const $offcanvas = $('.hm-offcanvas');
            const $overlay = $('.hm-offcanvas-overlay');
            const $close = $('.hm-offcanvas-close');

            function openMenu(e) {
                if (e) e.preventDefault();
                $offcanvas.addClass('active');
                $overlay.addClass('active');
                $('body').addClass('hm-lock');
            }

            function closeMenu(e) {
                if (e) e.preventDefault();
                $offcanvas.removeClass('active');
                $overlay.removeClass('active');
                $('body').removeClass('hm-lock');
            }

            $toggle.on('click', openMenu);
            $close.on('click', closeMenu);
            $overlay.on('click', closeMenu);

            // Homestay Mobile Filter Logic
            const $filterToggle = $('#hmFilterToggle');
            const $filterPanel = $('#hmFilterPanel');
            const $filterOverlay = $('#hmFilterOverlay');
            const $filterClose = $('#hmCloseFilters');

            function openFilters(e) {
                if (e) e.preventDefault();
                $filterPanel.addClass('active');
                $filterOverlay.addClass('active');
                $('body').css('overflow', 'hidden'); // Prevent background scroll
            }

            function closeFilters(e) {
                if (e) e.preventDefault();
                $filterPanel.removeClass('active');
                $filterOverlay.removeClass('active');
                $('body').css('overflow', '');
            }

            if ($filterToggle.length) {
                $filterToggle.on('click', openFilters);
                $filterClose.on('click', closeFilters);
                $filterOverlay.on('click', closeFilters);
            }
        }
    };

    $(document).ready(function () {
        HimalayanMart.init();
    });

})(jQuery);
