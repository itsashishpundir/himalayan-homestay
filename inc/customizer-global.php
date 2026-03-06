<?php
/**
 * Global Customizer Settings (Header, Footer, Archive)
 *
 * @package HimalayanHomestay
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'customize_register', function( $wp_customize ) {

    // ==============================================
    // HEADER & FOOTER SETTINGS (Global Panel)
    // ==============================================
    $wp_customize->add_panel( 'himalayanmart_layouts_panel', array(
        'priority'       => 20,
        'title'          => __( 'Header & Footer Settings', 'himalayanmart' ),
        'description'    => __( 'Control the global layout for headers and footers.', 'himalayanmart' ),
    ) );

    // --- Header Layout Selection ---
    $wp_customize->add_section( 'himalayanmart_header_selection_section', array(
        'title'       => __( 'Header Layout Selection', 'himalayanmart' ),
        'panel'       => 'himalayanmart_layouts_panel',
        'priority'    => 5,
    ) );

    $wp_customize->add_setting( 'himalayanmart_header_layout', array(
        'default'           => '3-tier',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'himalayanmart_header_layout', array(
        'label'       => __( 'Select Header Layout', 'himalayanmart' ),
        'section'     => 'himalayanmart_header_selection_section',
        'type'        => 'select',
        'choices'     => array(
            '3-tier'       => __( '3-Tier Header (Top Bar + Logo + Navigation)', 'himalayanmart' ),
            'modern-glass' => __( 'Modern Glass Header (Glassmorphism + Sticky)', 'himalayanmart' ),
            'futura-glass' => __( 'Futura Glass Header (Mega Menu + Search)', 'himalayanmart' ),
        ),
    ) );

    // --- Footer Layout Selection ---
    $wp_customize->add_section( 'himalayanmart_footer_selection_section', array(
        'title'       => __( 'Footer Layout Selection', 'himalayanmart' ),
        'panel'       => 'himalayanmart_layouts_panel',
        'priority'    => 15,
    ) );

    $wp_customize->add_setting( 'himalayanmart_footer_layout', array(
        'default'           => '4-column',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'himalayanmart_footer_layout', array(
        'label'       => __( 'Select Footer Layout', 'himalayanmart' ),
        'section'     => 'himalayanmart_footer_selection_section',
        'type'        => 'select',
        'choices'     => array(
            '4-column'           => __( '4-Column Footer (About + 2 Menus + Contact)', 'himalayanmart' ),
            'modern-multicolumn' => __( 'Modern Multi-Column Footer (Tabs + Newsletter)', 'himalayanmart' ),
            'futura-newsletter'  => __( 'Futura Newsletter Footer (4-Col + Social)', 'himalayanmart' ),
        ),
    ) );

    // --- Header Section ---
    $wp_customize->add_section('hm_futura_header_section', array(
        'title'       => __('Futura Glass Header Settings', 'himalayanmart'),
        'panel'       => 'himalayanmart_layouts_panel',
        'priority'    => 10,
    ));

    $futura_header_settings = array(
        'hm_futura_header_show_announcement' => array('default' => true,  'type' => 'checkbox', 'label' => 'Show Announcement Bar'),
        'hm_futura_header_announcement_text' => array('default' => 'New: Explore our Winter Collection in the Himalayas.', 'type' => 'textarea', 'label' => 'Announcement Text'),
        'hm_futura_header_announcement_cta_text' => array('default' => 'Learn more', 'type' => 'text', 'label' => 'Announcement CTA Text'),
        'hm_futura_header_announcement_cta_url'  => array('default' => '#', 'type' => 'url', 'label' => 'Announcement CTA URL'),
        'hm_futura_header_show_search'       => array('default' => true,  'type' => 'checkbox', 'label' => 'Show Search Bar'),
        'hm_futura_header_search_placeholder' => array('default' => 'Where are you going?', 'type' => 'text', 'label' => 'Search Placeholder'),
        'hm_futura_header_show_cta'          => array('default' => true,  'type' => 'checkbox', 'label' => 'Show CTA Button'),
        'hm_futura_header_cta_text'          => array('default' => 'List your home', 'type' => 'text', 'label' => 'CTA Button Text'),
        'hm_futura_header_cta_url'           => array('default' => '#', 'type' => 'url', 'label' => 'CTA Button URL'),
        'hm_futura_header_show_avatar'       => array('default' => true,  'type' => 'checkbox', 'label' => 'Show User Avatar / Login'),
        'hm_futura_header_glass_opacity'     => array('default' => 70, 'type' => 'range', 'label' => 'Glass Opacity (%)', 'input_attrs' => array('min' => 0, 'max' => 100, 'step' => 5)),
    );

    foreach ($futura_header_settings as $id => $args) {
        $sanitize = 'sanitize_text_field';
        if ($args['type'] === 'checkbox') $sanitize = 'wp_validate_boolean';
        if ($args['type'] === 'textarea') $sanitize = 'wp_kses_post';
        if ($args['type'] === 'url') $sanitize = 'esc_url_raw';
        if ($args['type'] === 'range') $sanitize = 'absint';

        $wp_customize->add_setting($id, array(
            'default'           => $args['default'],
            'sanitize_callback' => $sanitize,
            'transport'         => 'refresh',
        ));

        $control_args = array(
            'label'   => __($args['label'], 'himalayanmart'),
            'section' => 'hm_futura_header_section',
            'type'    => $args['type'],
        );
        if (isset($args['input_attrs'])) {
            $control_args['input_attrs'] = $args['input_attrs'];
        }
        $wp_customize->add_control($id, $control_args);
    }

    // --- Footer Section ---
    $wp_customize->add_section('hm_futura_footer_section', array(
        'title'       => __('Futura Newsletter Footer Settings', 'himalayanmart'),
        'panel'       => 'himalayanmart_layouts_panel',
        'priority'    => 20,
    ));

    $futura_footer_settings = array(
        'hm_futura_footer_show_newsletter'    => array('default' => true, 'type' => 'checkbox', 'label' => 'Show Newsletter Section'),
        'hm_futura_footer_newsletter_heading' => array('default' => 'Stay ahead of the curve', 'type' => 'text', 'label' => 'Newsletter Heading'),
        'hm_futura_footer_newsletter_desc'    => array('default' => 'Join 50,000+ travelers and get the latest on exclusive offers and unique experiences.', 'type' => 'textarea', 'label' => 'Newsletter Description'),
        'hm_futura_footer_newsletter_btn'     => array('default' => 'Sign Up Now', 'type' => 'text', 'label' => 'Newsletter Button Text'),
        'hm_futura_footer_privacy_text'       => array('default' => 'privacy policy', 'type' => 'text', 'label' => 'Privacy Link Text'),
        'hm_futura_footer_privacy_url'        => array('default' => '#', 'type' => 'url', 'label' => 'Privacy Link URL'),
        'hm_futura_footer_col1_title'         => array('default' => 'Discover', 'type' => 'text', 'label' => 'Column 1 Title'),
        'hm_futura_footer_col2_title'         => array('default' => 'Company', 'type' => 'text', 'label' => 'Column 2 Title'),
        'hm_futura_footer_col3_title'         => array('default' => 'Support', 'type' => 'text', 'label' => 'Column 3 Title'),
        'hm_futura_footer_col4_title'         => array('default' => 'Connect', 'type' => 'text', 'label' => 'Column 4 Title'),
        'hm_futura_footer_twitter'            => array('default' => '', 'type' => 'url', 'label' => 'Twitter / X URL'),
        'hm_futura_footer_facebook'           => array('default' => '', 'type' => 'url', 'label' => 'Facebook URL'),
        'hm_futura_footer_instagram'          => array('default' => '', 'type' => 'url', 'label' => 'Instagram URL'),
        'hm_futura_footer_youtube'            => array('default' => '', 'type' => 'url', 'label' => 'YouTube URL'),
        'hm_futura_footer_show_language'      => array('default' => true, 'type' => 'checkbox', 'label' => 'Show Language Selector'),
        'hm_futura_footer_copyright'          => array('default' => '© [year] [sitename]. All rights reserved.', 'type' => 'textarea', 'label' => 'Copyright Text'),
    );

    foreach ($futura_footer_settings as $id => $args) {
        $sanitize = 'sanitize_text_field';
        if ($args['type'] === 'checkbox') $sanitize = 'wp_validate_boolean';
        if ($args['type'] === 'textarea') $sanitize = 'wp_kses_post';
        if ($args['type'] === 'url') $sanitize = 'esc_url_raw';

        $wp_customize->add_setting($id, array(
            'default'           => $args['default'],
            'sanitize_callback' => $sanitize,
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control($id, array(
            'label'   => __($args['label'], 'himalayanmart'),
            'section' => 'hm_futura_footer_section',
            'type'    => $args['type'],
        ));
    }


    // ==============================================
    // HOMESTAY ARCHIVE SETTINGS
    // ==============================================
    $wp_customize->add_section( 'himalayanmart_homestay_archive_section', array(
        'title'       => __( 'Homestay Archive Settings', 'himalayanmart' ),
        'priority'    => 46,
        'description' => __( 'Customize the Homestay archive/locations page title prefix and suffix.', 'himalayanmart' ),
    ) );

    // Archive Title Prefix
    $wp_customize->add_setting( 'himalayanmart_homestay_archive_prefix', array(
        'default'           => 'Explore Homestays in ',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'himalayanmart_homestay_archive_prefix', array(
        'label'       => __( 'Archive Title Prefix', 'himalayanmart' ),
        'description' => __( 'Text to show before the location name. Example: "Explore Homestays in "', 'himalayanmart' ),
        'section'     => 'himalayanmart_homestay_archive_section',
        'type'        => 'text',
    ) );

    // Archive Title Suffix
    $wp_customize->add_setting( 'himalayanmart_homestay_archive_suffix', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'himalayanmart_homestay_archive_suffix', array(
        'label'       => __( 'Archive Title Suffix', 'himalayanmart' ),
        'description' => __( 'Text to show after the location name. Example: " (Premium)"', 'himalayanmart' ),
        'section'     => 'himalayanmart_homestay_archive_section',
        'type'        => 'text',
    ) );

    // Property Type Title Prefix
    $wp_customize->add_setting( 'himalayanmart_property_type_archive_prefix', array(
        'default'           => 'Explore ',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'himalayanmart_property_type_archive_prefix', array(
        'label'       => __( 'Property Type Prefix', 'himalayanmart' ),
        'description' => __( 'Text to show before the property type name. Example: "Explore "', 'himalayanmart' ),
        'section'     => 'himalayanmart_homestay_archive_section',
        'type'        => 'text',
    ) );

    // Property Type Title Suffix
    $wp_customize->add_setting( 'himalayanmart_property_type_archive_suffix', array(
        'default'           => ' Stays',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'himalayanmart_property_type_archive_suffix', array(
        'label'       => __( 'Property Type Suffix', 'himalayanmart' ),
        'description' => __( 'Text to show after the property type name. Example: " Stays"', 'himalayanmart' ),
        'section'     => 'himalayanmart_homestay_archive_section',
        'type'        => 'text',
    ) );

} );
