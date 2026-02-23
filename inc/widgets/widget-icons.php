<?php
/**
 * HimalayanMart Widget Icons Helper
 *
 * Provides inline SVG icons for widgets without external dependencies.
 *
 * @package HimalayanMart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get inline SVG icon
 *
 * @param string $icon  Icon name.
 * @param int    $size  Icon size in pixels.
 * @param string $class Additional CSS class.
 * @return string SVG HTML.
 */
function hm_get_widget_icon( $icon, $size = 20, $class = '' ) {
    $icons = array(
        // Arrows & Controls
        'chevron-down'  => '<path d="M6 9l6 6 6-6"/>',
        'chevron-right' => '<path d="M9 18l6-6-6-6"/>',
        'chevron-up'    => '<path d="M18 15l-6-6-6 6"/>',
        'plus'          => '<path d="M12 5v14M5 12h14"/>',
        'minus'         => '<path d="M5 12h14"/>',
        'x'             => '<path d="M18 6L6 18M6 6l12 12"/>',
        'arrow-right'   => '<path d="M5 12h14M12 5l7 7-7 7"/>',

        // Social Media
        'facebook'      => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>',
        'instagram'     => '<rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>',
        'twitter'       => '<path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/>',
        'youtube'       => '<path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"/><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"/>',
        'linkedin'      => '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/>',
        'pinterest'     => '<path d="M12 0C5.373 0 0 5.372 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 0 1 .083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/>',
        'tiktok'        => '<path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>',
        'whatsapp'      => '<path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/>',

        // Contact
        'phone'         => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>',
        'email'         => '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>',
        'location'      => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>',
        'clock'         => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
        'globe'         => '<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>',

        // General
        'home'          => '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',
        'shopping-bag'  => '<path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>',
        'heart'         => '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>',
        'star'          => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',
        'user'          => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
        'search'        => '<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>',
        'bed'           => '<path d="M2 4v16"/><path d="M2 8h18a2 2 0 0 1 2 2v10"/><path d="M2 17h20"/><path d="M6 8v9"/>',
        'users'         => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'send'          => '<line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>',
    );

    if ( ! isset( $icons[ $icon ] ) ) {
        return '';
    }

    $svg_class = 'hm-widget-icon' . ( $class ? ' ' . esc_attr( $class ) : '' );

    return sprintf(
        '<svg class="%s" width="%d" height="%d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">%s</svg>',
        $svg_class,
        $size,
        $size,
        $icons[ $icon ]
    );
}

/**
 * Get list of available icons for admin dropdowns
 *
 * @param string $category Optional. Filter by category.
 * @return array Icon options.
 */
function hm_get_widget_icon_options( $category = 'all' ) {
    $all_icons = array(
        'arrows' => array(
            'chevron-down'  => __( 'Chevron Down', 'himalayanmart' ),
            'chevron-right' => __( 'Chevron Right', 'himalayanmart' ),
            'chevron-up'    => __( 'Chevron Up', 'himalayanmart' ),
            'plus'          => __( 'Plus', 'himalayanmart' ),
            'minus'         => __( 'Minus', 'himalayanmart' ),
            'x'             => __( 'Close (X)', 'himalayanmart' ),
            'arrow-right'   => __( 'Arrow Right', 'himalayanmart' ),
        ),
        'social' => array(
            'facebook'  => __( 'Facebook', 'himalayanmart' ),
            'instagram' => __( 'Instagram', 'himalayanmart' ),
            'twitter'   => __( 'Twitter/X', 'himalayanmart' ),
            'youtube'   => __( 'YouTube', 'himalayanmart' ),
            'linkedin'  => __( 'LinkedIn', 'himalayanmart' ),
            'pinterest' => __( 'Pinterest', 'himalayanmart' ),
            'tiktok'    => __( 'TikTok', 'himalayanmart' ),
            'whatsapp'  => __( 'WhatsApp', 'himalayanmart' ),
        ),
        'contact' => array(
            'phone'    => __( 'Phone', 'himalayanmart' ),
            'email'    => __( 'Email', 'himalayanmart' ),
            'location' => __( 'Location', 'himalayanmart' ),
            'clock'    => __( 'Clock', 'himalayanmart' ),
            'globe'    => __( 'Globe', 'himalayanmart' ),
        ),
        'general' => array(
            'home'         => __( 'Home', 'himalayanmart' ),
            'shopping-bag' => __( 'Shopping Bag', 'himalayanmart' ),
            'heart'        => __( 'Heart', 'himalayanmart' ),
            'star'         => __( 'Star', 'himalayanmart' ),
            'user'         => __( 'User', 'himalayanmart' ),
            'search'       => __( 'Search', 'himalayanmart' ),
            'bed'          => __( 'Bed', 'himalayanmart' ),
            'users'        => __( 'Users', 'himalayanmart' ),
            'send'         => __( 'Send', 'himalayanmart' ),
        ),
    );

    if ( 'all' === $category ) {
        $merged = array();
        foreach ( $all_icons as $cat_icons ) {
            $merged = array_merge( $merged, $cat_icons );
        }
        return $merged;
    }

    return isset( $all_icons[ $category ] ) ? $all_icons[ $category ] : array();
}

/**
 * Get skin options for widgets
 *
 * @return array Skin options.
 */
function hm_get_widget_skin_options() {
    return array(
        'minimal'  => __( 'Minimal', 'himalayanmart' ),
        'boxed'    => __( 'Boxed', 'himalayanmart' ),
        'gradient' => __( 'Gradient', 'himalayanmart' ),
        'glass'    => __( 'Glass', 'himalayanmart' ),
        'dark'     => __( 'Dark', 'himalayanmart' ),
    );
}

/**
 * Get animation options for widgets
 *
 * @return array Animation options.
 */
function hm_get_widget_animation_options() {
    return array(
        'none'   => __( 'None', 'himalayanmart' ),
        'slide'  => __( 'Slide', 'himalayanmart' ),
        'fade'   => __( 'Fade', 'himalayanmart' ),
        'bounce' => __( 'Bounce', 'himalayanmart' ),
        'pulse'  => __( 'Pulse', 'himalayanmart' ),
        'rotate' => __( 'Rotate', 'himalayanmart' ),
    );
}
