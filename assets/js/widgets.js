/**
 * HimalayanMart Widget JavaScript
 *
 * Handles interactive widget functionality like FAQ accordion.
 *
 * @package HimalayanMart
 */

(function () {
    'use strict';

    /**
     * FAQ Accordion Widget
     */
    function initFaqAccordion() {
        const faqWidgets = document.querySelectorAll('.hm-widget-faq');

        faqWidgets.forEach(function (widget) {
            const allowMultiple = widget.dataset.allowMultiple === 'true';
            const questions = widget.querySelectorAll('.hm-faq-question');

            questions.forEach(function (question) {
                question.addEventListener('click', function () {
                    const item = this.closest('.hm-faq-item');
                    const isOpen = item.classList.contains('is-open');

                    // If not allowing multiple, close others first
                    if (!allowMultiple) {
                        const openItems = widget.querySelectorAll('.hm-faq-item.is-open');
                        openItems.forEach(function (openItem) {
                            if (openItem !== item) {
                                openItem.classList.remove('is-open');
                                openItem.querySelector('.hm-faq-question').setAttribute('aria-expanded', 'false');
                            }
                        });
                    }

                    // Toggle current item
                    item.classList.toggle('is-open');
                    this.setAttribute('aria-expanded', !isOpen);
                });
            });
        });
    }

    /**
     * Initialize on DOM ready
     */
    function init() {
        initFaqAccordion();
    }

    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
