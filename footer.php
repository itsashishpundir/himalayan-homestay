<?php
/**
 * The template for displaying the footer
 *
 * @package HimalayanMart
 */
?>

	</div><!-- #content -->

	<?php
    // Get selected footer layout from customizer
    $footer_layout = get_theme_mod('himalayanmart_footer_layout', '4-column');

    // Load the appropriate footer layout template
    get_template_part('template-parts/footer/footer', $footer_layout);
    ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
