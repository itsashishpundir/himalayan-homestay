<?php
/**
 * The template for displaying single hhb_homestay (Standalone Booking Plugin)
 * Optimized with modern glassmorphism UI from code.html
 *
 * @package HimalayanMart
 */

get_header();

while ( have_posts() ) :
    the_post();
    $post_id = get_the_ID();

    // Data from Plugin Meta
    $gallery_ids  = get_post_meta($post_id, 'hhb_gallery', true);
    $gallery_ids  = $gallery_ids ? explode(',', $gallery_ids) : array();
    $base_price   = get_post_meta($post_id, 'base_price_per_night', true);
    $offer_price  = get_post_meta($post_id, 'offer_price_per_night', true);
    $currency     = get_post_meta($post_id, 'currency', true) ?: 'INR';
    $max_guests   = get_post_meta($post_id, 'max_guests', true);
    $dos          = get_post_meta($post_id, 'hhb_dos', true);
    $donts        = get_post_meta($post_id, 'hhb_donts', true);
    $attractions  = get_post_meta($post_id, 'hhb_attractions', true) ?: array();
    $amenity_keys = get_post_meta($post_id, 'hhb_amenities', true) ?: array();
    $lat          = get_post_meta($post_id, 'lat', true);
    $lng          = get_post_meta($post_id, 'lng', true);

    // Taxonomies
    $locations = get_the_terms($post_id, 'hhb_location');
    $prop_types = get_the_terms($post_id, 'hhb_property_type');

    $display_price = $offer_price ? $offer_price : $base_price;
    ?>

    <!-- Styles from code.html integrated -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <!-- GLightbox for Images -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'primary': '#f45c25',
                        'background-light': '#f8f6f5',
                        'background-dark': '#221510',
                    },
                    fontFamily: {
                        'display': ['Plus Jakarta Sans', 'sans-serif']
                    },
                    borderRadius: {
                        'DEFAULT': '0.25rem',
                        'lg': '0.5rem',
                        'xl': '0.75rem',
                        '2xl': '1rem',
                        '3xl': '1.5rem',
                        'full': '9999px'
                    },
                    boxShadow: {
                        'glass': '0 8px 32px 0 rgba(31, 38, 135, 0.07)',
                        'glass-hover': '0 8px 32px 0 rgba(31, 38, 135, 0.15)',
                    }
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        .glass-panel {
            @apply bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl border border-white/40 dark:border-slate-700/30 shadow-glass;
        }
        .glass-card {
            @apply bg-white/60 dark:bg-slate-800/60 backdrop-blur-md border border-white/50 dark:border-slate-600/30 shadow-sm hover:shadow-glass-hover transition-all duration-300;
        }
        .glass-input {
            @apply bg-white/30 dark:bg-black/20 focus:bg-white/50 dark:focus:bg-black/40 backdrop-blur-sm border-none placeholder-slate-500 dark:placeholder-slate-400 text-slate-900 dark:text-white transition-all;
        }
        .glass-button {
             @apply bg-white/20 hover:bg-white/40 backdrop-blur-md border border-white/30 text-white rounded-full transition-colors;
        }.no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        /* FIX: Full screen background and layout */
        body { background: #f8f6f5 !important; }
        #page, .site, .site-content { 
            max-width: none !important; 
            padding: 0 !important; 
            margin: 0 !important;
            width: 100% !important;
            background: transparent !important;
        }
        .hhb-booking-widget { background: transparent !important; box-shadow: none !important; border: none !important; padding: 0 !important; }
        
        /* Ensure background image is full width */
        .hhb-main-bg-container {
            width: 100vw !important;
            max-width: 100vw !important;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
            min-height: 100vh;
        }
        body, html { overflow-x: hidden; margin: 0; padding: 0; }

        .hhb-breadcrumb-trail a {
            @apply hover:text-primary transition-colors font-semibold;
        }
        .hhb-breadcrumb-trail .sep {
            @apply mx-2 text-slate-400 font-normal;
        }
        .hhb-breadcrumb-trail .current {
            @apply text-slate-500 font-medium truncate max-w-[150px] md:max-w-none;
        }
    </style>

    <?php
    $bg_image_url = !empty($gallery_ids) ? wp_get_attachment_image_url($gallery_ids[0], 'full') : get_the_post_thumbnail_url($post_id, 'full');
    if (!$bg_image_url) {
        $bg_image_url = 'https://images.unsplash.com/photo-1516575150278-77136aed6920?q=80&w=2940&auto=format&fit=crop';
    }
    ?>
    <div class="hhb-main-bg-container bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 antialiased bg-fixed bg-cover bg-center relative" style="background-image: url('<?php echo esc_url($bg_image_url); ?>');">
        <div class="absolute inset-0 bg-background-light/90 dark:bg-background-dark/90 z-[0]"></div>
        
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 relative z-10">
            
            <!-- Breadcrumbs -->
            <div class="flex justify-between items-center mb-6">
                <nav class="hhb-breadcrumb-trail flex items-center text-sm text-slate-700 dark:text-slate-200 glass-card px-5 py-2.5 rounded-full !bg-white/40">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-lg">home</span>
                        Home
                    </a>
                    <span class="sep">/</span>
                    <a href="<?php echo esc_url(get_post_type_archive_link('hhb_homestay')); ?>">Homestays</a>
                    <?php
                    if ($locations && !is_wp_error($locations)) {
                        $deepest = $locations[count($locations) - 1];
                        echo '<span class="sep">/</span>';
                        echo '<a href="' . esc_url(get_term_link($deepest)) . '">' . esc_html($deepest->name) . '</a>';
                    }
                    ?>
                    <span class="sep">/</span>
                    <span class="current"><?php the_title(); ?></span>
                </nav>

                <div class="flex gap-3">
                    <button class="glass-card flex items-center gap-2 px-4 py-2 rounded-full hover:bg-white/60 dark:hover:bg-slate-800/60 transition-all text-slate-700 dark:text-slate-200 font-medium">
                        <span class="material-symbols-outlined text-sm">ios_share</span>
                        Share
                    </button>
                    <button class="glass-card flex items-center gap-2 px-4 py-2 rounded-full hover:bg-white/60 dark:hover:bg-slate-800/60 transition-all text-slate-700 dark:text-slate-200 font-medium">
                        <span class="material-symbols-outlined text-sm">favorite</span>
                        Save
                    </button>
                </div>
            </div>

            <!-- Dynamic Gallery -->
            <section class="mb-10 relative rounded-[2rem] overflow-hidden shadow-2xl group">
                <div class="grid grid-cols-4 grid-rows-2 gap-2 h-[500px] md:h-[600px]">
                    <?php if (!empty($gallery_ids)) : ?>
                        <!-- Main Image -->
                        <div class="col-span-4 md:col-span-2 row-span-2 relative overflow-hidden">
                            <?php $main_img_url = wp_get_attachment_image_url($gallery_ids[0], 'full'); ?>
                            <img alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-700 hover:scale-105 cursor-pointer glightbox" data-gallery="hhb-gallery" src="<?php echo esc_url($main_img_url); ?>"/>
                            <div class="absolute inset-0 bg-black/10 hover:bg-transparent transition-colors"></div>
                        </div>
                        
                        <!-- Secondary Images -->
                        <?php 
                        $extra_images = array_slice($gallery_ids, 1, 4);
                        foreach($extra_images as $index => $img_id): 
                            $thumb_url = wp_get_attachment_image_url($img_id, 'large');
                            if (!$thumb_url) continue;
                        ?>
                        <div class="col-span-2 md:col-span-1 row-span-1 relative overflow-hidden">
                            <img alt="Gallery image" class="w-full h-full object-cover transition-transform duration-700 hover:scale-105 cursor-pointer glightbox" data-gallery="hhb-gallery" src="<?php echo esc_url($thumb_url); ?>"/>
                            <div class="absolute inset-0 bg-black/10 hover:bg-transparent transition-colors"></div>
                            <?php if($index === 3 && count($gallery_ids) > 5): ?>
                                <button class="absolute bottom-4 right-4 glass-button px-4 py-2 text-sm font-semibold flex items-center gap-2 hover:bg-black/50 glightbox" data-gallery="hhb-gallery">
                                    <span class="material-symbols-outlined text-sm">grid_view</span>
                                    Show all <?php echo count($gallery_ids); ?> photos
                                </button>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <div class="col-span-4 bg-slate-200 flex items-center justify-center text-slate-400">
                             <span class="material-symbols-outlined text-6xl">image</span>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 relative">
                <div class="lg:col-span-2 space-y-10">
                    
                    <!-- Header Info -->
                    <div class="border-b border-slate-200/50 dark:border-slate-700/50 pb-8">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h1 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-2"><?php the_title(); ?></h1>
                                <p class="text-slate-600 dark:text-slate-300 text-lg">
                                    <?php 
                                    if($prop_types) echo esc_html($prop_types[0]->name);
                                    if($locations) echo " in " . esc_html($locations[0]->name);
                                    ?>
                                </p>
                            </div>
                            <div class="flex flex-col items-end">
                                <div class="flex items-center gap-1 bg-primary/10 px-2 py-1 rounded-md mb-2">
                                    <span class="material-symbols-outlined text-primary text-sm">verified</span>
                                    <span class="text-primary text-xs font-bold uppercase tracking-wide">Verified</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-4 text-sm font-medium text-slate-500 dark:text-slate-400 mt-2 mb-4">
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-base">group</span> <?php echo esc_html($max_guests); ?> guests</span>
                            <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-base">bed</span> Multiple rooms</span>
                            <?php if ($lat && $lng) : ?>
                            <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-600 hidden md:block"></span>
                            <span class="flex items-center gap-1 w-full md:w-auto mt-2 md:mt-0">
                                <span class="material-symbols-outlined text-base text-primary">my_location</span>
                                <?php echo esc_html($lat); ?>, <?php echo esc_html($lng); ?>
                            </span>
                            <?php endif; ?>
                            <div class="ml-auto flex items-center gap-1 w-full md:w-auto mt-2 md:mt-0 justify-end">
                                <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1">star</span>
                                <span class="text-slate-900 dark:text-white font-bold text-base">4.92</span>
                                <span class="underline decoration-slate-300 cursor-pointer hover:text-primary transition-colors">(Plugin Reviews)</span>
                            </div>
                        </div>

                        <?php if (!empty($attractions)) : ?>
                        <div class="mt-6 p-4 rounded-xl bg-slate-100/50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700">
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-lg">explore</span>
                                Nearby Attractions
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach($attractions as $item): ?>
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-white dark:bg-slate-700 rounded-full text-xs font-medium text-slate-700 dark:text-slate-300 shadow-sm border border-slate-200 dark:border-slate-600">
                                        <span class="material-symbols-outlined text-[14px] text-slate-400">place</span>
                                        <?php echo esc_html($item); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- About Stay -->
                    <div class="glass-panel p-8 rounded-3xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/10 rounded-bl-full -mr-8 -mt-8 blur-2xl"></div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">About this stay</h2>
                        <div class="text-slate-600 dark:text-slate-300 leading-relaxed entry-content">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <!-- Amenities -->
                    <?php if (!empty($amenity_keys)) : ?>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">What this place offers</h2>
                        <div class="grid grid-cols-2 gap-y-4 gap-x-8">
                            <?php
                            $all_amenities = array(
                                'wifi' => array('label' => 'WiFi', 'icon' => 'wifi'),
                                'parking' => array('label' => 'Free Parking', 'icon' => 'local_parking'),
                                'kitchen' => array('label' => 'Kitchen', 'icon' => 'soup_kitchen'),
                                'ac' => array('label' => 'Air Conditioning', 'icon' => 'ac_unit'),
                                'tv' => array('label' => 'TV', 'icon' => 'tv'),
                                'washing_machine' => array('label' => 'Washing', 'icon' => 'local_laundry_service'),
                                'hot_water' => array('label' => 'Hot Water', 'icon' => 'hot_tub'),
                                'garden' => array('label' => 'Garden', 'icon' => 'park'),
                                'balcony' => array('label' => 'Balcony', 'icon' => 'balcony'),
                                'fireplace' => array('label' => 'Fireplace', 'icon' => 'fireplace'),
                                'gym' => array('label' => 'Gym', 'icon' => 'fitness_center'),
                                'pool' => array('label' => 'Pool', 'icon' => 'pool')
                            );
                            
                            foreach ($amenity_keys as $key) :
                                if (!isset($all_amenities[$key])) continue;
                                ?>
                                <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-white/40 dark:hover:bg-slate-800/40 transition-colors">
                                    <span class="material-symbols-outlined text-slate-700 dark:text-slate-300 text-2xl"><?php echo $all_amenities[$key]['icon']; ?></span>
                                    <span class="text-slate-700 dark:text-slate-200"><?php echo esc_html($all_amenities[$key]['label']); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- House Rules -->
                    <?php if ($dos || $donts) : ?>
                    <div class="border-t border-slate-200/50 dark:border-slate-700/50 pt-10">
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">House Rules</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php if ($dos) : ?>
                            <div class="glass-card p-6 rounded-2xl">
                                <h4 class="font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-green-500">check_circle</span>
                                    Things to do
                                </h4>
                                <ul class="space-y-2 text-slate-600 dark:text-slate-300 text-sm">
                                    <?php foreach(explode("\n", $dos) as $line) if(trim($line)) echo '<li class="flex items-start gap-2"><span>&bull;</span>'.esc_html($line).'</li>'; ?>
                                </ul>
                            </div>
                            <?php endif; ?>

                            <?php if ($donts) : ?>
                            <div class="glass-card p-6 rounded-2xl">
                                <h4 class="font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-red-500">cancel</span>
                                    Things to avoid
                                </h4>
                                <ul class="space-y-2 text-slate-600 dark:text-slate-300 text-sm">
                                    <?php foreach(explode("\n", $donts) as $line) if(trim($line)) echo '<li class="flex items-start gap-2"><span>&bull;</span>'.esc_html($line).'</li>'; ?>
                                </ul>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>

                <!-- Sidebar / Booking Widget -->
                <div class="lg:col-span-1">
                    <div class="sticky top-28 space-y-8">
                        <div class="glass-panel p-6 rounded-3xl shadow-2xl border border-white/60 dark:border-slate-600/50">
                            <?php echo do_shortcode('[hhb_booking_form]'); ?>
                            
                            <p class="text-center text-xs text-slate-500 mt-6">You won't be charged yet</p>
                            <div class="glass-card p-4 rounded-2xl mt-6">
                                <h4 class="font-bold text-sm text-slate-900 dark:text-white mb-2">Cancellation Policy</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Free cancellation for 48 hours. Secure your booking today.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof GLightbox !== 'undefined') {
            const lightbox = GLightbox({ selector: '.glightbox' });
        }
    });
    </script>

<?php
endwhile;

get_footer();
