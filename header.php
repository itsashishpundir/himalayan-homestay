<?php
/**
 * The header for our theme
 *
 * @package HimalayanMart
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'himalayanmart' ); ?></a>

	<div id="content" class="site-content">
	    <?php
        // Get selected header layout from customizer
        $header_layout = get_theme_mod('himalayanmart_header_layout', '3-tier');

        // Load the appropriate header layout template
        get_template_part('template-parts/header/header', $header_layout);
        ?>
