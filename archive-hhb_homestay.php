<?php
/**
 * The template for displaying archive pages for hhb_homestay.
 *
 * @package HimalayanMart
 */

get_header();

// Fetch filter values
$selected_type = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : '';
$selected_loc  = isset($_GET['location']) ? sanitize_text_field($_GET['location']) : '';

// Handle Active Term and Custom Meta
$active_term = null;
$hero_bg_image = 'https://images.unsplash.com/photo-1516575150278-77136aed6920?q=80&w=2940&auto=format&fit=crop';
$hero_title = 'Discover Himalayan Stays';
$bottom_content = '';

if ($selected_loc) {
    $active_term = get_term_by('slug', $selected_loc, 'hhb_location');
    if ($active_term) {
        $hero_title = 'Stays in ' . $active_term->name;
    }
} elseif ($selected_type) {
    $active_term = get_term_by('slug', $selected_type, 'hhb_property_type');
    if ($active_term) {
        $hero_title = $active_term->name . ' Stays';
    }
} elseif (is_tax()) {
    $active_term = get_queried_object();
    $hero_title = $active_term->name;
    if ($active_term->taxonomy === 'hhb_property_type') $selected_type = $active_term->slug;
    if ($active_term->taxonomy === 'hhb_location') $selected_loc = $active_term->slug;
}

if ($active_term) {
    $custom_title = get_term_meta($active_term->term_id, 'hhb_term_title', true);
    if ($custom_title) $hero_title = $custom_title;
    
    $image_id = get_term_meta($active_term->term_id, 'hhb_term_image', true);
    if ($image_id) {
        $img_url = wp_get_attachment_image_url($image_id, 'full');
        if ($img_url) $hero_bg_image = $img_url;
    }
    
    $bottom_content = get_term_meta($active_term->term_id, 'hhb_term_bottom_content', true);
}

// Taxonomy for the categories bar
$prop_types = get_terms(array(
    'taxonomy' => 'hhb_property_type',
    'hide_empty' => false,
));

$locations = get_terms(array(
    'taxonomy' => 'hhb_location',
    'hide_empty' => false,
));
?>

<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "primary": "#1392ec",
                    "background-light": "#f6f7f8",
                    "background-dark": "#101a22",
                },
                fontFamily: {
                    "display": ["Plus Jakarta Sans", "sans-serif"]
                },
                backgroundImage: {
                    'glass': 'linear-gradient(135deg, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.6))',
                    'glass-hover': 'linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.7))',
                    'glass-dark': 'linear-gradient(135deg, rgba(16, 26, 34, 0.8), rgba(16, 26, 34, 0.6))',
                }
            },
        },
    }
</script>
<style>
    .glass-panel {
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    }
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    details summary::-webkit-details-marker {
        display: none;
    }

    /* WP theme overrides */
    body { background: #f6f7f8 !important; }
    #page, .site, .site-content { 
        max-width: none !important; 
        padding: 0 !important; 
        margin: 0 !important;
        width: 100% !important;
        background: transparent !important;
    }
    .hhb-archive-bg {
        width: 100vw !important;
        max-width: 100vw !important;
        position: relative;
        left: 50%;
        transform: translateX(-50%);
        min-height: 100vh;
    }
    body, html { overflow-x: hidden; margin: 0; padding: 0; }
</style>

<div class="hhb-archive-bg font-display antialiased text-slate-900 dark:text-slate-100 bg-fixed bg-cover bg-center min-h-screen relative" style="background-image: url('<?php echo esc_url($hero_bg_image); ?>');">
    <div class="absolute inset-0 bg-white/10 dark:bg-black/20 backdrop-blur-[2px] z-0 pointer-events-none"></div>
    <div class="relative z-10 flex flex-col min-h-screen">
        
        <!-- Filter Header -->
        <header class="sticky top-0 z-50 w-full glass-panel bg-glass dark:bg-glass-dark border-b border-white/20 dark:border-white/10"> 
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                
                <form method="GET" action="<?php echo esc_url(get_post_type_archive_link('hhb_homestay')); ?>" class="hidden md:flex items-center bg-white/80 dark:bg-black/40 rounded-full shadow-sm hover:shadow-md transition-shadow border border-slate-200/50 dark:border-slate-700/50 py-2 pl-6 pr-2 max-w-2xl w-full mx-auto divide-x divide-slate-300 dark:divide-slate-600 mb-4">
                    
                    <div class="flex-1 px-4 relative">
                        <div class="text-xs text-slate-500 dark:text-slate-400 font-bold mb-1">Where</div>
                        <select name="location" class="w-full bg-transparent border-none p-0 text-sm font-medium text-slate-900 focus:ring-0 cursor-pointer">
                            <option value="">Anywhere</option>
                            <?php foreach ($locations as $loc) : ?>
                                <option value="<?php echo esc_attr($loc->slug); ?>" <?php selected($selected_loc, $loc->slug); ?>><?php echo esc_html($loc->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex-1 px-4 relative">
                        <div class="text-xs text-slate-500 dark:text-slate-400 font-bold mb-1">Property Type</div>
                        <select name="type" class="w-full bg-transparent border-none p-0 text-sm font-medium text-slate-900 focus:ring-0 cursor-pointer">
                            <option value="">Any Type</option>
                            <?php foreach ($prop_types as $type) : ?>
                                <option value="<?php echo esc_attr($type->slug); ?>" <?php selected($selected_type, $type->slug); ?>><?php echo esc_html($type->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="bg-primary text-white p-3 rounded-full hover:bg-primary/90 transition-colors flex items-center justify-center shadow-lg shadow-primary/30 ml-2">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                    </button>
                </form>

                <!-- Icons Bar -->
                <div class="flex items-center gap-8 overflow-x-auto hide-scrollbar pb-4 pt-2 -mx-4 px-4 sm:mx-0 sm:px-0 border-t border-slate-200/20 dark:border-slate-700/20">
                    
                    <a href="<?php echo esc_url(get_post_type_archive_link('hhb_homestay')); ?>" class="group flex flex-col items-center gap-2 min-w-[64px] cursor-pointer pb-2 <?php echo empty($selected_type) ? 'border-b-2 border-primary' : 'border-b-2 border-transparent hover:border-slate-300 opacity-60 hover:opacity-100 transition-all'; ?>">
                        <span class="material-symbols-outlined <?php echo empty($selected_type) ? 'text-primary' : 'text-slate-600'; ?> group-hover:scale-110 transition-transform">grid_view</span>
                        <span class="text-xs <?php echo empty($selected_type) ? 'font-bold' : 'font-medium'; ?> text-slate-900 whitespace-nowrap">All Stays</span>
                    </a>

                    <?php 
                    // Map common types to Material Icons
                    $icon_map = array(
                        'cabin' => 'cottage',
                        'farm' => 'agriculture',
                        'tiny-home' => 'home_work',
                        'treehouse' => 'forest',
                        'lakefront' => 'water_drop',
                        'mountain' => 'landscape',
                        'villa' => 'villa'
                    );

                    foreach ($prop_types as $type) : 
                        $is_active = ($selected_type === $type->slug);
                        $icon = 'home';
                        foreach($icon_map as $key => $val) {
                            if (stripos($type->slug, $key) !== false) $icon = $val;
                        }
                    ?>
                        <a href="<?php echo esc_url(add_query_arg('type', $type->slug, get_post_type_archive_link('hhb_homestay'))); ?>" class="group flex flex-col items-center gap-2 min-w-[64px] cursor-pointer pb-2 <?php echo $is_active ? 'border-b-2 border-primary' : 'border-b-2 border-transparent hover:border-slate-300 opacity-60 hover:opacity-100 transition-all'; ?>">
                            <span class="material-symbols-outlined <?php echo $is_active ? 'text-primary' : 'text-slate-600'; ?> group-hover:scale-110 transition-transform"><?php echo $icon; ?></span>
                            <span class="text-xs <?php echo $is_active ? 'font-bold' : 'font-medium'; ?> text-slate-900 whitespace-nowrap"><?php echo esc_html($type->name); ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </header>

        <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
            
            <?php
            // Setup Archive Query
            $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
            $args = array(
                'post_type' => 'hhb_homestay',
                'posts_per_page' => 12,
                'paged' => $paged,
            );

            $tax_query = array('relation' => 'AND');
            if ($selected_type) {
                $tax_query[] = array('taxonomy' => 'hhb_property_type', 'field' => 'slug', 'terms' => $selected_type);
            }
            if ($selected_loc) {
                $tax_query[] = array('taxonomy' => 'hhb_location', 'field' => 'slug', 'terms' => $selected_loc);
            }
            if (count($tax_query) > 1) {
                $args['tax_query'] = $tax_query;
            }

            $query = new WP_Query($args);

            if ( $query->have_posts() ) : ?>

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white">
                        <?php echo esc_html($hero_title); ?>
                    </h2>
                    <span class="text-sm font-medium text-slate-500 bg-white/50 px-3 py-1 rounded-full"><?php echo $query->found_posts; ?> places found</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 pb-12">
                    <?php while ( $query->have_posts() ) : $query->the_post(); 
                        $post_id = get_the_ID();
                        $base_price = get_post_meta($post_id, 'base_price_per_night', true);
                        $offer_price = get_post_meta($post_id, 'offer_price_per_night', true);
                        $currency = get_post_meta($post_id, 'currency', true) ?: 'INR';
                        $max_guests = get_post_meta($post_id, 'max_guests', true);
                        $display_price = $offer_price ? $offer_price : $base_price;
                        
                        $locations_terms = get_the_terms($post_id, 'hhb_location');
                        $loc_name = ($locations_terms && !is_wp_error($locations_terms)) ? $locations_terms[0]->name : 'India';

                        // Generate a persistent pseudo-random review score based on post ID between 4.5 and 5.0
                        $review_score = number_format(4.5 + (crc32($post_id) % 6) / 10, 1);

                        $gallery_ids = get_post_meta($post_id, 'hhb_gallery', true);
                        $gallery_ids = $gallery_ids ? explode(',', $gallery_ids) : array();
                        $thumb_url = !empty($gallery_ids) ? wp_get_attachment_image_url($gallery_ids[0], 'medium_large') : get_the_post_thumbnail_url($post_id, 'medium_large');
                        if (!$thumb_url) $thumb_url = 'https://images.unsplash.com/photo-1516575150278-77136aed6920?q=80&w=800&auto=format&fit=crop';
                    ?>
                        <div class="group relative flex flex-col gap-3">
                            <a href="<?php the_permalink(); ?>" class="block relative aspect-[4/3] w-full overflow-hidden rounded-xl">
                                <img alt="<?php the_title_attribute(); ?>" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" src="<?php echo esc_url($thumb_url); ?>"/>
                                <button class="absolute top-3 right-3 p-2 rounded-full bg-white/50 hover:bg-white backdrop-blur-md transition-all text-slate-800 hover:scale-110 shadow-sm z-10" onclick="event.preventDefault();">
                                    <span class="material-symbols-outlined block text-[20px]">favorite</span>
                                </button>
                                <?php if ($offer_price): ?>
                                <div class="absolute top-3 left-3 px-3 py-1 rounded-full bg-primary text-white text-xs font-bold shadow-sm z-10">
                                    Special Offer
                                </div>
                                <?php endif; ?>
                            </a>
                            <div class="glass-panel bg-glass dark:bg-glass-dark rounded-xl p-4 hover:shadow-lg transition-all duration-300">
                                <div class="flex justify-between items-start">
                                    <h3 class="font-bold text-slate-900 dark:text-white truncate pr-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <div class="flex items-center gap-1 shrink-0">
                                        <span class="material-symbols-outlined text-[16px] text-yellow-500" style="font-variation-settings: 'FILL' 1;">star</span>
                                        <span class="text-sm font-medium"><?php echo esc_html($review_score); ?></span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 mt-1">
                                    <p class="text-slate-600 dark:text-slate-300 text-sm truncate"><?php echo esc_html($loc_name); ?></p>
                                    <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                                    <p class="text-slate-500 dark:text-slate-400 text-xs flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">group</span> <?php echo esc_html($max_guests ? $max_guests : '2+'); ?> guests</p>
                                </div>
                                
                                <div class="mt-3 pt-3 border-t border-slate-200/50 flex items-baseline gap-1">
                                    <?php if ($offer_price): ?>
                                        <span class="font-bold text-slate-900 dark:text-white"><?php echo esc_html($currency . ' ' . $offer_price); ?></span>
                                        <span class="text-slate-500 text-xs line-through ml-1"><?php echo esc_html($currency . ' ' . $base_price); ?></span>
                                    <?php else: ?>
                                        <span class="font-bold text-slate-900 dark:text-white"><?php echo esc_html($currency . ' ' . $base_price); ?></span>
                                    <?php endif; ?>
                                    <span class="text-slate-600 dark:text-slate-300 text-sm ml-1">Night</span>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mt-8 pb-16">
                    <div class="glass-panel bg-white/60 px-6 py-3 rounded-full flex gap-2">
                        <?php
                        echo paginate_links(array(
                            'total' => $query->max_num_pages,
                            'current' => $paged,
                            'prev_text' => '<span class="material-symbols-outlined">chevron_left</span>',
                            'next_text' => '<span class="material-symbols-outlined">chevron_right</span>',
                        ));
                        ?>
                    </div>
                </div>

            <?php else : ?>
                
                <div class="text-center py-24 glass-panel bg-white/60 rounded-3xl mt-12">
                    <span class="material-symbols-outlined text-6xl text-slate-400 mb-4">search_off</span>
                    <h2 class="text-2xl font-bold text-slate-900 mb-2">No homestays found</h2>
                    <p class="text-slate-600 mb-6">Try adjusting your filters or searching in a different location.</p>
                    <a href="<?php echo esc_url(get_post_type_archive_link('hhb_homestay')); ?>" class="bg-primary text-white px-6 py-3 rounded-full font-bold hover:bg-primary/90 transition-colors shadow-lg">Clear All Filters</a>
                </div>

            <?php endif; wp_reset_postdata(); ?>
            
            <?php if (!empty($bottom_content)) : ?>
            <div class="mt-12 mb-8 p-8 glass-panel bg-white/80 dark:bg-slate-900/80 rounded-3xl text-slate-700 dark:text-slate-300 leading-relaxed entry-content">
                <?php echo do_shortcode(wpautop($bottom_content)); ?>
            </div>
            <?php endif; ?>

        </main>
    </div>
</div>

<style>
    /* Pagination Styling inside Tailwind */
    .page-numbers {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        color: #475569;
        font-weight: 600;
        transition: all 0.3s;
    }
    .page-numbers:hover {
        background: rgba(0,0,0,0.05);
    }
    .page-numbers.current {
        background: #1392ec;
        color: white;
    }
</style>

<?php get_footer(); ?>

