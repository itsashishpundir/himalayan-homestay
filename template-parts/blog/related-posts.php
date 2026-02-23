<?php
/**
 * Template part for displaying related posts
 *
 * @package HimalayanMart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Get current post categories
$categories = get_the_category();
if ( empty( $categories ) ) {
    return;
}

$category_ids = array();
foreach ( $categories as $category ) {
    $category_ids[] = $category->term_id;
}

// Query related posts
$related_args = array(
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post__not_in'   => array( get_the_ID() ),
    'category__in'   => $category_ids,
    'orderby'        => 'rand',
);

$related_query = new WP_Query( $related_args );

if ( ! $related_query->have_posts() ) {
    return;
}
?>

<section class="related-posts-section">
    <h3 class="section-title"><?php esc_html_e( 'Related Posts', 'himalayanmart' ); ?></h3>

    <div class="related-posts-grid">
        <?php
        while ( $related_query->have_posts() ) :
            $related_query->the_post();
            ?>
            <article class="related-post-card">
                <?php if ( has_post_thumbnail() ) : ?>
                    <a href="<?php the_permalink(); ?>" class="card-thumbnail">
                        <?php the_post_thumbnail( 'medium_large' ); ?>
                    </a>
                <?php else : ?>
                    <a href="<?php the_permalink(); ?>" class="card-thumbnail no-thumb">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                    </a>
                <?php endif; ?>

                <div class="card-content">
                    <h4 class="card-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h4>
                    <div class="card-meta">
                        <?php echo esc_html( get_the_date() ); ?>
                    </div>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</section>

<?php
wp_reset_postdata();
