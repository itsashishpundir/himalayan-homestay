<?php
/**
 * Blog Customizer Settings
 *
 * @package HimalayanMart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function himalayanmart_customizer_blog( $wp_customize ) {

    // ==============================================
    // BLOG SECTION
    // ==============================================
    $wp_customize->add_section( 'himalayanmart_blog_section', array(
        'title'       => __( 'Blog Settings', 'himalayanmart' ),
        'priority'    => 45,
        'description' => __( 'Customize blog single post and archive page layouts.', 'himalayanmart' ),
    ) );

    // ==============================================
    // SINGLE POST SETTINGS
    // ==============================================
    $wp_customize->add_setting( 'himalayanmart_blog_single_heading', array(
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'himalayanmart_blog_single_heading', array(
        'label'       => __( '── Single Post Layout ──', 'himalayanmart' ),
        'section'     => 'himalayanmart_blog_section',
        'type'        => 'hidden',
        'description' => __( 'Configure single post page layout options.', 'himalayanmart' ),
    ) ) );

    // Single Post Layout
    $wp_customize->add_setting( 'himalayanmart_single_post_layout', array(
        'default'           => 'sidebar-right',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'himalayanmart_single_post_layout', array(
        'label'   => __( 'Single Post Layout', 'himalayanmart' ),
        'section' => 'himalayanmart_blog_section',
        'type'    => 'select',
        'choices' => array(
            'sidebar-right' => __( 'Content + Sidebar (Right)', 'himalayanmart' ),
            'sidebar-left'  => __( 'Sidebar + Content (Left)', 'himalayanmart' ),
            'no-sidebar'    => __( 'No Sidebar (Hero Layout)', 'himalayanmart' ),
        ),
    ) );

    // Content Width for No Sidebar Layout
    $wp_customize->add_setting( 'himalayanmart_single_content_width', array(
        'default'           => '800',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'himalayanmart_single_content_width', array(
        'label'       => __( 'Content Width (No Sidebar)', 'himalayanmart' ),
        'description' => __( 'Max width in pixels for content when no sidebar. Default: 800px', 'himalayanmart' ),
        'section'     => 'himalayanmart_blog_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 600,
            'max'  => 1200,
            'step' => 50,
        ),
    ) );

    // Show Author Box
    $wp_customize->add_setting( 'himalayanmart_single_show_author', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'himalayanmart_single_show_author', array(
        'label'   => __( 'Show Author Box', 'himalayanmart' ),
        'section' => 'himalayanmart_blog_section',
        'type'    => 'checkbox',
    ) );

    // Show Post Navigation
    $wp_customize->add_setting( 'himalayanmart_single_show_navigation', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'himalayanmart_single_show_navigation', array(
        'label'   => __( 'Show Post Navigation', 'himalayanmart' ),
        'section' => 'himalayanmart_blog_section',
        'type'    => 'checkbox',
    ) );

    // Show Share Buttons
    $wp_customize->add_setting( 'himalayanmart_single_show_share', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'himalayanmart_single_show_share', array(
        'label'   => __( 'Show Share Buttons', 'himalayanmart' ),
        'section' => 'himalayanmart_blog_section',
        'type'    => 'checkbox',
    ) );

    // Show Related Posts
    $wp_customize->add_setting( 'himalayanmart_single_show_related', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'himalayanmart_single_show_related', array(
        'label'   => __( 'Show Related Posts', 'himalayanmart' ),
        'section' => 'himalayanmart_blog_section',
        'type'    => 'checkbox',
    ) );

    // ==============================================
    // BLOG ARCHIVE SETTINGS
    // ==============================================
    $wp_customize->add_setting( 'himalayanmart_blog_archive_heading', array(
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'himalayanmart_blog_archive_heading', array(
        'label'       => __( '── Blog Archive Layout ──', 'himalayanmart' ),
        'section'     => 'himalayanmart_blog_section',
        'type'        => 'hidden',
        'description' => __( 'Configure blog archive/listing page options.', 'himalayanmart' ),
    ) ) );

    // Archive Layout
    $wp_customize->add_setting( 'himalayanmart_blog_archive_layout', array(
        'default'           => 'sidebar-right',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'himalayanmart_blog_archive_layout', array(
        'label'   => __( 'Archive Page Layout', 'himalayanmart' ),
        'section' => 'himalayanmart_blog_section',
        'type'    => 'select',
        'choices' => array(
            'sidebar-right' => __( 'Content + Sidebar (Right)', 'himalayanmart' ),
            'sidebar-left'  => __( 'Sidebar + Content (Left)', 'himalayanmart' ),
            'no-sidebar'    => __( 'No Sidebar (Full Width Grid)', 'himalayanmart' ),
        ),
    ) );

    // Posts Per Page
    $wp_customize->add_setting( 'himalayanmart_blog_posts_per_page', array(
        'default'           => 10,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'himalayanmart_blog_posts_per_page', array(
        'label'       => __( 'Posts Per Page', 'himalayanmart' ),
        'section'     => 'himalayanmart_blog_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 3,
            'max'  => 30,
            'step' => 1,
        ),
    ) );

    // Grid Columns
    $wp_customize->add_setting( 'himalayanmart_blog_grid_columns', array(
        'default'           => 2,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'himalayanmart_blog_grid_columns', array(
        'label'   => __( 'Grid Columns', 'himalayanmart' ),
        'section' => 'himalayanmart_blog_section',
        'type'    => 'select',
        'choices' => array(
            2 => __( '2 Columns', 'himalayanmart' ),
            3 => __( '3 Columns', 'himalayanmart' ),
            4 => __( '4 Columns', 'himalayanmart' ),
        ),
    ) );

    // Show Featured Post
    $wp_customize->add_setting( 'himalayanmart_blog_show_featured', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'himalayanmart_blog_show_featured', array(
        'label'       => __( 'Show Featured Post (First Post Large)', 'himalayanmart' ),
        'section'     => 'himalayanmart_blog_section',
        'type'        => 'checkbox',
    ) );

    // Show Excerpt
    $wp_customize->add_setting( 'himalayanmart_blog_show_excerpt', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'himalayanmart_blog_show_excerpt', array(
        'label'   => __( 'Show Post Excerpt', 'himalayanmart' ),
        'section' => 'himalayanmart_blog_section',
        'type'    => 'checkbox',
    ) );

    // Excerpt Length
    $wp_customize->add_setting( 'himalayanmart_blog_excerpt_length', array(
        'default'           => 15,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'himalayanmart_blog_excerpt_length', array(
        'label'       => __( 'Excerpt Length (words)', 'himalayanmart' ),
        'section'     => 'himalayanmart_blog_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 5,
            'max'  => 50,
            'step' => 5,
        ),
    ) );
}
add_action( 'customize_register', 'himalayanmart_customizer_blog' );

/**
 * Output blog customizer CSS
 */
function himalayanmart_blog_customizer_css() {
    $content_width = get_theme_mod( 'himalayanmart_single_content_width', 800 );
    $grid_columns  = get_theme_mod( 'himalayanmart_blog_grid_columns', 2 );
    ?>
    <style type="text/css">
        /* Blog Customizer CSS */
        .single-post-no-sidebar .single-post-content-wrapper {
            max-width: <?php echo esc_attr( $content_width ); ?>px;
        }

        .blog-posts-grid {
            grid-template-columns: repeat(<?php echo esc_attr( $grid_columns ); ?>, 1fr);
        }

        @media (max-width: 991px) {
            .blog-posts-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .blog-posts-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <?php
}
add_action( 'wp_head', 'himalayanmart_blog_customizer_css', 1000 );
