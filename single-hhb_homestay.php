<?php
/**
 * Single Homestay Template
 * Redesigned to match code.html Airbnb-style layout.
 * Integrates all plugin meta fields.
 *
 * @package HimalayanMart
 */

get_header();

while ( have_posts() ) :
    the_post();
    $post_id = get_the_ID();

    // =========================================================================
    // Data from Plugin Meta — ALL 14 fields + taxonomies
    // =========================================================================
    $gallery_ids     = get_post_meta($post_id, 'hhb_gallery', true);
    $gallery_ids     = $gallery_ids ? explode(',', $gallery_ids) : array();
    $price_range     = hhb_get_price_range( $post_id );
    $max_guests      = get_post_meta($post_id, 'hhb_max_guests', true) ?: 6;
    $dos             = get_post_meta($post_id, 'hhb_dos', true);
    $donts           = get_post_meta($post_id, 'hhb_donts', true);
    $attractions     = get_post_meta($post_id, 'hhb_attractions', true) ?: array();
    $amenity_keys    = get_post_meta($post_id, 'hhb_amenities', true) ?: array();
    $lat             = '';
    $lng             = '';
    $min_nights      = get_post_meta($post_id, 'hhb_min_nights', true) ?: 1;
    $max_nights      = get_post_meta($post_id, 'hhb_max_nights', true) ?: 30;
    $buffer_days     = get_post_meta($post_id, 'hhb_buffer_days', true) ?: 0;
    $deposit_percent = get_post_meta($post_id, 'hhb_deposit_percent', true) ?: 0;
    $extra_guest_fee  = get_post_meta($post_id, 'hhb_extra_guest_fee', true) ?: 0;

    // Address & Property Details
    $hhb_address      = get_post_meta($post_id, 'hhb_address', true);
    $hhb_city         = get_post_meta($post_id, 'hhb_city', true);
    $hhb_state        = get_post_meta($post_id, 'hhb_state', true);
    $hhb_country      = get_post_meta($post_id, 'hhb_country', true) ?: 'India';
    $hhb_postal_code  = get_post_meta($post_id, 'hhb_postal_code', true);
    $total_bedrooms   = get_post_meta($post_id, 'hhb_total_bedrooms', true);
    $total_bathrooms  = get_post_meta($post_id, 'hhb_total_bathrooms', true);
    $property_size    = get_post_meta($post_id, 'hhb_property_size', true);
    $year_established = get_post_meta($post_id, 'hhb_year_established', true);
    $checkin_time     = get_post_meta($post_id, 'hhb_checkin_time', true) ?: '14:00';
    $checkout_time    = get_post_meta($post_id, 'hhb_checkout_time', true) ?: '11:00';
    $early_checkin    = get_post_meta($post_id, 'hhb_early_checkin', true);
    $late_checkout    = get_post_meta($post_id, 'hhb_late_checkout', true);
    $contact_phone    = get_post_meta($post_id, 'hhb_contact_phone', true);
    $contact_email    = get_post_meta($post_id, 'hhb_contact_email', true);
    $website_url      = get_post_meta($post_id, 'hhb_website_url', true);
    $host_bio         = get_post_meta($post_id, 'hhb_host_bio', true);

    // Map address (replaces old lat/lng)
    $map_address = implode(', ', array_filter([$hhb_address, $hhb_city, $hhb_state, $hhb_country]));

    // Rooms
    $rooms = get_children([
        'post_parent' => $post_id,
        'post_type'   => 'hhb_room',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby'     => 'title',
        'order'       => 'ASC',
    ]);

    // Taxonomies
    $locations  = get_the_terms($post_id, 'hhb_location');
    $prop_types = get_the_terms($post_id, 'hhb_property_type');

    $location_name = ($locations && !is_wp_error($locations)) ? $locations[0]->name : '';

    // Live rating from reviews DB
    global $wpdb;
    $hhb_rtable     = $wpdb->prefix . 'hhb_reviews';
    $hhb_rexist     = $wpdb->get_var( "SHOW TABLES LIKE '{$hhb_rtable}'" );
    $display_rating = '4.9';
    if ( $hhb_rexist ) {
        $rrow = $wpdb->get_row( $wpdb->prepare(
            "SELECT AVG(rating) AS avg_r FROM {$hhb_rtable} WHERE homestay_id = %d AND status = 'approved'",
            $post_id
        ) );
        if ( $rrow && $rrow->avg_r ) {
            $display_rating = number_format( (float) $rrow->avg_r, 1 );
        }
    }

    // Amenity map
    $all_amenities = array(
        'wifi'            => array('label' => 'WiFi', 'icon' => 'wifi'),
        'parking'         => array('label' => 'Free Parking', 'icon' => 'local_parking'),
        'kitchen'         => array('label' => 'Kitchen', 'icon' => 'kitchen'),
        'ac'              => array('label' => 'Air Conditioning', 'icon' => 'ac_unit'),
        'tv'              => array('label' => 'TV', 'icon' => 'tv'),
        'washing_machine' => array('label' => 'Washing Machine', 'icon' => 'local_laundry_service'),
        'hot_water'       => array('label' => 'Hot Water', 'icon' => 'hot_tub'),
        'garden'          => array('label' => 'Garden', 'icon' => 'yard'),
        'balcony'         => array('label' => 'Balcony', 'icon' => 'balcony'),
        'fireplace'       => array('label' => 'Fireplace', 'icon' => 'fireplace'),
        'gym'             => array('label' => 'Gym', 'icon' => 'fitness_center'),
        'pool'            => array('label' => 'Swimming Pool', 'icon' => 'pool'),
    );

    // =========================================================================
    // Schema.org JSON-LD (LodgingBusiness)
    // =========================================================================
    $schema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'LodgingBusiness',
        'name'        => get_the_title(),
        'description' => wp_trim_words( strip_shortcodes( wp_strip_all_tags( get_the_content() ) ), 40 ),
        'url'         => get_permalink(),
        'image'       => has_post_thumbnail() ? get_the_post_thumbnail_url( $post_id, 'full' ) : ( isset($gallery_ids[0]) ? wp_get_attachment_image_url($gallery_ids[0], 'full') : '' ),
        'priceRange'  => $price_range ? $price_range['formatted'] : '',
        'address'     => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => $hhb_address,
            'addressLocality' => $hhb_city,
            'addressRegion'   => $hhb_state,
            'postalCode'      => $hhb_postal_code,
            'addressCountry'  => $hhb_country,
        ],
        'location'    => [
            '@type' => 'Place',
            'name'  => $location_name,
        ],
    ];
    
    if ( ! empty( $lat ) && ! empty( $lng ) ) {
        $schema['geo'] = [
            '@type'     => 'GeoCoordinates',
            'latitude'  => $lat,
            'longitude' => $lng,
        ];
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
    ?>    <?php /* Assets (Tailwind, Material Symbols, GLightbox, Inter font) are enqueued
              via functions.php for is_singular('hhb_homestay') — no inline tags needed. */ ?>

    <style>
        body { font-family: 'Inter', sans-serif; background: #f8f6f6 !important; }
        .sticky-card { top: 100px; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        #page, .site, .site-content {
            max-width: none !important; padding: 0 !important; margin: 0 !important;
            width: 100% !important; background: transparent !important;
        }
        .hhb-single-wrap { width: 100vw; max-width: 100vw; position: relative; left: 50%; transform: translateX(-50%); }
        .hhb-booking-widget { background: transparent !important; box-shadow: none !important; border: none !important; padding: 0 !important; }
        body, html { overflow-x: hidden; }

        /* ── GLightbox — hide caption ── */
        .glightbox-clean .gdesc-inner { display: none !important; }

        /* Navigation arrows — orange circles */
        .glightbox-clean .gnext,
        .glightbox-clean .gprev {
            background: rgba(232,94,48,0.85) !important;
            border-radius: 50% !important;
            width: 44px !important;
            height: 44px !important;
            backdrop-filter: blur(8px);
            transition: background 0.2s, transform 0.2s;
        }
        .glightbox-clean .gnext:hover,
        .glightbox-clean .gprev:hover {
            background: #e85e30 !important;
            transform: scale(1.1);
        }
    </style>

    <div class="hhb-single-wrap bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 antialiased font-display">
        <main class="max-w-7xl mx-auto px-4 md:px-10 lg:px-20 py-6">

            <!-- ============================================================= -->
            <!-- TITLE & BADGES -->
            <!-- ============================================================= -->
            <div class="mb-6">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold mb-1"><?php the_title(); ?></h1>
                        <?php if ($hhb_city || $hhb_state) : ?>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-2 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[15px]">location_on</span>
                            <?php echo esc_html(implode(', ', array_filter([$hhb_city, $hhb_state, $hhb_country]))); ?>
                            <?php if ($hhb_postal_code) echo ' ' . esc_html($hhb_postal_code); ?>
                        </p>
                        <?php endif; ?>
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-slate-600 dark:text-slate-400 font-medium">
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-primary text-sm">star</span>
                                <span class="text-slate-900 dark:text-slate-100"><?php echo esc_html( $display_rating ); ?></span>
                                <span>(Reviews)</span>
                            </div>
                            <span>·</span>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">verified_user</span>
                                <span>Verified Host</span>
                            </div>
                            <?php if ($location_name && !empty($locations) && !is_wp_error($locations)) :
                                $loc_link = get_term_link($locations[0]);
                            ?>
                            <span>·</span>
                            <a href="<?php echo esc_url(is_wp_error($loc_link) ? '#' : $loc_link); ?>" class="underline hover:text-primary"><?php echo esc_html($location_name); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <!-- Wishlist Toggle -->
                        <button type="button" class="hhb-wishlist-toggle flex items-center gap-2 px-3 py-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition text-sm font-semibold group/wishlist" data-post-id="<?php echo get_the_ID(); ?>" aria-label="Save to Wishlist">
                            <?php $is_hearted = \Himalayan\Homestay\Interface\Frontend\WishlistHandler::is_in_wishlist(get_the_ID()); ?>
                            <span class="material-symbols-outlined text-lg transition-transform group-hover/wishlist:scale-110 hhb-wishlist-icon" style="<?php echo $is_hearted ? 'color: #ef4444; font-variation-settings: \'FILL\' 1;' : 'font-variation-settings: \'FILL\' 0;'; ?>">favorite</span>
                            <span class="hhb-wishlist-text underline"><?php echo $is_hearted ? 'Saved' : 'Save'; ?></span>
                        </button>

                        <!-- Share Dropdown -->
                        <div class="relative" id="hhb-share-wrap">
                            <button id="hhb-share-btn" onclick="document.getElementById('hhb-share-menu').classList.toggle('hidden')" class="flex items-center gap-2 px-3 py-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition text-sm font-semibold">
                                <span class="material-symbols-outlined text-lg">share</span> <span class="underline">Share</span>
                            </button>
                            <div id="hhb-share-menu" class="hidden absolute right-0 top-full mt-2 w-52 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xl z-50 overflow-hidden py-1">
                                <?php
                                $share_url   = urlencode( get_permalink() );
                                $share_title = urlencode( get_the_title() );
                                ?>
                                <a href="https://wa.me/?text=<?php echo $share_title; ?>%20<?php echo $share_url; ?>" target="_blank" rel="noopener" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                    <svg class="w-5 h-5 shrink-0" fill="#25D366" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.117.551 4.103 1.513 5.834L.057 23.215a.75.75 0 00.923.923l5.381-1.456A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.891 0-3.668-.523-5.186-1.432l-.373-.22-3.865 1.046 1.046-3.866-.22-.372A9.944 9.944 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                                    WhatsApp
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" target="_blank" rel="noopener" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                    <svg class="w-5 h-5 shrink-0" fill="#1877F2" viewBox="0 0 24 24"><path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.791-4.697 4.533-4.697 1.312 0 2.686.236 2.686.236v2.97h-1.513c-1.491 0-1.956.931-1.956 1.886v2.267h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/></svg>
                                    Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?text=<?php echo $share_title; ?>&url=<?php echo $share_url; ?>" target="_blank" rel="noopener" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                    <svg class="w-5 h-5 shrink-0" fill="#000000" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                    Twitter / X
                                </a>
                                <hr class="border-slate-100 dark:border-slate-700 mx-3"/>
                                <button onclick="navigator.clipboard.writeText('<?php echo esc_js(get_permalink()); ?>').then(()=>{this.querySelector('span.label').textContent='Copied!';setTimeout(()=>{this.querySelector('span.label').textContent='Copy Link'},2000)})" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors w-full text-left">
                                    <span class="material-symbols-outlined text-slate-400 text-lg">link</span>
                                    <span class="label">Copy Link</span>
                                </button>
                            </div>
                        </div>
                        <script>
                        document.addEventListener('click', function(e){
                            var wrap = document.getElementById('hhb-share-wrap');
                            if(wrap && !wrap.contains(e.target)){
                                var m = document.getElementById('hhb-share-menu');
                                if(m) m.classList.add('hidden');
                            }
                        });
                        </script>

                        <button class="flex items-center gap-2 px-3 py-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition text-sm font-semibold">
                            <span class="material-symbols-outlined text-lg">favorite</span> Save
                        </button>
                    </div>
                </div>
            </div>

            <!-- ============================================================= -->
            <!-- HERO GALLERY (1 large + 4 small) -->
            <!-- ============================================================= -->
            <div class="grid grid-cols-1 md:grid-cols-4 grid-rows-2 gap-3 h-[300px] md:h-[500px] mb-10 overflow-hidden rounded-xl relative group">
                <?php if (!empty($gallery_ids)) : ?>
                    <div class="md:col-span-2 md:row-span-2 relative">
                        <?php $main_img = wp_get_attachment_image_url($gallery_ids[0], 'full'); ?>
                        <img alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover hover:opacity-90 transition cursor-pointer glightbox" data-gallery="hhb-gallery" src="<?php echo esc_url($main_img); ?>" fetchpriority="high" />
                    </div>
                    <?php
                    $extras = array_slice($gallery_ids, 1, 4);
                    $corner_classes = ['', 'rounded-tr-xl', '', 'rounded-br-xl'];
                    foreach ($extras as $i => $img_id) :
                        $url = wp_get_attachment_image_url($img_id, 'large');
                        if (!$url) continue;
                    ?>
                    <div class="hidden md:block relative <?php echo $corner_classes[$i] ?? ''; ?> overflow-hidden">
                        <img alt="Gallery" class="w-full h-full object-cover hover:opacity-90 transition cursor-pointer glightbox" data-gallery="hhb-gallery" src="<?php echo esc_url($url); ?>" loading="lazy" />
                    </div>
                    <?php endforeach; ?>

                    <?php if (count($gallery_ids) > 5) : ?>
                    <button onclick="document.querySelector('.glightbox').click()" class="absolute bottom-6 right-6 bg-white dark:bg-slate-900 text-slate-900 dark:text-white border border-slate-900 dark:border-slate-100 text-xs md:text-sm font-bold py-1.5 px-4 rounded-lg flex items-center gap-2 shadow-lg hover:scale-105 transition-transform">
                        <span class="material-symbols-outlined text-lg">grid_view</span> Show all <?php echo count($gallery_ids); ?> photos
                    </button>
                    <div style="display: none;">
                        <?php
                        $hidden_images = array_slice($gallery_ids, 5);
                        foreach ($hidden_images as $h_id) :
                            $h_url = wp_get_attachment_image_url($h_id, 'full');
                            if ($h_url) :
                        ?>
                        <a href="<?php echo esc_url($h_url); ?>" class="glightbox" data-gallery="hhb-gallery"></a>
                        <?php endif; endforeach; ?>
                    </div>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="md:col-span-4 md:row-span-2 bg-slate-200 flex items-center justify-center">
                        <span class="material-symbols-outlined text-6xl text-slate-400">image</span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- About Section -->
            <div class="mb-10">
                <h3 class="text-xl font-bold mb-4">About this stay</h3>
                <div class="text-slate-600 dark:text-slate-400 leading-relaxed max-w-4xl entry-content">
                    <?php the_content(); ?>
                </div>
            </div>

            <!-- ============================================================= -->
            <!-- 2-COLUMN LAYOUT: Content + Sticky Booking Card -->
            <!-- ============================================================= -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

                <!-- LEFT COLUMN -->
                <div class="lg:col-span-2 space-y-10">

                    <!-- Row 1: Badges + Capacity -->
                    <div class="flex flex-col gap-6 p-6 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                        <!-- Property Type Badges -->
                        <div class="flex flex-wrap gap-2">
                            <?php if ($prop_types && !is_wp_error($prop_types)) : foreach ($prop_types as $pt) :
                            $pt_link = get_term_link($pt);
                        ?>
                                <a href="<?php echo esc_url(is_wp_error($pt_link) ? '#' : $pt_link); ?>" class="px-3 py-1 bg-primary/10 text-primary text-xs font-bold rounded-lg uppercase tracking-wider hover:bg-primary/20 transition"><?php echo esc_html($pt->name); ?></a>
                        <?php endforeach; endif; ?>
                        <?php if ($location_name && !empty($locations) && !is_wp_error($locations)) :
                            $loc_link2 = get_term_link($locations[0]);
                        ?>
                            <a href="<?php echo esc_url(is_wp_error($loc_link2) ? '#' : $loc_link2); ?>" class="px-3 py-1 bg-primary/10 text-primary text-xs font-bold rounded-lg uppercase tracking-wider hover:bg-primary/20 transition"><?php echo esc_html($location_name); ?></a>
                        <?php endif; ?>
                        </div>

                        <!-- Capacity Info -->
                        <div class="flex flex-wrap items-center gap-6 pt-4 border-t border-slate-100 dark:border-slate-800">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-slate-400">groups</span>
                                <div>
                                    <p class="text-sm font-bold"><?php echo esc_html($max_guests); ?> Guests</p>
                                    <p class="text-xs text-slate-500">Maximum capacity</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-slate-400">dark_mode</span>
                                <div>
                                    <p class="text-sm font-bold"><?php echo esc_html($min_nights); ?>–<?php echo esc_html($max_nights); ?> Nights</p>
                                    <p class="text-xs text-slate-500">Stay duration</p>
                                </div>
                            </div>
                            <?php if ($buffer_days > 0) : ?>
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-slate-400">cleaning_services</span>
                                <div>
                                    <p class="text-sm font-bold"><?php echo esc_html($buffer_days); ?> Day Buffer</p>
                                    <p class="text-xs text-slate-500">Between bookings</p>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if ($extra_guest_fee > 0) : ?>
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-slate-400">person_add</span>
                                <div>
                                    <p class="text-sm font-bold">₹<?php echo esc_html( number_format( $extra_guest_fee ) ); ?></p>
                                    <p class="text-xs text-slate-500">Extra guest / night</p>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if ($total_bedrooms) : ?>
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-slate-400">bed</span>
                                <div>
                                    <p class="text-sm font-bold"><?php echo esc_html($total_bedrooms); ?> Bedroom<?php echo $total_bedrooms > 1 ? 's' : ''; ?></p>
                                    <p class="text-xs text-slate-500">Total bedrooms</p>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if ($total_bathrooms) : ?>
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-slate-400">bathroom</span>
                                <div>
                                    <p class="text-sm font-bold"><?php echo esc_html($total_bathrooms); ?> Bathroom<?php echo $total_bathrooms > 1 ? 's' : ''; ?></p>
                                    <p class="text-xs text-slate-500">Total bathrooms</p>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if ($property_size) : ?>
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-slate-400">crop_square</span>
                                <div>
                                    <p class="text-sm font-bold"><?php echo esc_html(number_format($property_size)); ?> sq.ft</p>
                                    <p class="text-xs text-slate-500">Property size</p>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if ($year_established) : ?>
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-slate-400">history_edu</span>
                                <div>
                                    <p class="text-sm font-bold">Est. <?php echo esc_html($year_established); ?></p>
                                    <p class="text-xs text-slate-500">Year established</p>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Rooms -->
                    <?php if (!empty($rooms)) : ?>
                    <div class="p-6 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                        <h3 class="text-lg font-bold mb-5">Available Rooms</h3>
                        <div class="space-y-4">
                            <?php foreach ($rooms as $room) :
                                $r_base    = get_post_meta($room->ID, 'room_base_price', true);
                                $r_weekend = get_post_meta($room->ID, 'room_weekend_price', true);
                                $r_guests  = get_post_meta($room->ID, 'room_max_guests', true) ?: 2;
                                $r_qty     = get_post_meta($room->ID, 'room_quantity', true) ?: 1;
                                $r_bed     = get_post_meta($room->ID, 'room_bed_type', true);
                                $r_size    = get_post_meta($room->ID, 'room_size_sqft', true);
                                $r_min     = get_post_meta($room->ID, 'room_min_nights', true) ?: 1;
                                $r_xfee    = get_post_meta($room->ID, 'room_extra_guest_fee', true);
                            ?>
                            <div class="flex flex-col sm:flex-row items-start gap-4 pb-4 border-b border-slate-100 dark:border-slate-800 last:border-0 last:pb-0">
                                <div class="flex-1">
                                    <h4 class="font-bold text-slate-900 dark:text-white text-sm"><?php echo esc_html($room->post_title); ?></h4>
                                    <div class="flex flex-wrap gap-x-4 gap-y-1 mt-1.5">
                                        <?php if ($r_bed) : ?>
                                        <span class="text-xs text-slate-500 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">king_bed</span><?php echo esc_html($r_bed); ?></span>
                                        <?php endif; ?>
                                        <span class="text-xs text-slate-500 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">group</span>Up to <?php echo esc_html($r_guests); ?> guests</span>
                                        <?php if ($r_size) : ?>
                                        <span class="text-xs text-slate-500 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">crop_square</span><?php echo esc_html($r_size); ?> sq.ft</span>
                                        <?php endif; ?>
                                        <?php if ($r_qty > 1) : ?>
                                        <span class="text-xs text-slate-500 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">content_copy</span><?php echo esc_html($r_qty); ?> available</span>
                                        <?php endif; ?>
                                        <?php if ($r_min > 1) : ?>
                                        <span class="text-xs text-slate-500 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">calendar_today</span>Min <?php echo esc_html($r_min); ?> nights</span>
                                        <?php endif; ?>
                                        <?php if ($r_xfee > 0) : ?>
                                        <span class="text-xs text-slate-500 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">person_add</span>₹<?php echo esc_html(number_format($r_xfee)); ?> extra guest/night</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    <?php if ($r_base) : ?>
                                        <p class="text-primary font-black text-base">₹<?php echo esc_html(number_format($r_base)); ?></p>
                                        <span class="text-slate-400 text-[10px] font-bold uppercase tracking-tighter">per night</span>
                                        <?php if ($r_weekend && $r_weekend != $r_base) : ?>
                                        <p class="text-xs text-slate-400 mt-0.5">₹<?php echo esc_html(number_format($r_weekend)); ?> weekends</p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Row 2: Things To Do & House Rules -->
                    <?php if ($dos || $donts) : ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php if ($dos) : ?>
                        <div class="p-6 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                            <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-green-500">task_alt</span> Things To Do
                            </h3>
                            <ul class="space-y-3">
                                <?php foreach (explode("\n", $dos) as $line) : if (trim($line)) : ?>
                                <li class="flex gap-3 items-start">
                                    <div class="bg-primary/10 text-primary p-1 rounded">
                                        <span class="material-symbols-outlined text-base">check</span>
                                    </div>
                                    <span class="text-sm font-medium"><?php echo esc_html(trim($line)); ?></span>
                                </li>
                                <?php endif; endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <?php if ($donts) : ?>
                        <div class="p-6 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                            <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-red-500">gavel</span> House Rules
                            </h3>
                            <ul class="space-y-3">
                                <?php foreach (explode("\n", $donts) as $line) : if (trim($line)) : ?>
                                <li class="flex gap-3 items-start">
                                    <span class="material-symbols-outlined text-slate-400 text-lg">block</span>
                                    <span class="text-sm"><?php echo esc_html(trim($line)); ?></span>
                                </li>
                                <?php endif; endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Check-in / Check-out Policy -->
                    <div class="p-6 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                        <h3 class="text-lg font-bold mb-5 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">schedule</span> Check-in &amp; Check-out
                        </h3>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div class="text-center p-3 bg-slate-50 dark:bg-slate-800 rounded-lg">
                                <span class="material-symbols-outlined text-slate-400 text-2xl block mb-1">login</span>
                                <p class="text-xs text-slate-500 mb-0.5">Check-in from</p>
                                <p class="text-sm font-bold"><?php echo esc_html($checkin_time); ?></p>
                            </div>
                            <div class="text-center p-3 bg-slate-50 dark:bg-slate-800 rounded-lg">
                                <span class="material-symbols-outlined text-slate-400 text-2xl block mb-1">logout</span>
                                <p class="text-xs text-slate-500 mb-0.5">Check-out by</p>
                                <p class="text-sm font-bold"><?php echo esc_html($checkout_time); ?></p>
                            </div>
                            <div class="text-center p-3 bg-slate-50 dark:bg-slate-800 rounded-lg">
                                <span class="material-symbols-outlined text-2xl block mb-1 <?php echo $early_checkin === 'yes' ? 'text-green-500' : 'text-slate-300'; ?>">alarm</span>
                                <p class="text-xs text-slate-500 mb-0.5">Early Check-in</p>
                                <p class="text-sm font-bold <?php echo $early_checkin === 'yes' ? 'text-green-600' : 'text-slate-400'; ?>"><?php echo $early_checkin === 'yes' ? 'Available' : 'On request'; ?></p>
                            </div>
                            <div class="text-center p-3 bg-slate-50 dark:bg-slate-800 rounded-lg">
                                <span class="material-symbols-outlined text-2xl block mb-1 <?php echo $late_checkout === 'yes' ? 'text-green-500' : 'text-slate-300'; ?>">alarm_on</span>
                                <p class="text-xs text-slate-500 mb-0.5">Late Check-out</p>
                                <p class="text-sm font-bold <?php echo $late_checkout === 'yes' ? 'text-green-600' : 'text-slate-400'; ?>"><?php echo $late_checkout === 'yes' ? 'Available' : 'On request'; ?></p>
                            </div>
                        </div>
                        <?php if ($contact_phone || $contact_email || $website_url) : ?>
                        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Property Contact</p>
                            <div class="flex flex-wrap gap-4">
                                <?php if ($contact_phone) : ?>
                                <a href="tel:<?php echo esc_attr($contact_phone); ?>" class="flex items-center gap-2 text-sm text-slate-600 hover:text-primary transition-colors font-medium">
                                    <span class="material-symbols-outlined text-[16px]">call</span><?php echo esc_html($contact_phone); ?>
                                </a>
                                <?php endif; ?>
                                <?php if ($contact_email) : ?>
                                <a href="mailto:<?php echo esc_attr($contact_email); ?>" class="flex items-center gap-2 text-sm text-slate-600 hover:text-primary transition-colors font-medium">
                                    <span class="material-symbols-outlined text-[16px]">mail</span><?php echo esc_html($contact_email); ?>
                                </a>
                                <?php endif; ?>
                                <?php if ($website_url) : ?>
                                <a href="<?php echo esc_url($website_url); ?>" target="_blank" rel="noopener" class="flex items-center gap-2 text-sm text-slate-600 hover:text-primary transition-colors font-medium">
                                    <span class="material-symbols-outlined text-[16px]">language</span>Website
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Row 3: Attractions & Location Map -->
                    <?php if (!empty($attractions) || $map_address) : ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php if (!empty($attractions)) : ?>
                        <div class="p-6 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                            <h3 class="text-lg font-bold mb-4">Nearby Attractions</h3>
                            <div class="space-y-4">
                                <?php foreach ($attractions as $item) : ?>
                                <div class="flex justify-between items-center pb-2 border-b border-slate-100 dark:border-slate-800">
                                    <span class="text-sm font-medium flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-base">place</span>
                                        <?php echo esc_html($item); ?>
                                    </span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($map_address) : ?>
                        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden flex flex-col h-full">
                            <div class="flex-1 relative min-h-[200px]">
                                <iframe
                                    class="w-full h-full min-h-[200px]"
                                    style="border:0"
                                    loading="lazy"
                                    src="https://maps.google.com/maps?q=<?php echo urlencode($map_address); ?>&z=14&output=embed"
                                    allowfullscreen>
                                </iframe>
                            </div>
                            <div class="p-4">
                                <h3 class="text-sm font-bold mb-1">Where you'll be</h3>
                                <p class="text-xs text-slate-500 leading-relaxed"><?php echo esc_html($map_address); ?><?php if ($hhb_postal_code) echo ' – ' . esc_html($hhb_postal_code); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Divider -->
                    <div class="h-px bg-slate-200 dark:border-slate-800"></div>

                    <!-- Amenities Full List -->
                    <?php if (!empty($amenity_keys)) : ?>
                    <div>
                        <h3 class="text-xl font-bold mb-6">What this place offers</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <?php foreach ($amenity_keys as $key) :
                                if (!isset($all_amenities[$key])) continue;
                            ?>
                            <div class="flex items-center gap-4 py-2">
                                <span class="material-symbols-outlined text-slate-600"><?php echo $all_amenities[$key]['icon']; ?></span>
                                <span class="font-medium"><?php echo esc_html($all_amenities[$key]['label']); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>

                <!-- ========================================================= -->
                <!-- RIGHT COLUMN: Sticky Booking Card -->
                <!-- ========================================================= -->
                <div class="relative">
                    <div class="sticky sticky-card bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xl space-y-4">

                        <!-- Price Header -->
                        <div class="flex justify-between items-end">
                            <div class="flex flex-col">
                                <div class="flex items-baseline gap-1">
                                    <?php if ( $price_range ) : ?>
                                        <span class="text-2xl font-black"><?php echo esc_html( $price_range['formatted'] ); ?></span>
                                    <?php else : ?>
                                        <span class="text-2xl font-black">—</span>
                                    <?php endif; ?>
                                    <span class="text-slate-500 font-medium">Night</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 text-sm font-bold">
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1">star</span> <?php echo esc_html( $display_rating ); ?>
                            </div>
                        </div>

                        <!-- Booking Widget -->
                        <?php echo do_shortcode('[hhb_booking_form]'); ?>

                        <p class="text-center text-sm text-slate-500">You won't be charged yet</p>

                        <!-- Deposit Info -->
                        <?php if ($deposit_percent > 0 && $deposit_percent < 100) : ?>
                        <div class="pt-4 mt-4 border-t border-slate-200 dark:border-slate-800 flex items-center gap-3">
                            <div class="bg-green-50 text-green-600 p-2 rounded-full">
                                <span class="material-symbols-outlined text-xl">payments</span>
                            </div>
                            <p class="text-xs font-medium text-slate-600 dark:text-slate-400 leading-snug">
                                <span class="text-slate-900 dark:text-white font-bold">Pay just <?php echo esc_html($deposit_percent); ?>% deposit now.</span>
                                Balance due at check-in.
                            </p>
                        </div>
                        <?php endif; ?>

                        <!-- Min Nights Info -->
                        <?php if ($min_nights > 1) : ?>
                        <div class="flex items-center gap-3 pt-2">
                            <div class="bg-primary/10 text-primary p-2 rounded-full">
                                <span class="material-symbols-outlined text-xl">calendar_month</span>
                            </div>
                            <p class="text-xs font-medium text-slate-600 dark:text-slate-400 leading-snug">
                                <span class="text-slate-900 dark:text-white font-bold">Minimum <?php echo esc_html($min_nights); ?> nights stay.</span>
                                Plan accordingly.
                            </p>
                        </div>
                        <?php endif; ?>

                        <!-- Cancellation -->
                        <div class="pt-4 border-t border-slate-200 dark:border-slate-800">
                            <h4 class="text-sm font-bold mb-1">Cancellation Policy</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">Free cancellation for 48 hours. Secure your booking today.</p>
                        </div>
                    </div>

                    <!-- Host Profile Card -->
                    <?php
                    $host_author_id = get_post_field( 'post_author', $post_id );
                    $h_name   = get_post_meta( $post_id, 'hhb_host_name', true ) ?: get_the_author_meta( 'display_name', $host_author_id );
                    $h_email  = get_post_meta( $post_id, 'hhb_host_email', true ) ?: get_the_author_meta( 'user_email', $host_author_id );
                    $h_phone  = get_post_meta( $post_id, 'hhb_host_phone', true );
                    if ( empty( $h_phone ) ) $h_phone = get_user_meta( $host_author_id, 'billing_phone', true );
                    $h_avatar = get_post_meta( $post_id, 'hhb_host_avatar_url', true );
                    if ( empty( $h_avatar ) ) $h_avatar = get_avatar_url( $host_author_id, [ 'size' => 150 ] );
                    ?>
                    <div class="mt-6 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                        <h4 class="text-sm font-bold mb-4 text-slate-900 dark:text-white">Meet your Host</h4>
                        <div class="flex items-center gap-4">
                            <img src="<?php echo esc_url( $h_avatar ); ?>" alt="<?php echo esc_attr( $h_name ); ?>" class="w-14 h-14 rounded-full object-cover border-2 border-primary/30">
                            <div class="flex-1 min-w-0">
                                <div class="font-bold text-slate-900 dark:text-white text-base"><?php echo esc_html( $h_name ); ?></div>
                                <a href="mailto:<?php echo esc_attr( $h_email ); ?>" class="flex items-center gap-1.5 text-xs text-slate-500 hover:text-primary transition-colors mt-1 truncate">
                                    <span class="material-symbols-outlined text-[14px]">mail</span>
                                    <?php echo esc_html( $h_email ); ?>
                                </a>
                                <?php if ( ! empty( $h_phone ) ) : ?>
                                <a href="tel:<?php echo esc_attr( $h_phone ); ?>" class="flex items-center gap-1.5 text-xs text-slate-500 hover:text-primary transition-colors mt-1">
                                    <span class="material-symbols-outlined text-[14px]">call</span>
                                    <?php echo esc_html( $h_phone ); ?>
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if ( ! empty( $host_bio ) ) : ?>
                        <p class="text-xs text-slate-500 leading-relaxed mt-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                            <?php echo esc_html( $host_bio ); ?>
                        </p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <!-- ============================================================= -->
            <!-- SIMILAR STAYS -->
            <!-- ============================================================= -->
            <?php
            $related = new WP_Query([
                'post_type'      => 'hhb_homestay',
                'posts_per_page' => 3,
                'post__not_in'   => [$post_id],
                'orderby'        => 'rand',
                'tax_query'      => $locations ? [[
                    'taxonomy' => 'hhb_location',
                    'terms'    => wp_list_pluck($locations, 'term_id'),
                ]] : [],
            ]);
            if ($related->have_posts()) :
            ?>
            <div class="mt-20 pt-10 border-t border-slate-200 dark:border-slate-800">
                <h2 class="text-2xl font-bold mb-8">Similar Properties You May Like</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php while ($related->have_posts()) : $related->the_post();
                        $r_id          = get_the_ID();
                        $r_price_range = hhb_get_price_range( $r_id );
                        $r_max         = get_post_meta( $r_id, 'hhb_max_guests', true );
                        $r_locs  = get_the_terms($r_id, 'hhb_location');
                        $r_loc   = ($r_locs && !is_wp_error($r_locs)) ? $r_locs[0]->name : 'India';
                        $r_types = get_the_terms($r_id, 'hhb_property_type');
                        
                        // Persistent pseudo-random review score 
                        $r_score = number_format(4.5 + (crc32($r_id) % 6) / 10, 1);

                        $r_gallery = get_post_meta($r_id, 'hhb_gallery', true);
                        $r_gallery = $r_gallery ? explode(',', $r_gallery) : array();
                        $r_thumb = !empty($r_gallery) ? wp_get_attachment_image_url($r_gallery[0], 'medium_large') : get_the_post_thumbnail_url($r_id, 'medium_large');
                        if (!$r_thumb) $r_thumb = 'https://images.unsplash.com/photo-1516575150278-77136aed6920?q=80&w=800&auto=format&fit=crop';
                    ?>
                    <div class="group relative flex flex-col gap-3">
                        <a href="<?php the_permalink(); ?>" class="block relative aspect-[4/3] w-full overflow-hidden rounded-xl bg-slate-200">
                            <img alt="<?php the_title_attribute(); ?>" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" src="<?php echo esc_url($r_thumb); ?>"/>
                            <button class="absolute top-3 right-3 p-2 rounded-full bg-white/50 hover:bg-white backdrop-blur-md transition-all text-slate-800 hover:scale-110 shadow-sm z-10" onclick="event.preventDefault();">
                                <span class="material-symbols-outlined block text-[20px]">favorite</span>
                            </button>
                            
                            <div class="absolute top-3 left-3 flex flex-wrap gap-2 pointer-events-none z-10">
                                <?php if ($r_types && !is_wp_error($r_types)) : foreach(array_slice($r_types, 0, 1) as $term) : ?>
                                    <embed-a href="<?php echo esc_url(add_query_arg('type', $term->slug, get_post_type_archive_link('hhb_homestay'))); ?>" class="bg-primary text-white backdrop-blur px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm pointer-events-auto hover:bg-primary-dark transition-colors inline-block" onclick="event.stopPropagation(); window.location.href=this.getAttribute('href');">
                                        <?php echo esc_html($term->name); ?>
                                    </embed-a>
                                <?php endforeach; endif; ?>
                                
                                <?php if ($r_locs && !is_wp_error($r_locs)) : foreach(array_slice($r_locs, 0, 1) as $loc) : ?>
                                    <embed-a href="<?php echo esc_url(add_query_arg('location', $loc->slug, get_post_type_archive_link('hhb_homestay'))); ?>" class="bg-primary text-white backdrop-blur px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm pointer-events-auto hover:bg-primary-dark transition-colors inline-block" onclick="event.stopPropagation(); window.location.href=this.getAttribute('href');">
                                        <?php echo esc_html($loc->name); ?>
                                    </embed-a>
                                <?php endforeach; endif; ?>
                            </div>

                        </a>
                        <div class="glass-panel bg-white border border-slate-200 dark:border-slate-800 rounded-xl p-4 hover:shadow-lg transition-all duration-300">
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-slate-900 dark:text-white truncate pr-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <div class="flex items-center gap-1 shrink-0">
                                    <span class="material-symbols-outlined text-[16px] text-yellow-500" style="font-variation-settings: 'FILL' 1;">star</span>
                                    <span class="text-sm font-medium"><?php echo esc_html($r_score); ?></span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 mt-1">
                                <p class="text-slate-600 dark:text-slate-300 text-sm truncate"><?php echo esc_html($r_loc); ?></p>
                                <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                                <p class="text-slate-500 dark:text-slate-400 text-xs flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">group</span> <?php echo esc_html($r_max ? $r_max : '2+'); ?> guests</p>
                            </div>
                            
                            <div class="mt-3 pt-3 border-t border-slate-200/50 flex items-baseline gap-1">
                                <?php if ( $r_price_range ) : ?>
                                    <span class="font-bold text-slate-900 dark:text-white"><?php echo esc_html( $r_price_range['formatted'] ); ?></span>
                                <?php else : ?>
                                    <span class="text-slate-400 text-sm">Price TBD</span>
                                <?php endif; ?>
                                <span class="text-slate-600 dark:text-slate-300 text-sm ml-1">Night</span>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
            <?php endif; ?>

        </main>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof GLightbox !== 'undefined') {
            GLightbox({ selector: '.glightbox' });
        }

        // Wishlist Toggle Logic for Single Page
        const toggleBtn = document.querySelector('.hhb-wishlist-toggle');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const postId = this.dataset.postId;
                const icon = this.querySelector('.hhb-wishlist-icon');
                const textSpan = this.querySelector('.hhb-wishlist-text');
                
                // Optimistic UI update
                const isCurrentlyHearted = textSpan.innerText === 'Saved';
                
                if (isCurrentlyHearted) {
                    textSpan.innerText = 'Save';
                    icon.style.color = '';
                    icon.style.fontVariationSettings = "'FILL' 0";
                } else {
                    textSpan.innerText = 'Saved';
                    icon.style.color = '#ef4444';
                    icon.style.fontVariationSettings = "'FILL' 1";
                }

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
                        // Revert on fail
                        if (isCurrentlyHearted) {
                            textSpan.innerText = 'Saved';
                            icon.style.color = '#ef4444';
                            icon.style.fontVariationSettings = "'FILL' 1";
                        } else {
                            textSpan.innerText = 'Save';
                            icon.style.color = '';
                            icon.style.fontVariationSettings = "'FILL' 0";
                        }
                    }
                })
                .catch(err => console.error(err));
            });
        }
    });
    </script>

<?php
endwhile;
get_footer();
