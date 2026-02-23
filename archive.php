<?php
/**
 * The template for displaying archive pages
 *
 * @package HimalayanMart
 */

get_header();
?>

<main id="primary" class="site-main">
    <!-- Archive Header -->
    <div class="blog-page-header archive-header">
        <div class="hm-container">
            <div class="blog-header-content">
                <?php
                the_archive_title( '<h1 class="blog-page-title">', '</h1>' );
                the_archive_description( '<p class="blog-page-description">', '</p>' );
                ?>
            </div>
        </div>
    </div>

    <div class="hm-container">
        <div class="blog-archive-layout">
            <!-- Main Content Column -->
            <div class="blog-posts-column">
                <?php if ( have_posts() ) : ?>

                    <!-- Posts Grid -->
                    <div class="blog-posts-grid">
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-card' ); ?>>
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <a href="<?php the_permalink(); ?>" class="blog-card-thumbnail">
                                        <?php the_post_thumbnail( 'medium_large' ); ?>
                                    </a>
                                <?php else : ?>
                                    <a href="<?php the_permalink(); ?>" class="blog-card-thumbnail blog-card-no-thumb">
                                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                            <circle cx="8.5" cy="8.5" r="1.5"/>
                                            <polyline points="21 15 16 10 5 21"/>
                                        </svg>
                                    </a>
                                <?php endif; ?>

                                <div class="blog-card-content">
                                    <?php if ( has_category() ) : ?>
                                        <div class="blog-card-categories">
                                            <?php
                                            $categories = get_the_category();
                                            if ( ! empty( $categories ) ) :
                                                ?>
                                                <a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="category-badge">
                                                    <?php echo esc_html( $categories[0]->name ); ?>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>

                                    <h3 class="blog-card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>

                                    <div class="blog-card-excerpt">
                                        <?php echo wp_trim_words( get_the_excerpt(), 15, '...' ); ?>
                                    </div>

                                    <div class="blog-card-meta">
                                        <div class="meta-date">
                                            <?php echo esc_html( get_the_date() ); ?>
                                        </div>
                                        <div class="meta-reading-time">
                                            <?php himalayanmart_reading_time(); ?>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>

                    <!-- Pagination -->
                    <nav class="blog-pagination">
                        <?php
                        the_posts_pagination( array(
                            'mid_size'  => 2,
                            'prev_text' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg> <span>' . esc_html__( 'Previous', 'himalayanmart' ) . '</span>',
                            'next_text' => '<span>' . esc_html__( 'Next', 'himalayanmart' ) . '</span> <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>',
                        ) );
                        ?>
                    </nav>

                <?php else : ?>
                    <div class="no-posts-found">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                            <polyline points="10 9 9 9 8 9"/>
                        </svg>
                        <h2><?php esc_html_e( 'No posts found', 'himalayanmart' ); ?></h2>
                        <p><?php esc_html_e( 'It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'himalayanmart' ); ?></p>
                        <?php get_search_form(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar Column -->
            <aside class="blog-sidebar-column">
                <?php get_sidebar( 'blog' ); ?>
            </aside>
        </div>
    </div>
</main>

<?php
get_footer();
