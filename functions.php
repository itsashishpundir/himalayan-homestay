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

/**
 * Setup Theme
 */
function himalayan_homestay_setup() {
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );

    register_nav_menus(
        array(
            'primary' => esc_html__( 'Primary Menu', 'himalayanmart' ),
            'footer-1' => esc_html__( 'Footer Menu 1', 'himalayanmart' ),
            'footer-2' => esc_html__( 'Footer Menu 2', 'himalayanmart' ),
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

    // Main JS
    wp_enqueue_script('himalayanmart-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), HIMALAYANMART_VERSION, true);

        if ( is_singular('hhb_homestay') ) {
        wp_enqueue_style('hhb-homestay-style', get_template_directory_uri() . '/assets/css/homestay.css', array('himalayanmart-main'), HIMALAYANMART_VERSION);
    }

    wp_enqueue_style( 'himalayan-homestay-style', get_stylesheet_uri(), array(), HIMALAYANMART_VERSION );
}
add_action( 'wp_enqueue_scripts', 'himalayan_homestay_scripts' );

/**
 * Load Customizer settings.
 */
require get_template_directory() . '/inc/customizer/header-footer.php';

require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/widgets.php';
require get_template_directory() . '/inc/customizer/blog.php';


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
