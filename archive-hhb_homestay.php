<?php
/**
 * The template for displaying archive pages for hhb_homestay.
 *
 * Implements the full-screen hero and property grid from code.html
 *
 * @package HimalayanMart
 */

get_header();

// Fetch filter values
$selected_type = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : '';
$selected_loc  = isset($_GET['location']) ? sanitize_text_field($_GET['location']) : '';

// Prefix and Suffix from Customizer (Location)
$title_prefix = get_theme_mod('himalayanmart_homestay_archive_prefix', 'Explore Homestays in ');
$title_suffix = get_theme_mod('himalayanmart_homestay_archive_suffix', '');

// Prefix and Suffix from Customizer (Property Type)
$prop_prefix = get_theme_mod('himalayanmart_property_type_archive_prefix', 'Explore ');
$prop_suffix = get_theme_mod('himalayanmart_property_type_archive_suffix', ' Stays');

// Handle Active Term and Title logic
$active_term = null;
$location_name = 'the Himalayas';
$hero_bg_image = 'https://images.unsplash.com/photo-1516575150278-77136aed6920?q=80&w=2940&auto=format&fit=crop';
$hero_desc = 'Experience the magic of the Himalayas in our handpicked cozy homestays. Nestled amidst snow-capped peaks and lush pine forests, find your perfect winter vibe and enjoy the warm hospitality of local hosts.';

$is_property_type = false;

if ($selected_loc) {
    $active_term = get_term_by('slug', $selected_loc, 'hhb_location');
    if ($active_term) {
        $location_name = $active_term->name;
    }
} elseif ($selected_type) {
    $active_term = get_term_by('slug', $selected_type, 'hhb_property_type');
    if ($active_term) {
        $location_name = $active_term->name;
        $is_property_type = true;
    }
} elseif (is_tax()) {
    $active_term = get_queried_object();
    $location_name = $active_term->name;
    if ($active_term->taxonomy === 'hhb_property_type') {
        $selected_type = $active_term->slug;
        $is_property_type = true;
    }
    if ($active_term->taxonomy === 'hhb_location') $selected_loc = $active_term->slug;
}

// Final Dynamic Title
if ($is_property_type) {
    $hero_title = $prop_prefix . $location_name . $prop_suffix;
} else {
    $hero_title = $title_prefix . $location_name . $title_suffix;
}

if ($active_term) {
    // Custom Term meta overrides
    $custom_title = get_term_meta($active_term->term_id, 'hhb_term_title', true);
    if ($custom_title) $hero_title = $custom_title;
    
    $image_id = get_term_meta($active_term->term_id, 'hhb_term_image', true);
    if ($image_id) {
        $img_url = wp_get_attachment_image_url($image_id, 'full');
        if ($img_url) $hero_bg_image = $img_url;
    }
    
    $term_desc = term_description($active_term->term_id);
    if ($term_desc) $hero_desc = wp_strip_all_tags($term_desc);
}

// Taxonomies for references
$prop_types = get_terms(array('taxonomy' => 'hhb_property_type', 'hide_empty' => false));
$locations  = get_terms(array('taxonomy' => 'hhb_location', 'hide_empty' => false));
?>

<?php /* Assets (Tailwind, Material Symbols, Inter font) are enqueued
         via functions.php for archive and taxonomy pages — no inline tags needed. */ ?>



<style>
    .mountain-texture {
        background-image: radial-gradient(circle at 2px 2px, rgba(232, 94, 48, 0.05) 1px, transparent 0);
        background-size: 40px 40px;
    }
    .hero-glass-search {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    /* WP Overrides */
    #page, .site, .site-content { max-width: none !important; padding: 0 !important; margin: 0 !important; width: 100% !important; }
    .hhb-archive-wrap { overflow-x: hidden; width: 100%; }
    /* Pagination — inline horizontal layout */
    .hhb-archive-wrap .page-numbers,
    .hhb-archive-wrap nav.pagination ul,
    .hhb-archive-wrap ul.page-numbers {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 6px;
        list-style: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .hhb-archive-wrap ul.page-numbers li { display: flex; }
    .hhb-archive-wrap ul.page-numbers li a,
    .hhb-archive-wrap ul.page-numbers li span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 44px;
        height: 44px;
        padding: 0 14px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 14px;
        border: 1.5px solid #e2e8f0;
        background: #fff;
        color: #334155;
        text-decoration: none;
        transition: background .15s, color .15s, border-color .15s;
    }
    .hhb-archive-wrap ul.page-numbers li a:hover {
        background: #e85e30;
        color: #fff;
        border-color: #e85e30;
    }
    .hhb-archive-wrap ul.page-numbers li span.current {
        background: #e85e30;
        color: #fff;
        border-color: #e85e30;
    }
    .hhb-archive-wrap ul.page-numbers li span.dots {
        border-color: transparent;
        background: transparent;
    }
</style>

<div class="hhb-archive-wrap font-display text-slate-900 bg-background-light">
    <main class="relative">
        
        <!-- Hero Section -->
        <section class="relative h-[75vh] min-h-[500px] flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center transition-all duration-700" style="background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.6)), url('<?php echo esc_url($hero_bg_image); ?>')"></div>
            
            <div class="relative z-10 text-center px-4 max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-white mb-6 drop-shadow-lg leading-tight">
                    <?php echo esc_html($hero_title); ?>
                </h1>
                <p class="text-base md:text-lg text-white/90 leading-relaxed font-medium mb-10 max-w-2xl mx-auto drop-shadow-md">
                    <?php echo esc_html($hero_desc); ?>
                </p>
                
                <!-- Quick Search / Filter Bar -->
                <div class="hero-glass-search p-2 rounded-2xl max-w-xl mx-auto flex flex-col md:flex-row items-center gap-2">
                    <div class="flex items-center gap-3 px-4 py-2 w-full text-white">
                        <span class="material-symbols-outlined">location_on</span>
                        <select onchange="window.location.href=this.value" class="bg-transparent border-none focus:ring-0 text-white w-full text-sm font-bold cursor-pointer appearance-none">
                            <option value="<?php echo esc_url(get_post_type_archive_link('hhb_homestay')); ?>" class="text-slate-900">All Locations</option>
                            <?php foreach ($locations as $loc) : ?>
                                <option value="<?php echo esc_url(add_query_arg('location', $loc->slug, get_post_type_archive_link('hhb_homestay'))); ?>" <?php selected($selected_loc, $loc->slug); ?> class="text-slate-900"><?php echo esc_html($loc->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="h-6 w-[1px] bg-white/20 hidden md:block"></div>
                    <div class="flex items-center gap-3 px-4 py-2 w-full text-white">
                        <span class="material-symbols-outlined">cottage</span>
                        <select onchange="window.location.href=this.value" class="bg-transparent border-none focus:ring-0 text-white w-full text-sm font-bold cursor-pointer appearance-none">
                            <option value="<?php echo esc_url(get_post_type_archive_link('hhb_homestay')); ?>" class="text-slate-900">All Types</option>
                            <?php foreach ($prop_types as $type) : ?>
                                <option value="<?php echo esc_url(add_query_arg('type', $type->slug, get_post_type_archive_link('hhb_homestay'))); ?>" <?php selected($selected_type, $type->slug); ?> class="text-slate-900"><?php echo esc_html($type->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Property Grid -->
        <section class="py-16 px-6 md:px-20 relative mountain-texture">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                    <div>
                        <h2 class="text-3xl font-bold mb-2">Available Stays</h2>
                        <p class="text-slate-500">Showing handpicked properties in <?php echo esc_html($location_name); ?></p>
                    </div>
                    
                    <div class="flex gap-2">
                        <!-- Desktop Sorting/Filtering Placeholders -->
                        <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm font-bold text-slate-600">
                           <span class="material-symbols-outlined text-sm">sort</span>
                           <span>Sort by Price</span>
                        </div>
                    </div>
                </div>

                <?php
                global $wpdb;
                $hhb_arch_rtable = $wpdb->prefix . 'hhb_reviews';
                $hhb_arch_rexist = $wpdb->get_var( "SHOW TABLES LIKE '{$hhb_arch_rtable}'" );
                ?>
                <?php if ( have_posts() ) : ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <?php while ( have_posts() ) : the_post();
                            $price_range = hhb_get_price_range( get_the_ID() );
                            $types       = get_the_terms( get_the_ID(), 'hhb_property_type' );
                            $locs        = get_the_terms( get_the_ID(), 'hhb_location' );
                            $arch_rating = 0;
                            $arch_review_count = 0;
                            if ( $hhb_arch_rexist ) {
                                $arch_rrow   = $wpdb->get_row( $wpdb->prepare(
                                    "SELECT AVG(rating) AS avg_r, COUNT(*) AS cnt FROM {$hhb_arch_rtable} WHERE homestay_id = %d AND status = 'approved'",
                                    get_the_ID()
                                ) );
                                if ( $arch_rrow && $arch_rrow->cnt > 0 ) {
                                    $arch_rating = round( (float) $arch_rrow->avg_r, 1 );
                                    $arch_review_count = (int) $arch_rrow->cnt;
                                }
                            }
                        ?>
                            <article class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 transition-all hover:shadow-xl hover:-translate-y-1">
                                <div class="relative aspect-[4/3] overflow-hidden">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-110')); ?>
                                        </a>
                                    <?php else : ?>
                                        <a href="<?php the_permalink(); ?>" class="block w-full h-full bg-slate-100 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-4xl text-slate-300">landscape</span>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <div class="absolute top-4 left-4 flex flex-wrap gap-2 pointer-events-none">
                                        <?php if ($types && !is_wp_error($types)) : foreach(array_slice($types, 0, 1) as $term) : 
                                            $term_link = get_term_link($term);
                                        ?>
                                            <a href="<?php echo esc_url(is_wp_error($term_link) ? '#' : $term_link); ?>" class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-black text-slate-700 uppercase tracking-widest shadow-sm pointer-events-auto hover:bg-slate-100 transition-colors">
                                                <?php echo esc_html($term->name); ?>
                                            </a>
                                        <?php endforeach; endif; ?>
                                    </div>

                                    <?php 
                                    $is_best_seller = get_post_meta(get_the_ID(), '_is_best_seller', true);
                                    if ($is_best_seller) : ?>
                                        <div class="absolute top-4 right-4 bg-primary text-white px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg z-10">
                                            BEST SELLER
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Wishlist Heart -->
                                    <button type="button" class="hhb-wishlist-toggle absolute top-4 <?php echo $is_best_seller ? 'right-[125px]' : 'right-4'; ?> z-20 w-8 h-8 rounded-full bg-white/70 backdrop-blur border border-white flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-white transition-all shadow-sm group/heart" data-post-id="<?php echo get_the_ID(); ?>" aria-label="Toggle Wishlist" onclick="event.preventDefault();">
                                        <?php $is_hearted = \Himalayan\Homestay\Interface\Frontend\WishlistHandler::is_in_wishlist(get_the_ID()); ?>
                                        <svg class="w-5 h-5 transition-transform duration-300 group-hover/heart:scale-110" 
                                             fill="<?php echo $is_hearted ? 'currentColor' : 'none'; ?>" 
                                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                             style="<?php echo $is_hearted ? 'color: #ef4444;' : ''; ?>">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <h3 class="text-xl font-bold text-slate-900 group-hover:text-primary transition-colors pr-4">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        <div class="text-right shrink-0">
                                            <?php if ( $price_range ) : ?>
                                                <p class="text-primary font-black text-xl leading-none"><?php echo esc_html( $price_range['formatted'] ); ?></p>
                                                <span class="text-slate-400 text-[10px] font-bold uppercase tracking-tighter">per night</span>
                                            <?php else : ?>
                                                <p class="text-slate-400 text-sm font-medium">Price TBD</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-4 text-slate-500 text-sm mb-6 pb-6 border-b border-slate-50">
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-lg">group</span>
                                            <span class="font-semibold text-xs"><?php echo get_post_meta(get_the_ID(), 'hhb_max_guests', true) ?: '2'; ?> Guest</span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-lg">bed</span>
                                            <span class="font-semibold text-xs"><?php echo get_post_meta(get_the_ID(), 'hhb_total_bedrooms', true) ?: '1'; ?> BR</span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-lg">star</span>
                                            <span class="font-semibold text-xs">
                                                <?php if ( $arch_review_count > 0 ) : ?>
                                                    <?php echo esc_html( $arch_rating ); ?> <span class="text-slate-400 font-medium">(<?php echo esc_html( $arch_review_count ); ?>)</span>
                                                <?php else : ?>
                                                    New
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                    </div>

                                    <a href="<?php the_permalink(); ?>" class="block w-full py-4 bg-slate-50 text-slate-900 font-black text-center text-sm rounded-xl hover:bg-primary hover:text-white transition-all transform active:scale-95 shadow-sm">
                                        View Details
                                    </a>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>
                    
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const toggles = document.querySelectorAll('.hhb-wishlist-toggle');
                        toggles.forEach(toggle => {
                            toggle.addEventListener('click', function(e) {
                                e.preventDefault();
                                e.stopPropagation();
                                
                                const postId = this.dataset.postId;
                                const svg = this.querySelector('svg');
                                
                                // Optimistic update
                                const isCurrentlyHearted = svg.getAttribute('fill') === 'currentColor';
                                if (isCurrentlyHearted) {
                                    svg.setAttribute('fill', 'none');
                                    svg.style.color = '';
                                    svg.style.transform = 'scale(0.9)';
                                } else {
                                    svg.setAttribute('fill', 'currentColor');
                                    svg.style.color = '#ef4444';
                                    svg.style.transform = 'scale(1.2)';
                                }
                                setTimeout(() => { svg.style.transform = ''; }, 200);

                                const formData = new FormData();
                                formData.append('action', 'hhb_toggle_wishlist');
                                formData.append('post_id', postId);
                                formData.append('security', '<?php echo wp_create_nonce("hhb_wishlist_nonce"); ?>');

                                fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (!data.success) {
                                        alert(data.data);
                                        // Revert on failure
                                        if (isCurrentlyHearted) {
                                            svg.setAttribute('fill', 'currentColor');
                                            svg.style.color = '#ef4444';
                                        } else {
                                            svg.setAttribute('fill', 'none');
                                            svg.style.color = '';
                                        }
                                    }
                                })
                                .catch(err => console.error(err));
                            });
                        });
                    });
                    </script>

                    <!-- Pagination -->
                    <?php
                    // For real taxonomy URLs (e.g. /property-type/cheap-homestay/), use the term link.
                    // For GET-param filtered archive pages (e.g. ?location=india), build the URL with params.
                    if ( is_tax() && $active_term ) {
                        $pagination_base = get_term_link( $active_term );
                        $pagination_fmt  = 'page/%#%/';
                        $add_args        = false;
                    } else {
                        $paged_args = array();
                        if ( $selected_loc )  $paged_args['location'] = $selected_loc;
                        if ( $selected_type ) $paged_args['type']     = $selected_type;
                        $pagination_base = add_query_arg( $paged_args, get_post_type_archive_link('hhb_homestay') );
                        $pagination_fmt  = '?paged=%#%';
                        $add_args        = false;
                    }
                    ?>
                    <div class="mt-16 flex justify-center">
                        <?php
                        echo paginate_links( array(
                            'base'      => trailingslashit( $pagination_base ) . '%_%',
                            'format'    => $pagination_fmt,
                            'current'   => max( 1, get_query_var('paged') ),
                            'total'     => $wp_query->max_num_pages,
                            'prev_text' => '<span class="material-symbols-outlined">chevron_left</span>',
                            'next_text' => '<span class="material-symbols-outlined">chevron_right</span>',
                            'type'      => 'list',
                            'add_args'  => $add_args,
                        ) );
                        ?>
                    </div>

                <?php else : ?>
                    <div class="text-center py-20 bg-white rounded-3xl border border-slate-100 border-dashed">
                        <span class="material-symbols-outlined text-6xl text-slate-200 mb-4">other_houses</span>
                        <h3 class="text-2xl font-bold text-slate-400">No properties found at this time</h3>
                        <p class="text-slate-400 mt-2">Try adjusting your filters or checking back later.</p>
                        <a href="<?php echo esc_url(get_post_type_archive_link('hhb_homestay')); ?>" class="inline-block mt-6 text-primary font-bold transition-opacity hover:opacity-80">Clear all filters</a>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php
        // Bottom Content — displayed below the property grid for SEO (set per-term in taxonomy admin)
        $bottom_content = '';
        if ( $active_term ) {
            $bottom_content = get_term_meta( $active_term->term_id, 'hhb_term_bottom_content', true );
        }
        if ( $bottom_content ) : ?>
        <section class="relative py-20 px-6 md:px-20 mountain-texture" style="background-color:#f8f6f6; border-top: 3px solid #e85e30;">

            <!-- Decorative top stripe -->
            <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-transparent via-primary to-transparent opacity-30"></div>

            <div class="max-w-4xl mx-auto">

                <!-- Section Label -->
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-primary" style="font-size:20px;">menu_book</span>
                    </div>
                    <div>
                        <span class="text-xs font-black uppercase tracking-widest text-primary/70 block leading-none mb-0.5">About</span>
                        <p class="text-sm font-bold text-slate-500 leading-none"><?php echo esc_html( $location_name ); ?></p>
                    </div>
                    <div class="flex-1 h-px bg-slate-200 ml-4"></div>
                </div>

                <!-- Content -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 md:p-12" style="border-left: 4px solid #e85e30;">
                    <div class="prose prose-slate prose-lg max-w-none
                        prose-headings:font-black prose-headings:text-slate-900 prose-headings:leading-tight
                        prose-h2:text-2xl prose-h3:text-xl
                        prose-p:text-slate-600 prose-p:leading-relaxed
                        prose-a:text-primary prose-a:font-semibold hover:prose-a:opacity-80
                        prose-strong:text-slate-800
                        prose-ul:text-slate-600 prose-li:marker:text-primary">
                        <?php echo wp_kses_post( $bottom_content ); ?>
                    </div>
                </div>

                <!-- Decorative footer line -->
                <div class="flex items-center gap-4 mt-10">
                    <div class="flex-1 h-px bg-slate-200"></div>
                    <span class="material-symbols-outlined text-slate-300" style="font-size:18px;">landscape</span>
                    <div class="flex-1 h-px bg-slate-200"></div>
                </div>

            </div>
        </section>
        <?php endif; ?>

    </main>
</div>

<?php get_footer(); ?>
