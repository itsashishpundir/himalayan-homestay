<?php
/**
 * The template for displaying search results pages
 *
 * @package HimalayanMart
 */

get_header();
?>

<main id="primary" class="site-main">
    <!-- Search Header -->
    <div class="blog-page-header search-header">
        <div class="hm-container">
            <div class="blog-header-content">
                <h1 class="blog-page-title">
                    <?php
                    printf(
                        /* translators: %s: search query */
                        esc_html__( 'Search Results for: %s', 'himalayanmart' ),
                        '<span>' . get_search_query() . '</span>'
                    );
                    ?>
                </h1>
                <p class="blog-page-description">
                    <?php
                    global $wp_query;
                    printf(
                        /* translators: %d: number of results */
                        esc_html( _n( '%d result found', '%d results found', $wp_query->found_posts, 'himalayanmart' ) ),
                        $wp_query->found_posts
                    );
                    ?>
                </p>
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
                                    <div class="blog-card-categories">
                                        <span class="category-badge"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></span>
                                    </div>

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
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <h2><?php esc_html_e( 'Nothing Found', 'himalayanmart' ); ?></h2>
                        <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'himalayanmart' ); ?></p>
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
