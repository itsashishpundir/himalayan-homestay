<?php
/**
 * The blog posts page template (Posts Archive)
 *
 * Implements the full-width grid layout from code.html
 *
 * @package HimalayanMart
 */

get_header();

// Determine Page Title and Description depending on if this is the posts page or archive
$page_title = esc_html__( 'Journal', 'himalayanmart' );
$page_desc  = esc_html__( 'Discover hand-picked stories, expert guides, and hidden gems from the most remote corners of the world.', 'himalayanmart' );

if ( is_home() && ! is_front_page() ) {
    $posts_page_id = get_option( 'page_for_posts' );
    if ( $posts_page_id ) {
        $page_title = get_the_title( $posts_page_id );
        $post_page_desc = get_post_meta( $posts_page_id, 'hero_subtitle', true );
        if ( ! empty( $post_page_desc ) ) {
            $page_desc = $post_page_desc;
        }
    }
}
?>

<style>
    /* Add the same mountain wrapper that single.php uses */
    .archive-mountain-wrap {
        background-color: #f8f6f6;
        background-image: radial-gradient(circle at 2px 2px, rgba(232, 94, 48, 0.05) 1px, transparent 0);
        background-size: 40px 40px;
        min-height: 100vh;
        width: 100%;
    }
    
    /* Apply Tailwind classes to default WP pagination to match code.html */
    .hm-tailwind-pagination .navigation { margin-top: 4rem; display: flex; align-items: center; justify-content: center; gap: 0.75rem; }
    .hm-tailwind-pagination .nav-links { display: flex; gap: 0.75rem; align-items: center; }
    .hm-tailwind-pagination .page-numbers {
        width: 2.5rem; height: 2.5rem; display: flex; align-items: center; justify-content: center;
        border-radius: 0.75rem; background: white; border: 1px solid #e2e8f0; color: #475569;
        font-weight: 700; font-size: 0.875rem; transition: all 0.2s; text-decoration: none;
    }
    .hm-tailwind-pagination .page-numbers:hover { border-color: #e85e30; color: #e85e30; }
    .hm-tailwind-pagination .page-numbers.current { background: #e85e30; color: white; border-color: #e85e30; outline: none; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
    .hm-tailwind-pagination .page-numbers.dots { border: none; background: transparent; pointer-events: none; width: auto; color: #94a3b8; }
</style>

<div class="archive-mountain-wrap font-display text-slate-900 dark:text-slate-100 pb-20">
    <main class="max-w-7xl mx-auto px-6 py-12">
        
        <!-- Archive Header Section -->
        <div class="mb-12">
            <h2 class="text-5xl font-black tracking-tight mb-4"><?php echo esc_html( $page_title ); ?></h2>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <p class="text-slate-600 max-w-xl text-lg relative z-10">
                    <?php echo esc_html( $page_desc ); ?>
                </p>
                
                <!-- Category Filter Row -->
                <div class="flex gap-2 overflow-x-auto pb-2 md:pb-0 hide-scrollbar relative z-10">
                    <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="<?php echo is_home() ? 'bg-primary text-white border-primary' : 'bg-white border-slate-200 text-slate-700 hover:border-primary'; ?> border px-5 py-2 rounded-full text-sm font-semibold shrink-0 transition-colors">
                        <?php esc_html_e( 'All Posts', 'himalayanmart' ); ?>
                    </a>
                    <?php
                    $categories = get_categories( array( 'hide_empty' => true, 'number' => 4, 'orderby' => 'count', 'order' => 'DESC' ) );
                    foreach ( $categories as $cat ) {
                        $is_active = is_category( $cat->term_id );
                        $btn_classes = $is_active ? 'bg-primary text-white border-primary' : 'bg-white border-slate-200 text-slate-700 hover:border-primary';
                        echo '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '" class="border px-5 py-2 rounded-full text-sm font-semibold shrink-0 transition-colors ' . esc_attr( $btn_classes ) . '">' . esc_html( $cat->name ) . '</a>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <?php if ( have_posts() ) : ?>
            
            <!-- Blog Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 relative z-10">
                <?php while ( have_posts() ) : the_post(); ?>
                    
                    <!-- Card -->
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all group flex flex-col border border-slate-100' ); ?>>
                        
                        <a href="<?php the_permalink(); ?>" class="relative block aspect-[16/10] overflow-hidden">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500' ) ); ?>
                            <?php else : ?>
                                <div class="w-full h-full bg-slate-100 group-hover:scale-105 transition-transform duration-500 flex items-center justify-center text-slate-300">
                                    <span class="material-symbols-outlined text-4xl">landscape</span>
                                </div>
                            <?php endif; ?>
                            
                            <?php 
                            $cats = get_the_category();
                            if ( $cats ) : 
                            ?>
                                <span class="absolute top-4 left-4 bg-primary text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider shadow-lg">
                                    <?php echo esc_html( $cats[0]->name ); ?>
                                </span>
                            <?php endif; ?>
                        </a>
                        
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex items-center gap-3 text-slate-400 text-xs font-medium mb-3">
                                <span><?php echo esc_html( strtoupper( get_the_date( 'M d, Y' ) ) ); ?></span>
                                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                <span>
                                    <?php 
                                    $word_count = str_word_count( wp_strip_all_tags( get_the_content() ) );
                                    echo esc_html( strtoupper( max( 1, ceil( $word_count / 200 ) ) . ' MIN READ' ) );
                                    ?>
                                </span>
                            </div>
                            
                            <h3 class="text-xl font-bold mb-3 group-hover:text-primary transition-colors leading-tight">
                                <a href="<?php the_permalink(); ?>" class="block"><?php the_title(); ?></a>
                            </h3>
                            
                            <p class="text-slate-600 text-sm line-clamp-2 mb-6 flex-1">
                                <?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?>
                            </p>
                            
                            <div class="mt-auto flex items-center justify-between border-t border-slate-50 pt-4">
                                <div class="flex items-center gap-2">
                                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 32, '', '', array( 'class' => 'w-8 h-8 rounded-full bg-slate-200' ) ); ?>
                                    <span class="text-xs font-bold text-slate-700"><?php the_author(); ?></span>
                                </div>
                                <a href="<?php the_permalink(); ?>" class="material-symbols-outlined text-primary group-hover:translate-x-1 transition-transform">arrow_forward</a>
                            </div>
                        </div>
                    </article>

                <?php endwhile; ?>
            </div>

            <!-- Pagination Section -->
            <div class="hm-tailwind-pagination relative z-10">
                <?php
                the_posts_pagination( array(
                    'mid_size'  => 2,
                    'prev_text' => '<span class="material-symbols-outlined text-xl leading-none">chevron_left</span>',
                    'next_text' => '<span class="material-symbols-outlined text-xl leading-none">chevron_right</span>',
                ) );
                ?>
            </div>

        <?php else : ?>
            
            <div class="text-center py-20">
                <span class="material-symbols-outlined text-6xl text-slate-300 mb-4 block">search_off</span>
                <h2 class="text-2xl font-bold text-slate-900 mb-2"><?php esc_html_e( 'No posts found', 'himalayanmart' ); ?></h2>
                <p class="text-slate-500"><?php esc_html_e( 'It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'himalayanmart' ); ?></p>
            </div>
            
        <?php endif; ?>

    </main>
</div>

<?php get_footer(); ?>
