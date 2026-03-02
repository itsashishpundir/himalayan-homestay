<?php
/**
 * FuturaStays Newsletter Footer
 *
 * Premium footer with newsletter section, 4-column link grid,
 * social icons, language selector, and copyright bar.
 *
 * @package HimalayanMart
 */
if ( ! defined( 'ABSPATH' ) ) exit;

// Customizer values
$show_newsletter   = get_theme_mod( 'hm_futura_footer_show_newsletter', true );
$newsletter_heading= get_theme_mod( 'hm_futura_footer_newsletter_heading', 'Stay ahead of the curve' );
$newsletter_desc   = get_theme_mod( 'hm_futura_footer_newsletter_desc', 'Join 50,000+ travelers and get the latest on exclusive offers and unique experiences.' );
$newsletter_btn    = get_theme_mod( 'hm_futura_footer_newsletter_btn', 'Sign Up Now' );
$privacy_text      = get_theme_mod( 'hm_futura_footer_privacy_text', 'privacy policy' );
$privacy_url       = get_theme_mod( 'hm_futura_footer_privacy_url', '#' );

$col1_title = get_theme_mod( 'hm_futura_footer_col1_title', 'Discover' );
$col2_title = get_theme_mod( 'hm_futura_footer_col2_title', 'Company' );
$col3_title = get_theme_mod( 'hm_futura_footer_col3_title', 'Support' );
$col4_title = get_theme_mod( 'hm_futura_footer_col4_title', 'Connect' );

$twitter_url   = get_theme_mod( 'hm_futura_footer_twitter', '' );
$instagram_url = get_theme_mod( 'hm_futura_footer_instagram', '' );
$youtube_url   = get_theme_mod( 'hm_futura_footer_youtube', '' );
$facebook_url  = get_theme_mod( 'hm_futura_footer_facebook', '' );

$show_language = get_theme_mod( 'hm_futura_footer_show_language', true );

$copyright = get_theme_mod( 'hm_futura_footer_copyright', '© [year] [sitename]. All rights reserved.' );
$copyright = str_replace( '[year]', date( 'Y' ), $copyright );
$copyright = str_replace( '[sitename]', get_bloginfo( 'name' ), $copyright );

$footer_bg      = get_theme_mod( 'hm_futura_footer_bg', '#ffffff' );
$footer_text    = get_theme_mod( 'hm_futura_footer_text_color', '#475569' );
$footer_heading = get_theme_mod( 'hm_futura_footer_heading_color', '#e85e30' );
?>

<footer class="futura-footer border-t border-slate-200 dark:border-slate-800 pt-20 pb-10" style="background:<?php echo esc_attr( $footer_bg ); ?>; color:<?php echo esc_attr( $footer_text ); ?>;">
<div class="container mx-auto px-4 md:px-10">

    <?php if ( $show_newsletter ) : ?>
    <!-- Newsletter Section -->
    <div class="flex flex-col lg:flex-row items-center justify-between gap-10 pb-20 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-md text-center lg:text-left">
            <h3 class="text-3xl font-black mb-4 tracking-tight text-slate-900 dark:text-white"><?php echo esc_html( $newsletter_heading ); ?></h3>
            <p class="text-slate-500 dark:text-slate-400"><?php echo esc_html( $newsletter_desc ); ?></p>
        </div>
        <div class="w-full max-w-lg">
            <form class="flex flex-col sm:flex-row gap-3" action="#" method="post">
                <input class="flex-1 bg-slate-100 dark:bg-slate-800 border-none rounded-xl px-5 py-4 focus:ring-2 focus:ring-primary/20 text-sm outline-none" placeholder="<?php esc_attr_e( 'Enter your email', 'himalayanmart' ); ?>" type="email" name="email" required />
                <button class="bg-primary hover:bg-primary/90 text-white font-bold px-8 py-4 rounded-xl transition-all whitespace-nowrap" type="submit"><?php echo esc_html( $newsletter_btn ); ?></button>
            </form>
            <?php if ( $privacy_text ) : ?>
            <p class="text-xs text-slate-400 mt-4 text-center sm:text-left">
                <?php esc_html_e( 'We care about your data in our', 'himalayanmart' ); ?>
                <a class="underline hover:text-primary transition-colors" href="<?php echo esc_url( $privacy_url ); ?>"><?php echo esc_html( $privacy_text ); ?></a>.
            </p>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Main Footer Links -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-12 py-20">

        <!-- Column 1: Discover -->
        <div class="flex flex-col gap-6">
            <h4 class="font-black text-sm uppercase tracking-widest" style="color:<?php echo esc_attr( $footer_heading ); ?>;"><?php echo esc_html( $col1_title ); ?></h4>
            <?php
            wp_nav_menu( array(
                'theme_location' => 'footer-discover',
                'container'      => false,
                'menu_class'     => 'futura-footer-links',
                'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                'depth'          => 1,
                'fallback_cb'    => function() {
                    echo '<ul class="futura-footer-links">';
                    echo '<li><a href="#">' . esc_html__( 'Trending Places', 'himalayanmart' ) . '</a></li>';
                    echo '<li><a href="#">' . esc_html__( 'Featured Homes', 'himalayanmart' ) . '</a></li>';
                    echo '<li><a href="#">' . esc_html__( 'Travel Experiences', 'himalayanmart' ) . '</a></li>';
                    echo '</ul>';
                },
            ) );
            ?>
        </div>

        <!-- Column 2: Company -->
        <div class="flex flex-col gap-6">
            <h4 class="font-black text-sm uppercase tracking-widest" style="color:<?php echo esc_attr( $footer_heading ); ?>;"><?php echo esc_html( $col2_title ); ?></h4>
            <?php
            wp_nav_menu( array(
                'theme_location' => 'footer-company',
                'container'      => false,
                'menu_class'     => 'futura-footer-links',
                'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                'depth'          => 1,
                'fallback_cb'    => function() {
                    echo '<ul class="futura-footer-links">';
                    echo '<li><a href="#">' . esc_html__( 'About Us', 'himalayanmart' ) . '</a></li>';
                    echo '<li><a href="#">' . esc_html__( 'Careers', 'himalayanmart' ) . '</a></li>';
                    echo '<li><a href="#">' . esc_html__( 'Newsroom', 'himalayanmart' ) . '</a></li>';
                    echo '</ul>';
                },
            ) );
            ?>
        </div>

        <!-- Column 3: Support -->
        <div class="flex flex-col gap-6">
            <h4 class="font-black text-sm uppercase tracking-widest" style="color:<?php echo esc_attr( $footer_heading ); ?>;"><?php echo esc_html( $col3_title ); ?></h4>
            <?php
            wp_nav_menu( array(
                'theme_location' => 'footer-support',
                'container'      => false,
                'menu_class'     => 'futura-footer-links',
                'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                'depth'          => 1,
                'fallback_cb'    => function() {
                    echo '<ul class="futura-footer-links">';
                    echo '<li><a href="#">' . esc_html__( 'Help Center', 'himalayanmart' ) . '</a></li>';
                    echo '<li><a href="#">' . esc_html__( 'Safety Center', 'himalayanmart' ) . '</a></li>';
                    echo '<li><a href="#">' . esc_html__( 'Report a problem', 'himalayanmart' ) . '</a></li>';
                    echo '</ul>';
                },
            ) );
            ?>
        </div>

        <!-- Column 4: Connect -->
        <div class="flex flex-col gap-6">
            <h4 class="font-black text-sm uppercase tracking-widest" style="color:<?php echo esc_attr( $footer_heading ); ?>;"><?php echo esc_html( $col4_title ); ?></h4>
            <div class="flex gap-4">
                <?php if ( $twitter_url ) : ?>
                <a class="size-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center hover:bg-primary hover:text-white transition-all" href="<?php echo esc_url( $twitter_url ); ?>" target="_blank" rel="noopener" aria-label="Twitter">
                    <svg class="size-5 fill-current" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                </a>
                <?php endif; ?>

                <?php if ( $facebook_url ) : ?>
                <a class="size-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center hover:bg-primary hover:text-white transition-all" href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener" aria-label="Facebook">
                    <svg class="size-5 fill-current" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                </a>
                <?php endif; ?>

                <?php if ( $instagram_url ) : ?>
                <a class="size-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center hover:bg-primary hover:text-white transition-all" href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener" aria-label="Instagram">
                    <svg class="size-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849s-.011 3.585-.069 4.85c-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07s-3.584-.012-4.849-.07c-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849s.012-3.584.07-4.849c.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948s.014 3.667.072 4.947c.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072s3.667-.014 4.947-.072c4.358-.2 6.78-2.618 6.98-6.98.058-1.281.072-1.689.072-4.948s-.014-3.667-.072-4.947c-.2-4.358-2.618-6.78-6.98-6.98-1.281-.058-1.689-.072-4.948-.072zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
                <?php endif; ?>

                <?php if ( $youtube_url ) : ?>
                <a class="size-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center hover:bg-primary hover:text-white transition-all" href="<?php echo esc_url( $youtube_url ); ?>" target="_blank" rel="noopener" aria-label="YouTube">
                    <svg class="size-5 fill-current" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 4-8 4z"/></svg>
                </a>
                <?php endif; ?>

                <?php if ( ! $twitter_url && ! $facebook_url && ! $instagram_url && ! $youtube_url ) : ?>
                <p class="text-sm text-slate-400"><?php esc_html_e( 'Add social links in Customizer', 'himalayanmart' ); ?></p>
                <?php endif; ?>
            </div>

            <?php if ( $show_language ) : ?>
            <div class="mt-4">
                <button class="flex items-center gap-2 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-xl">language</span>
                    <span class="font-bold text-sm"><?php esc_html_e( 'English (US)', 'himalayanmart' ); ?></span>
                </button>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Copyright and Legal -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-6 pt-10 border-t border-slate-200 dark:border-slate-800 text-sm font-medium" style="color:<?php echo esc_attr( $footer_text ); ?>;">
        <div class="flex items-center gap-2">
            <span class="font-bold text-slate-900 dark:text-white"><?php bloginfo( 'name' ); ?></span>
            <span><?php echo wp_kses_post( $copyright ); ?></span>
        </div>
        <div class="flex flex-wrap justify-center gap-6">
            <?php if ( $privacy_url && $privacy_url !== '#' ) : ?>
            <a class="hover:text-primary transition-colors" href="<?php echo esc_url( $privacy_url ); ?>"><?php esc_html_e( 'Privacy', 'himalayanmart' ); ?></a>
            <?php endif; ?>
            <a class="hover:text-primary transition-colors" href="<?php echo esc_url( get_privacy_policy_url() ?: '#' ); ?>"><?php esc_html_e( 'Terms', 'himalayanmart' ); ?></a>
            <a class="hover:text-primary transition-colors" href="<?php echo esc_url( home_url( '/sitemap.xml' ) ); ?>"><?php esc_html_e( 'Sitemap', 'himalayanmart' ); ?></a>
        </div>
    </div>

</div>
</footer>
