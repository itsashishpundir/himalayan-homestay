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
