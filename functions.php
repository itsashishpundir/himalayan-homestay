<?php
/**
 * Himalayan Homestay functions and definitions
 *
 * @package HimalayanMart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define('HIMALAYANMART_VERSION', '1.0.0');

// Homepage & Contact Page Customizer settings + AJAX handler.
require_once get_template_directory() . '/inc/customizer-pages.php';

/**
 * Setup Theme
 */
function himalayan_homestay_setup() {
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );

    register_nav_menus(
        array(
            'primary'          => esc_html__( 'Primary Menu', 'himalayanmart' ),
            'footer-1'         => esc_html__( 'Footer Menu 1', 'himalayanmart' ),
            'footer-2'         => esc_html__( 'Footer Menu 2', 'himalayanmart' ),
            'footer-discover'  => esc_html__( 'FuturaStays Footer: Discover', 'himalayanmart' ),
            'footer-company'   => esc_html__( 'FuturaStays Footer: Company', 'himalayanmart' ),
            'footer-support'   => esc_html__( 'FuturaStays Footer: Support', 'himalayanmart' ),
        )
    );

    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );
}
add_action( 'after_setup_theme', 'himalayan_homestay_setup' );

/**
 * Enqueue scripts and styles.
 */
function himalayan_homestay_scripts() {
    // Styles
    wp_enqueue_style('himalayanmart-main', get_template_directory_uri() . '/assets/css/main.css', array(), HIMALAYANMART_VERSION);
    wp_enqueue_style('himalayanmart-responsive', get_template_directory_uri() . '/assets/css/responsive.css', array('himalayanmart-main'), HIMALAYANMART_VERSION);
    wp_enqueue_style('dashicons');

    // GLightbox for Gallery
    wp_enqueue_style('glightbox', 'https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css', array(), '3.2.0');
    wp_enqueue_script('glightbox', 'https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js', array(), '3.2.0', true);

    // Conditional loading for Blog
    if ( is_home() || is_archive() || is_singular('post') || is_search() ) {
        wp_enqueue_style('himalayanmart-blog', get_template_directory_uri() . '/assets/css/blog.css', array('himalayanmart-main'), HIMALAYANMART_VERSION);
    }
// Font Awesome for icons
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');

    // Tailwind + Material Symbols for homestay pages (single, archive, taxonomy)
    $is_homestay_page = is_singular('hhb_homestay')
        || is_post_type_archive('hhb_homestay')
        || is_tax('hhb_location')
        || is_tax('hhb_property_type');

    if ( (is_single() && get_post_type() === 'post') || is_home() || is_archive() || is_search() || $is_homestay_page ) {
        wp_enqueue_script( 'tailwindcss', 'https://cdn.tailwindcss.com?plugins=forms,container-queries,typography', array(), null, false );
        
        // Add inline configuration for Tailwind
        $tailwind_config = "
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'primary': '#e85e30',
                        'background-light': '#f8f6f6',
                        'background-dark': '#211511',
                    },
                    fontFamily: {
                        'display': ['Inter']
                    }
                }
            }
        };";
        wp_add_inline_script( 'tailwindcss', $tailwind_config, 'before' );
    }

    // Material Symbols Outlined — needed for homestay pages AND blog/post templates.
    $needs_material_symbols = $is_homestay_page
        || is_home()
        || is_archive()
        || is_singular( 'post' )
        || is_category()
        || is_tag()
        || is_search();
    if ( $needs_material_symbols ) {
        wp_enqueue_style( 'material-symbols-outlined', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=block', array(), null );
    }
    // Google Fonts 
    wp_enqueue_style( 'himalayanmart-organic-fonts', 'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap', array(), null );
    wp_enqueue_style( 'himalayanmart-material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), null );

    // Header/Footer Assets - Load based on selected layout
    $header_layout = get_theme_mod('himalayanmart_header_layout', '3-tier');
    $footer_layout = get_theme_mod('himalayanmart_footer_layout', '4-column');

    // Default header/footer styles (for 3-tier and 4-column layouts)
    if ($header_layout === '3-tier' || $footer_layout === '4-column') {
        wp_enqueue_style('himalayanmart-header-footer', get_template_directory_uri() . '/assets/css/header-footer.css', array(), HIMALAYANMART_VERSION);
        wp_enqueue_style('himalayanmart-menu-offcanvas', get_template_directory_uri() . '/assets/css/menu-offcanvas.css', array(), HIMALAYANMART_VERSION);
        wp_enqueue_script('himalayanmart-header-footer', get_template_directory_uri() . '/assets/js/header-footer.js', array('jquery'), HIMALAYANMART_VERSION, true);
    }

    // Modern layouts styles (for modern-glass header and modern-multicolumn footer)
    if ($header_layout === 'modern-glass' || $footer_layout === 'modern-multicolumn') {
        wp_enqueue_style('himalayanmart-modern-layouts', get_template_directory_uri() . '/assets/css/modern-layouts.css', array(), HIMALAYANMART_VERSION);
        wp_enqueue_script('himalayanmart-modern-layouts', get_template_directory_uri() . '/assets/js/modern-layouts.js', array(), HIMALAYANMART_VERSION, true);
    }

    // FuturaStays layouts (for futura-glass header and futura-newsletter footer)
    if ($header_layout === 'futura-glass' || $footer_layout === 'futura-newsletter') {
        // Tailwind CDN (used by FuturaStays templates)
        wp_enqueue_script('tailwindcss-cdn', 'https://cdn.tailwindcss.com?plugins=forms,container-queries', array(), null, false);
        wp_add_inline_script('tailwindcss-cdn', "tailwind.config={darkMode:'class',theme:{extend:{colors:{primary:'#e85e30','background-light':'#f8f6f6','background-dark':'#211511'},fontFamily:{display:['Inter','sans-serif']}}}};");
        // Material Symbols Outlined (icons for FuturaStays header/footer)
        wp_enqueue_style('material-symbols-outlined', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap', array(), null);
        // FuturaStays custom CSS/JS
        wp_enqueue_style('himalayanmart-futura-layouts', get_template_directory_uri() . '/assets/css/futura-layouts.css', array(), HIMALAYANMART_VERSION);
        wp_enqueue_script('himalayanmart-futura-layouts', get_template_directory_uri() . '/assets/js/futura-layouts.js', array(), HIMALAYANMART_VERSION, true);
    }

    // Main JS (Deferred via filter below)
    wp_enqueue_script('himalayanmart-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), HIMALAYANMART_VERSION, true);

    // GLightbox only on single homestay (gallery lightbox)
    if ( is_singular('hhb_homestay') ) {
        wp_enqueue_style('glightbox', 'https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css', array(), '3.2.0');
        wp_enqueue_script('glightbox', 'https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js', array(), '3.2.0', true);
    }

    if ( $is_homestay_page ) {
        wp_enqueue_style('hhb-homestay-style', get_template_directory_uri() . '/assets/css/homestay.css', array('himalayanmart-main'), HIMALAYANMART_VERSION);
    }

    wp_enqueue_style( 'himalayan-homestay-style', get_stylesheet_uri(), array(), HIMALAYANMART_VERSION );

    // Globally define Material Symbols Outlined CSS class.
    // Google Fonts provides this via their CDN stylesheet, but adding it inline here
    // ensures icons render correctly even if the external stylesheet is delayed/blocked.
    wp_add_inline_style( 'himalayanmart-main', "
        @font-face {
            font-family: 'Material Symbols Outlined';
            font-style: normal;
            font-weight: 100 700;
            src: url(https://fonts.gstatic.com/s/materialsymbolsoutlined/v235/kJF1BvYX7BgnkSrUwT8OhrdQw4oELdPIeeII9v6oDMzByHX9rA6RzaxHMPdY43zj-jCxv3fzvRNU22ZXGJpEpjC_1n-q_4MrImHCIJIZrDCvHOejbd5zrDAt.woff2) format('woff2');
        }
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            -webkit-font-feature-settings: 'liga';
            font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }
    " );

    // Note: Select2 and WP Media Uploader are enqueued by the plugin (TemplateLoader / BookingWidget) on pages that need them.
}
add_action( 'wp_enqueue_scripts', 'himalayan_homestay_scripts' );

/**
 * Performance: Add 'defer' to scripts.
 */
add_filter( 'script_loader_tag', function ( $tag, $handle ) {
    $defer_scripts = [
        'himalayanmart-main',
        'himalayanmart-header-footer',
        'himalayanmart-modern-layouts',
        'himalayanmart-futura-layouts',
        'glightbox'
    ];
    if ( in_array( $handle, $defer_scripts, true ) ) {
        return str_replace( ' src', ' defer src', $tag );
    }
    return $tag;
}, 10, 2 );

/**
 * Performance: Resource Hints (Preconnect).
 */
add_filter( 'wp_resource_hints', function( $urls, $relation_type ) {
    if ( 'preconnect' === $relation_type ) {
        $urls[] = 'https://fonts.googleapis.com';
        $urls[] = 'https://fonts.gstatic.com';
        $urls[] = 'https://cdn.tailwindcss.com';
    }
    return $urls;
}, 10, 2 );

/**
 * Hide WordPress Admin Bar for all users except Administrators.
 */
add_action('after_setup_theme', function() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
});

// SMTP Configuration has been moved to the plugin's Infrastructure/Notifications layer.

/**
 * Load helper functions and widgets.
 */
require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/widgets.php';


// Data migrations have been moved to the plugin's Database layer.

/**
 * Host Application form handlers and custom post type registration
 * have been migrated to the Himalayan Homestay Bookings plugin.
 */


// hm_create_become_a_host_page() and hhb_archive_filter_query() have been moved to the plugin.

// Customizer includes removed — customizer settings are no longer used by this theme.

/**
 * Security Headers
 * Adds HTTP security headers to all frontend responses.
 * skill: security-auditor
 */
add_action( 'send_headers', function () {
    // Prevent MIME sniffing (e.g. serving JS as HTML).
    header( 'X-Content-Type-Options: nosniff' );

    // Block the site from being embedded in iframes on other domains.
    header( 'X-Frame-Options: SAMEORIGIN' );

    // Legacy XSS filter for older browsers.
    header( 'X-XSS-Protection: 1; mode=block' );

    // Only send the origin in Referer header.
    header( 'Referrer-Policy: strict-origin-when-cross-origin' );

    // Restrict access to browser APIs.
    header( 'Permissions-Policy: geolocation=(), microphone=(), camera=()' );

    // Content Security Policy — allow sources required by this theme.
    // Skip CSP entirely on the Host Dashboard: wp.media uses Backbone.js/underscore _.template()
    // which requires 'unsafe-eval', and the media uploader also loads scripts from admin URLs
    // that would be blocked. The dashboard is already behind a login + role check.
    // Host dashboard pages are now served by the plugin — check both old and plugin page templates
    $is_host_dashboard = is_page_template( 'page-host-panel.php' ) || is_page_template( 'host-panel-template' );
    if ( ! is_admin() && ! $is_host_dashboard ) {
        $home        = esc_url( home_url() );
        $csp_parts   = [
            "default-src 'self' {$home}",
            "script-src  'self' 'unsafe-inline' 'unsafe-eval' cdn.tailwindcss.com cdn.jsdelivr.net cdnjs.cloudflare.com fonts.googleapis.com {$home} blob: https://www.paypal.com https://www.paypalobjects.com https://checkout.razorpay.com",
            "style-src   'self' 'unsafe-inline' cdn.tailwindcss.com cdn.jsdelivr.net cdnjs.cloudflare.com fonts.googleapis.com fonts.gstatic.com {$home} https://www.paypalobjects.com",
            "font-src    'self' fonts.gstatic.com cdnjs.cloudflare.com data: https://www.paypalobjects.com",
            "img-src     'self' data: blob: *.unsplash.com *.gravatar.com secure.gravatar.com s.w.org *.wp.com {$home} https://www.paypalobjects.com https://checkout.razorpay.com",
            "connect-src 'self' {$home} https://api.razorpay.com https://lumberjack.razorpay.com https://api.paypal.com https://www.paypal.com https://www.sandbox.paypal.com",
            "frame-src   'self' *.google.com *.google.co.in https://www.paypal.com https://www.sandbox.paypal.com https://api.razorpay.com https://checkout.razorpay.com",
            "frame-ancestors 'self'",
            "worker-src  'self' blob:",
        ];
        header( 'Content-Security-Policy: ' . implode( '; ', $csp_parts ) );
    }
} );

/**
 * Remove WordPress version from all public pages (reduces fingerprinting).
 */
add_filter( 'the_generator', '__return_empty_string' );
remove_action( 'wp_head', 'wp_generator' );
