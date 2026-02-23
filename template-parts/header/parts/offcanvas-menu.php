<?php if (!defined('ABSPATH')) exit; ?>

<div class="hm-offcanvas" id="hmOffcanvas" aria-hidden="true">
    <div class="hm-offcanvas__backdrop" data-hm-close></div>

    <div class="hm-offcanvas__panel" role="dialog" aria-modal="true">
        <div class="hm-offcanvas__header">
            <strong><?php esc_html_e('Menu', 'himalayanmart'); ?></strong>
            <button type="button" class="hm-offcanvas__close" data-hm-close aria-label="<?php esc_attr_e('Close', 'himalayanmart'); ?>">✕</button>
        </div>

        <div class="hm-offcanvas__body">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'hm-mobile-menu',
                'fallback_cb'    => false,
            ));
            ?>
        </div>
    </div>
</div>
