<?php
/**
 * Footer Layout: Modern Multi-Column Footer
 *
 * A modern footer layout with:
 * - Horizontal tab navigation
 * - Multi-column grid (responsive)
 * - Newsletter subscription form
 * - Social links with hover effects
 * - Copyright bar
 *
 * Layout ID: modern-multicolumn
 *
 * @package HimalayanMart
 */

if (!defined('ABSPATH')) exit;

// Get customizer settings
$show_tabs           = get_theme_mod('hm_modern_footer_show_tabs', true);
$show_newsletter     = get_theme_mod('hm_modern_footer_show_newsletter', true);
$newsletter_title    = get_theme_mod('hm_modern_footer_newsletter_title', 'Subscribe to our Newsletter');
$newsletter_subtitle = get_theme_mod('hm_modern_footer_newsletter_subtitle', 'Get the latest updates, deals and exclusive offers.');
$show_app_badges     = get_theme_mod('hm_modern_footer_show_app_badges', false);
$show_borders        = get_theme_mod('hm_modern_footer_show_borders', false);

// Column content from customizer
$about_heading = get_theme_mod('himalayanmart_footer_about_heading', 'About Us');
$about_text    = get_theme_mod('himalayanmart_footer_about_text', 'Your trusted destination for authentic Himalayan products and homestay experiences.');
$menu1_title   = get_theme_mod('himalayanmart_footer_menu1_title', 'Quick Links');
$menu2_title   = get_theme_mod('himalayanmart_footer_menu2_title', 'Customer Service');
$contact_title = get_theme_mod('himalayanmart_footer_contact_title', 'Contact Us');
$phone         = get_theme_mod('himalayanmart_footer_phone', '');
$email         = get_theme_mod('himalayanmart_footer_email', '');
$address       = get_theme_mod('himalayanmart_footer_address', '');

// Copyright
$copyright = get_theme_mod('himalayanmart_footer_copyright', '© [year] [sitename]. All rights reserved.');
$copyright = str_replace('[year]', date('Y'), $copyright);
$copyright = str_replace('[sitename]', get_bloginfo('name'), $copyright);

// Build footer classes
$footer_classes = array('hm-modern-footer');
if ($show_borders) {
    $footer_classes[] = 'hm-footer-with-borders';
}
?>

<footer class="<?php echo esc_attr(implode(' ', $footer_classes)); ?>">

    <?php if ($show_tabs) : ?>
    <!-- Horizontal Tab Navigation -->
    <div class="hm-footer-tabs">
        <div class="hm-container">
            <nav class="hm-footer-tabs-nav">
                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="hm-footer-tab">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                    <span><?php esc_html_e('Shop', 'himalayanmart'); ?></span>
                </a>
                <a href="<?php echo esc_url(get_post_type_archive_link('homestay')); ?>" class="hm-footer-tab">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span><?php esc_html_e('Homestays', 'himalayanmart'); ?></span>
                </a>
                <a href="<?php echo esc_url(home_url('/about')); ?>" class="hm-footer-tab">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <span><?php esc_html_e('About', 'himalayanmart'); ?></span>
                </a>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="hm-footer-tab">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                    </svg>
                    <span><?php esc_html_e('Contact', 'himalayanmart'); ?></span>
                </a>
                <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="hm-footer-tab">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span><?php esc_html_e('Account', 'himalayanmart'); ?></span>
                </a>
            </nav>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($show_newsletter) : ?>
    <!-- Newsletter Section -->
    <div class="hm-footer-newsletter">
        <div class="hm-container">
            <div class="hm-newsletter-inner">
                <div class="hm-newsletter-content">
                    <h3 class="hm-newsletter-title"><?php echo esc_html($newsletter_title); ?></h3>
                    <p class="hm-newsletter-subtitle"><?php echo esc_html($newsletter_subtitle); ?></p>
                </div>
                <form class="hm-newsletter-form" action="#" method="post">
                    <div class="hm-newsletter-input-wrap">
                        <input type="email" name="newsletter_email" placeholder="<?php esc_attr_e('Enter your email address', 'himalayanmart'); ?>" required>
                        <button type="submit" class="hm-newsletter-btn">
                            <span><?php esc_html_e('Subscribe', 'himalayanmart'); ?></span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Main Footer Content -->
    <div class="hm-footer-main">
        <div class="hm-container">
            <div class="hm-footer-grid">

                <!-- Column 1: About & Logo -->
                <div class="hm-footer-col hm-footer-about">
                    <div class="hm-footer-logo">
                        <?php
                        if (has_custom_logo()) {
                            the_custom_logo();
                        } else {
                            echo '<h2 class="hm-site-title">' . get_bloginfo('name') . '</h2>';
                        }
                        ?>
                    </div>
                    <?php if ($about_text) : ?>
                    <p class="hm-footer-description"><?php echo wp_kses_post($about_text); ?></p>
                    <?php endif; ?>

                    <!-- Social Links -->
                    <div class="hm-footer-socials">
                        <?php
                        $socials = array(
                            'facebook'  => array(
                                'label' => 'Facebook',
                                'icon'  => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>',
                            ),
                            'twitter'   => array(
                                'label' => 'Twitter',
                                'icon'  => '<path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>',
                            ),
                            'instagram' => array(
                                'label' => 'Instagram',
                                'icon'  => '<rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>',
                            ),
                            'youtube'   => array(
                                'label' => 'YouTube',
                                'icon'  => '<path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>',
                            ),
                        );

                        foreach ($socials as $social => $data) {
                            $url = get_theme_mod('himalayanmart_footer_' . $social);
                            if ($url) {
                                echo '<a href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer" class="hm-social-link hm-social-' . esc_attr($social) . '" title="' . esc_attr($data['label']) . '">';
                                echo '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">' . $data['icon'] . '</svg>';
                                echo '</a>';
                            }
                        }
                        ?>
                    </div>
                </div>

                <!-- Column 2: Quick Links Menu -->
                <div class="hm-footer-col hm-footer-links">
                    <h4 class="hm-footer-heading"><?php echo esc_html($menu1_title); ?></h4>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-menu-1',
                        'container'      => false,
                        'menu_class'     => 'hm-footer-menu',
                        'fallback_cb'    => false,
                    ));
                    ?>
                </div>

                <!-- Column 3: Customer Service Menu -->
                <div class="hm-footer-col hm-footer-links">
                    <h4 class="hm-footer-heading"><?php echo esc_html($menu2_title); ?></h4>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-menu-2',
                        'container'      => false,
                        'menu_class'     => 'hm-footer-menu',
                        'fallback_cb'    => false,
                    ));
                    ?>
                </div>

                <!-- Column 4: Contact Info -->
                <div class="hm-footer-col hm-footer-contact">
                    <h4 class="hm-footer-heading"><?php echo esc_html($contact_title); ?></h4>
                    <ul class="hm-contact-list">
                        <?php if ($phone) : ?>
                        <li class="hm-contact-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                        </li>
                        <?php endif; ?>

                        <?php if ($email) : ?>
                        <li class="hm-contact-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                        </li>
                        <?php endif; ?>

                        <?php if ($address) : ?>
                        <li class="hm-contact-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span><?php echo esc_html($address); ?></span>
                        </li>
                        <?php endif; ?>
                    </ul>

                    <?php if ($show_app_badges) : ?>
                    <!-- App Download Badges -->
                    <div class="hm-app-badges">
                        <a href="#" class="hm-app-badge">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/app-store.svg'); ?>" alt="<?php esc_attr_e('Download on App Store', 'himalayanmart'); ?>">
                        </a>
                        <a href="#" class="hm-app-badge">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/google-play.svg'); ?>" alt="<?php esc_attr_e('Get it on Google Play', 'himalayanmart'); ?>">
                        </a>
                    </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

    <!-- Copyright Bar -->
    <div class="hm-footer-bottom">
        <div class="hm-container">
            <div class="hm-footer-bottom-inner">
                <div class="hm-copyright">
                    <?php echo wp_kses_post($copyright); ?>
                </div>
                <div class="hm-payment-methods">
                    <span class="hm-payment-label"><?php esc_html_e('We Accept:', 'himalayanmart'); ?></span>
                    <div class="hm-payment-icons">
                        <svg width="32" height="20" viewBox="0 0 32 20" fill="currentColor" aria-label="Visa"><rect width="32" height="20" rx="2" fill="#1A1F71"/><path d="M13.5 13.5h-1.8l1.1-7h1.8l-1.1 7zm7.4-6.8c-.4-.1-.9-.3-1.6-.3-1.8 0-3 .9-3 2.3 0 1 .9 1.5 1.6 1.9.7.3 1 .6 1 .9 0 .5-.6.7-1.1.7-.7 0-1.2-.1-1.8-.4l-.3-.1-.3 1.7c.5.2 1.3.4 2.2.4 1.9 0 3.1-.9 3.1-2.4 0-.8-.5-1.4-1.5-1.9-.6-.3-1-.5-1-.9 0-.3.3-.6 1-.6.6 0 1 .1 1.3.2l.2.1.2-1.6z" fill="#fff"/></svg>
                        <svg width="32" height="20" viewBox="0 0 32 20" fill="currentColor" aria-label="Mastercard"><rect width="32" height="20" rx="2" fill="#EB001B"/><circle cx="12" cy="10" r="6" fill="#EB001B"/><circle cx="20" cy="10" r="6" fill="#F79E1B"/><path d="M16 5.4a6 6 0 0 0 0 9.2 6 6 0 0 0 0-9.2z" fill="#FF5F00"/></svg>
                        <svg width="32" height="20" viewBox="0 0 32 20" fill="currentColor" aria-label="PayPal"><rect width="32" height="20" rx="2" fill="#003087"/><path d="M11 7h2c1.5 0 2.5.8 2.3 2.2-.2 1.8-1.5 2.8-3 2.8h-.8l-.4 2.5H9.5L11 7zm1.8 3.5c.8 0 1.3-.5 1.4-1.2.1-.6-.3-1-1-1h-.7l-.4 2.2h.7z" fill="#fff"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>
