<?php
/**
 * Header Layout: 3-Tier Header
 *
 * A three-row header layout consisting of:
 * - Row 1: Top Bar (Promo text)
 * - Row 2: Main Header (Logo centered, icons on right)
 * - Row 3: Navigation (Desktop only)
 *
 * Layout ID: 3-tier
 *
 * @package HimalayanMart
 */

if (!defined('ABSPATH')) exit;

$promo_text = get_theme_mod('himalayanmart_topbar_text', 'Big Sale! Get 50% off on all items this week! Shop Now!');
?>

<header class="hm-store-header">
    
    <!-- Row 1: Top Bar -->
    <div class="hm-store-topbar">
        <div class="hm-container">
            <div class="hm-topbar-content">
                <?php if ($promo_text) : ?>
                    <span class="hm-promo-text"><?php echo wp_kses_post($promo_text); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Row 2: Main Header (Logo & Icons) -->
    <div class="hm-store-main">
        <div class="hm-container">
            <div class="hm-main-inner">
                
                <!-- Mobile Hamburger (Left) -->
                <button class="hm-mobile-toggle" aria-label="Toggle Menu">
                    <span class="dashicons dashicons-menu"></span>
                </button>

                <!-- Logo (Desktop: Center / Mobile: Center) -->
                <div class="hm-logo-center">
                    <?php 
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        echo '<h1 class="site-title"><a href="' . esc_url(home_url('/')) . '" rel="home">' . get_bloginfo('name') . '</a></h1>';
                    }
                    ?>
                </div>

                <!-- Right Icons -->
                <div class="hm-header-icons">
                    <!-- Cart -->
                    <a href="<?php echo class_exists('WooCommerce') ? esc_url(wc_get_cart_url()) : '#'; ?>" class="hm-icon-link" title="<?php esc_attr_e('View Cart', 'himalayanmart'); ?>">
                        <span class="dashicons dashicons-cart"></span>
                        <?php 
                        if (class_exists('WooCommerce')) {
                            $count = WC()->cart->get_cart_contents_count();
                            if ($count > 0) {
                                echo '<span class="hm-cart-count">' . esc_html($count) . '</span>';
                            }
                        }
                        ?>
                    </a>
                    
                    <!-- Account -->
                    <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="hm-icon-link" title="<?php esc_attr_e('My Account', 'himalayanmart'); ?>">
                        <span class="dashicons dashicons-admin-users"></span>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Row 3: Navigation (Desktop Only) -->
    <div class="hm-store-nav-wrap desktop-only">
        <div class="hm-container">
            <nav id="site-navigation" class="hm-main-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                    'menu_class'     => 'hm-nav-menu',
                    'fallback_cb'    => false,
                ));
                ?>
            </nav>
        </div>
    </div>

    <!-- Off-Canvas Drawer -->
    <div class="hm-offcanvas-overlay"></div>
    <div class="hm-offcanvas">
        <div class="hm-offcanvas-header">
            <div class="hm-offcanvas-logo">
                 <?php 
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        echo '<span class="site-title">' . get_bloginfo('name') . '</span>';
                    }
                ?>
            </div>
            <button class="hm-offcanvas-close" aria-label="Close Menu">&times;</button>
        </div>
        
        <div class="hm-offcanvas-body">
            <nav class="hm-mobile-nav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'hm-offcanvas-menu',
                    'fallback_cb'    => false,
                ));
                ?>
            </nav>
        </div>

        <div class="hm-offcanvas-footer">
            <!-- Mobile Cart & Account -->
             <div class="hm-mobile-actions">
                <!-- Cart -->
                <a href="<?php echo class_exists('WooCommerce') ? esc_url(wc_get_cart_url()) : '#'; ?>" class="hm-mobile-action-link">
                    <span class="dashicons dashicons-cart"></span>
                    <span class="hm-text"><?php esc_html_e('Cart', 'himalayanmart'); ?></span>
                    <?php 
                    if (class_exists('WooCommerce')) {
                        $count = WC()->cart->get_cart_contents_count();
                        if ($count > 0) {
                            echo '<span class="hm-count">(' . esc_html($count) . ')</span>';
                        }
                    }
                    ?>
                </a>
                
                <!-- Account -->
                <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="hm-mobile-action-link">
                    <span class="dashicons dashicons-admin-users"></span>
                     <span class="hm-text"><?php esc_html_e('Login', 'himalayanmart'); ?></span>
                </a>
            </div>

            <!-- Socials -->
            <div class="hm-offcanvas-socials">
                <?php
                $socials = array('facebook', 'twitter', 'youtube', 'instagram');
                foreach ($socials as $social) {
                    $url = get_theme_mod('himalayanmart_social_' . $social);
                    if ($url) {
                        echo '<a href="' . esc_url($url) . '" target="_blank" class="hm-social-icon ' . esc_attr($social) . '">';
                        echo '<span class="dashicons dashicons-' . esc_attr($social) . '"></span>';
                        echo '</a>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

</header>
