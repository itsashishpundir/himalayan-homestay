<?php
/**
 * Front Page Template
 *
 * Dynamic homepage pulling live data from hhb_homestay CPT.
 * All text customizable via WordPress Customizer.
 *
 * @package HimalayanHomestay
 */

get_header();

/* ── Customizer values (with defaults) ──────────────────────────── */
$hero_img   = get_theme_mod( 'hhb_home_hero_image', 'https://images.unsplash.com/photo-1516575150278-77136aed6920?q=80&w=2940&auto=format&fit=crop' );
$hero_h1    = get_theme_mod( 'hhb_home_hero_heading', 'Stay in the Heart of the Himalayas' );
$hero_sub   = get_theme_mod( 'hhb_home_hero_subheading', 'Handpicked homestays with local hospitality — breathtaking views, warm hosts, unforgettable mornings.' );

// Trust cards
$trust_cards = [
    [ 'icon' => 'verified_user',   'title' => get_theme_mod( 'hhb_trust_1_title', 'Verified Properties' ),    'desc' => get_theme_mod( 'hhb_trust_1_desc', 'Every stay personally inspected by our team.' ) ],
    [ 'icon' => 'sell',            'title' => get_theme_mod( 'hhb_trust_2_title', 'Transparent Pricing' ),     'desc' => get_theme_mod( 'hhb_trust_2_desc', 'What you see is what you pay. No hidden fees.' ) ],
    [ 'icon' => 'handshake',       'title' => get_theme_mod( 'hhb_trust_3_title', 'Direct Booking' ),          'desc' => get_theme_mod( 'hhb_trust_3_desc', 'Book directly with hosts. No middlemen, no commission markup.' ) ],
    [ 'icon' => 'support_agent',   'title' => get_theme_mod( 'hhb_trust_4_title', 'Local Support' ),           'desc' => get_theme_mod( 'hhb_trust_4_desc', 'Our team is based in the mountains, always reachable.' ) ],
    [ 'icon' => 'king_bed',        'title' => get_theme_mod( 'hhb_trust_5_title', 'Clean & Comfortable' ),     'desc' => get_theme_mod( 'hhb_trust_5_desc', 'Quality beds, hot water, clean linens — guaranteed.' ) ],
];

// How It Works
$steps = [
    [ 'icon' => 'search',        'title' => get_theme_mod( 'hhb_step_1_title', 'Choose Your Stay' ),        'desc' => get_theme_mod( 'hhb_step_1_desc', 'Browse our curated collection of verified mountain homestays.' ) ],
    [ 'icon' => 'event_available','title' => get_theme_mod( 'hhb_step_2_title', 'Confirm Availability' ),   'desc' => get_theme_mod( 'hhb_step_2_desc', 'Pick your dates and check real-time availability.' ) ],
    [ 'icon' => 'lock',           'title' => get_theme_mod( 'hhb_step_3_title', 'Secure Payment' ),          'desc' => get_theme_mod( 'hhb_step_3_desc', 'Pay safely online. Your money is protected.' ) ],
    [ 'icon' => 'landscape',      'title' => get_theme_mod( 'hhb_step_4_title', 'Enjoy Your Trip' ),         'desc' => get_theme_mod( 'hhb_step_4_desc', 'Pack your bags and enjoy authentic mountain living.' ) ],
];

// Taxonomy data for search bar and destinations
$locations  = get_terms( [ 'taxonomy' => 'hhb_location', 'hide_empty' => false ] );
$prop_types = get_terms( [ 'taxonomy' => 'hhb_property_type', 'hide_empty' => false ] );

// Featured homestays query
$featured_args = [
    'post_type'      => 'hhb_homestay',
    'posts_per_page' => 6,
    'post_status'    => 'publish',
    'meta_query'     => [
        [
            'key'   => '_is_best_seller',
            'value' => '1',
        ],
    ],
];
$featured_query = new WP_Query( $featured_args );

// Fallback to latest if no featured
if ( ! $featured_query->have_posts() ) {
    $featured_query = new WP_Query( [
        'post_type'      => 'hhb_homestay',
        'posts_per_page' => 6,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ] );
}

// Removed direct DB queries for reviews for performance reasons.
// Reviews are now lazy-loaded via AJAX when the section scrolls into view.
global $wpdb;
$reviews_table = $wpdb->prefix . 'hhb_reviews';
$table_exists  = $wpdb->get_var( "SHOW TABLES LIKE '{$reviews_table}'" );
?>

<style>
/* ── Front Page Scoped Styles ──────────────────────────────────── */
.hhb-fp-hero {
    position: relative;
    min-height: 85vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.hhb-fp-hero-bg {
    position: absolute; inset: 0;
    background-size: cover;
    background-position: center;
}
.hhb-fp-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.65) 100%);
}
.hhb-fp-search-bar {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(255,255,255,0.2);
}
.hhb-fp-search-bar select,
.hhb-fp-search-bar input {
    background: transparent;
    border: none;
    color: #fff;
    font-weight: 600;
    font-size: 14px;
    outline: none;
    width: 100%;
    cursor: pointer;
}
.hhb-fp-search-bar select option { color: #1e293b; }
.hhb-fp-search-bar input::placeholder { color: rgba(255,255,255,0.6); }
.hhb-fp-search-bar input::-webkit-calendar-picker-indicator { filter: invert(1); cursor: pointer; }

.hhb-fp-section { padding: 80px 24px; }
.hhb-fp-section-alt { background: #f8f6f4; }

/* Trust cards */
.hhb-trust-card {
    text-align: center;
    padding: 32px 20px;
    border-radius: 16px;
    background: #fff;
    border: 1px solid #f1f1f1;
    transition: all 0.3s;
}
.hhb-trust-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.08);
}
.hhb-trust-icon {
    width: 56px; height: 56px;
    border-radius: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #fef3ee;
    color: #e85e30;
    margin-bottom: 16px;
    font-size: 28px;
}

/* Steps */
.hhb-step-num {
    width: 40px; height: 40px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #e85e30;
    color: #fff;
    font-weight: 800;
    font-size: 16px;
    margin-bottom: 16px;
}

/* Destination cards */
.hhb-dest-card {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    aspect-ratio: 4/3;
    cursor: pointer;
    transition: transform 0.3s;
}
.hhb-dest-card:hover { transform: scale(1.02); }
.hhb-dest-card img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.7s;
}
.hhb-dest-card:hover img { transform: scale(1.1); }
.hhb-dest-card-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(180deg, transparent 40%, rgba(0,0,0,0.7) 100%);
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 24px;
}

/* Review cards */
.hhb-review-card {
    background: #fff;
    border-radius: 16px;
    padding: 28px;
    border: 1px solid #f1f1f1;
    transition: all 0.3s;
}
.hhb-review-card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,0.06);
}
.hhb-review-stars { color: #f59e0b; font-size: 16px; letter-spacing: 2px; }

/* Connector line for steps */
@media (min-width: 768px) {
    .hhb-steps-grid { position: relative; }
    .hhb-steps-grid::before {
        content: '';
        position: absolute;
        top: 20px;
        left: calc(12.5% + 20px);
        right: calc(12.5% + 20px);
        height: 2px;
        background: repeating-linear-gradient(90deg, #e85e30 0, #e85e30 6px, transparent 6px, transparent 12px);
        z-index: 0;
    }
    .hhb-step-item { position: relative; z-index: 1; }
}
</style>

<!-- ═══════════════════════════════════════════════════════════════
     SECTION 1 — HERO
     ═══════════════════════════════════════════════════════════════ -->
<section class="hhb-fp-hero">
    <div class="hhb-fp-hero-bg" style="background-image: url('<?php echo esc_url( $hero_img ); ?>')"></div>
    <div class="hhb-fp-hero-overlay"></div>

    <div class="relative z-10 text-center px-4 max-w-5xl mx-auto">
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-white mb-6 drop-shadow-lg leading-tight">
            <?php echo esc_html( $hero_h1 ); ?>
        </h1>
        <p class="text-base md:text-lg text-white/85 leading-relaxed font-medium mb-10 max-w-2xl mx-auto">
            <?php echo esc_html( $hero_sub ); ?>
        </p>

        <!-- Buttons -->
        <div class="flex items-center justify-center gap-4 mb-10">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'hhb_homestay' ) ); ?>" class="px-8 py-3.5 bg-primary text-white font-bold rounded-xl text-sm hover:brightness-110 transition shadow-lg">
                Browse Stays
            </a>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'hhb_homestay' ) ); ?>" class="px-8 py-3.5 bg-transparent border-2 border-white text-white font-bold rounded-xl text-sm hover:bg-white hover:text-slate-900 transition">
                Check Availability
            </a>
        </div>

        <!-- Search Bar -->
        <div class="hhb-fp-search-bar p-2.5 rounded-2xl max-w-3xl mx-auto">
            <form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'hhb_homestay' ) ); ?>" class="flex flex-col md:flex-row items-center gap-2">
                <!-- Location -->
                <div class="flex items-center gap-3 px-4 py-2.5 w-full">
                    <span class="material-symbols-outlined text-white/70">location_on</span>
                    <select name="location">
                        <option value="">All Locations</option>
                        <?php if ( $locations && ! is_wp_error( $locations ) ) : foreach ( $locations as $loc ) : ?>
                            <option value="<?php echo esc_attr( $loc->slug ); ?>"><?php echo esc_html( $loc->name ); ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="h-6 w-[1px] bg-white/20 hidden md:block"></div>
                <!-- Check-in -->
                <div class="flex items-center gap-3 px-4 py-2.5 w-full">
                    <span class="material-symbols-outlined text-white/70">calendar_today</span>
                    <input type="date" name="checkin" placeholder="Check-in">
                </div>
                <div class="h-6 w-[1px] bg-white/20 hidden md:block"></div>
                <!-- Check-out -->
                <div class="flex items-center gap-3 px-4 py-2.5 w-full">
                    <span class="material-symbols-outlined text-white/70">event</span>
                    <input type="date" name="checkout" placeholder="Check-out">
                </div>
                <div class="h-6 w-[1px] bg-white/20 hidden md:block"></div>
                <!-- Guests -->
                <div class="flex items-center gap-3 px-4 py-2.5 w-full">
                    <span class="material-symbols-outlined text-white/70">group</span>
                    <select name="guests">
                        <option value="">Guests</option>
                        <?php for ( $i = 1; $i <= 10; $i++ ) : ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?> Guest<?php echo $i > 1 ? 's' : ''; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <!-- Search button -->
                <button type="submit" class="shrink-0 px-6 py-3 bg-primary text-white font-bold rounded-xl text-sm hover:brightness-110 transition flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">search</span>
                    Search
                </button>
            </form>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════
     SECTION 2 — WHY CHOOSE US
     ═══════════════════════════════════════════════════════════════ -->
<section class="hhb-fp-section hhb-fp-section-alt">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-black text-slate-900 mb-3">
                <?php echo esc_html( get_theme_mod( 'hhb_trust_heading', 'Why Book With Us' ) ); ?>
            </h2>
            <p class="text-slate-500 max-w-xl mx-auto">
                <?php echo esc_html( get_theme_mod( 'hhb_trust_subheading', 'We do things differently — no middlemen, no inflated prices, just honest mountain hospitality.' ) ); ?>
            </p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
            <?php foreach ( $trust_cards as $card ) : ?>
                <div class="hhb-trust-card">
                    <div class="hhb-trust-icon">
                        <span class="material-symbols-outlined"><?php echo esc_html( $card['icon'] ); ?></span>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 mb-2"><?php echo esc_html( $card['title'] ); ?></h3>
                    <p class="text-xs text-slate-500 leading-relaxed"><?php echo esc_html( $card['desc'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════
     SECTION 3 — FEATURED STAYS (Live Data)
     ═══════════════════════════════════════════════════════════════ -->
<section class="hhb-fp-section">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-end justify-between mb-12">
            <div>
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 mb-2">Featured Stays</h2>
                <p class="text-slate-500">Handpicked properties loved by our guests</p>
            </div>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'hhb_homestay' ) ); ?>" class="text-primary font-bold text-sm hover:underline hidden md:block">
                View All →
            </a>
        </div>

        <?php if ( $featured_query->have_posts() ) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while ( $featured_query->have_posts() ) : $featured_query->the_post();
                    $price       = get_post_meta( get_the_ID(), 'base_price_per_night', true );
                    $offer_price = get_post_meta( get_the_ID(), 'offer_price_per_night', true );
                    $max_guests  = get_post_meta( get_the_ID(), 'max_guests', true ) ?: '2';
                    $bedrooms    = get_post_meta( get_the_ID(), 'hhb_bedrooms', true ) ?: '1';
                    $locs        = get_the_terms( get_the_ID(), 'hhb_location' );
                    $types       = get_the_terms( get_the_ID(), 'hhb_property_type' );
                    $loc_name    = ( $locs && ! is_wp_error( $locs ) ) ? $locs[0]->name : '';
                    $city        = get_post_meta( get_the_ID(), 'hhb_city', true );
                    $display_loc = $city ?: $loc_name;

                    // Rating from reviews table
                    $avg_rating = 0;
                    $review_count = 0;
                    if ( $table_exists ) {
                        $rating_row = $wpdb->get_row( $wpdb->prepare(
                            "SELECT AVG(rating) AS avg_r, COUNT(*) AS cnt FROM {$reviews_table} WHERE homestay_id = %d AND status = 'approved'",
                            get_the_ID()
                        ) );
                        if ( $rating_row ) {
                            $avg_rating   = round( (float) $rating_row->avg_r, 1 );
                            $review_count = (int) $rating_row->cnt;
                        }
                    }
                    $display_rating = $avg_rating ?: '4.9';
                ?>
                    <article class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 transition-all hover:shadow-xl hover:-translate-y-1">
                        <!-- Image -->
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'large', [ 'class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-110' ] ); ?>
                                </a>
                            <?php else : ?>
                                <a href="<?php the_permalink(); ?>" class="block w-full h-full bg-slate-100 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl text-slate-300">landscape</span>
                                </a>
                            <?php endif; ?>

                            <!-- Badges -->
                            <div class="absolute top-4 left-4 flex flex-wrap gap-2">
                                <?php if ( $types && ! is_wp_error( $types ) ) : ?>
                                    <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-black text-primary uppercase tracking-widest shadow-sm">
                                        <?php echo esc_html( $types[0]->name ); ?>
                                    </span>
                                <?php endif; ?>
                                <?php if ( $display_loc ) : ?>
                                    <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-black text-slate-700 uppercase tracking-widest shadow-sm">
                                        <?php echo esc_html( $display_loc ); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <?php if ( $offer_price && $offer_price < $price ) : ?>
                                <div class="absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg">
                                    <?php echo round( ( ( $price - $offer_price ) / $price ) * 100 ); ?>% OFF
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold text-slate-900 group-hover:text-primary transition-colors pr-4">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <div class="text-right shrink-0">
                                    <?php if ( $offer_price && $offer_price < $price ) : ?>
                                        <p class="text-slate-400 text-xs line-through">₹<?php echo number_format( $price ); ?></p>
                                    <?php endif; ?>
                                    <p class="text-primary font-black text-xl leading-none">
                                        ₹<?php echo number_format( $offer_price && $offer_price < $price ? $offer_price : ( $price ?: 0 ) ); ?>
                                    </p>
                                    <span class="text-slate-400 text-[10px] font-bold uppercase tracking-tighter">per night</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 text-slate-500 text-sm mb-6 pb-6 border-b border-slate-50">
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-lg">group</span>
                                    <span class="font-semibold text-xs"><?php echo esc_html( $max_guests ); ?> Guest<?php echo $max_guests > 1 ? 's' : ''; ?></span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-lg">bed</span>
                                    <span class="font-semibold text-xs"><?php echo esc_html( $bedrooms ); ?> BR</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-lg">star</span>
                                    <span class="font-semibold text-xs"><?php echo esc_html( $display_rating ); ?></span>
                                </div>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="block w-full py-4 bg-slate-50 text-slate-900 font-black text-center text-sm rounded-xl hover:bg-primary hover:text-white transition-all transform active:scale-95 shadow-sm">
                                View Details
                            </a>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>

            <!-- Mobile "View All" -->
            <div class="mt-8 text-center md:hidden">
                <a href="<?php echo esc_url( get_post_type_archive_link( 'hhb_homestay' ) ); ?>" class="text-primary font-bold text-sm hover:underline">
                    View All Stays →
                </a>
            </div>
        <?php else : ?>
            <p class="text-slate-500 text-center py-12">No homestays published yet. Check back soon!</p>
        <?php endif; ?>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════
     SECTION 4 — POPULAR DESTINATIONS (Live Taxonomy)
     ═══════════════════════════════════════════════════════════════ -->
<?php if ( $locations && ! is_wp_error( $locations ) && count( $locations ) > 0 ) : ?>
<section class="hhb-fp-section hhb-fp-section-alt">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-black text-slate-900 mb-3">Explore Destinations</h2>
            <p class="text-slate-500">Find your perfect mountain escape by location</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            <?php foreach ( array_slice( $locations, 0, 8 ) as $loc ) :
                $loc_link  = get_term_link( $loc );
                $image_id  = get_term_meta( $loc->term_id, 'hhb_term_image', true );
                $loc_image = $image_id ? wp_get_attachment_image_url( $image_id, 'medium_large' ) : 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=800&auto=format&fit=crop';
                $stay_count = $loc->count;
            ?>
                <a href="<?php echo esc_url( is_wp_error( $loc_link ) ? '#' : $loc_link ); ?>" class="hhb-dest-card">
                    <img src="<?php echo esc_url( $loc_image ); ?>" alt="<?php echo esc_attr( $loc->name ); ?>" loading="lazy">
                    <div class="hhb-dest-card-overlay">
                        <h3 class="text-white font-black text-lg leading-tight"><?php echo esc_html( $loc->name ); ?></h3>
                        <span class="text-white/70 text-xs font-semibold mt-1">
                            <?php echo esc_html( $stay_count ); ?> stay<?php echo $stay_count !== 1 ? 's' : ''; ?>
                        </span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>


<!-- ═══════════════════════════════════════════════════════════════
     SECTION 5 — HOW IT WORKS
     ═══════════════════════════════════════════════════════════════ -->
<section class="hhb-fp-section">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-14">
            <h2 class="text-3xl md:text-4xl font-black text-slate-900 mb-3">How It Works</h2>
            <p class="text-slate-500">Book your perfect stay in 4 simple steps</p>
        </div>

        <div class="hhb-steps-grid grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <?php foreach ( $steps as $i => $step ) : ?>
                <div class="hhb-step-item">
                    <div class="hhb-step-num"><?php echo $i + 1; ?></div>
                    <div class="hhb-trust-icon mx-auto">
                        <span class="material-symbols-outlined"><?php echo esc_html( $step['icon'] ); ?></span>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 mt-3 mb-2"><?php echo esc_html( $step['title'] ); ?></h3>
                    <p class="text-xs text-slate-500 leading-relaxed"><?php echo esc_html( $step['desc'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════
     SECTION 6 — GUEST REVIEWS (Live Data)
     ═══════════════════════════════════════════════════════════════ -->
<?php if ( $table_exists ) : ?>
<section id="hhb-reviews-section" class="hhb-fp-section hhb-fp-section-alt transition-opacity duration-1000">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-black text-slate-900 mb-3">What Our Guests Say</h2>
            <p class="text-slate-500">Real experiences from real travelers</p>
        </div>

        <div id="hhb-reviews-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Skeletons inside grid -->
            <?php for($i=0; $i<3; $i++): ?>
                <div class="hhb-review-card opacity-50 animate-pulse">
                    <div class="h-4 bg-slate-200 rounded w-1/3 mb-4"></div>
                    <div class="h-4 bg-slate-200 rounded w-full mb-2"></div>
                    <div class="h-4 bg-slate-200 rounded w-5/6 mb-6"></div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-200"></div>
                        <div class="flex-1">
                            <div class="h-3 bg-slate-200 rounded w-1/2 mb-1.5"></div>
                            <div class="h-2 bg-slate-200 rounded w-1/3"></div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const reviewSection = document.getElementById('hhb-reviews-section');
    const reviewGrid = document.getElementById('hhb-reviews-grid');
    if (!reviewSection || !reviewGrid) return;

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Fetch reviews
                const formData = new FormData();
                formData.append('action', 'hhb_load_reviews');
                
                fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success && res.data) {
                        reviewGrid.innerHTML = res.data;
                        // Trigger CSS transitions
                        setTimeout(() => {
                            reviewGrid.querySelectorAll('.opacity-0').forEach(el => {
                                el.classList.remove('opacity-0', 'translate-y-4');
                            });
                        }, 50);
                    } else {
                        reviewSection.style.display = 'none';
                    }
                })
                .catch(() => reviewSection.style.display = 'none');

                // Stop observing after firing
                obs.unobserve(entry.target);
            }
        });
    }, { rootMargin: '200px' }); // Fire slightly before scroll

    observer.observe(reviewSection);
});
</script>
<?php endif; ?>


<?php get_footer(); ?>
