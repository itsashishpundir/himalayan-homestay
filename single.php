<?php
/**
 * The template for displaying all single posts
 *
 * @package HimalayanMart
 */

get_header();

// Get customizer settings
$layout           = get_theme_mod( 'himalayanmart_single_post_layout', 'sidebar-right' );
$show_author      = get_theme_mod( 'himalayanmart_single_show_author', true );
$show_navigation  = get_theme_mod( 'himalayanmart_single_show_navigation', true );
$show_share       = get_theme_mod( 'himalayanmart_single_show_share', true );
$show_related     = get_theme_mod( 'himalayanmart_single_show_related', true );

// Determine layout classes
$layout_class = 'single-post-' . $layout;
$has_sidebar  = ( $layout !== 'no-sidebar' );
?>

<main id="primary" class="site-main <?php echo esc_attr( $layout_class ); ?>">
    <?php
    while ( have_posts() ) :
        the_post();

        if ( $layout === 'no-sidebar' ) :
            // NO SIDEBAR LAYOUT - Hero Style
            ?>
            <!-- Hero Section with Full Width Featured Image -->
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="single-post-hero">
                    <div class="hero-image-wrapper">
                        <?php the_post_thumbnail( 'full', array( 'class' => 'hero-featured-image' ) ); ?>
                        <div class="hero-overlay"></div>
                    </div>
                    <div class="hero-content">
                        <div class="hm-container">
                            <?php if ( has_category() ) : ?>
                                <div class="post-categories">
                                    <?php
                                    $categories = get_the_category();
                                    foreach ( $categories as $category ) :
                                        ?>
                                        <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="category-badge">
                                            <?php echo esc_html( $category->name ); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <h1 class="hero-title"><?php the_title(); ?></h1>
                            <div class="hero-meta">
                                <div class="meta-author">
                                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 44 ); ?>
                                    <span><?php the_author(); ?></span>
                                </div>
                                <div class="meta-date">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                        <line x1="16" y1="2" x2="16" y2="6"/>
                                        <line x1="8" y1="2" x2="8" y2="6"/>
                                        <line x1="3" y1="10" x2="21" y2="10"/>
                                    </svg>
                                    <?php echo esc_html( get_the_date() ); ?>
                                </div>
                                <div class="meta-reading-time">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    <?php himalayanmart_reading_time(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Content Section (Centered, Not Full Width) -->
            <div class="single-post-content-wrapper">
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post-article no-sidebar-article' ); ?>>
                    <?php if ( ! has_post_thumbnail() ) : ?>
                        <!-- Show header inside content if no featured image -->
                        <header class="single-post-header">
                            <?php if ( has_category() ) : ?>
                                <div class="post-categories">
                                    <?php
                                    $categories = get_the_category();
                                    foreach ( $categories as $category ) :
                                        ?>
                                        <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="category-badge">
                                            <?php echo esc_html( $category->name ); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <h1 class="single-post-title"><?php the_title(); ?></h1>
                            <div class="single-post-meta">
                                <div class="meta-item meta-author">
                                    <div class="author-avatar-small">
                                        <?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
                                    </div>
                                    <div class="author-details">
                                        <span class="meta-label"><?php esc_html_e( 'By', 'himalayanmart' ); ?></span>
                                        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="author-name">
                                            <?php the_author(); ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="meta-item meta-date">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                        <line x1="16" y1="2" x2="16" y2="6"/>
                                        <line x1="8" y1="2" x2="8" y2="6"/>
                                        <line x1="3" y1="10" x2="21" y2="10"/>
                                    </svg>
                                    <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                        <?php echo esc_html( get_the_date() ); ?>
                                    </time>
                                </div>
                                <div class="meta-item meta-reading-time">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    <?php himalayanmart_reading_time(); ?>
                                </div>
                            </div>
                        </header>
                    <?php endif; ?>

                    <!-- Post Content -->
                    <div class="single-post-content entry-content">
                        <?php
                        the_content();

                        wp_link_pages(
                            array(
                                'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'himalayanmart' ) . '</span>',
                                'after'       => '</div>',
                                'link_before' => '<span class="page-number">',
                                'link_after'  => '</span>',
                            )
                        );
                        ?>
                    </div>

                    <!-- Post Footer -->
                    <footer class="single-post-footer">
                        <!-- Tags -->
                        <?php if ( has_tag() ) : ?>
                            <div class="post-tags">
                                <span class="tags-label">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                                        <line x1="7" y1="7" x2="7.01" y2="7"/>
                                    </svg>
                                    <?php esc_html_e( 'Tags:', 'himalayanmart' ); ?>
                                </span>
                                <div class="tags-list">
                                    <?php the_tags( '', '', '' ); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Share Buttons -->
                        <?php if ( $show_share ) : ?>
                            <div class="post-share">
                                <span class="share-label"><?php esc_html_e( 'Share:', 'himalayanmart' ); ?></span>
                                <div class="share-buttons">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( get_permalink() ); ?>" target="_blank" rel="noopener noreferrer" class="share-btn share-facebook" aria-label="<?php esc_attr_e( 'Share on Facebook', 'himalayanmart' ); ?>">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url=<?php echo esc_url( get_permalink() ); ?>&text=<?php echo esc_attr( get_the_title() ); ?>" target="_blank" rel="noopener noreferrer" class="share-btn share-twitter" aria-label="<?php esc_attr_e( 'Share on Twitter', 'himalayanmart' ); ?>">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>
                                    </a>
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url( get_permalink() ); ?>&title=<?php echo esc_attr( get_the_title() ); ?>" target="_blank" rel="noopener noreferrer" class="share-btn share-linkedin" aria-label="<?php esc_attr_e( 'Share on LinkedIn', 'himalayanmart' ); ?>">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
                                    </a>
                                    <a href="mailto:?subject=<?php echo esc_attr( get_the_title() ); ?>&body=<?php echo esc_url( get_permalink() ); ?>" class="share-btn share-email" aria-label="<?php esc_attr_e( 'Share via Email', 'himalayanmart' ); ?>">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </footer>
                </article>

                <!-- Post Navigation -->
                <?php if ( $show_navigation ) : ?>
                    <nav class="post-navigation">
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        ?>
                        <?php if ( $prev_post ) : ?>
                            <a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="nav-previous">
                                <span class="nav-subtitle">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                                    <?php esc_html_e( 'Previous Post', 'himalayanmart' ); ?>
                                </span>
                                <span class="nav-title"><?php echo esc_html( get_the_title( $prev_post ) ); ?></span>
                            </a>
                        <?php endif; ?>
                        <?php if ( $next_post ) : ?>
                            <a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="nav-next">
                                <span class="nav-subtitle">
                                    <?php esc_html_e( 'Next Post', 'himalayanmart' ); ?>
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </span>
                                <span class="nav-title"><?php echo esc_html( get_the_title( $next_post ) ); ?></span>
                            </a>
                        <?php endif; ?>
                    </nav>
                <?php endif; ?>

                <!-- Author Box -->
                <?php if ( $show_author ) : ?>
                    <?php himalayanmart_author_box(); ?>
                <?php endif; ?>

                <!-- Related Posts -->
                <?php if ( $show_related ) : ?>
                    <?php get_template_part( 'template-parts/blog/related', 'posts' ); ?>
                <?php endif; ?>

                <!-- Comments -->
                <?php
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
                ?>
            </div>
            <?php

        else :
            // SIDEBAR LAYOUT (Left or Right)
            ?>
            <div class="hm-container">
                <div class="blog-single-layout <?php echo esc_attr( $layout ); ?>">
                    <!-- Main Content Column -->
                    <div class="blog-content-column">
                        <?php get_template_part( 'template-parts/content', 'single' ); ?>

                        <!-- Post Navigation -->
                        <?php if ( $show_navigation ) : ?>
                            <nav class="post-navigation">
                                <?php
                                $prev_post = get_previous_post();
                                $next_post = get_next_post();
                                ?>
                                <?php if ( $prev_post ) : ?>
                                    <a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="nav-previous">
                                        <span class="nav-subtitle">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                                            <?php esc_html_e( 'Previous Post', 'himalayanmart' ); ?>
                                        </span>
                                        <span class="nav-title"><?php echo esc_html( get_the_title( $prev_post ) ); ?></span>
                                    </a>
                                <?php endif; ?>
                                <?php if ( $next_post ) : ?>
                                    <a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="nav-next">
                                        <span class="nav-subtitle">
                                            <?php esc_html_e( 'Next Post', 'himalayanmart' ); ?>
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                        </span>
                                        <span class="nav-title"><?php echo esc_html( get_the_title( $next_post ) ); ?></span>
                                    </a>
                                <?php endif; ?>
                            </nav>
                        <?php endif; ?>

                        <!-- Author Box -->
                        <?php if ( $show_author ) : ?>
                            <?php himalayanmart_author_box(); ?>
                        <?php endif; ?>

                        <!-- Related Posts -->
                        <?php if ( $show_related ) : ?>
                            <?php get_template_part( 'template-parts/blog/related', 'posts' ); ?>
                        <?php endif; ?>

                        <!-- Comments -->
                        <?php
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;
                        ?>
                    </div>

                    <!-- Sidebar Column -->
                    <aside class="blog-sidebar-column">
                        <?php get_sidebar( 'blog' ); ?>
                    </aside>
                </div>
            </div>
            <?php
        endif;

    endwhile;
    ?>
</main>

<?php
get_footer();
