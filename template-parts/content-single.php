<?php
/**
 * Template part for displaying single posts
 *
 * @package HimalayanMart
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post-article' ); ?>>
    <!-- Post Header -->
    <header class="single-post-header">
        <!-- Categories -->
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

        <!-- Title -->
        <h1 class="single-post-title"><?php the_title(); ?></h1>

        <!-- Post Meta -->
        <div class="single-post-meta">
            <!-- Author -->
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

            <!-- Date -->
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

            <!-- Reading Time -->
            <div class="meta-item meta-reading-time">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
                <?php himalayanmart_reading_time(); ?>
            </div>

            <!-- Comments -->
            <div class="meta-item meta-comments">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                <?php himalayanmart_comments_count(); ?>
            </div>
        </div>
    </header>

    <!-- Featured Image -->
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="single-post-thumbnail">
            <?php the_post_thumbnail( 'large', array( 'class' => 'featured-image' ) ); ?>
            <?php
            $caption = get_the_post_thumbnail_caption();
            if ( $caption ) :
                ?>
                <figcaption class="thumbnail-caption"><?php echo esc_html( $caption ); ?></figcaption>
            <?php endif; ?>
        </div>
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
        <?php if ( get_theme_mod( 'himalayanmart_single_show_share', true ) ) : ?>
            <div class="post-share">
                <span class="share-label"><?php esc_html_e( 'Share:', 'himalayanmart' ); ?></span>
                <div class="share-buttons">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( get_permalink() ); ?>"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="share-btn share-facebook"
                       aria-label="<?php esc_attr_e( 'Share on Facebook', 'himalayanmart' ); ?>">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                        </svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo esc_url( get_permalink() ); ?>&text=<?php echo esc_attr( get_the_title() ); ?>"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="share-btn share-twitter"
                       aria-label="<?php esc_attr_e( 'Share on Twitter', 'himalayanmart' ); ?>">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/>
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url( get_permalink() ); ?>&title=<?php echo esc_attr( get_the_title() ); ?>"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="share-btn share-linkedin"
                       aria-label="<?php esc_attr_e( 'Share on LinkedIn', 'himalayanmart' ); ?>">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/>
                            <rect x="2" y="9" width="4" height="12"/>
                            <circle cx="4" cy="4" r="2"/>
                        </svg>
                    </a>
                    <a href="mailto:?subject=<?php echo esc_attr( get_the_title() ); ?>&body=<?php echo esc_url( get_permalink() ); ?>"
                       class="share-btn share-email"
                       aria-label="<?php esc_attr_e( 'Share via Email', 'himalayanmart' ); ?>">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </footer>
</article>
