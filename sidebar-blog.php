<?php
/**
 * The sidebar template for blog pages
 *
 * @package HimalayanMart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div class="blog-sidebar">
    <?php if ( is_active_sidebar( 'sidebar-blog' ) ) : ?>
        <?php dynamic_sidebar( 'sidebar-blog' ); ?>
    <?php else : ?>
        <!-- Default Sidebar Content when no widgets assigned -->

        <!-- Search Widget -->
        <div class="sidebar-widget widget-search">
            <h3 class="widget-title"><?php esc_html_e( 'Search', 'himalayanmart' ); ?></h3>
            <?php get_search_form(); ?>
        </div>

        <!-- Recent Posts Widget -->
        <div class="sidebar-widget widget-recent-posts">
            <h3 class="widget-title"><?php esc_html_e( 'Recent Posts', 'himalayanmart' ); ?></h3>
            <ul class="recent-posts-list">
                <?php
                $recent_posts = wp_get_recent_posts( array(
                    'numberposts' => 5,
                    'post_status' => 'publish',
                ) );

                foreach ( $recent_posts as $post ) :
                    ?>
                    <li class="recent-post-item">
                        <?php if ( has_post_thumbnail( $post['ID'] ) ) : ?>
                            <a href="<?php echo esc_url( get_permalink( $post['ID'] ) ); ?>" class="recent-post-thumb">
                                <?php echo get_the_post_thumbnail( $post['ID'], 'thumbnail' ); ?>
                            </a>
                        <?php endif; ?>
                        <div class="recent-post-content">
                            <a href="<?php echo esc_url( get_permalink( $post['ID'] ) ); ?>" class="recent-post-title">
                                <?php echo esc_html( $post['post_title'] ); ?>
                            </a>
                            <span class="recent-post-date">
                                <?php echo esc_html( get_the_date( '', $post['ID'] ) ); ?>
                            </span>
                        </div>
                    </li>
                <?php endforeach; wp_reset_postdata(); ?>
            </ul>
        </div>

        <!-- Categories Widget -->
        <div class="sidebar-widget widget-categories">
            <h3 class="widget-title"><?php esc_html_e( 'Categories', 'himalayanmart' ); ?></h3>
            <ul class="categories-list">
                <?php
                wp_list_categories( array(
                    'orderby'    => 'count',
                    'order'      => 'DESC',
                    'show_count' => true,
                    'title_li'   => '',
                    'number'     => 10,
                ) );
                ?>
            </ul>
        </div>

        <!-- Tags Widget -->
        <div class="sidebar-widget widget-tags">
            <h3 class="widget-title"><?php esc_html_e( 'Popular Tags', 'himalayanmart' ); ?></h3>
            <div class="tags-cloud">
                <?php
                wp_tag_cloud( array(
                    'smallest' => 12,
                    'largest'  => 16,
                    'unit'     => 'px',
                    'number'   => 20,
                    'format'   => 'flat',
                ) );
                ?>
            </div>
        </div>

    <?php endif; ?>
</div>
