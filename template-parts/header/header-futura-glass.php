<?php
/**
 * FuturaStays Glass Header
 *
 * Fixed glass-nav header with announcement bar, mega menu,
 * search bar, CTA button, and user avatar.
 *
 * @package HimalayanMart
 */
if ( ! defined( 'ABSPATH' ) ) exit;

// Customizer values
$show_announcement = get_theme_mod( 'hm_futura_header_show_announcement', true );
$announcement_text = get_theme_mod( 'hm_futura_header_announcement_text', 'New: Explore our Winter Collection in the Himalayas.' );
$announcement_cta  = get_theme_mod( 'hm_futura_header_announcement_cta_text', 'Learn more' );
$announcement_url  = get_theme_mod( 'hm_futura_header_announcement_cta_url', '#' );
$announcement_bg   = get_theme_mod( 'hm_futura_header_announcement_bg', '#e85e30' );
$announcement_tc   = get_theme_mod( 'hm_futura_header_announcement_text_color', '#ffffff' );

$show_search       = get_theme_mod( 'hm_futura_header_show_search', true );
$search_placeholder= get_theme_mod( 'hm_futura_header_search_placeholder', 'Where are you going?' );
$show_cta          = get_theme_mod( 'hm_futura_header_show_cta', true );
$cta_text          = get_theme_mod( 'hm_futura_header_cta_text', 'List your homestay' );
$cta_url           = get_theme_mod( 'hm_futura_header_cta_url', home_url( '/become-a-host/' ) );
$show_avatar       = get_theme_mod( 'hm_futura_header_show_avatar', true );
$glass_opacity     = get_theme_mod( 'hm_futura_header_glass_opacity', 70 );
$nav_text_color    = get_theme_mod( 'hm_futura_header_nav_text_color', '#334155' );

// Mega menu — customizer settings
$mega_label    = get_theme_mod( 'hm_futura_mega_label', 'Stays' );
$mega_rows     = max( 1, min( 20, intval( get_theme_mod( 'hm_futura_mega_rows', 6 ) ) ) );
$mega_compact  = (bool) get_theme_mod( 'hm_futura_mega_compact', false );
$mega_half_w   = (bool) get_theme_mod( 'hm_futura_mega_half_width', false );

// 3-Column independent links
$mega_col_links_raw = get_theme_mod( 'hm_futura_mega_col_links', '{"col1":[],"col2":[],"col3":[]}' );
$mega_col_links     = json_decode( $mega_col_links_raw, true );
if ( ! is_array( $mega_col_links ) ) {
    $mega_col_links = array( 'col1' => array(), 'col2' => array(), 'col3' => array() );
}

// Ensure all 3 columns exist
foreach ( array( 'col1', 'col2', 'col3' ) as $ck ) {
    if ( ! isset( $mega_col_links[ $ck ] ) ) {
        $mega_col_links[ $ck ] = array();
    }
}

$mega_has_links = false;
foreach ( $mega_col_links as $col_items ) {
    if ( ! empty( $col_items ) ) { $mega_has_links = true; break; }
}

// Spotlight Settings (kept for future use but hidden in 3-col mode)
$mega_show_spotlight = get_theme_mod( 'hm_futura_mega_show_spotlight', false );
$mega_spotlight_img  = get_theme_mod( 'hm_futura_mega_spotlight_img', '' );
$mega_spotlight_title    = get_theme_mod( 'hm_futura_mega_spotlight_title', 'Become a Host' );
$mega_spotlight_desc     = get_theme_mod( 'hm_futura_mega_spotlight_desc', 'Earn extra income by opening your home to travelers.' );
$mega_spotlight_btn_text = get_theme_mod( 'hm_futura_mega_spotlight_btn_text', 'Learn More' );
$mega_spotlight_url      = get_theme_mod( 'hm_futura_mega_spotlight_url', home_url( '/become-a-host/' ) );

$mega_show_taxonomies = false; // Using 3-col custom links now

// Extra top-level custom links
$header_links_raw = get_theme_mod( 'hm_futura_header_extra_links', '[]' );
$header_extra_links = json_decode( $header_links_raw, true );
if ( ! is_array( $header_extra_links ) ) {
    $header_extra_links = array();
} else {
    usort($header_extra_links, function($a, $b) {
        return (int)($a['order'] ?? 0) <=> (int)($b['order'] ?? 0);
    });
}

// Logged-in user info
$current_user = wp_get_current_user();
$user_avatar = '';
if ( $current_user->ID ) {
    $custom_avatar_id = get_user_meta( $current_user->ID, 'hhb_avatar_id', true );
    if ( $custom_avatar_id ) {
        $user_avatar = wp_get_attachment_image_url( $custom_avatar_id, 'thumbnail' );
    }
    if ( ! $user_avatar ) {
        $user_avatar = get_avatar_url( $current_user->ID, array( 'size' => 80 ) );
    }
}
?>

<header id="futura-header" class="fixed top-0 left-0 right-0 z-50">

    <?php if ( $show_announcement ) : ?>
    <!-- Announcement Bar -->
    <div class="futura-announcement" style="background:<?php echo esc_attr( $announcement_bg ); ?>; color:<?php echo esc_attr( $announcement_tc ); ?>;">
        <div class="container mx-auto flex items-center justify-center gap-2 py-2 px-4 text-center text-sm font-medium tracking-wide">
            <span><?php echo wp_kses_post( $announcement_text ); ?></span>
            <?php if ( $announcement_cta ) : ?>
            <a class="underline font-bold hover:opacity-80 flex items-center gap-1 transition-opacity" href="<?php echo esc_url( $announcement_url ); ?>" style="color:<?php echo esc_attr( $announcement_tc ); ?>;">
                <?php echo esc_html( $announcement_cta ); ?> <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Main Navigation -->
    <nav class="futura-glass-nav px-4 md:px-10 py-3" style="--glass-opacity:<?php echo esc_attr( $glass_opacity / 100 ); ?>; color:<?php echo esc_attr( $nav_text_color ); ?>;">
        <div class="container mx-auto flex items-center justify-between gap-4">

            <!-- Logo -->
            <div class="flex items-center gap-3 shrink-0">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <div class="size-10 bg-primary rounded-lg flex items-center justify-center text-white">
                        <span class="material-symbols-outlined text-2xl">travel_explore</span>
                    </div>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-xl font-extrabold tracking-tight hidden sm:block hover:text-primary transition-colors" style="color:inherit; text-decoration:none;">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Desktop Menu & Search -->
            <div class="hidden lg:flex items-center gap-8 flex-1 justify-center max-w-4xl px-4">

                <!-- Mega Menu -->
                <?php ob_start(); ?>
                <?php if ( $mega_has_links ) : ?>
                <div class="group static">
                    <button class="flex items-center gap-1 font-semibold hover:text-primary transition-colors py-4 px-2" style="color:inherit;">
                        <?php echo esc_html( $mega_label ); ?>
                    </button>
                    <!-- Mega Dropdown: 3-Column -->
                    <div class="futura-mega-menu absolute top-full z-[100] transition-all duration-300 opacity-0 invisible pointer-events-none group-hover:opacity-100 group-hover:visible group-hover:pointer-events-auto bg-white shadow-[0_20px_50px_rgba(0,0,0,0.15)] border-b border-slate-200"
                         style="<?php echo $mega_half_w ? 'left:auto; right:auto; width:52vw; max-width:820px;' : 'left:0; right:0;'; ?> border-radius:0;">

                        <!-- Invisible bridge for mouse travel stability -->
                        <div class="absolute -top-4 left-0 right-0 h-4"></div>

                        <div class="container mx-auto <?php echo $mega_compact ? 'px-8 py-6' : 'px-8 md:px-16 py-10'; ?>">
                            <div class="grid grid-cols-3 gap-x-10">
                                <?php
                                $col_keys = array( 'col1', 'col2', 'col3' );
                                foreach ( $col_keys as $col_key ) :
                                    $col_items = $mega_col_links[ $col_key ] ?? array();
                                    $col_items = array_slice( $col_items, 0, $mega_rows );
                                ?>
                                <div class="mega-column">
                                    <div class="flex flex-col gap-1">
                                        <?php foreach ( $col_items as $item ) :
                                            $display    = sanitize_text_field( $item['name'] ?? '' );
                                            $link       = esc_url( $item['link'] ?? '#' );
                                            $icon       = sanitize_text_field( $item['icon'] ?? '' );
                                            $icon_color = $item['color'] ?? '';
                                            // Validate & default color
                                            if ( ! preg_match('/^#[0-9a-fA-F]{6}$/', $icon_color) ) {
                                                $icon_color = '#e85e30';
                                            }
                                            // Convert hex to rgba for a subtle 10% tint background
                                            $r = hexdec( substr( ltrim($icon_color,'#'), 0, 2 ) );
                                            $g = hexdec( substr( ltrim($icon_color,'#'), 2, 2 ) );
                                            $b = hexdec( substr( ltrim($icon_color,'#'), 4, 2 ) );
                                            $icon_bg = "rgba($r,$g,$b,0.1)";
                                            if ( empty( $display ) ) continue;
                                        ?>
                                            <a href="<?php echo $link; ?>" class="futura-mega-link">
                                                <?php if ( $icon ) : ?>
                                                <span class="futura-mega-icon"
                                                      style="background:<?php echo esc_attr($icon_bg); ?>; color:<?php echo esc_attr($icon_color); ?>;">
                                                    <span class="material-symbols-outlined"><?php echo esc_html($icon); ?></span>
                                                </span>
                                                <?php endif; ?>
                                                <span class="futura-mega-link-label"><?php echo esc_html( $display ); ?></span>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php
                $futura_mega_menu_desktop_html = ob_get_clean();
                
                $has_mega = false;
                foreach($header_extra_links as $l) {
                    if (($l['link'] ?? '') === '#mega-menu') { $has_mega = true; break; }
                }
                ?>

                <!-- Custom Top Level Links -->
                <?php foreach ( $header_extra_links as $link_item ) : 
                    $link_name = sanitize_text_field( $link_item['name'] ?? '' );
                    $link_url  = esc_url_raw( $link_item['link'] ?? '#' );
                    if ( ! $link_name ) continue;
                    
                    if ( $link_url === '#mega-menu' ) {
                        echo $futura_mega_menu_desktop_html;
                    } else {
                ?>
                <a href="<?php echo esc_url( $link_url ); ?>" class="font-semibold hover:text-primary transition-colors py-4 text-[15px]" style="color:inherit; text-decoration: none;">
                    <?php echo esc_html( $link_name ); ?>
                </a>
                <?php 
                    }
                endforeach; ?>

                <!-- WordPress Primary Menu Items -->
                <?php
                $primary_menu_html = wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'futura-desktop-menu flex items-center gap-6 m-0 p-0 list-none',
                    'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                    'depth'          => 1,
                    'fallback_cb'    => false,
                    'echo'           => false,
                ) );

                $mega_pos = (int) get_theme_mod( 'hm_futura_mega_position', 0 );

                // If the user hasn't forced it as a custom link, intelligently inject it into the WP primary menu
                if ( ! $has_mega && $primary_menu_html ) {
                    $items_array = explode('<li', $primary_menu_html);
                    if ( count($items_array) > 1 ) {
                        $inject_index = min( $mega_pos + 1, count($items_array) );
                        $mega_li_html = ' class="menu-item list-none p-0 m-0">' . $futura_mega_menu_desktop_html . '</li>';
                        array_splice( $items_array, $inject_index, 0, $mega_li_html );
                        $primary_menu_html = implode( '<li', $items_array );
                        $has_mega = true;
                    }
                }

                // Absolute fallback if primary menu is empty and it wasn't in custom links
                if ( ! $has_mega ) {
                    echo $futura_mega_menu_desktop_html;
                }

                echo $primary_menu_html;
                ?>

                <!-- Search Bar -->
                <?php if ( $show_search ) : ?>
                <div class="flex-1 max-w-md">
                    <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="relative group/search">
                        <input type="search" name="s" class="w-full bg-slate-100 dark:bg-slate-800 border-none rounded-full px-5 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 placeholder:text-slate-500 outline-none" placeholder="<?php echo esc_attr( $search_placeholder ); ?>" value="<?php echo get_search_query(); ?>" />
                    </form>
                </div>
                <?php endif; ?>

            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-2 md:gap-4">

                <?php if ( $show_cta ) : ?>
                <a href="<?php echo esc_url( $cta_url ); ?>" class="hhb-header-cta-btn hidden md:flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-full font-bold text-sm shadow-lg" style="text-decoration:none;">
                    <?php echo esc_html( $cta_text ); ?>
                </a>
                <?php endif; ?>

                <!-- Mobile Search Toggle -->
                <button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors lg:hidden" style="color:inherit;" id="futura-mobile-search-toggle">
                    <span class="material-symbols-outlined">search</span>
                </button>

                <!-- User Avatar / My Account -->
                <?php if ( $show_avatar ) : ?>
                    <?php $my_account_url = home_url( '/my-account/' ); ?>
                    <?php if ( is_user_logged_in() ) : ?>
                    <a href="<?php echo esc_url( $my_account_url ); ?>" class="h-10 w-10 rounded-full overflow-hidden border-2 border-primary/20 cursor-pointer hover:border-primary transition-all p-0.5 block">
                        <img src="<?php echo esc_url( $user_avatar ); ?>" alt="<?php echo esc_attr( $current_user->display_name ); ?>" class="w-full h-full rounded-full object-cover" />
                    </a>
                    <?php else : ?>
                    <a href="<?php echo esc_url( $my_account_url ); ?>" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors" style="color:inherit; text-decoration:none;">
                        <span class="material-symbols-outlined">person</span>
                    </a>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Mobile Hamburger -->
                <button class="lg:hidden p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full" style="color:inherit;" id="futura-mobile-menu-toggle">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </div>

        </div>
    </nav>

    <!-- Mobile Off-Canvas Menu -->
    <div id="futura-mobile-menu" class="futura-mobile-panel hidden">
        <div class="futura-mobile-panel-overlay"></div>
        <div class="futura-mobile-panel-content">
            <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-slate-700">
                <div class="futura-mobile-logo h-8 [&>a>img]:h-full [&>a>img]:w-auto">
                    <?php if ( has_custom_logo() ) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <span class="font-extrabold text-lg"><?php bloginfo( 'name' ); ?></span>
                    <?php endif; ?>
                </div>
                <button id="futura-mobile-menu-close" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Mobile Search -->
            <?php if ( $show_search ) : ?>
            <div class="p-4">
                <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="relative">
                    <input type="search" name="s" class="w-full bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-4 shadow-sm outline-none text-sm" placeholder="<?php echo esc_attr( $search_placeholder ); ?>" />
                </form>
            </div>
            <?php endif; ?>

            <!-- Mobile Accordion Menu -->
            <div class="divide-y divide-slate-200 dark:divide-slate-700 overflow-y-auto flex-1">

                <!-- Mobile Accordion — 3-column links flattened -->
                <?php ob_start(); ?>
                <?php
                // Flatten all 3 columns into one list for mobile
                $mobile_all_links = array();
                foreach ( array( 'col1', 'col2', 'col3' ) as $ck ) {
                    foreach ( $mega_col_links[ $ck ] ?? array() as $it ) {
                        if ( ! empty( $it['name'] ) ) $mobile_all_links[] = $it;
                    }
                }
                ?>
                <?php if ( ! empty( $mobile_all_links ) ) : ?>
                <details class="group p-4">
                    <summary class="list-none flex justify-between items-center cursor-pointer font-bold">
                        <?php echo esc_html( $mega_label ); ?>
                        <span class="material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
                    </summary>
                    <div class="mt-4 flex flex-col gap-4 pl-2 border-l-2 border-primary/20 ml-2">
                        <?php foreach ( $mobile_all_links as $item ) :
                            $display = sanitize_text_field( $item['name'] ?? '' );
                            $link    = esc_url( $item['link'] ?? '#' );
                            if ( ! $display ) continue;
                        ?>
                        <a class="text-sm font-medium hover:text-primary transition-colors" href="<?php echo $link; ?>" style="text-decoration:none;">
                            <?php echo esc_html( $display ); ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </details>
                <?php endif; ?>
                <?php
                $futura_mega_menu_mobile_html = ob_get_clean();
                $has_mega_mobile = false;
                foreach($header_extra_links as $l) {
                    if (($l['link'] ?? '') === '#mega-menu') { $has_mega_mobile = true; break; }
                }
                ?>

                <!-- Custom Top-Level Links (Mobile) -->
                <?php foreach ( $header_extra_links as $link_item ) : 
                    $link_name = sanitize_text_field( $link_item['name'] ?? '' );
                    $link_url  = esc_url_raw( $link_item['link'] ?? '#' );
                    if ( ! $link_name ) continue;
                    
                    if ( $link_url === '#mega-menu' ) {
                        echo $futura_mega_menu_mobile_html;
                    } else {
                ?>
                <div class="px-4 py-3 border-b border-slate-200 dark:border-slate-700">
                    <a href="<?php echo esc_url( $link_url ); ?>" class="text-sm font-bold text-slate-800 dark:text-slate-100 hover:text-primary transition-colors" style="text-decoration: none;">
                        <?php echo esc_html( $link_name ); ?>
                    </a>
                </div>
                <?php 
                    }
                endforeach; ?>

                <!-- Primary Menu Items -->
                <?php
                $primary_menu_mobile_html = wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'futura-mobile-nav-list p-0 m-0 list-none',
                    'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                    'depth'          => 1,
                    'fallback_cb'    => false,
                    'echo'           => false,
                ) );

                if ( ! $has_mega_mobile && $primary_menu_mobile_html ) {
                    $items_array_mobile = explode('<li', $primary_menu_mobile_html);
                    if ( count($items_array_mobile) > 1 ) {
                        $mega_pos_mob     = (int) get_theme_mod( 'hm_futura_mega_position', 0 );
                        $inject_index_mob = min( $mega_pos_mob + 1, count($items_array_mobile) );
                        $mega_li_mob_html = ' class="menu-item list-none p-0 m-0 border-b border-slate-200 dark:border-slate-700">' . $futura_mega_menu_mobile_html . '</li>';
                        array_splice( $items_array_mobile, $inject_index_mob, 0, $mega_li_mob_html );
                        $primary_menu_mobile_html = implode( '<li', $items_array_mobile );
                        $has_mega_mobile = true;
                    }
                }

                if ( ! $has_mega_mobile ) {
                    echo $futura_mega_menu_mobile_html;
                }

                echo $primary_menu_mobile_html;
                ?>
            </div>

            <!-- Mobile CTA -->
            <?php if ( $show_cta ) : ?>
            <div class="p-4 border-t border-slate-200 dark:border-slate-700">
                <a href="<?php echo esc_url( $cta_url ); ?>" class="hhb-header-cta-btn block w-full text-center bg-primary text-white px-5 py-3 rounded-xl font-bold text-sm shadow-lg" style="text-decoration:none;">
                    <?php echo esc_html( $cta_text ); ?>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- Spacer to offset fixed header -->
<div class="futura-header-spacer"></div>
