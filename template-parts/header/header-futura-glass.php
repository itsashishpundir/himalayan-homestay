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

// Mega menu items from hhb_property_type taxonomy
$mega_menu_icons = array(
    'beach_access', 'landscape', 'location_city', 'eco', 'home_mini', 'domain',
    'cottage', 'apartment', 'villa', 'cabin', 'hotel', 'house'
);
$property_types = get_terms( array(
    'taxonomy'   => 'hhb_property_type',
    'hide_empty' => false,
    'number'     => 6,
) );

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

                <!-- Mega Menu: Stays -->
                <?php if ( ! empty( $property_types ) && ! is_wp_error( $property_types ) ) : ?>
                <div class="relative group">
                    <button class="flex items-center gap-1 font-semibold hover:text-primary transition-colors py-4" style="color:inherit;">
                        <?php esc_html_e( 'Stays', 'himalayanmart' ); ?>
                        <span class="material-symbols-outlined text-base">expand_more</span>
                    </button>
                    <!-- Mega Dropdown -->
                    <div class="futura-mega-menu absolute top-[calc(100%-1rem)] left-0 w-[500px] bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl rounded-xl shadow-2xl border border-primary/10 p-4 grid grid-cols-2 gap-2 z-50">
                        <?php foreach ( $property_types as $idx => $type ) :
                            $icon = isset( $mega_menu_icons[ $idx ] ) ? $mega_menu_icons[ $idx ] : 'home';
                            $desc = $type->description ?: esc_html__( 'Explore this category', 'himalayanmart' );
                            $link = get_term_link( $type );
                            if ( is_wp_error( $link ) ) $link = '#';
                        ?>
                        <a class="flex gap-4 p-3 rounded-lg hover:bg-primary/5 transition-all group/item" href="<?php echo esc_url( $link ); ?>">
                            <div class="size-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center group-hover/item:bg-primary group-hover/item:text-white transition-colors shrink-0">
                                <span class="material-symbols-outlined"><?php echo esc_html( $icon ); ?></span>
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-bold text-sm text-slate-900 dark:text-white"><?php echo esc_html( $type->name ); ?></h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 truncate"><?php echo esc_html( $desc ); ?></p>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- WordPress Primary Menu Items -->
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'futura-desktop-menu',
                    'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                    'depth'          => 1,
                    'fallback_cb'    => false,
                ) );
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
                <a href="<?php echo esc_url( $cta_url ); ?>" class="hidden md:flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-full font-bold text-sm shadow-lg shadow-primary/20 hover:scale-105 active:scale-95 transition-all" style="text-decoration:none;">
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

                <!-- Stays Accordion -->
                <?php if ( ! empty( $property_types ) && ! is_wp_error( $property_types ) ) : ?>
                <details class="group p-4">
                    <summary class="list-none flex justify-between items-center cursor-pointer font-bold">
                        <?php esc_html_e( 'Stays', 'himalayanmart' ); ?>
                        <span class="material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
                    </summary>
                    <div class="mt-4 flex flex-col gap-4 pl-2 border-l-2 border-primary/20 ml-2">
                        <?php foreach ( $property_types as $type ) :
                            $link = get_term_link( $type );
                            if ( is_wp_error( $link ) ) $link = '#';
                        ?>
                        <a class="text-sm font-medium hover:text-primary transition-colors" href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $type->name ); ?></a>
                        <?php endforeach; ?>
                    </div>
                </details>
                <?php endif; ?>

                <!-- Primary Menu Items -->
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'futura-mobile-nav-list',
                    'items_wrap'     => '<div class="%2$s">%3$s</div>',
                    'depth'          => 1,
                    'fallback_cb'    => false,
                ) );
                ?>
            </div>

            <!-- Mobile CTA -->
            <?php if ( $show_cta ) : ?>
            <div class="p-4 border-t border-slate-200 dark:border-slate-700">
                <a href="<?php echo esc_url( $cta_url ); ?>" class="block w-full text-center bg-primary text-white px-5 py-3 rounded-xl font-bold text-sm shadow-lg shadow-primary/20 transition-all" style="text-decoration:none;">
                    <?php echo esc_html( $cta_text ); ?>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- Spacer to offset fixed header -->
<div class="futura-header-spacer"></div>
