<?php
/**
 * Homestay Customizer Settings
 *
 * @package HimalayanMart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function himalayanmart_customizer_homestay( $wp_customize ) {

    // ==============================================
    // HOMEPAGE FEATURED SECTION
    // ==============================================
    $wp_customize->add_section( 'himalayanmart_homepage_featured_section', array(
        'title'       => __( 'Homepage Featured Stays', 'himalayanmart' ),
        'panel'       => 'hhb_frontpage_panel',
        'priority'    => 45,
        'description' => __( 'Customize the featured stays grid and texts on the homepage.', 'himalayanmart' ),
    ) );

    // Section Label
    $wp_customize->add_setting( 'hhb_featured_label', array(
        'default'           => 'Best Sellers',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'hhb_featured_label', array(
        'label'       => __( 'Section Top Label', 'himalayanmart' ),
        'section'     => 'himalayanmart_homepage_featured_section',
        'type'        => 'text',
    ) );

    // Section Heading
    $wp_customize->add_setting( 'hhb_featured_heading', array(
        'default'           => 'Featured Stays',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'hhb_featured_heading', array(
        'label'       => __( 'Section Main Heading', 'himalayanmart' ),
        'section'     => 'himalayanmart_homepage_featured_section',
        'type'        => 'text',
    ) );

    // Section Subheading
    $wp_customize->add_setting( 'hhb_featured_subheading', array(
        'default'           => 'Handpicked properties loved by our guests',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'hhb_featured_subheading', array(
        'label'       => __( 'Section Subheading', 'himalayanmart' ),
        'section'     => 'himalayanmart_homepage_featured_section',
        'type'        => 'textarea',
    ) );

    // Number of Items
    $wp_customize->add_setting( 'hhb_featured_item_count', array(
        'default'           => 6,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'hhb_featured_item_count', array(
        'label'       => __( 'Number of Featured Items', 'himalayanmart' ),
        'description' => __( 'How many featured homestays to display on the homepage.', 'himalayanmart' ),
        'section'     => 'himalayanmart_homepage_featured_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 2, 'max' => 24, 'step' => 1 ),
    ) );

    // Number of Columns
    $wp_customize->add_setting( 'hhb_featured_grid_cols', array(
        'default'           => '4',
        'sanitize_callback' => 'sanitize_key',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'hhb_featured_grid_cols', array(
        'label'       => __( 'Desktop Grid Columns', 'himalayanmart' ),
        'description' => __( 'Choose how many cards to show per row on large desktop screens.', 'himalayanmart' ),
        'section'     => 'himalayanmart_homepage_featured_section',
        'type'        => 'select',
        'choices'     => array(
            '3' => __( '3 Columns', 'himalayanmart' ),
            '4' => __( '4 Columns', 'himalayanmart' ),
            '5' => __( '5 Columns', 'himalayanmart' ),
        ),
    ) );

    // ==============================================
    // HOMESTAY ARCHIVE SECTION
    // ==============================================
    $wp_customize->add_section( 'himalayanmart_homestay_archive_section', array(
        'title'       => __( 'Homestay Archive Settings', 'himalayanmart' ),
        'priority'    => 46,
        'description' => __( 'Customize the Homestay archive/locations page title and layout.', 'himalayanmart' ),
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

    // ==============================================
    // PROPERTY TYPE ARCHIVE SECTION
    // ==============================================
    $wp_customize->add_section( 'himalayanmart_property_type_archive_section', array(
        'title'       => __( 'Property Type Archive Settings', 'himalayanmart' ),
        'priority'    => 47,
        'description' => __( 'Customize the Property Type archive page title.', 'himalayanmart' ),
    ) );

    // Property Type Title Prefix
    $wp_customize->add_setting( 'himalayanmart_property_type_archive_prefix', array(
        'default'           => 'Explore ',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'himalayanmart_property_type_archive_prefix', array(
        'label'       => __( 'Archive Title Prefix', 'himalayanmart' ),
        'description' => __( 'Text to show before the property type name. Example: "Explore "', 'himalayanmart' ),
        'section'     => 'himalayanmart_property_type_archive_section',
        'type'        => 'text',
    ) );

    // Property Type Title Suffix
    $wp_customize->add_setting( 'himalayanmart_property_type_archive_suffix', array(
        'default'           => ' Stays',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'himalayanmart_property_type_archive_suffix', array(
        'label'       => __( 'Archive Title Suffix', 'himalayanmart' ),
        'description' => __( 'Text to show after the property type name. Example: " Stays"', 'himalayanmart' ),
        'section'     => 'himalayanmart_property_type_archive_section',
        'type'        => 'text',
    ) );

}
add_action( 'customize_register', 'himalayanmart_customizer_homestay' );
