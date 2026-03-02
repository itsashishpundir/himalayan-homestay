<?php
/**
 * Single Post Template — FuturaStays Design
 *
 * Implements the exact structure and Tailwind classes from code.html
 *
 * @package HimalayanMart
 */

get_header();

// Customizer settings
$layout          = get_theme_mod( 'himalayanmart_single_post_layout', 'sidebar-right' );
$show_author     = get_theme_mod( 'himalayanmart_single_show_author', true );
$show_navigation = get_theme_mod( 'himalayanmart_single_show_navigation', true );
$show_share      = get_theme_mod( 'himalayanmart_single_show_share', true );
$show_related    = get_theme_mod( 'himalayanmart_single_show_related', true );
$has_sidebar     = ( $layout !== 'no-sidebar' );

// Determine main content and sidebar widths based on layout
$main_class = 'lg:w-2/3';
$side_class = 'lg:w-1/3 space-y-8';
$flex_dir   = 'flex-col lg:flex-row';

if ( $layout === 'sidebar-left' ) {
    $flex_dir = 'flex-col lg:flex-row-reverse';
} elseif ( $layout === 'no-sidebar' ) {
    $main_class = 'w-full max-w-4xl mx-auto';
}
?>

<style>
    /* Specific styles from code.html that might not be in the global theme CSS */
    .single-post-mountain-wrap {
        background-color: #f8f6f6;
        background-image: radial-gradient(circle at 2px 2px, rgba(232, 94, 48, 0.05) 1px, transparent 0);
        background-size: 40px 40px;
        min-height: 100vh;
        width: 100%;
    }
    .fs-glass {
        background: rgba(255, 255, 255, 0.7) !important;
        backdrop-filter: blur(12px) !important;
        -webkit-backdrop-filter: blur(12px) !important;
        border: 1px solid rgba(255, 255, 255, 0.3) !important;
    }
</style>

<div class="single-post-mountain-wrap font-display text-slate-900 dark:text-slate-100">
    <main class="max-w-7xl mx-auto px-6 py-12">
    <?php while ( have_posts() ) : the_post(); ?>
    
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-8 font-medium">
        <a class="hover:text-primary transition-colors" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'himalayanmart' ); ?></a>
        <span class="material-symbols-outlined text-xs">chevron_right</span>
        <a class="hover:text-primary transition-colors" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><?php esc_html_e( 'Journal', 'himalayanmart' ); ?></a>
        <?php
        $cats = get_the_category();
        if ( $cats ) :
        ?>
        <span class="material-symbols-outlined text-xs">chevron_right</span>
        <a class="hover:text-primary transition-colors" href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>"><?php echo esc_html( $cats[0]->name ); ?></a>
        <?php endif; ?>
        <span class="material-symbols-outlined text-xs">chevron_right</span>
        <span class="text-primary font-bold"><?php echo esc_html( wp_trim_words( get_the_title(), 5, '...' ) ); ?></span>
    </nav>

    <div class="flex <?php echo esc_attr( $flex_dir ); ?> gap-12">
        
        <!-- Main Content -->
        <article class="<?php echo esc_attr( $main_class ); ?>" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <?php if ( has_post_thumbnail() ) : ?>
            <div class="relative rounded-3xl overflow-hidden mb-10 group shadow-2xl">
                <?php the_post_thumbnail( 'full', array( 'class' => 'w-full aspect-[16/9] object-cover transition-transform duration-700 group-hover:scale-105' ) ); ?>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent flex flex-col justify-end p-10">
                    <?php if ( $cats ) : ?>
                    <a href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>" class="bg-primary hover:bg-orange-600 transition-colors text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-widest w-fit mb-4">
                        <?php echo esc_html( $cats[0]->name ); ?>
                    </a>
                    <?php endif; ?>
                    
                    <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4"><?php the_title(); ?></h1>
                    
                    <div class="flex items-center gap-4 text-white/80 text-sm">
                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">calendar_today</span> <?php echo esc_html( get_the_date( 'M j, Y' ) ); ?></span>
                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">schedule</span> <?php 
                            $word_count = str_word_count( wp_strip_all_tags( get_the_content() ) );
                            echo esc_html( max( 1, ceil( $word_count / 200 ) ) . ' min read' );
                        ?></span>
                    </div>
                </div>
            </div>
            <?php else : ?>
            <header class="mb-10">
                <?php if ( $cats ) : ?>
                <a href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>" class="bg-primary/10 text-primary text-xs font-bold px-3 py-1 rounded-full uppercase tracking-widest w-fit mb-4 inline-block hover:bg-primary hover:text-white transition-colors">
                    <?php echo esc_html( $cats[0]->name ); ?>
                </a>
                <?php endif; ?>
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white leading-tight mb-4"><?php the_title(); ?></h1>
                <div class="flex items-center gap-4 text-slate-500 text-sm">
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">calendar_today</span> <?php echo esc_html( get_the_date( 'M j, Y' ) ); ?></span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">schedule</span> <?php 
                        $word_count = str_word_count( wp_strip_all_tags( get_the_content() ) );
                        echo esc_html( max( 1, ceil( $word_count / 200 ) ) . ' min read' );
                    ?></span>
                </div>
            </header>
            <?php endif; ?>

            <div class="prose prose-slate bg-transparent lg:prose-xl dark:prose-invert max-w-none space-y-6 fs-content">
                <!-- Apply code.html paragraph styles to inner paragraphs -->
                <style>
                    /* p class="text-lg leading-relaxed text-slate-700" */
                    .fs-content p { font-size: 1.125rem !important; line-height: 1.625 !important; color: #334155 !important; margin-bottom: 1.5rem !important; margin-top: 0 !important; }
                    
                    /* h2 class="text-3xl font-bold text-slate-900 mt-12 mb-6" */
                    .fs-content h2 { font-size: 1.875rem !important; line-height: 2.25rem !important; font-weight: 700 !important; color: #0f172a !important; margin-top: 3rem !important; margin-bottom: 1.5rem !important; }
                    
                    /* h3 class="text-xl font-bold mt-6 mb-3" */
                    .fs-content h3 { font-size: 1.25rem !important; line-height: 1.75rem !important; font-weight: 700 !important; color: #0f172a !important; margin-top: 1.5rem !important; margin-bottom: 0.75rem !important; }
                    
                    /* ul class="list-disc ml-5 space-y-2 text-sm" */
                    .fs-content ul { list-style-type: disc !important; margin-left: 1.25rem !important; font-size: 0.875rem !important; line-height: 1.25rem !important; color: #334155 !important; }
                    .fs-content ul li { margin-top: 0.5rem !important; margin-bottom: 0 !important; }
                    
                    /* Blockquote matching code.html specific boxes */
                    .fs-content blockquote, .wp-block-quote { 
                        border-left: 4px solid #e85e30 !important; 
                        background: rgba(232,94,48,0.05) !important; 
                        padding: 1.5rem !important; 
                        border-radius: 0 1rem 1rem 0 !important; 
                        margin: 2rem 0 !important; 
                        font-style: normal !important; 
                        color: #0f172a !important;
                    }
                    
                    .fs-content a { color: #e85e30 !important; font-weight: 600 !important; text-decoration: none !important; }
                    .fs-content a:hover { text-decoration: underline !important; }
                </style>
                
                <?php
                the_content();
                wp_link_pages( array(
                    'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'himalayanmart' ) . '</span>',
                    'after'  => '</div>',
                ) );
                ?>
            </div>

            <!-- Tags -->
            <?php if ( has_tag() ) : ?>
            <div class="flex flex-wrap gap-2 mt-12 mb-8">
                <?php
                $tags = get_the_tags();
                foreach ( $tags as $tag ) {
                    echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" class="bg-primary/5 text-primary border border-primary/20 hover:bg-primary hover:text-white transition-colors text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">' . esc_html( $tag->name ) . '</a>';
                }
                ?>
            </div>
            <?php endif; ?>

            <!-- Share Buttons -->
            <?php if ( $show_share ) : ?>
            <div class="flex items-center gap-3 py-6 border-t border-b border-primary/10 my-8">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest mr-2"><?php esc_html_e( 'Share Layout', 'himalayanmart' ); ?></span>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( get_permalink() ); ?>" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-primary/5 text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                </a>
                <a href="https://twitter.com/intent/tweet?url=<?php echo esc_url( get_permalink() ); ?>&text=<?php echo esc_attr( get_the_title() ); ?>" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-primary/5 text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>
                </a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url( get_permalink() ); ?>" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-primary/5 text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
                </a>
            </div>
            <?php endif; ?>

            <!-- Post Navigation -->
            <?php if ( $show_navigation ) :
                $prev_post = get_previous_post();
                $next_post = get_next_post();
                if ( $prev_post || $next_post ) :
            ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
                <?php if ( $prev_post ) : ?>
                <a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="group p-6 rounded-2xl border border-primary/10 hover:border-primary/30 hover:shadow-lg transition-all bg-white dark:bg-slate-800">
                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-2 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">arrow_back</span> <?php esc_html_e( 'Previous', 'himalayanmart' ); ?>
                    </div>
                    <div class="font-bold text-slate-800 dark:text-white group-hover:text-primary transition-colors leading-snug">
                        <?php echo esc_html( wp_trim_words( get_the_title( $prev_post ), 8 ) ); ?>
                    </div>
                </a>
                <?php else : ?><div></div><?php endif; ?>

                <?php if ( $next_post ) : ?>
                <a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="group p-6 rounded-2xl border border-primary/10 hover:border-primary/30 hover:shadow-lg transition-all bg-white dark:bg-slate-800 text-right">
                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-2 flex items-center justify-end gap-1">
                        <?php esc_html_e( 'Next', 'himalayanmart' ); ?> <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </div>
                    <div class="font-bold text-slate-800 dark:text-white group-hover:text-primary transition-colors leading-snug">
                        <?php echo esc_html( wp_trim_words( get_the_title( $next_post ), 8 ) ); ?>
                    </div>
                </a>
                <?php else : ?><div></div><?php endif; ?>
            </div>
            <?php endif; endif; ?>

            <!-- Author Box (Mobile / Bottom of content) -->
            <?php if ( $show_author && ! $has_sidebar ) : // Only show here if no sidebar ?>
            <div class="fs-glass p-8 rounded-3xl shadow-sm border border-primary/10 mb-10">
                <div class="flex items-center gap-4 mb-4">
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 64, '', '', array( 'class' => 'w-16 h-16 rounded-full border-2 border-primary' ) ); ?>
                    <div>
                        <h4 class="font-bold text-lg text-slate-900"><?php the_author(); ?></h4>
                        <p class="text-xs text-slate-500 uppercase font-bold tracking-tight"><?php echo esc_html( get_the_author_meta( 'user_url' ) ? 'Writer' : 'Author' ); ?></p>
                    </div>
                </div>
                <?php if ( get_the_author_meta( 'description' ) ) : ?>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-6">
                    <?php echo esc_html( get_the_author_meta( 'description' ) ); ?>
                </p>
                <?php endif; ?>
                <div class="flex gap-4">
                    <?php if ( get_the_author_meta( 'user_url' ) ) : ?>
                    <a href="<?php echo esc_url( get_the_author_meta( 'user_url' ) ); ?>" class="p-2 rounded-full bg-primary/10 text-primary hover:bg-primary hover:text-white transition-all"><span class="material-symbols-outlined text-sm">public</span></a>
                    <?php endif; ?>
                    <a href="mailto:<?php echo esc_attr( get_the_author_meta( 'user_email' ) ); ?>" class="p-2 rounded-full bg-primary/10 text-primary hover:bg-primary hover:text-white transition-all"><span class="material-symbols-outlined text-sm">alternate_email</span></a>
                </div>
            </div>
            <?php endif; ?>

            <!-- Related Posts -->
            <?php if ( $show_related ) : ?>
                <?php get_template_part( 'template-parts/blog/related', 'posts' ); ?>
            <?php endif; ?>

            <!-- Comments -->
            <?php
            if ( comments_open() || get_comments_number() ) :
                echo '<div class="mt-12">';
                comments_template();
                echo '</div>';
            endif;
            ?>
        </article>

        <?php if ( $has_sidebar ) : ?>
        <!-- Sidebar: Right (1/3) -->
        <aside class="<?php echo esc_attr( $side_class ); ?>">
            
            <!-- 1. Author Widget -->
            <?php if ( $show_author ) : ?>
            <div class="fs-glass p-8 rounded-3xl shadow-sm border border-primary/10">
                <h3 class="text-sm font-bold text-primary uppercase tracking-widest mb-6"><?php esc_html_e( 'The Author', 'himalayanmart' ); ?></h3>
                <div class="flex items-center gap-4 mb-4">
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 64, '', '', array( 'class' => 'w-16 h-16 rounded-full border-2 border-primary object-cover' ) ); ?>
                    <div>
                        <h4 class="font-bold text-lg text-slate-900"><?php the_author(); ?></h4>
                        <p class="text-xs text-slate-500 uppercase font-bold tracking-tight"><?php echo esc_html( get_the_author_meta( 'user_url' ) ? 'Writer' : 'Author' ); ?></p>
                    </div>
                </div>
                <?php if ( get_the_author_meta( 'description' ) ) : ?>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-6">
                    <?php echo esc_html( get_the_author_meta( 'description' ) ); ?>
                </p>
                <?php endif; ?>
                <div class="flex gap-4">
                    <?php if ( get_the_author_meta( 'user_url' ) ) : ?>
                    <a href="<?php echo esc_url( get_the_author_meta( 'user_url' ) ); ?>" target="_blank" class="p-2 rounded-full bg-primary/10 text-primary hover:bg-primary hover:text-white transition-all"><span class="material-symbols-outlined text-sm">public</span></a>
                    <?php endif; ?>
                    <a href="mailto:<?php echo esc_attr( get_the_author_meta( 'user_email' ) ); ?>" class="p-2 rounded-full bg-primary/10 text-primary hover:bg-primary hover:text-white transition-all"><span class="material-symbols-outlined text-sm">alternate_email</span></a>
                </div>
            </div>
            <?php endif; ?>

            <!-- 2. Trending Destinations (Categories) -->
            <div class="fs-glass p-8 rounded-3xl shadow-sm border border-primary/10">
                <h3 class="text-sm font-bold text-primary uppercase tracking-widest mb-6"><?php esc_html_e( 'Trending Near You', 'himalayanmart' ); ?></h3>
                <ul class="space-y-4">
                    <?php
                    $top_cats = get_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'number' => 4, 'hide_empty' => true ) );
                    foreach ( $top_cats as $cat ) :
                    ?>
                    <li>
                        <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="group flex justify-between items-center py-2 border-b border-primary/5 hover:border-primary/20 transition-all">
                            <span class="font-medium text-slate-700 group-hover:text-primary transition-colors"><?php echo esc_html( $cat->name ); ?></span>
                            <span class="bg-primary/10 text-primary text-xs font-bold px-2 py-1 rounded-lg"><?php echo esc_html( str_pad( $cat->count, 2, '0', STR_PAD_LEFT ) ); ?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- 3. Dynamic Sidebar (Featured Homestay Carousel + others) -->
            <?php if ( is_active_sidebar( 'sidebar-blog' ) ) : ?>
                <style>
                    /* Make Dynamic Widgets match the code.html glass card style */
                    .fs-sidebar-widget { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(232, 94, 48, 0.1); padding: 2rem; border-radius: 1.5rem; margin-bottom: 2rem; }
                    .fs-sidebar-widget .widget-title { font-size: 0.875rem; font-weight: 700; color: #e85e30; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1.5rem; }
                    
                    /* Specific styling for the actual carousel to match the Featured Homestay card from code.html */
                    .widget_hm_homestay_carousel { padding: 0 !important; border: 1px solid rgba(232, 94, 48, 0.1); border-radius: 1.5rem; background: rgba(255,255,255,0.7); overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
                    .widget_hm_homestay_carousel .widget-title { margin: 1.5rem 1.5rem 0.5rem; display: none; } /* Hide the basic title, use the carousel's internal one if desired, or let it rip */
                    .hm-carousel-wrap { border-radius: 1.5rem; }
                    .hm-card-body { padding: 1.5rem; background: transparent; border: none; }
                    .hm-card-img { border-radius: 0; aspect-ratio: auto; height: 16rem; }
                    .hm-card-badge { top: 1rem; right: 1rem; background: rgba(255,255,255,0.9); color: #e85e30; padding: 0.25rem 0.75rem; }
                    .hm-card-title { font-size: 1.25rem; }
                    .hm-card-price .price-amount { font-size: 1.5rem; }
                    .hm-card-cta { border-radius: 1rem; padding: 1rem; }
                </style>
                <?php dynamic_sidebar( 'sidebar-blog' ); ?>
            <?php endif; ?>

            <!-- 4. Newsletter Signup (if not heavily using the widget) -->
            <!-- We include a hardcoded version here as requested by code.html, but the user may prefer their widget. 
                 We will render the one from code.html since they wanted EXACT match. -->
            <div class="bg-primary p-8 rounded-3xl shadow-lg text-white">
                <h3 class="text-lg font-bold mb-2"><?php esc_html_e( 'Join the Expedition', 'himalayanmart' ); ?></h3>
                <p class="text-sm text-white/80 mb-6 leading-relaxed"><?php esc_html_e( 'Weekly dispatches from the world\'s most remote corners. No fluff, just exploration.', 'himalayanmart' ); ?></p>
                <form class="space-y-3" onsubmit="event.preventDefault();">
                    <input class="w-full bg-white/10 border-white/20 rounded-xl px-4 py-3 placeholder:text-white/40 focus:ring-white/50 focus:border-white text-sm text-white outline-none" placeholder="<?php esc_attr_e( 'Your satellite email...', 'himalayanmart' ); ?>" type="email" required/>
                    <button class="w-full bg-white text-primary py-3 rounded-xl font-bold text-sm uppercase tracking-widest hover:bg-background-light transition-all" type="submit"><?php esc_html_e( 'Subscribe', 'himalayanmart' ); ?></button>
                </form>
                <p class="text-[10px] text-white/50 mt-4 text-center uppercase tracking-widest"><?php esc_html_e( 'Privacy encrypted. 2026 Secured.', 'himalayanmart' ); ?></p>
            </div>

        </aside>
        <?php endif; ?>

    </div>
    <?php endwhile; ?>
    </main>
</div>

<?php get_footer(); ?>
