<?php
/**
 * Header Layout: Modern Glass Header
 *
 * A modern glassmorphism header with:
 * - Optional announcement bar
 * - Sticky header with blur effect
 * - Centered/left logo options
 * - Right-aligned icons
 * - Mobile hamburger with slide-in canvas
 *
 * Layout ID: modern-glass
 *
 * @package HimalayanMart
 */

if (!defined('ABSPATH')) exit;

// Get customizer settings
$show_announcement       = get_theme_mod('hm_modern_header_show_announcement', true);
$announcement_text       = get_theme_mod('hm_modern_header_announcement_text', 'Free shipping on orders over $50! Shop Now');
$announcement_style      = get_theme_mod('hm_modern_header_announcement_style', 'solid');
$sticky_header           = get_theme_mod('hm_modern_header_sticky', true);
$header_style            = get_theme_mod('hm_modern_header_style', 'glass');
$canvas_position         = get_theme_mod('hm_modern_header_canvas_position', 'left');
$canvas_width            = get_theme_mod('hm_modern_header_canvas_width', '70');
$show_search                  = get_theme_mod('hm_modern_header_show_search', true);
$show_cart                    = get_theme_mod('hm_modern_header_show_cart', true);
$show_account                 = get_theme_mod('hm_modern_header_show_account', true);
$announcement_on_scroll       = get_theme_mod('hm_modern_header_announcement_on_scroll', false);
$mobile_sticky_announcement   = get_theme_mod('hm_modern_header_mobile_sticky_announcement', false);

// Build header classes
$header_classes = array('hm-modern-header');
if ($sticky_header) {
    $header_classes[] = 'hm-sticky-header';
}
$header_classes[] = 'hm-header-style-' . esc_attr($header_style);
if ($announcement_on_scroll) {
    $header_classes[] = 'hm-announcement-on-scroll';
}
if ($mobile_sticky_announcement) {
    $header_classes[] = 'hm-mobile-sticky-announcement';
}

// Data attributes for JavaScript
$header_data = array(
    'announcement-on-scroll' => $announcement_on_scroll ? 'true' : 'false',
    'sticky'                 => $sticky_header ? 'true' : 'false',
);
$data_attrs = '';
foreach ($header_data as $key => $value) {
    $data_attrs .= ' data-' . esc_attr($key) . '="' . esc_attr($value) . '"';
}
?>

<header class="<?php echo esc_attr(implode(' ', $header_classes)); ?>"<?php echo $data_attrs; ?>>

    <?php if ($show_announcement && $announcement_text) : ?>
    <!-- Announcement Bar -->
    <div class="hm-announcement-bar hm-announcement-<?php echo esc_attr($announcement_style); ?>">
        <div class="hm-container">
            <div class="hm-announcement-content">
                <span class="hm-announcement-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </span>
                <span class="hm-announcement-text"><?php echo wp_kses_post($announcement_text); ?></span>
                <button type="button" class="hm-announcement-close" aria-label="<?php esc_attr_e('Close announcement', 'himalayanmart'); ?>">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Main Header -->
    <div class="hm-header-main">
        <div class="hm-container">
            <div class="hm-header-inner">

                <!-- Mobile Hamburger (Left) -->
                <button type="button" class="hm-hamburger-btn" aria-label="<?php esc_attr_e('Open menu', 'himalayanmart'); ?>" aria-expanded="false">
                    <span class="hm-hamburger-line"></span>
                    <span class="hm-hamburger-line"></span>
                    <span class="hm-hamburger-line"></span>
                </button>

                <!-- Logo -->
                <div class="hm-header-logo">
                    <?php
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        echo '<a href="' . esc_url(home_url('/')) . '" class="hm-site-title" rel="home">' . get_bloginfo('name') . '</a>';
                    }
                    ?>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hm-header-nav" role="navigation" aria-label="<?php esc_attr_e('Primary Navigation', 'himalayanmart'); ?>">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'modern-primary-menu',
                        'container'      => false,
                        'menu_class'     => 'hm-modern-nav-menu',
                        'fallback_cb'    => false,
                    ));
                    ?>
                </nav>

                <!-- Header Icons -->
                <div class="hm-header-icons">
                    <?php if ($show_search) : ?>
                    <!-- Search Toggle -->
                    <button type="button" class="hm-header-icon hm-search-toggle" aria-label="<?php esc_attr_e('Search', 'himalayanmart'); ?>">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                    <?php endif; ?>

                    <?php if ($show_account) : ?>
                    <!-- Account -->
                    <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="hm-header-icon hm-account-icon" title="<?php esc_attr_e('My Account', 'himalayanmart'); ?>">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </a>
                    <?php endif; ?>

                    <?php if ($show_cart && class_exists('WooCommerce')) : ?>
                    <!-- Cart -->
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="hm-header-icon hm-cart-icon" title="<?php esc_attr_e('View Cart', 'himalayanmart'); ?>">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <?php
                        $cart_count = WC()->cart->get_cart_contents_count();
                        if ($cart_count > 0) : ?>
                        <span class="hm-cart-badge"><?php echo esc_html($cart_count); ?></span>
                        <?php endif; ?>
                    </a>
                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>

    <!-- Search Overlay -->
    <?php if ($show_search) : ?>
    <div class="hm-search-overlay" aria-hidden="true">
        <div class="hm-search-overlay-inner">
            <form role="search" method="get" class="hm-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="search" class="hm-search-input" placeholder="<?php esc_attr_e('Search products, homestays...', 'himalayanmart'); ?>" name="s" autocomplete="off">
                <button type="submit" class="hm-search-submit">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
                <button type="button" class="hm-search-close">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </form>
        </div>
    </div>
    <?php endif; ?>

</header>

<!-- Mobile Canvas Overlay -->
<div class="hm-canvas-overlay" aria-hidden="true"></div>
<div class="hm-canvas-panel hm-canvas-<?php echo esc_attr($canvas_position); ?>" style="--canvas-width: <?php echo esc_attr($canvas_width); ?>%;" aria-hidden="true">

    <!-- Canvas Header -->
    <div class="hm-canvas-header">
        <div class="hm-canvas-logo">
            <?php
            if (has_custom_logo()) {
                the_custom_logo();
            } else {
                echo '<span class="hm-site-title">' . get_bloginfo('name') . '</span>';
            }
            ?>
        </div>
        <button type="button" class="hm-canvas-close" aria-label="<?php esc_attr_e('Close menu', 'himalayanmart'); ?>">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <!-- Canvas Body -->
    <div class="hm-canvas-body">
        <!-- Quick Access Buttons -->
        <div class="hm-canvas-quick-links">
            <?php
            // Get global icon settings
            $icon_size  = get_theme_mod('hm_modern_header_btn_icon_size', 18);
            $icon_color = get_theme_mod('hm_modern_header_btn_icon_color', '#374151');
            
            // Button Configuration
            $buttons = array('btn1', 'btn2', 'btn3');
            
            foreach ($buttons as $btn) {
                $text       = get_theme_mod('hm_modern_header_' . $btn . '_text');
                $url        = get_theme_mod('hm_modern_header_' . $btn . '_url');
                $icon_type  = get_theme_mod('hm_modern_header_' . $btn . '_icon_type', 'preset');
                $icon       = get_theme_mod('hm_modern_header_' . $btn . '_icon');
                $custom_icon_id = get_theme_mod('hm_modern_header_' . $btn . '_custom_icon');

                // Default values if not set
                if (empty($text) && $btn === 'btn1') $text = 'Shop';
                if (empty($url) && $btn === 'btn1') $url = (function_exists('wc_get_page_id') && wc_get_page_id('shop')) ? get_permalink(wc_get_page_id('shop')) : '/shop/';
                if (empty($icon) && $btn === 'btn1') $icon = 'shop';

                if (empty($text) && $btn === 'btn2') $text = 'Homestays';
                if (empty($url) && $btn === 'btn2') $url = get_post_type_archive_link('homestay');
                if (empty($icon) && $btn === 'btn2') $icon = 'homestay';

                if (empty($text) && $btn === 'btn3') $text = 'Offers';
                if (empty($url) && $btn === 'btn3') $url = home_url('/offers');
                if (empty($icon) && $btn === 'btn3') $icon = 'offers';

                if ($text && $url) :
            ?>
            <a href="<?php echo esc_url($url); ?>" class="hm-quick-link">
                <?php 
                // Render Icon based on type
                if ($icon_type === 'custom' && !empty($custom_icon_id)) {
                    // Custom SVG upload
                    $custom_icon_url = wp_get_attachment_url($custom_icon_id);
                    if ($custom_icon_url) {
                        echo '<img src="' . esc_url($custom_icon_url) . '" alt="" class="hm-quick-link-custom-icon" style="width: ' . esc_attr($icon_size) . 'px; height: ' . esc_attr($icon_size) . 'px;">';
                    }
                } else {
                    // Preset SVG icons
                    $svg_style = 'width="' . esc_attr($icon_size) . '" height="' . esc_attr($icon_size) . '" style="stroke: ' . esc_attr($icon_color) . ';"';
                    
                    switch ($icon) {
                        case 'shop':
                            echo '<svg ' . $svg_style . ' viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>';
                            break;
                        case 'homestay':
                        case 'home':
                            echo '<svg ' . $svg_style . ' viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>';
                            break;
                        case 'offers':
                            echo '<svg ' . $svg_style . ' viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>';
                            break;
                        case 'user':
                            echo '<svg ' . $svg_style . ' viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>';
                            break;
                        case 'heart':
                            echo '<svg ' . $svg_style . ' viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>';
                            break;
                        case 'search':
                            echo '<svg ' . $svg_style . ' viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>';
                            break;
                        case 'phone':
                            echo '<svg ' . $svg_style . ' viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>';
                            break;
                        case 'cart':
                            echo '<svg ' . $svg_style . ' viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>';
                            break;
                        case 'star':
                            echo '<svg ' . $svg_style . ' viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>';
                            break;
                        case 'map':
                            echo '<svg ' . $svg_style . ' viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>';
                            break;
                        case 'mail':
                            echo '<svg ' . $svg_style . ' viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>';
                            break;
                        default:
                            // Default circle if unknown icon
                            echo '<svg ' . $svg_style . ' viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle></svg>';
                    }
                }
                ?>
                <span><?php echo esc_html($text); ?></span>
            </a>
            <?php 
                endif; 
            } 
            ?>
        </div>

        <!-- Mobile Navigation -->
        <nav class="hm-canvas-nav">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'hm-canvas-menu',
                'fallback_cb'    => false,
            ));
            ?>
        </nav>
    </div>

    <!-- Canvas Footer -->
    <div class="hm-canvas-footer">
        <!-- Account & Cart Links -->
        <div class="hm-canvas-actions">
            <?php if (class_exists('WooCommerce')) : ?>
            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="hm-canvas-action">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <span><?php esc_html_e('Cart', 'himalayanmart'); ?></span>
                <?php
                $cart_count = WC()->cart->get_cart_contents_count();
                if ($cart_count > 0) : ?>
                <span class="hm-action-badge"><?php echo esc_html($cart_count); ?></span>
                <?php endif; ?>
            </a>
            <?php endif; ?>

            <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="hm-canvas-action">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span><?php esc_html_e('Account', 'himalayanmart'); ?></span>
            </a>
        </div>

        <!-- Social Links -->
        <div class="hm-canvas-socials">
            <?php
            $socials = array(
                'facebook'  => 'M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z',
                'twitter'   => 'M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z',
                'instagram' => 'M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37zM17.5 6.5h.01M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5z',
                'youtube'   => 'M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z',
            );

            foreach ($socials as $social => $path) {
                $url = get_theme_mod('himalayanmart_footer_' . $social);
                if ($url) {
                    echo '<a href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer" class="hm-canvas-social">';
                    echo '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="' . $path . '"></path></svg>';
                    echo '</a>';
                }
            }
            ?>
        </div>
    </div>
</div>
