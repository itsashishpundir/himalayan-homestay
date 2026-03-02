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

    // Material Symbols Outlined for homestay pages
    if ( $is_homestay_page ) {
        wp_enqueue_style( 'material-symbols-outlined', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap', array(), null );
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

    // Select2 (Used in Host Dashboard)
    wp_enqueue_style( 'select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', array(), '4.1.0' );
    wp_enqueue_script( 'select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), '4.1.0', true );

    // Native WP Media Uploader for Host Dashboard. 
    if ( is_page_template( 'page-host-panel.php' ) || isset($_GET['view']) ) {
        // WordPress native wp_enqueue_media() strictly requires the user to have 
        // the 'upload_files' capability to print out the thickbox / backbone templates and JS.
        $user = wp_get_current_user();
        if ( $user->exists() && ! $user->has_cap( 'upload_files' ) ) {
            $user->add_cap( 'upload_files' );
        }
        wp_enqueue_media();
    }
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

/**
 * Configure SMTP for Local Development/Testing
 * Pulls credentials from the Himalayan Homestays Settings -> SMTP Config tab.
 */
add_action( 'phpmailer_init', function( $phpmailer ) {
    $smtp_email = get_option( 'hhb_smtp_email' );
    $smtp_pass  = get_option( 'hhb_smtp_pass' );
    
    if ( $smtp_email && $smtp_pass ) {
        $phpmailer->isSMTP();
        $phpmailer->Host       = 'smtp.gmail.com';
        $phpmailer->SMTPAuth   = true;
        $phpmailer->Port       = 465;
        $phpmailer->Username   = $smtp_email;
        $phpmailer->Password   = $smtp_pass;
        $phpmailer->SMTPSecure = 'ssl';
        $phpmailer->From       = $smtp_email;
        $phpmailer->FromName   = get_bloginfo('name') . ' (Local SMTP)';
    }
} );

/**
 * Load helper functions and widgets.
 */
require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/widgets.php';


add_action( 'init', function() {
    if ( ! get_option( 'himalayan_homestay_mods_copied' ) ) {
        $old_mods = get_option( 'theme_mods_himalayajunction' );
        if ( $old_mods ) {
            update_option( 'theme_mods_himalayan-homestay', $old_mods );
            update_option( 'himalayan_homestay_mods_copied', true );
        }
    }
});



// Temporary migration script to move old homestays to the new plugin's post type
add_action( 'init', function() {
    if ( ! get_option( 'hhb_migrated_old_homestays' ) ) {
        global $wpdb;
        
        // Update post type from 'homestay' to 'hhb_homestay'
        $wpdb->query( "UPDATE {$wpdb->posts} SET post_type = 'hhb_homestay' WHERE post_type = 'homestay'" );
        
        // Map old meta keys to new meta keys if needed
        // (Old ones used an underscore prefix e.g., _homestay_price_per_night)
        $wpdb->query( "UPDATE {$wpdb->postmeta} SET meta_key = 'base_price_per_night' WHERE meta_key = '_homestay_price_per_night'" );
        $wpdb->query( "UPDATE {$wpdb->postmeta} SET meta_key = 'max_guests' WHERE meta_key = '_homestay_max_guests'" );
        $wpdb->query( "UPDATE {$wpdb->postmeta} SET meta_key = 'room_count' WHERE meta_key = '_homestay_bedrooms'" );
        $wpdb->query( "UPDATE {$wpdb->postmeta} SET meta_key = 'hhb_gallery' WHERE meta_key = '_homestay_gallery'" );
        $wpdb->query( "UPDATE {$wpdb->postmeta} SET meta_key = 'cancellation_policy' WHERE meta_key = '_homestay_cancellation_policy'" );
        $wpdb->query( "UPDATE {$wpdb->postmeta} SET meta_key = 'lat' WHERE meta_key = '_homestay_google_map_embed'" ); // Just mapping arbitrarily for preservation
        $wpdb->query( "UPDATE {$wpdb->postmeta} SET meta_key = 'hhb_amenities' WHERE meta_key = '_homestay_amenities'" );
        
        update_option( 'hhb_migrated_old_homestays', true );
    }
});

/**
 * Host Application form handlers and custom post type registration
 * have been migrated to the Himalayan Homestay Bookings plugin.
 */


/**
 * Auto-create the "Become a Host" page if it doesn't exist.
 */
function hm_create_become_a_host_page() {
    if ( get_option( 'hm_become_host_page_created' ) ) return;

    $existing = get_page_by_path( 'become-a-host' );
    if ( ! $existing ) {
        wp_insert_post( array(
            'post_title'  => 'Become a Host',
            'post_name'   => 'become-a-host',
            'post_status' => 'publish',
            'post_type'   => 'page',
            'post_content'=> '',
        ) );
    }
    update_option( 'hm_become_host_page_created', true );
}
add_action( 'init', 'hm_create_become_a_host_page' );

/**
 * Filter the main query for the Homestay archive by ?location= and ?type= GET params.
 * This enables correct pagination when using GET-param based filtering.
 */
add_action( 'pre_get_posts', 'hhb_archive_filter_query' );
function hhb_archive_filter_query( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    // Only apply on the hhb_homestay post-type archive
    if ( ! $query->is_post_type_archive( 'hhb_homestay' ) ) {
        return;
    }

    $tax_query = array();

    $location = isset( $_GET['location'] ) ? sanitize_text_field( $_GET['location'] ) : '';
    if ( $location ) {
        $tax_query[] = array(
            'taxonomy' => 'hhb_location',
            'field'    => 'slug',
            'terms'    => $location,
        );
    }

    $type = isset( $_GET['type'] ) ? sanitize_text_field( $_GET['type'] ) : '';
    if ( $type ) {
        $tax_query[] = array(
            'taxonomy' => 'hhb_property_type',
            'field'    => 'slug',
            'terms'    => $type,
        );
    }

    if ( ! empty( $tax_query ) ) {
        $query->set( 'tax_query', $tax_query );
    }
}

/**
 * Include Customizer Settings
 */
require get_template_directory() . '/inc/customizer/header-footer.php';
require get_template_directory() . '/inc/customizer/blog.php';
require get_template_directory() . '/inc/customizer/homestay.php';

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
    $is_host_dashboard = is_page_template( 'page-host-panel.php' );
    if ( ! is_admin() && ! $is_host_dashboard ) {
        $home        = esc_url( home_url() );
        $csp_parts   = [
            "default-src 'self' {$home}",
            "script-src  'self' 'unsafe-inline' 'unsafe-eval' cdn.tailwindcss.com cdn.jsdelivr.net cdnjs.cloudflare.com fonts.googleapis.com {$home} blob:",
            "style-src   'self' 'unsafe-inline' cdn.tailwindcss.com cdn.jsdelivr.net cdnjs.cloudflare.com fonts.googleapis.com fonts.gstatic.com {$home}",
            "font-src    'self' fonts.gstatic.com cdnjs.cloudflare.com data:",
            "img-src     'self' data: blob: *.unsplash.com *.gravatar.com secure.gravatar.com {$home}",
            "connect-src 'self' {$home}",
            "frame-src   'self' *.google.com *.google.co.in",
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
