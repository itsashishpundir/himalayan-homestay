<?php
/**
 * Register widget areas and custom widgets.
 *
 * @package HimalayanMart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Load widget helper functions
 */
require_once get_template_directory() . '/inc/widgets/widget-icons.php';

/**
 * Load custom widget classes
 */
require_once get_template_directory() . '/inc/widgets/class-widget-faq.php';
require_once get_template_directory() . '/inc/widgets/class-widget-featured-homestays.php';
require_once get_template_directory() . '/inc/widgets/class-widget-featured-products.php';
require_once get_template_directory() . '/inc/widgets/class-widget-contact-info.php';
require_once get_template_directory() . '/inc/widgets/class-widget-social-links.php';
require_once get_template_directory() . '/inc/widgets/class-widget-newsletter.php';
require_once get_template_directory() . '/inc/widgets/class-widget-homestay-carousel.php';

/**
 * Register widget areas
 */
function himalayanmart_widgets_init() {
    // Blog Sidebar
    register_sidebar( array(
        'name'          => esc_html__( 'Blog Sidebar', 'himalayanmart' ),
        'id'            => 'sidebar-blog',
        'description'   => esc_html__( 'Widgets for blog single post and archive pages.', 'himalayanmart' ),
        'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    // Footer Column 1
    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 1', 'himalayanmart' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Add widgets here.', 'himalayanmart' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    // Footer Column 2
    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 2', 'himalayanmart' ),
        'id'            => 'footer-2',
        'description'   => esc_html__( 'Add widgets here.', 'himalayanmart' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    // Footer Column 3
    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 3', 'himalayanmart' ),
        'id'            => 'footer-3',
        'description'   => esc_html__( 'Add widgets here.', 'himalayanmart' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    // Footer Column 4
    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 4', 'himalayanmart' ),
        'id'            => 'footer-4',
        'description'   => esc_html__( 'Add widgets here.', 'himalayanmart' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    // Register custom widgets
    register_widget( 'HM_Widget_FAQ' );
    register_widget( 'HM_Widget_Featured_Homestays' );
    register_widget( 'HM_Widget_Featured_Products' );
    register_widget( 'HM_Widget_Contact_Info' );
    register_widget( 'HM_Widget_Social_Links' );
    register_widget( 'HM_Widget_Newsletter' );
    register_widget( 'HM_Widget_Homestay_Carousel' );
}
add_action( 'widgets_init', 'himalayanmart_widgets_init' );

/**
 * Enqueue widget assets
 */
function himalayanmart_widget_assets() {
    // Widget CSS
    wp_enqueue_style(
        'himalayanmart-widgets',
        get_template_directory_uri() . '/assets/css/widgets.css',
        array(),
        filemtime( get_template_directory() . '/assets/css/widgets.css' )
    );

    // Widget JS (for FAQ accordion)
    wp_enqueue_script(
        'himalayanmart-widgets',
        get_template_directory_uri() . '/assets/js/widgets.js',
        array(),
        filemtime( get_template_directory() . '/assets/js/widgets.js' ),
        true
    );
}
add_action( 'wp_enqueue_scripts', 'himalayanmart_widget_assets' );

