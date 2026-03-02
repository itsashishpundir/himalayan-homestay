<?php
if (!defined('ABSPATH')) exit;

/**
 * Header & Footer Layout System
 *
 * This file manages the header and footer layout customizer settings.
 * To add a new layout:
 * 1. Create template file: template-parts/header/header-{layout-id}.php or template-parts/footer/footer-{layout-id}.php
 * 2. Add the layout to the appropriate function below (himalayanmart_get_header_layouts or himalayanmart_get_footer_layouts)
 * 3. Create a customizer section for the layout settings if needed
 *
 * @package HimalayanMart
 */

/**
 * Get available header layouts
 *
 * @return array Array of layout_id => layout_name
 */
function himalayanmart_get_header_layouts() {
    return apply_filters('himalayanmart_header_layouts', array(
        '3-tier'       => __('3-Tier Header (Top Bar + Logo + Navigation)', 'himalayanmart'),
        'modern-glass' => __('Modern Glass Header (Glassmorphism + Sticky)', 'himalayanmart'),
        'futura-glass' => __('FuturaStays Glass (Mega Menu + Search)', 'himalayanmart'),
    ));
}

/**
 * Get available footer layouts
 *
 * @return array Array of layout_id => layout_name
 */
function himalayanmart_get_footer_layouts() {
    return apply_filters('himalayanmart_footer_layouts', array(
        '4-column'            => __('4-Column Footer (About + 2 Menus + Contact)', 'himalayanmart'),
        'modern-multicolumn'  => __('Modern Multi-Column Footer (Tabs + Newsletter)', 'himalayanmart'),
        'futura-newsletter'   => __('FuturaStays Newsletter (4-Col + Social)', 'himalayanmart'),
    ));
}

/**
 * Get current header layout
 *
 * @return string Layout ID
 */
function himalayanmart_get_current_header_layout() {
    return get_theme_mod('himalayanmart_header_layout', '3-tier');
}

/**
 * Get current footer layout
 *
 * @return string Layout ID
 */
function himalayanmart_get_current_footer_layout() {
    return get_theme_mod('himalayanmart_footer_layout', '4-column');
}

/**
 * Header & Footer Customizer Settings
 */
function himalayanmart_customizer_header_footer($wp_customize) {
    // ==============================================
    // LAYOUT SELECTION PANEL
    // ==============================================
    $wp_customize->add_panel('himalayanmart_layouts_panel', array(
        'title'       => __('Header & Footer Layouts', 'himalayanmart'),
        'priority'    => 25,
        'description' => __('Choose and customize header and footer layouts.', 'himalayanmart'),
    ));

    // ==============================================
    // HEADER LAYOUT SECTION
    // ==============================================
    $wp_customize->add_section('himalayanmart_header_layout_section', array(
        'title'       => __('Header Layout', 'himalayanmart'),
        'panel'       => 'himalayanmart_layouts_panel',
        'priority'    => 10,
        'description' => __('Select your preferred header layout.', 'himalayanmart'),
    ));

    // Header Layout Selection
    $wp_customize->add_setting('himalayanmart_header_layout', array(
        'default'           => '3-tier',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('himalayanmart_header_layout', array(
        'label'       => __('Select Header Layout', 'himalayanmart'),
        'description' => __('Choose a header layout for your site.', 'himalayanmart'),
        'section'     => 'himalayanmart_header_layout_section',
        'type'        => 'select',
        'choices'     => himalayanmart_get_header_layouts(),
    ));

    // ==============================================
    // FOOTER LAYOUT SECTION
    // ==============================================
    $wp_customize->add_section('himalayanmart_footer_layout_section', array(
        'title'       => __('Footer Layout', 'himalayanmart'),
        'panel'       => 'himalayanmart_layouts_panel',
        'priority'    => 20,
        'description' => __('Select your preferred footer layout.', 'himalayanmart'),
    ));

    // Footer Layout Selection
    $wp_customize->add_setting('himalayanmart_footer_layout', array(
        'default'           => '4-column',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('himalayanmart_footer_layout', array(
        'label'       => __('Select Footer Layout', 'himalayanmart'),
        'description' => __('Choose a footer layout for your site.', 'himalayanmart'),
        'section'     => 'himalayanmart_footer_layout_section',
        'type'        => 'select',
        'choices'     => himalayanmart_get_footer_layouts(),
    ));

    // ==============================================
    // HEADER SETTINGS SECTION (3-Tier Header)
    // ==============================================
	$wp_customize->add_section('himalayanmart_header_section', array(
		'title'       => __('3-Tier Header Settings', 'himalayanmart'),
        'panel'       => 'himalayanmart_layouts_panel',
		'priority'    => 30,
		'description' => __('Customize the 3-Tier Header layout (Top Bar + Logo + Navigation).', 'himalayanmart'),
	));

    // Top Bar Text
    $wp_customize->add_setting('himalayanmart_topbar_text', array(
        'default'           => 'Big Sale! Get 50% off on all items this week! Shop Now!',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('himalayanmart_topbar_text', array(
        'label'       => __('Top Bar Promo Text', 'himalayanmart'),
        'section'     => 'himalayanmart_header_section',
        'type'        => 'textarea',
    ));

    // Colors
    $colors = array(
        'himalayanmart_topbar_bg'    => array('default' => '#1e3a8a', 'label' => 'Top Bar Background'),
        'himalayanmart_topbar_text_color'  => array('default' => '#ffffff', 'label' => 'Top Bar Text'),
        'himalayanmart_nav_bg'       => array('default' => '#ffffff', 'label' => 'Navigation Background'),
        'himalayanmart_nav_text'     => array('default' => '#333333', 'label' => 'Navigation Text'),
        'himalayanmart_offcanvas_bg'      => array('default' => '#ffffff', 'label' => 'Off-Canvas Background'),
        'himalayanmart_offcanvas_text'    => array('default' => '#ffffff', 'label' => 'Off-Canvas Text'),
        'himalayanmart_offcanvas_border'  => array('default' => '#000000', 'label' => 'Off-Canvas Border Color'),
    );

    foreach ($colors as $id => $args) {
        $wp_customize->add_setting($id, array(
            'default'           => $args['default'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $id, array(
            'label'    => __($args['label'], 'himalayanmart'),
            'section'  => 'himalayanmart_header_section',
            'settings' => $id,
        )));
    }
    // Off-Canvas Opacity
    $wp_customize->add_setting('himalayanmart_offcanvas_opacity', array(
        'default'           => '100', // Default 100%
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('himalayanmart_offcanvas_opacity', array(
        'label'       => __('Off-Canvas Background Opacity (%)', 'himalayanmart'),
        'section'     => 'himalayanmart_header_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
            'step' => 1,
        ),
    ));

    // ==============================================
    // LOGO SIZE SETTINGS
    // ==============================================

    // Logo Size - Desktop
    $wp_customize->add_setting('himalayanmart_logo_width_desktop', array(
        'default'           => 180,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('himalayanmart_logo_width_desktop', array(
        'label'       => __('Logo Width - Desktop (px)', 'himalayanmart'),
        'description' => __('Logo width on desktop screens (992px and above)', 'himalayanmart'),
        'section'     => 'himalayanmart_header_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 50,
            'max'  => 400,
            'step' => 5,
        ),
    ));

    $wp_customize->add_setting('himalayanmart_logo_height_desktop', array(
        'default'           => 60,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('himalayanmart_logo_height_desktop', array(
        'label'       => __('Logo Max Height - Desktop (px)', 'himalayanmart'),
        'section'     => 'himalayanmart_header_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 20,
            'max'  => 150,
            'step' => 5,
        ),
    ));

    // Logo Size - Tablet
    $wp_customize->add_setting('himalayanmart_logo_width_tablet', array(
        'default'           => 150,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('himalayanmart_logo_width_tablet', array(
        'label'       => __('Logo Width - Tablet (px)', 'himalayanmart'),
        'description' => __('Logo width on tablet screens (768px - 991px)', 'himalayanmart'),
        'section'     => 'himalayanmart_header_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 50,
            'max'  => 300,
            'step' => 5,
        ),
    ));

    $wp_customize->add_setting('himalayanmart_logo_height_tablet', array(
        'default'           => 50,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('himalayanmart_logo_height_tablet', array(
        'label'       => __('Logo Max Height - Tablet (px)', 'himalayanmart'),
        'section'     => 'himalayanmart_header_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 20,
            'max'  => 120,
            'step' => 5,
        ),
    ));

    // Logo Size - Mobile
    $wp_customize->add_setting('himalayanmart_logo_width_mobile', array(
        'default'           => 120,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('himalayanmart_logo_width_mobile', array(
        'label'       => __('Logo Width - Mobile (px)', 'himalayanmart'),
        'description' => __('Logo width on mobile screens (below 768px)', 'himalayanmart'),
        'section'     => 'himalayanmart_header_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 50,
            'max'  => 200,
            'step' => 5,
        ),
    ));

    $wp_customize->add_setting('himalayanmart_logo_height_mobile', array(
        'default'           => 40,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('himalayanmart_logo_height_mobile', array(
        'label'       => __('Logo Max Height - Mobile (px)', 'himalayanmart'),
        'section'     => 'himalayanmart_header_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 20,
            'max'  => 80,
            'step' => 5,
        ),
    ));

    // ==============================================
    // FOOTER SETTINGS SECTION (4-Column Footer)
    // ==============================================
    $wp_customize->add_section('himalayanmart_footer_section', array(
        'title'       => __('4-Column Footer Settings', 'himalayanmart'),
        'panel'       => 'himalayanmart_layouts_panel',
        'priority'    => 40,
        'description' => __('Customize the 4-Column Footer layout (About + 2 Menus + Contact + Copyright).', 'himalayanmart'),
    ));

    // Footer About Section
    $wp_customize->add_setting('himalayanmart_footer_show_logo', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('himalayanmart_footer_show_logo', array(
        'label'   => __('Show Logo in Footer', 'himalayanmart'),
        'section' => 'himalayanmart_footer_section',
        'type'    => 'checkbox',
    ));

    $wp_customize->add_setting('himalayanmart_footer_about_heading', array(
        'default'           => 'About Us',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('himalayanmart_footer_about_heading', array(
        'label'   => __('About Heading', 'himalayanmart'),
        'section' => 'himalayanmart_footer_section',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('himalayanmart_footer_about_text', array(
        'default'           => 'YourStore is your go-to online shop for the best deals on top quality products.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('himalayanmart_footer_about_text', array(
        'label'   => __('About Text', 'himalayanmart'),
        'section' => 'himalayanmart_footer_section',
        'type'    => 'textarea',
    ));

    // Footer Menu Titles
    $wp_customize->add_setting('himalayanmart_footer_menu1_title', array(
        'default'           => 'Customer Service',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('himalayanmart_footer_menu1_title', array(
        'label'   => __('Menu Column 1 Title', 'himalayanmart'),
        'section' => 'himalayanmart_footer_section',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('himalayanmart_footer_menu2_title', array(
        'default'           => 'Information',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('himalayanmart_footer_menu2_title', array(
        'label'   => __('Menu Column 2 Title', 'himalayanmart'),
        'section' => 'himalayanmart_footer_section',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('himalayanmart_footer_contact_title', array(
        'default'           => 'Contact Us',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('himalayanmart_footer_contact_title', array(
        'label'   => __('Contact Column Title', 'himalayanmart'),
        'section' => 'himalayanmart_footer_section',
        'type'    => 'text',
    ));

    // Contact Information
    $wp_customize->add_setting('himalayanmart_footer_phone', array(
        'default'           => '+1 234 567 8900',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('himalayanmart_footer_phone', array(
        'label'   => __('Phone Number', 'himalayanmart'),
        'section' => 'himalayanmart_footer_section',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('himalayanmart_footer_email', array(
        'default'           => 'info@yourstore.com',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('himalayanmart_footer_email', array(
        'label'   => __('Email Address', 'himalayanmart'),
        'section' => 'himalayanmart_footer_section',
        'type'    => 'email',
    ));

    $wp_customize->add_setting('himalayanmart_footer_address', array(
        'default'           => '1234 Market St, Suite 100, Springfield, IL 62701',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('himalayanmart_footer_address', array(
        'label'   => __('Physical Address', 'himalayanmart'),
        'section' => 'himalayanmart_footer_section',
        'type'    => 'textarea',
    ));

    // Social Media URLs
    $socials = array('facebook', 'twitter', 'instagram', 'youtube');
    foreach ($socials as $social) {
        $wp_customize->add_setting('himalayanmart_footer_' . $social, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('himalayanmart_footer_' . $social, array(
            'label'   => __(ucfirst($social) . ' URL', 'himalayanmart'),
            'section' => 'himalayanmart_footer_section',
            'type'    => 'url',
        ));
    }

    // Copyright Text
    $wp_customize->add_setting('himalayanmart_footer_copyright', array(
        'default'           => '© [year] [sitename]. All rights reserved.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('himalayanmart_footer_copyright', array(
        'label'       => __('Copyright Text', 'himalayanmart'),
        'description' => __('Use [year] for current year and [sitename] for site name.', 'himalayanmart'),
        'section'     => 'himalayanmart_footer_section',
        'type'        => 'textarea',
    ));

    // ==============================================
    // FOOTER HEIGHT/PADDING SETTINGS
    // ==============================================

    // Main Footer Padding Top
    $wp_customize->add_setting('himalayanmart_footer_padding_top', array(
        'default'           => 60,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('himalayanmart_footer_padding_top', array(
        'label'       => __('Main Footer Padding Top (px)', 'himalayanmart'),
        'description' => __('Adjust the top padding of the main footer section', 'himalayanmart'),
        'section'     => 'himalayanmart_footer_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 200,
            'step' => 5,
        ),
    ));

    // Main Footer Padding Bottom
    $wp_customize->add_setting('himalayanmart_footer_padding_bottom', array(
        'default'           => 60,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('himalayanmart_footer_padding_bottom', array(
        'label'       => __('Main Footer Padding Bottom (px)', 'himalayanmart'),
        'description' => __('Adjust the bottom padding of the main footer section', 'himalayanmart'),
        'section'     => 'himalayanmart_footer_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 200,
            'step' => 5,
        ),
    ));

    // Copyright Section Padding Top
    $wp_customize->add_setting('himalayanmart_copyright_padding_top', array(
        'default'           => 20,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('himalayanmart_copyright_padding_top', array(
        'label'       => __('Copyright Bar Padding Top (px)', 'himalayanmart'),
        'description' => __('Adjust the top padding of the copyright section', 'himalayanmart'),
        'section'     => 'himalayanmart_footer_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
            'step' => 5,
        ),
    ));

    // Copyright Section Padding Bottom
    $wp_customize->add_setting('himalayanmart_copyright_padding_bottom', array(
        'default'           => 20,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('himalayanmart_copyright_padding_bottom', array(
        'label'       => __('Copyright Bar Padding Bottom (px)', 'himalayanmart'),
        'description' => __('Adjust the bottom padding of the copyright section', 'himalayanmart'),
        'section'     => 'himalayanmart_footer_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
            'step' => 5,
        ),
    ));

    // Footer Colors
    $footer_colors = array(
        'himalayanmart_footer_bg'         => array('default' => '#2c3e50', 'label' => 'Footer Background'),
        'himalayanmart_footer_text'       => array('default' => '#ecf0f1', 'label' => 'Footer Text'),
        'himalayanmart_footer_heading'    => array('default' => '#ffffff', 'label' => 'Footer Headings'),
        'himalayanmart_footer_link'       => array('default' => '#ecf0f1', 'label' => 'Footer Links'),
        'himalayanmart_footer_link_hover' => array('default' => '#ffffff', 'label' => 'Footer Link Hover'),
        'himalayanmart_footer_bottom_bg'  => array('default' => '#1a252f', 'label' => 'Copyright Bar Background'),
        'himalayanmart_footer_bottom_text' => array('default' => '#95a5a6', 'label' => 'Copyright Bar Text'),
    );

    foreach ($footer_colors as $id => $args) {
        $wp_customize->add_setting($id, array(
            'default'           => $args['default'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $id, array(
            'label'    => __($args['label'], 'himalayanmart'),
            'section'  => 'himalayanmart_footer_section',
            'settings' => $id,
        )));
    }

    // ==============================================
    // MODERN GLASS HEADER SETTINGS
    // ==============================================
    $wp_customize->add_section('himalayanmart_modern_header_section', array(
        'title'       => __('Modern Glass Header Settings', 'himalayanmart'),
        'panel'       => 'himalayanmart_layouts_panel',
        'priority'    => 35,
        'description' => __('Customize the Modern Glass Header layout.', 'himalayanmart'),
    ));

    // --- ANNOUNCEMENT BAR SETTINGS ---
    $wp_customize->add_setting('hm_modern_header_announcement_heading', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'hm_modern_header_announcement_heading', array(
        'label'       => __('── Announcement Bar ──', 'himalayanmart'),
        'section'     => 'himalayanmart_modern_header_section',
        'type'        => 'hidden',
        'description' => __('Configure the announcement bar appearance.', 'himalayanmart'),
    )));

    // Show Announcement Bar
    $wp_customize->add_setting('hm_modern_header_show_announcement', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hm_modern_header_show_announcement', array(
        'label'   => __('Show Announcement Bar', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
        'type'    => 'checkbox',
    ));

    // Announcement Text
    $wp_customize->add_setting('hm_modern_header_announcement_text', array(
        'default'           => 'Free shipping on orders over $50! Shop Now',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hm_modern_header_announcement_text', array(
        'label'   => __('Announcement Text', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
        'type'    => 'textarea',
    ));

    // Announcement Bar Style
    $wp_customize->add_setting('hm_modern_header_announcement_style', array(
        'default'           => 'solid',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hm_modern_header_announcement_style', array(
        'label'   => __('Announcement Bar Style', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
        'type'    => 'select',
        'choices' => array(
            'solid'    => __('Solid Color', 'himalayanmart'),
            'gradient' => __('Gradient', 'himalayanmart'),
        ),
    ));

    // Announcement Bar Background Color
    $wp_customize->add_setting('hm_modern_header_announcement_bg', array(
        'default'           => '#3b82f6',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hm_modern_header_announcement_bg', array(
        'label'   => __('Announcement Background Color', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
    )));

    // Announcement Bar Gradient Start
    $wp_customize->add_setting('hm_modern_header_announcement_gradient_from', array(
        'default'           => '#3b82f6',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hm_modern_header_announcement_gradient_from', array(
        'label'       => __('Announcement Gradient Start', 'himalayanmart'),
        'description' => __('Used when Gradient style is selected.', 'himalayanmart'),
        'section'     => 'himalayanmart_modern_header_section',
    )));

    // Announcement Bar Gradient End
    $wp_customize->add_setting('hm_modern_header_announcement_gradient_to', array(
        'default'           => '#8b5cf6',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hm_modern_header_announcement_gradient_to', array(
        'label'   => __('Announcement Gradient End', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
    )));

    // Announcement Bar Text Color
    $wp_customize->add_setting('hm_modern_header_announcement_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hm_modern_header_announcement_text_color', array(
        'label'   => __('Announcement Text Color', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
    )));

    // --- MAIN HEADER SETTINGS ---
    $wp_customize->add_setting('hm_modern_header_main_heading', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'hm_modern_header_main_heading', array(
        'label'       => __('── Main Header ──', 'himalayanmart'),
        'section'     => 'himalayanmart_modern_header_section',
        'type'        => 'hidden',
        'description' => __('Configure the main header appearance.', 'himalayanmart'),
    )));

    // Sticky Header
    $wp_customize->add_setting('hm_modern_header_sticky', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hm_modern_header_sticky', array(
        'label'   => __('Enable Sticky Header', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
        'type'    => 'checkbox',
    ));

    // Header Style
    $wp_customize->add_setting('hm_modern_header_style', array(
        'default'           => 'glass',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hm_modern_header_style', array(
        'label'   => __('Header Style', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
        'type'    => 'select',
        'choices' => array(
            'glass'    => __('Glassmorphism (Blur effect)', 'himalayanmart'),
            'solid'    => __('Solid Background', 'himalayanmart'),
            'gradient' => __('Gradient Background', 'himalayanmart'),
        ),
    ));

    // Header Background Color
    $wp_customize->add_setting('hm_modern_header_bg', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hm_modern_header_bg', array(
        'label'   => __('Header Background Color', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
    )));

    // Header Text Color
    $wp_customize->add_setting('hm_modern_header_text', array(
        'default'           => '#1f2937',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hm_modern_header_text', array(
        'label'   => __('Header Text Color', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
    )));

    // Header Gradient Start
    $wp_customize->add_setting('hm_modern_header_gradient_from', array(
        'default'           => '#3b82f6',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hm_modern_header_gradient_from', array(
        'label'       => __('Header Gradient Start', 'himalayanmart'),
        'description' => __('Used when Gradient style is selected.', 'himalayanmart'),
        'section'     => 'himalayanmart_modern_header_section',
    )));

    // Header Gradient End
    $wp_customize->add_setting('hm_modern_header_gradient_to', array(
        'default'           => '#8b5cf6',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hm_modern_header_gradient_to', array(
        'label'   => __('Header Gradient End', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
    )));

    // Header Background Opacity (for glass effect)
    $wp_customize->add_setting('hm_modern_header_bg_opacity', array(
        'default'           => 85,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hm_modern_header_bg_opacity', array(
        'label'       => __('Header Background Opacity (%)', 'himalayanmart'),
        'description' => __('For glassmorphism effect. 0 = transparent, 100 = solid.', 'himalayanmart'),
        'section'     => 'himalayanmart_modern_header_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
            'step' => 5,
        ),
    ));

    // Accent Color
    $wp_customize->add_setting('hm_modern_header_accent', array(
        'default'           => '#3b82f6',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hm_modern_header_accent', array(
        'label'   => __('Accent Color', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
    )));

    // Icon Opacity
    $wp_customize->add_setting('hm_modern_header_icon_opacity', array(
        'default'           => 100,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hm_modern_header_icon_opacity', array(
        'label'       => __('Icon Opacity (%)', 'himalayanmart'),
        'section'     => 'himalayanmart_modern_header_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 20,
            'max'  => 100,
            'step' => 5,
        ),
    ));

    // --- SCROLL BEHAVIOR SETTINGS ---
    $wp_customize->add_setting('hm_modern_header_scroll_heading', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'hm_modern_header_scroll_heading', array(
        'label'       => __('── Scroll Behavior ──', 'himalayanmart'),
        'section'     => 'himalayanmart_modern_header_section',
        'type'        => 'hidden',
        'description' => __('Configure header appearance when scrolling.', 'himalayanmart'),
    )));

    // Show Announcement on Scroll
    $wp_customize->add_setting('hm_modern_header_announcement_on_scroll', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hm_modern_header_announcement_on_scroll', array(
        'label'       => __('Show Announcement Bar on Scroll', 'himalayanmart'),
        'description' => __('Keep announcement bar visible when header is sticky.', 'himalayanmart'),
        'section'     => 'himalayanmart_modern_header_section',
        'type'        => 'checkbox',
    ));

    // Scrolled Header Background Color
    $wp_customize->add_setting('hm_modern_header_scroll_bg', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hm_modern_header_scroll_bg', array(
        'label'   => __('Scrolled Header Background', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
    )));

    // Scrolled Header Text Color
    $wp_customize->add_setting('hm_modern_header_scroll_text', array(
        'default'           => '#1f2937',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hm_modern_header_scroll_text', array(
        'label'   => __('Scrolled Header Text Color', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
    )));

    // Scrolled Header Background Opacity
    $wp_customize->add_setting('hm_modern_header_scroll_bg_opacity', array(
        'default'           => 95,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hm_modern_header_scroll_bg_opacity', array(
        'label'       => __('Scrolled Header Opacity (%)', 'himalayanmart'),
        'section'     => 'himalayanmart_modern_header_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
            'step' => 5,
        ),
    ));

    // Scrolled Icon Opacity
    $wp_customize->add_setting('hm_modern_header_scroll_icon_opacity', array(
        'default'           => 100,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hm_modern_header_scroll_icon_opacity', array(
        'label'       => __('Scrolled Icon Opacity (%)', 'himalayanmart'),
        'section'     => 'himalayanmart_modern_header_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 20,
            'max'  => 100,
            'step' => 5,
        ),
    ));

    // Scrolled Announcement Background
    $wp_customize->add_setting('hm_modern_header_scroll_announcement_bg', array(
        'default'           => '#1f2937',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hm_modern_header_scroll_announcement_bg', array(
        'label'       => __('Scrolled Announcement Background', 'himalayanmart'),
        'description' => __('Used when announcement is visible on scroll.', 'himalayanmart'),
        'section'     => 'himalayanmart_modern_header_section',
    )));

    // Scrolled Announcement Text Color
    $wp_customize->add_setting('hm_modern_header_scroll_announcement_text', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hm_modern_header_scroll_announcement_text', array(
        'label'   => __('Scrolled Announcement Text', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
    )));

    // Scrolled Announcement Opacity
    $wp_customize->add_setting('hm_modern_header_scroll_announcement_opacity', array(
        'default'           => 90,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hm_modern_header_scroll_announcement_opacity', array(
        'label'       => __('Scrolled Announcement Opacity (%)', 'himalayanmart'),
        'section'     => 'himalayanmart_modern_header_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
            'step' => 5,
        ),
    ));

    // --- ICON VISIBILITY SETTINGS ---
    $wp_customize->add_setting('hm_modern_header_icons_heading', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'hm_modern_header_icons_heading', array(
        'label'       => __('── Icons & Elements ──', 'himalayanmart'),
        'section'     => 'himalayanmart_modern_header_section',
        'type'        => 'hidden',
        'description' => __('Toggle header icons visibility.', 'himalayanmart'),
    )));

    // Show Search
    $wp_customize->add_setting('hm_modern_header_show_search', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('hm_modern_header_show_search', array(
        'label'   => __('Show Search Icon', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
        'type'    => 'checkbox',
    ));

    // Show Cart
    $wp_customize->add_setting('hm_modern_header_show_cart', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('hm_modern_header_show_cart', array(
        'label'   => __('Show Cart Icon', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
        'type'    => 'checkbox',
    ));

    // Show Account
    $wp_customize->add_setting('hm_modern_header_show_account', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('hm_modern_header_show_account', array(
        'label'   => __('Show Account Icon', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
        'type'    => 'checkbox',
    ));

    // --- MOBILE MENU SETTINGS ---
    $wp_customize->add_setting('hm_modern_header_mobile_heading', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'hm_modern_header_mobile_heading', array(
        'label'       => __('── Mobile Menu ──', 'himalayanmart'),
        'section'     => 'himalayanmart_modern_header_section',
        'type'        => 'hidden',
        'description' => __('Configure mobile menu behavior.', 'himalayanmart'),
    )));

    // Mobile Sticky Announcement
    $wp_customize->add_setting('hm_modern_header_mobile_sticky_announcement', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hm_modern_header_mobile_sticky_announcement', array(
        'label'       => __('Sticky Announcement on Mobile', 'himalayanmart'),
        'description' => __('Keep announcement bar fixed at top on mobile devices.', 'himalayanmart'),
        'section'     => 'himalayanmart_modern_header_section',
        'type'        => 'checkbox',
    ));

    // Canvas Panel Position
    $wp_customize->add_setting('hm_modern_header_canvas_position', array(
        'default'           => 'left',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hm_modern_header_canvas_position', array(
        'label'   => __('Mobile Menu Position', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
        'type'    => 'select',
        'choices' => array(
            'left'  => __('Slide from Left', 'himalayanmart'),
            'right' => __('Slide from Right', 'himalayanmart'),
        ),
    ));

    // Canvas Panel Width
    $wp_customize->add_setting('hm_modern_header_canvas_width', array(
        'default'           => '70',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hm_modern_header_canvas_width', array(
        'label'       => __('Mobile Menu Width (%)', 'himalayanmart'),
        'section'     => 'himalayanmart_modern_header_section',
        'type'        => 'select',
        'choices'     => array(
            '50'  => __('50% of screen', 'himalayanmart'),
            '70'  => __('70% of screen', 'himalayanmart'),
            '85'  => __('85% of screen', 'himalayanmart'),
            '100' => __('Full screen', 'himalayanmart'),
        ),
    ));

    // Canvas Close Button Color
    $wp_customize->add_setting('hm_modern_header_canvas_close_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hm_modern_header_canvas_close_color', array(
        'label'   => __('Mobile Menu Close Button Color', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
    )));

    // ==============================================
    // MODERN MULTI-COLUMN FOOTER SETTINGS
    // ==============================================
    $wp_customize->add_section('himalayanmart_modern_footer_section', array(
        'title'       => __('Modern Multi-Column Footer Settings', 'himalayanmart'),
        'panel'       => 'himalayanmart_layouts_panel',
        'priority'    => 45,
        'description' => __('Customize the Modern Multi-Column Footer layout.', 'himalayanmart'),
    ));

    // Show Tab Navigation
    $wp_customize->add_setting('hm_modern_footer_show_tabs', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('hm_modern_footer_show_tabs', array(
        'label'   => __('Show Tab Navigation', 'himalayanmart'),
        'section' => 'himalayanmart_modern_footer_section',
        'type'    => 'checkbox',
    ));

    // Show Newsletter
    $wp_customize->add_setting('hm_modern_footer_show_newsletter', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('hm_modern_footer_show_newsletter', array(
        'label'   => __('Show Newsletter Section', 'himalayanmart'),
        'section' => 'himalayanmart_modern_footer_section',
        'type'    => 'checkbox',
    ));

    // Newsletter Title
    $wp_customize->add_setting('hm_modern_footer_newsletter_title', array(
        'default'           => 'Subscribe to our Newsletter',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hm_modern_footer_newsletter_title', array(
        'label'   => __('Newsletter Title', 'himalayanmart'),
        'section' => 'himalayanmart_modern_footer_section',
        'type'    => 'text',
    ));

    // Newsletter Subtitle
    $wp_customize->add_setting('hm_modern_footer_newsletter_subtitle', array(
        'default'           => 'Get the latest updates, deals and exclusive offers.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hm_modern_footer_newsletter_subtitle', array(
        'label'   => __('Newsletter Subtitle', 'himalayanmart'),
        'section' => 'himalayanmart_modern_footer_section',
        'type'    => 'textarea',
    ));

    // Show App Badges
    $wp_customize->add_setting('hm_modern_footer_show_app_badges', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('hm_modern_footer_show_app_badges', array(
        'label'   => __('Show App Download Badges', 'himalayanmart'),
        'section' => 'himalayanmart_modern_footer_section',
        'type'    => 'checkbox',
    ));

    // --- FOOTER COLUMN BORDERS ---
    $wp_customize->add_setting('hm_modern_footer_borders_heading', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'hm_modern_footer_borders_heading', array(
        'label'       => __('── Column Borders ──', 'himalayanmart'),
        'section'     => 'himalayanmart_modern_footer_section',
        'type'        => 'hidden',
        'description' => __('Add glowing borders between footer columns.', 'himalayanmart'),
    )));

    // Show Column Borders
    $wp_customize->add_setting('hm_modern_footer_show_borders', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('hm_modern_footer_show_borders', array(
        'label'   => __('Show Column Borders', 'himalayanmart'),
        'section' => 'himalayanmart_modern_footer_section',
        'type'    => 'checkbox',
    ));

    // Border Color
    $wp_customize->add_setting('hm_modern_footer_border_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hm_modern_footer_border_color', array(
        'label'   => __('Border Color', 'himalayanmart'),
        'section' => 'himalayanmart_modern_footer_section',
    )));

    // Border Glow Intensity
    $wp_customize->add_setting('hm_modern_footer_border_glow', array(
        'default'           => 50,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hm_modern_footer_border_glow', array(
        'label'       => __('Border Glow Intensity (%)', 'himalayanmart'),
        'section'     => 'himalayanmart_modern_footer_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
            'step' => 5,
        ),
    ));

    // Border Height Percentage
    $wp_customize->add_setting('hm_modern_footer_border_height', array(
        'default'           => 50,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hm_modern_footer_border_height', array(
        'label'       => __('Border Height (%)', 'himalayanmart'),
        'description' => __('Height of border relative to column. 50% = half height, centered.', 'himalayanmart'),
        'section'     => 'himalayanmart_modern_footer_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 20,
            'max'  => 100,
            'step' => 5,
        ),
    ));

    // Border Opacity
    $wp_customize->add_setting('hm_modern_footer_border_opacity', array(
        'default'           => 30,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hm_modern_footer_border_opacity', array(
        'label'       => __('Border Opacity (%)', 'himalayanmart'),
        'section'     => 'himalayanmart_modern_footer_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 10,
            'max'  => 100,
            'step' => 5,
        ),
    ));

    // Modern Footer Colors
    $modern_footer_colors = array(
        'hm_modern_footer_bg'            => array('default' => '#111827', 'label' => 'Footer Background'),
        'hm_modern_footer_text'          => array('default' => '#9ca3af', 'label' => 'Footer Text Color'),
        'hm_modern_footer_heading'       => array('default' => '#ffffff', 'label' => 'Footer Headings'),
        'hm_modern_footer_link'          => array('default' => '#9ca3af', 'label' => 'Footer Link Color'),
        'hm_modern_footer_link_hover'    => array('default' => '#3b82f6', 'label' => 'Footer Link Hover'),
        'hm_modern_footer_tabs_bg'       => array('default' => '#1f2937', 'label' => 'Tab Navigation Background'),
        'hm_modern_footer_newsletter_bg' => array('default' => '#1f2937', 'label' => 'Newsletter Background'),
        'hm_modern_footer_accent'        => array('default' => '#3b82f6', 'label' => 'Accent Color'),
        'hm_modern_footer_bottom_bg'     => array('default' => '#030712', 'label' => 'Copyright Bar Background'),
    );

    foreach ($modern_footer_colors as $id => $args) {
        $wp_customize->add_setting($id, array(
            'default'           => $args['default'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $id, array(
            'label'   => __($args['label'], 'himalayanmart'),
            'section' => 'himalayanmart_modern_footer_section',
        )));
    }
    // --- QUICK ACCESS BUTTONS ---
    $wp_customize->add_setting('hm_modern_header_quick_access_heading', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'hm_modern_header_quick_access_heading', array(
        'label'       => __('── Quick Access Buttons (Mobile) ──', 'himalayanmart'),
        'section'     => 'himalayanmart_modern_header_section',
        'type'        => 'hidden',
        'description' => __('Customize the 3 quick access buttons in the mobile menu.', 'himalayanmart'),
    )));

    // Global Icon Settings
    $wp_customize->add_setting('hm_modern_header_btn_icon_size', array(
        'default'           => 18,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hm_modern_header_btn_icon_size', array(
        'label'       => __('Icon Size (px)', 'himalayanmart'),
        'description' => __('Size of icons for all buttons', 'himalayanmart'),
        'section'     => 'himalayanmart_modern_header_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 48,
            'step' => 2,
        ),
    ));

    $wp_customize->add_setting('hm_modern_header_btn_icon_color', array(
        'default'           => '#374151',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hm_modern_header_btn_icon_color', array(
        'label'   => __('Icon Color', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
    )));

    // Button 1
    $wp_customize->add_setting('hm_modern_header_btn1_text', array(
        'default'           => 'Shop',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hm_modern_header_btn1_text', array(
        'label'   => __('Button 1 Text', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('hm_modern_header_btn1_url', array(
        'default'           => '/shop/',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hm_modern_header_btn1_url', array(
        'label'   => __('Button 1 Link', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
        'type'    => 'url',
    ));

    $wp_customize->add_setting('hm_modern_header_btn1_icon_type', array(
        'default'           => 'preset',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hm_modern_header_btn1_icon_type', array(
        'label'   => __('Button 1 Icon Type', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
        'type'    => 'select',
        'choices' => array(
            'preset' => __('Preset Icon', 'himalayanmart'),
            'custom' => __('Custom SVG Upload', 'himalayanmart'),
        ),
    ));

    $wp_customize->add_setting('hm_modern_header_btn1_icon', array(
        'default'           => 'shop',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hm_modern_header_btn1_icon', array(
        'label'   => __('Button 1 Preset Icon', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
        'type'    => 'select',
        'choices' => array(
            'shop'     => 'Shop Bag',
            'homestay' => 'Homestay/House',
            'offers'   => 'Gift/Offers',
            'user'     => 'User/Account',
            'heart'    => 'Heart/Wishlist',
            'search'   => 'Search',
            'phone'    => 'Phone',
            'home'     => 'Home',
            'cart'     => 'Cart',
            'star'     => 'Star',
            'map'      => 'Map Pin',
            'mail'     => 'Email',
        ),
    ));

    $wp_customize->add_setting('hm_modern_header_btn1_custom_icon', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'hm_modern_header_btn1_custom_icon', array(
        'label'     => __('Button 1 Custom SVG', 'himalayanmart'),
        'description' => __('Upload an SVG icon', 'himalayanmart'),
        'section'   => 'himalayanmart_modern_header_section',
        'mime_type' => 'image',
    )));

    // Button 2
    $wp_customize->add_setting('hm_modern_header_btn2_text', array(
        'default'           => 'Homestays',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hm_modern_header_btn2_text', array(
        'label'   => __('Button 2 Text', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('hm_modern_header_btn2_url', array(
        'default'           => '/homestay/',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hm_modern_header_btn2_url', array(
        'label'   => __('Button 2 Link', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
        'type'    => 'url',
    ));

    $wp_customize->add_setting('hm_modern_header_btn2_icon_type', array(
        'default'           => 'preset',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hm_modern_header_btn2_icon_type', array(
        'label'   => __('Button 2 Icon Type', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
        'type'    => 'select',
        'choices' => array(
            'preset' => __('Preset Icon', 'himalayanmart'),
            'custom' => __('Custom SVG Upload', 'himalayanmart'),
        ),
    ));

    $wp_customize->add_setting('hm_modern_header_btn2_icon', array(
        'default'           => 'homestay',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hm_modern_header_btn2_icon', array(
        'label'   => __('Button 2 Preset Icon', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
        'type'    => 'select',
        'choices' => array(
            'shop'     => 'Shop Bag',
            'homestay' => 'Homestay/House',
            'offers'   => 'Gift/Offers',
            'user'     => 'User/Account',
            'heart'    => 'Heart/Wishlist',
            'search'   => 'Search',
            'phone'    => 'Phone',
            'home'     => 'Home',
            'cart'     => 'Cart',
            'star'     => 'Star',
            'map'      => 'Map Pin',
            'mail'     => 'Email',
        ),
    ));

    $wp_customize->add_setting('hm_modern_header_btn2_custom_icon', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'hm_modern_header_btn2_custom_icon', array(
        'label'     => __('Button 2 Custom SVG', 'himalayanmart'),
        'description' => __('Upload an SVG icon', 'himalayanmart'),
        'section'   => 'himalayanmart_modern_header_section',
        'mime_type' => 'image',
    )));

    // Button 3
    $wp_customize->add_setting('hm_modern_header_btn3_text', array(
        'default'           => 'Offers',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hm_modern_header_btn3_text', array(
        'label'   => __('Button 3 Text', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('hm_modern_header_btn3_url', array(
        'default'           => '/offers/',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hm_modern_header_btn3_url', array(
        'label'   => __('Button 3 Link', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
        'type'    => 'url',
    ));

    $wp_customize->add_setting('hm_modern_header_btn3_icon_type', array(
        'default'           => 'preset',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hm_modern_header_btn3_icon_type', array(
        'label'   => __('Button 3 Icon Type', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
        'type'    => 'select',
        'choices' => array(
            'preset' => __('Preset Icon', 'himalayanmart'),
            'custom' => __('Custom SVG Upload', 'himalayanmart'),
        ),
    ));

    $wp_customize->add_setting('hm_modern_header_btn3_icon', array(
        'default'           => 'offers',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hm_modern_header_btn3_icon', array(
        'label'   => __('Button 3 Preset Icon', 'himalayanmart'),
        'section' => 'himalayanmart_modern_header_section',
        'type'    => 'select',
        'choices' => array(
            'shop'     => 'Shop Bag',
            'homestay' => 'Homestay/House',
            'offers'   => 'Gift/Offers',
            'user'     => 'User/Account',
            'heart'    => 'Heart/Wishlist',
            'search'   => 'Search',
            'phone'    => 'Phone',
            'home'     => 'Home',
            'cart'     => 'Cart',
            'star'     => 'Star',
            'map'      => 'Map Pin',
            'mail'     => 'Email',
        ),
    ));

    $wp_customize->add_setting('hm_modern_header_btn3_custom_icon', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'hm_modern_header_btn3_custom_icon', array(
        'label'     => __('Button 3 Custom SVG', 'himalayanmart'),
        'description' => __('Upload an SVG icon', 'himalayanmart'),
        'section'   => 'himalayanmart_modern_header_section',
        'mime_type' => 'image',
    )));

    // ==============================================
    // FUTURASTAYS GLASS HEADER SETTINGS
    // ==============================================
    $wp_customize->add_section('hm_futura_header_section', array(
        'title'       => __('FuturaStays Header Settings', 'himalayanmart'),
        'panel'       => 'himalayanmart_layouts_panel',
        'priority'    => 36,
        'description' => __('Customize the FuturaStays Glass Header (Mega Menu + Search).', 'himalayanmart'),
    ));

    // --- Announcement Bar ---
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

    // Announcement BG Color
    $wp_customize->add_setting('hm_futura_header_announcement_bg', array(
        'default' => '#e85e30', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hm_futura_header_announcement_bg', array(
        'label' => __('Announcement BG Color', 'himalayanmart'), 'section' => 'hm_futura_header_section',
    )));

    // Announcement Text Color
    $wp_customize->add_setting('hm_futura_header_announcement_text_color', array(
        'default' => '#ffffff', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hm_futura_header_announcement_text_color', array(
        'label' => __('Announcement Text Color', 'himalayanmart'), 'section' => 'hm_futura_header_section',
    )));

    // Nav Text Color
    $wp_customize->add_setting('hm_futura_header_nav_text_color', array(
        'default' => '#334155', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hm_futura_header_nav_text_color', array(
        'label' => __('Navigation Text Color', 'himalayanmart'), 'section' => 'hm_futura_header_section',
    )));

    // ==============================================
    // FUTURASTAYS NEWSLETTER FOOTER SETTINGS
    // ==============================================
    $wp_customize->add_section('hm_futura_footer_section', array(
        'title'       => __('FuturaStays Footer Settings', 'himalayanmart'),
        'panel'       => 'himalayanmart_layouts_panel',
        'priority'    => 45,
        'description' => __('Customize the FuturaStays Newsletter Footer.', 'himalayanmart'),
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

    // Footer Colors
    $futura_footer_colors = array(
        'hm_futura_footer_bg'            => array('default' => '#ffffff', 'label' => 'Footer Background'),
        'hm_futura_footer_text_color'    => array('default' => '#475569', 'label' => 'Footer Text Color'),
        'hm_futura_footer_heading_color' => array('default' => '#e85e30', 'label' => 'Column Heading Color'),
    );
    foreach ($futura_footer_colors as $id => $args) {
        $wp_customize->add_setting($id, array(
            'default' => $args['default'], 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'refresh',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $id, array(
            'label' => __($args['label'], 'himalayanmart'), 'section' => 'hm_futura_footer_section',
        )));
    }
    // ==============================================
    // BECOME-A-HOST PAGE SETTINGS
    // ==============================================
    $wp_customize->add_section('hm_host_page_section', array(
        'title'       => __('Become-a-Host Page', 'himalayanmart'),
        'panel'       => 'himalayanmart_layouts_panel',
        'priority'    => 50,
        'description' => __('Customize the Become-a-Host landing page hero and content.', 'himalayanmart'),
    ));

    // Hero Image
    $wp_customize->add_setting('hm_host_hero_image', array(
        'default' => '', 'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'hm_host_hero_image', array(
        'label'     => __('Hero Background Image', 'himalayanmart'),
        'section'   => 'hm_host_page_section',
        'mime_type' => 'image',
    )));

    // Hero text fields
    $host_text_fields = array(
        'hm_host_hero_badge'    => array('default' => 'Host the Future', 'label' => 'Hero Badge Text'),
        'hm_host_hero_title'    => array('default' => 'Share Your World.<br>Become a <span class="text-primary">Host.</span>', 'label' => 'Hero Title (HTML allowed)'),
        'hm_host_hero_subtitle' => array('default' => 'Join our exclusive community of premium mountain retreats and unique homestays.', 'label' => 'Hero Subtitle'),
        'hm_host_step1_title'   => array('default' => 'Apply Online', 'label' => 'Step 1 Title'),
        'hm_host_step1_desc'    => array('default' => 'Submit your property details and photos through this form.', 'label' => 'Step 1 Description'),
        'hm_host_step2_title'   => array('default' => 'Manual Review', 'label' => 'Step 2 Title'),
        'hm_host_step2_desc'    => array('default' => 'Our team reviews every application within 48 hours.', 'label' => 'Step 2 Description'),
        'hm_host_step3_title'   => array('default' => 'Onboarding', 'label' => 'Step 3 Title'),
        'hm_host_step3_desc'    => array('default' => 'Once approved, we help you set up your profile.', 'label' => 'Step 3 Description'),
        'hm_host_benefit1'      => array('default' => 'Reach thousands of verified travelers', 'label' => 'Benefit 1'),
        'hm_host_benefit2'      => array('default' => 'Dedicated host support & assistance', 'label' => 'Benefit 2'),
        'hm_host_benefit3'      => array('default' => '24/7 customer support for your guests', 'label' => 'Benefit 3'),
    );

    foreach ($host_text_fields as $id => $args) {
        $sanitize = (strpos($id, 'title') !== false && strpos($id, 'step') === false) ? 'wp_kses_post' : 'sanitize_text_field';
        $wp_customize->add_setting($id, array(
            'default' => $args['default'], 'sanitize_callback' => $sanitize, 'transport' => 'refresh',
        ));
        $wp_customize->add_control($id, array(
            'label'   => __($args['label'], 'himalayanmart'),
            'section' => 'hm_host_page_section',
            'type'    => (strpos($id, 'desc') !== false || strpos($id, 'subtitle') !== false) ? 'textarea' : 'text',
        ));
    }

}
add_action('customize_register', 'himalayanmart_customizer_header_footer');

function himalayanmart_hex2rgb($hex) {
    $hex = str_replace("#", "", $hex);
    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }
    return "$r, $g, $b";
}

function himalayanmart_customizer_css() {
    $offcanvas_bg_hex = get_theme_mod('himalayanmart_offcanvas_bg', '#ffffff');
    $offcanvas_opacity_val = get_theme_mod('himalayanmart_offcanvas_opacity', '100');
    // Ensure opacity is a float between 0 and 1
    $offcanvas_opacity = floatval($offcanvas_opacity_val) / 100;

    // Fallback if hex is invalid
    if (empty($offcanvas_bg_hex)) $offcanvas_bg_hex = '#ffffff';

    $offcanvas_rgb = himalayanmart_hex2rgb($offcanvas_bg_hex);
    $offcanvas_rgba = "rgba($offcanvas_rgb, $offcanvas_opacity)";

    // Logo sizes
    $logo_width_desktop  = get_theme_mod('himalayanmart_logo_width_desktop', 180);
    $logo_height_desktop = get_theme_mod('himalayanmart_logo_height_desktop', 60);
    $logo_width_tablet   = get_theme_mod('himalayanmart_logo_width_tablet', 150);
    $logo_height_tablet  = get_theme_mod('himalayanmart_logo_height_tablet', 50);
    $logo_width_mobile   = get_theme_mod('himalayanmart_logo_width_mobile', 120);
    $logo_height_mobile  = get_theme_mod('himalayanmart_logo_height_mobile', 40);
    ?>
    <style type="text/css">
        /* Customizer CSS Generated at <?php echo date('Y-m-d H:i:s'); ?> */
        :root {
            --hm-topbar-bg: <?php echo esc_attr(get_theme_mod('himalayanmart_topbar_bg', '#1e3a8a')); ?>;
            --hm-topbar-text: <?php echo esc_attr(get_theme_mod('himalayanmart_topbar_text_color', '#ffffff')); ?>;
            --hm-nav-bg: <?php echo esc_attr(get_theme_mod('himalayanmart_nav_bg', '#ffffff')); ?>;
            --hm-nav-text: <?php echo esc_attr(get_theme_mod('himalayanmart_nav_text', '#333333')); ?>;
            --hm-offcanvas-bg: <?php echo $offcanvas_rgba; ?>;
            --hm-offcanvas-text: <?php echo esc_attr(get_theme_mod('himalayanmart_offcanvas_text', '#ffffff')); ?>;
            --hm-offcanvas-border: <?php echo esc_attr(get_theme_mod('himalayanmart_offcanvas_border', '#000000')); ?>;

            /* Footer Variables */
            --hm-footer-bg: <?php echo esc_attr(get_theme_mod('himalayanmart_footer_bg', '#2c3e50')); ?>;
            --hm-footer-text: <?php echo esc_attr(get_theme_mod('himalayanmart_footer_text', '#ecf0f1')); ?>;
            --hm-footer-heading: <?php echo esc_attr(get_theme_mod('himalayanmart_footer_heading', '#ffffff')); ?>;
            --hm-footer-link: <?php echo esc_attr(get_theme_mod('himalayanmart_footer_link', '#ecf0f1')); ?>;
            --hm-footer-link-hover: <?php echo esc_attr(get_theme_mod('himalayanmart_footer_link_hover', '#ffffff')); ?>;
            --hm-footer-bottom-bg: <?php echo esc_attr(get_theme_mod('himalayanmart_footer_bottom_bg', '#1a252f')); ?>;
            --hm-footer-bottom-text: <?php echo esc_attr(get_theme_mod('himalayanmart_footer_bottom_text', '#95a5a6')); ?>;

            /* Footer Height/Padding Variables */
            --hm-footer-padding-top: <?php echo esc_attr(get_theme_mod('himalayanmart_footer_padding_top', 60)); ?>px;
            --hm-footer-padding-bottom: <?php echo esc_attr(get_theme_mod('himalayanmart_footer_padding_bottom', 60)); ?>px;
            --hm-copyright-padding-top: <?php echo esc_attr(get_theme_mod('himalayanmart_copyright_padding_top', 20)); ?>px;
            --hm-copyright-padding-bottom: <?php echo esc_attr(get_theme_mod('himalayanmart_copyright_padding_bottom', 20)); ?>px;

            /* Modern Glass Header Variables */
            --hm-modern-header-bg: <?php echo esc_attr(get_theme_mod('hm_modern_header_bg', '#ffffff')); ?>;
            --hm-modern-header-text: <?php echo esc_attr(get_theme_mod('hm_modern_header_text', '#1f2937')); ?>;
            --hm-modern-header-accent: <?php echo esc_attr(get_theme_mod('hm_modern_header_accent', '#3b82f6')); ?>;
            --hm-modern-header-gradient-from: <?php echo esc_attr(get_theme_mod('hm_modern_header_gradient_from', '#3b82f6')); ?>;
            --hm-modern-header-gradient-to: <?php echo esc_attr(get_theme_mod('hm_modern_header_gradient_to', '#8b5cf6')); ?>;
            --hm-modern-header-bg-rgb: <?php echo himalayanmart_hex2rgb(get_theme_mod('hm_modern_header_bg', '#ffffff')); ?>;
            --hm-modern-header-bg-opacity: <?php echo esc_attr(get_theme_mod('hm_modern_header_bg_opacity', 85) / 100); ?>;
            --hm-modern-header-icon-opacity: <?php echo esc_attr(get_theme_mod('hm_modern_header_icon_opacity', 100) / 100); ?>;

            /* Announcement Bar Variables */
            --hm-modern-announcement-bg: <?php echo esc_attr(get_theme_mod('hm_modern_header_announcement_bg', '#3b82f6')); ?>;
            --hm-modern-announcement-text: <?php echo esc_attr(get_theme_mod('hm_modern_header_announcement_text_color', '#ffffff')); ?>;
            --hm-modern-announcement-gradient-from: <?php echo esc_attr(get_theme_mod('hm_modern_header_announcement_gradient_from', '#3b82f6')); ?>;
            --hm-modern-announcement-gradient-to: <?php echo esc_attr(get_theme_mod('hm_modern_header_announcement_gradient_to', '#8b5cf6')); ?>;

            /* Scroll State Variables */
            --hm-modern-header-scroll-bg: <?php echo esc_attr(get_theme_mod('hm_modern_header_scroll_bg', '#ffffff')); ?>;
            --hm-modern-header-scroll-text: <?php echo esc_attr(get_theme_mod('hm_modern_header_scroll_text', '#1f2937')); ?>;
            --hm-modern-header-scroll-bg-rgb: <?php echo himalayanmart_hex2rgb(get_theme_mod('hm_modern_header_scroll_bg', '#ffffff')); ?>;
            --hm-modern-header-scroll-bg-opacity: <?php echo esc_attr(get_theme_mod('hm_modern_header_scroll_bg_opacity', 95) / 100); ?>;
            --hm-modern-header-scroll-icon-opacity: <?php echo esc_attr(get_theme_mod('hm_modern_header_scroll_icon_opacity', 100) / 100); ?>;
            --hm-modern-scroll-announcement-bg: <?php echo esc_attr(get_theme_mod('hm_modern_header_scroll_announcement_bg', '#1f2937')); ?>;
            --hm-modern-scroll-announcement-text: <?php echo esc_attr(get_theme_mod('hm_modern_header_scroll_announcement_text', '#ffffff')); ?>;
            --hm-modern-scroll-announcement-bg-rgb: <?php echo himalayanmart_hex2rgb(get_theme_mod('hm_modern_header_scroll_announcement_bg', '#1f2937')); ?>;
            --hm-modern-scroll-announcement-opacity: <?php echo esc_attr(get_theme_mod('hm_modern_header_scroll_announcement_opacity', 90) / 100); ?>;

            /* Mobile Menu Variables */
            --hm-modern-canvas-close-color: <?php echo esc_attr(get_theme_mod('hm_modern_header_canvas_close_color', '#000000')); ?>;

            /* Modern Multi-Column Footer Variables */
            --hm-modern-footer-bg: <?php echo esc_attr(get_theme_mod('hm_modern_footer_bg', '#111827')); ?>;
            --hm-modern-footer-text: <?php echo esc_attr(get_theme_mod('hm_modern_footer_text', '#9ca3af')); ?>;
            --hm-modern-footer-heading: <?php echo esc_attr(get_theme_mod('hm_modern_footer_heading', '#ffffff')); ?>;
            --hm-modern-footer-link: <?php echo esc_attr(get_theme_mod('hm_modern_footer_link', '#9ca3af')); ?>;
            --hm-modern-footer-link-hover: <?php echo esc_attr(get_theme_mod('hm_modern_footer_link_hover', '#3b82f6')); ?>;
            --hm-modern-footer-tabs-bg: <?php echo esc_attr(get_theme_mod('hm_modern_footer_tabs_bg', '#1f2937')); ?>;
            --hm-modern-footer-newsletter-bg: <?php echo esc_attr(get_theme_mod('hm_modern_footer_newsletter_bg', '#1f2937')); ?>;
            --hm-modern-footer-accent: <?php echo esc_attr(get_theme_mod('hm_modern_footer_accent', '#3b82f6')); ?>;
            --hm-modern-footer-bottom-bg: <?php echo esc_attr(get_theme_mod('hm_modern_footer_bottom_bg', '#030712')); ?>;

            /* Footer Border Variables */
            --hm-modern-footer-border-color: <?php echo esc_attr(get_theme_mod('hm_modern_footer_border_color', '#ffffff')); ?>;
            --hm-modern-footer-border-color-rgb: <?php echo himalayanmart_hex2rgb(get_theme_mod('hm_modern_footer_border_color', '#ffffff')); ?>;
            --hm-modern-footer-border-glow: <?php echo esc_attr(get_theme_mod('hm_modern_footer_border_glow', 50) / 100); ?>;
            --hm-modern-footer-border-height: <?php echo esc_attr(get_theme_mod('hm_modern_footer_border_height', 50)); ?>%;
            --hm-modern-footer-border-opacity: <?php echo esc_attr(get_theme_mod('hm_modern_footer_border_opacity', 30) / 100); ?>;

            /* Logo Sizes */
            --hm-logo-width-desktop: <?php echo esc_attr($logo_width_desktop); ?>px;
            --hm-logo-height-desktop: <?php echo esc_attr($logo_height_desktop); ?>px;
            --hm-logo-width-tablet: <?php echo esc_attr($logo_width_tablet); ?>px;
            --hm-logo-height-tablet: <?php echo esc_attr($logo_height_tablet); ?>px;
            --hm-logo-width-mobile: <?php echo esc_attr($logo_width_mobile); ?>px;
            --hm-logo-height-mobile: <?php echo esc_attr($logo_height_mobile); ?>px;
        }

        /* Logo Responsive Sizes */
        .hm-logo-center .custom-logo-link,
        .hm-logo-center .custom-logo-link img,
        .custom-logo-link,
        .custom-logo-link img {
            max-width: var(--hm-logo-width-desktop);
            max-height: var(--hm-logo-height-desktop);
            width: auto;
            height: auto;
        }

        @media (max-width: 991px) {
            .hm-logo-center .custom-logo-link,
            .hm-logo-center .custom-logo-link img,
            .custom-logo-link,
            .custom-logo-link img {
                max-width: var(--hm-logo-width-tablet);
                max-height: var(--hm-logo-height-tablet);
            }
        }

        @media (max-width: 767px) {
            .hm-logo-center .custom-logo-link,
            .hm-logo-center .custom-logo-link img,
            .custom-logo-link,
            .custom-logo-link img {
                max-width: var(--hm-logo-width-mobile);
                max-height: var(--hm-logo-height-mobile);
            }
        }

        /* Footer Height/Padding Styles */
        .hm-footer-main {
            padding-top: var(--hm-footer-padding-top, 60px);
            padding-bottom: var(--hm-footer-padding-bottom, 60px);
        }

        .hm-footer-bottom {
            padding-top: var(--hm-copyright-padding-top, 20px);
            padding-bottom: var(--hm-copyright-padding-bottom, 20px);
        }
    </style>
    <?php
}
add_action('wp_head', 'himalayanmart_customizer_css', 999);


