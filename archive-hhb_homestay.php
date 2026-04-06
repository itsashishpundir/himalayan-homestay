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
$current_sort  = isset($_GET['sort']) && in_array($_GET['sort'], ['price_asc','price_desc'], true) ? $_GET['sort'] : '';

// Helper: build a sort URL that preserves existing filters (location, type)
if ( ! function_exists('hhb_sort_url') ) {
    function hhb_sort_url( string $new_sort ): string {
        $params = array_filter([
            'location' => isset($_GET['location']) ? sanitize_text_field($_GET['location']) : '',
            'type'     => isset($_GET['type'])     ? sanitize_text_field($_GET['type'])     : '',
            'sort'     => $new_sort,
        ]);
        $base = get_post_type_archive_link('hhb_homestay') ?: home_url('/');
        return $params ? trailingslashit($base) . '?' . http_build_query($params) : $base;
    }
}

// Prefix and Suffix from Customizer (Location)
$title_prefix = get_theme_mod('himalayanmart_homestay_archive_prefix', 'Explore Homestays in ');
$title_suffix = get_theme_mod('himalayanmart_homestay_archive_suffix', '');

// Prefix and Suffix from Customizer (Property Type)
$prop_prefix = get_theme_mod('himalayanmart_property_type_archive_prefix', 'Explore ');
$prop_suffix = get_theme_mod('himalayanmart_property_type_archive_suffix', ' Stays');

// Handle Active Term and Title logic
$active_term = null;
$location_name = 'the Himalayas';
$hero_bg_image = get_theme_mod('himalayanmart_archive_global_hero_image', 'https://images.unsplash.com/photo-1516575150278-77136aed6920?q=80&w=2940&auto=format&fit=crop');
$hero_desc = get_theme_mod('himalayanmart_archive_global_hero_subtitle', 'Experience the magic of the Himalayas in our handpicked cozy homestays. Nestled amidst snow-capped peaks and lush pine forests, find your perfect winter vibe and enjoy the warm hospitality of local hosts.');

$is_property_type = false;

if ($selected_loc) {
    $active_term = get_term_by('slug', $selected_loc, 'hhb_location');
    if ($active_term) {
        $location_name = $active_term->name;
    } else {
        // Free-text search — use the typed value as the display name.
        $location_name = $selected_loc;
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
    
    $term_desc = term_description($active_term->term_id);
    if ($term_desc) $hero_desc = wp_strip_all_tags($term_desc);
}

// Taxonomies for references
$prop_types      = get_terms(array('taxonomy' => 'hhb_property_type', 'hide_empty' => false));
$locations       = get_terms(array('taxonomy' => 'hhb_location', 'hide_empty' => false));
// Latest 5 locations for autocomplete suggestions (most recently added first)
$locations_top5  = get_terms(array('taxonomy' => 'hhb_location', 'hide_empty' => false, 'orderby' => 'id', 'order' => 'DESC', 'number' => 5));
?>

<?php /* Assets (Tailwind, Material Symbols, Inter font) are enqueued
         via functions.php for archive and taxonomy pages — no inline tags needed. */ ?>



<style>
    /* Contact-Style Hero classes for Archive */
    .hhb-contact-hero {
        position: relative;
        min-height: 280px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .hhb-contact-hero-bg {
        position: absolute; inset: 0;
        background-size: cover;
        background-position: center;
    }
    .hhb-contact-hero-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.6) 100%);
    }

    .mountain-texture {
        background-image: radial-gradient(circle at 2px 2px, rgba(232, 94, 48, 0.05) 1px, transparent 0);
        background-size: 40px 40px;
    }
    /* ── Hero Search ── */
    .hhb-arc-search-wrap { width: 100%; max-width: 580px; margin: 0 auto; }

    .hhb-arc-search-bar {
        position: relative;
        z-index: 50;
        display: flex;
        align-items: center;
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.18);
        border-radius: 100px;
        padding: 6px 6px 6px 20px;
        gap: 8px;
        transition: border-color .25s, background .25s;
    }
    .hhb-arc-search-bar:focus-within {
        background: rgba(255,255,255,0.13);
        border-color: rgba(255,255,255,0.35);
        box-shadow: 0 0 0 4px rgba(244,92,37,0.15), 0 8px 32px rgba(0,0,0,0.2);
    }
    .hhb-arc-search-icon {
        color: rgba(255,255,255,0.6);
        flex-shrink: 0;
        display: flex;
        align-items: center;
        font-size: 20px;
    }
    .hhb-arc-search-input {
        flex: 1;
        background: transparent !important;
        border: none;
        outline: none;
        color: #fff !important;
        font-size: 15px;
        font-weight: 500;
        letter-spacing: 0.01em;
        min-width: 0;
        padding: 8px 0;
    }
    .hhb-arc-search-input::placeholder { color: rgba(255,255,255,0.45); }
    .hhb-arc-search-btn {
        flex-shrink: 0;
        background: linear-gradient(135deg, #f45c25, #e04010);
        color: #fff;
        border: none;
        border-radius: 100px;
        padding: 10px 24px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        letter-spacing: 0.02em;
        transition: opacity .2s, transform .2s;
        box-shadow: 0 4px 14px rgba(244,92,37,0.45);
    }
    .hhb-arc-search-btn:hover { opacity: .88; transform: scale(1.03); }

    /* Suggestions panel */
    .hhb-arc-loc-wrap { position: relative; flex: 1; min-width: 0; }
    .hhb-arc-suggestions {
        position: absolute;
        top: calc(100% + 14px);
        left: -20px;
        right: -8px;
        background: rgba(8,14,28,0.90);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid rgba(255,255,255,0.10);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 16px 48px rgba(0,0,0,0.5);
        opacity: 0;
        visibility: hidden;
        transform: translateY(-6px);
        transition: opacity .2s, transform .2s, visibility .2s;
        z-index: 100;
    }
    .hhb-arc-suggestions.is-open {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    .hhb-arc-sug-label {
        padding: 10px 16px 6px;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.35);
    }
    .hhb-arc-sug-item {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 11px 16px;
        background: transparent;
        border: none;
        color: rgba(255,255,255,0.85);
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        text-align: left;
        transition: background .15s, color .15s;
    }
    .hhb-arc-sug-item:hover, .hhb-arc-sug-item:focus {
        background: rgba(255,255,255,0.07);
        color: #fff;
        outline: none;
    }
    .hhb-arc-sug-dot {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: #f45c25;
        flex-shrink: 0;
    }

    /* Property type pills */
    .hhb-arc-pills {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 8px;
        margin-top: 16px;
    }
    .hhb-arc-pill {
        display: inline-flex;
        align-items: center;
        padding: 6px 16px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.03em;
        text-decoration: none;
        border: 1.5px solid rgba(255,255,255,0.25);
        color: rgba(255,255,255,0.75);
        background: rgba(255,255,255,0.06);
        backdrop-filter: blur(8px);
        transition: all .2s;
    }
    .hhb-arc-pill:hover {
        border-color: rgba(255,255,255,0.55);
        color: #fff;
        background: rgba(255,255,255,0.12);
    }
    .hhb-arc-pill.is-active {
        background: #fff;
        border-color: #fff;
        color: #1a1a2e;
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
        <section class="hhb-contact-hero">
            <div class="hhb-contact-hero-bg" style="background-image: url('<?php echo esc_url($hero_bg_image); ?>')"></div>
            <div class="hhb-contact-hero-overlay"></div>
            
            <div class="relative z-10 text-center px-4 py-16 max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-black text-white mb-3 drop-shadow-lg">
                    <?php echo esc_html($hero_title); ?>
                </h1>
                <p class="text-white/80 text-base md:text-lg max-w-xl mx-auto mb-10">
                    <?php echo esc_html($hero_desc); ?>
                </p>
                
                <!-- Search + Filter -->
                <div class="hhb-arc-search-wrap">
                    <form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'hhb_homestay' ) ); ?>" class="hhb-arc-search-bar" id="hhb-arc-form">
                        <span class="hhb-arc-search-icon material-symbols-outlined">search</span>
                        <div class="hhb-arc-loc-wrap">
                            <input type="text" name="location" id="hhb-arc-loc-input"
                                   value="<?php echo esc_attr( $selected_loc ); ?>"
                                   placeholder="Search a destination…"
                                   class="hhb-arc-search-input" autocomplete="off">
                            <?php if ( $selected_type ) : ?>
                                <input type="hidden" name="type" value="<?php echo esc_attr( $selected_type ); ?>">
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="hhb-arc-search-btn">Search</button>
                    </form>

                    <!-- Property type pills -->
                    <?php if ( $prop_types && ! is_wp_error( $prop_types ) ) : ?>
                    <div class="hhb-arc-pills">
                        <a href="<?php echo esc_url( get_post_type_archive_link( 'hhb_homestay' ) ); ?>"
                           class="hhb-arc-pill <?php echo ! $selected_type ? 'is-active' : ''; ?>">All</a>
                        <?php foreach ( $prop_types as $type ) : ?>
                        <a href="<?php echo esc_url( add_query_arg( 'type', $type->slug, get_post_type_archive_link( 'hhb_homestay' ) ) ); ?>"
                           class="hhb-arc-pill <?php echo $selected_type === $type->slug ? 'is-active' : ''; ?>">
                            <?php echo esc_html( $type->name ); ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
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
                    
                    <div class="flex gap-2 flex-wrap items-center">
                        <!-- Sort Pills -->
                        <span class="text-xs font-black text-slate-400 uppercase tracking-widest mr-1">Sort:</span>
                        <a href="<?php echo esc_url( hhb_sort_url('price_asc') ); ?>"
                           class="inline-flex items-center gap-1.5 border border-slate-200 rounded-xl px-4 py-2 text-sm font-bold transition-all
                                  <?php echo $current_sort === 'price_asc' ? 'bg-primary text-white border-primary shadow-md shadow-primary/25' : 'bg-white text-slate-600 hover:border-primary hover:text-primary'; ?>"
                           title="Sort cheapest first">
                          <svg width="11" height="11" viewBox="0 0 12 12" fill="currentColor"><path d="M6 2L2 8h8L6 2z"/></svg>
                          Low &rarr; High
                        </a>
                        <a href="<?php echo esc_url( hhb_sort_url('price_desc') ); ?>"
                           class="inline-flex items-center gap-1.5 border border-slate-200 rounded-xl px-4 py-2 text-sm font-bold transition-all
                                  <?php echo $current_sort === 'price_desc' ? 'bg-primary text-white border-primary shadow-md shadow-primary/25' : 'bg-white text-slate-600 hover:border-primary hover:text-primary'; ?>"
                           title="Sort most expensive first">
                          <svg width="11" height="11" viewBox="0 0 12 12" fill="currentColor"><path d="M6 10L2 4h8l-4 6z"/></svg>
                          High &rarr; Low
                        </a>
                        <?php if ($current_sort) : ?>
                          <a href="<?php echo esc_url( hhb_sort_url('') ); ?>"
                             class="text-xs font-bold text-slate-400 hover:text-primary transition-colors px-2 py-1 rounded-lg"
                             title="Clear sort">&#x2715; Clear</a>
                        <?php endif; ?>
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
                    window.hhbAjax = window.hhbAjax || { url: '<?php echo admin_url("admin-ajax.php"); ?>', nonce: '<?php echo wp_create_nonce("hhb_wishlist_nonce"); ?>' };

                    function hhbToggleWishlist(btn) {
                        // If not logged in, show the login modal (injected by WishlistHandler::output_login_modal)
                        if (!window.hhbIsLoggedIn) {
                            var modal = document.getElementById('hhb-wishlist-modal');
                            if (modal) { modal.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
                            return;
                        }

                        var postId = btn.dataset.postId;
                        var svg   = btn.querySelector('svg');
                        if (!svg || !postId) return;

                        // Optimistic UI update
                        var isHearted = svg.getAttribute('fill') === 'currentColor';
                        if (isHearted) {
                            svg.setAttribute('fill', 'none');
                            svg.style.color = '';
                        } else {
                            svg.setAttribute('fill', 'currentColor');
                            svg.style.color = '#ef4444';
                        }
                        svg.style.transform = 'scale(1.2)';
                        setTimeout(function() { svg.style.transform = ''; }, 200);

                        var formData = new FormData();
                        formData.append('action',   'hhb_toggle_wishlist');
                        formData.append('post_id',  postId);
                        formData.append('security', window.hhbAjax.nonce);

                        fetch(window.hhbAjax.url, { method: 'POST', body: formData })
                            .then(function(r) { return r.json(); })
                            .then(function(data) {
                                if (!data.success) {
                                    // Revert optimistic update
                                    if (isHearted) { svg.setAttribute('fill', 'currentColor'); svg.style.color = '#ef4444'; }
                                    else           { svg.setAttribute('fill', 'none');          svg.style.color = ''; }
                                }
                            })
                            .catch(function(err) { console.error('HHB Wishlist error:', err); });
                    }

                    document.addEventListener('DOMContentLoaded', function() {
                        document.querySelectorAll('.hhb-wishlist-toggle').forEach(function(btn) {
                            btn.addEventListener('click', function(e) {
                                e.preventDefault();
                                e.stopPropagation();
                                hhbToggleWishlist(this);
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
        $custom_about_title = '';
        if ( $active_term ) {
            $bottom_content = get_term_meta( $active_term->term_id, 'hhb_term_bottom_content', true );
            $custom_about_title = get_term_meta( $active_term->term_id, 'hhb_term_custom_about', true );
        }
        
        if ( empty( $custom_about_title ) && $active_term ) {
            $custom_about_title = 'About ' . $active_term->name;
        }
        
        if ( $bottom_content ) : ?>
        <section class="py-16 md:py-24 px-6 relative bg-white border-t border-slate-100">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-5xl font-display font-black text-slate-900 mb-6 tracking-tight"><?php echo esc_html( $custom_about_title ); ?></h2>
                    <div class="w-20 h-1.5 bg-primary mx-auto rounded-full opacity-80"></div>
                </div>

                <div class="prose prose-slate prose-lg max-w-none 
                    prose-headings:font-display prose-headings:font-black prose-headings:text-slate-900
                    prose-h2:text-3xl prose-h3:text-2xl
                    prose-p:text-slate-600 prose-p:leading-relaxed
                    prose-a:text-primary prose-a:font-bold hover:prose-a:underline
                    prose-strong:text-slate-900
                    prose-ul:text-slate-600 prose-li:marker:text-primary">
                    <?php echo wp_kses_post( $bottom_content ); ?>
                </div>

                <!-- Subtle bottom separator -->
                <div class="flex items-center justify-center gap-4 mt-20 opacity-40">
                    <div class="w-16 h-px bg-slate-300"></div>
                    <span class="material-symbols-outlined text-slate-400">landscape</span>
                    <div class="w-16 h-px bg-slate-300"></div>
                </div>
            </div>
        </section>
        <?php endif; ?>

    </main>
</div>

<?php get_footer(); ?>
