<?php
/**
 * Template Name: Complete Canvas (No Title)
 * Template Post Type: page
 *
 * This template removes the native page title entirely, allowing
 * you to build the page title and hero layouts via Custom HTML
 * or blocks.
 *
 * @package HimalayanMart
 */

get_header(); ?>

<main id="primary" class="site-main">

    <?php
    while ( have_posts() ) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="entry-content" style="padding-top: 2rem;">
                <?php
                the_content();

                wp_link_pages(
                    array(
                        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'himalayanmart' ),
                        'after'  => '</div>',
                    )
                );
                ?>
            </div><!-- .entry-content -->
        </article><!-- #post-<?php the_ID(); ?> -->
        <?php

        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;

    endwhile; // End of the loop.
    ?>

</main><!-- #primary -->

<?php
get_footer();
