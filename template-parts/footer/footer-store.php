<?php
/**
 * Template part for displaying the Store Footer
 *
 * @package HimalayanMart
 */

if (!defined('ABSPATH')) exit;
?>

<footer class="hm-store-footer">
    <div class="hm-footer-main">
        <div class="hm-container">
            <div class="hm-footer-grid">
                
                <!-- Column 1: Logo & About -->
                <div class="hm-footer-col hm-footer-about">
                    <?php if (get_theme_mod('himalayanmart_footer_show_logo', true)) : ?>
                        <div class="hm-footer-logo">
                            <?php 
                            if (has_custom_logo()) {
                                the_custom_logo();
                            } else {
                                echo '<h2 class="site-title">' . get_bloginfo('name') . '</h2>';
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php 
                    $about_heading = get_theme_mod('himalayanmart_footer_about_heading', 'About Us');
                    $about_text = get_theme_mod('himalayanmart_footer_about_text', 'Your description goes here.');
                    if ($about_heading || $about_text) : 
                    ?>
                        <?php if ($about_heading) : ?>
                            <h3 class="hm-footer-heading"><?php echo esc_html($about_heading); ?></h3>
                        <?php endif; ?>
                        <?php if ($about_text) : ?>
                            <p class="hm-footer-description"><?php echo wp_kses_post($about_text); ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Column 2: Customer Service Menu -->
                <div class="hm-footer-col hm-footer-menu-1">
                    <h3 class="hm-footer-heading"><?php echo esc_html(get_theme_mod('himalayanmart_footer_menu1_title', 'Customer Service')); ?></h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-menu-1',
                        'container'      => false,
                        'menu_class'     => 'hm-footer-menu',
                        'fallback_cb'    => false,
                    ));
                    ?>
                </div>

                <!-- Column 3: Information Menu -->
                <div class="hm-footer-col hm-footer-menu-2">
                    <h3 class="hm-footer-heading"><?php echo esc_html(get_theme_mod('himalayanmart_footer_menu2_title', 'Information')); ?></h3>
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
                    <h3 class="hm-footer-heading"><?php echo esc_html(get_theme_mod('himalayanmart_footer_contact_title', 'Contact Us')); ?></h3>
                    
                    <div class="hm-contact-info">
                        <?php $phone = get_theme_mod('himalayanmart_footer_phone'); ?>
                        <?php if ($phone) : ?>
                            <div class="hm-contact-item">
                                <span class="dashicons dashicons-phone"></span>
                                <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                            </div>
                        <?php endif; ?>

                        <?php $email = get_theme_mod('himalayanmart_footer_email'); ?>
                        <?php if ($email) : ?>
                            <div class="hm-contact-item">
                                <span class="dashicons dashicons-email"></span>
                                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                            </div>
                        <?php endif; ?>

                        <?php $address = get_theme_mod('himalayanmart_footer_address'); ?>
                        <?php if ($address) : ?>
                            <div class="hm-contact-item">
                                <span class="dashicons dashicons-location"></span>
                                <span><?php echo esc_html($address); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Social Media Icons -->
                    <div class="hm-footer-socials">
                        <?php
                        $socials = array(
                            'facebook'  => array('icon' => 'dashicons-facebook', 'label' => 'Facebook'),
                            'twitter'   => array('icon' => 'dashicons-twitter', 'label' => 'Twitter'),
                            'youtube'   => array('icon' => 'dashicons-youtube', 'label' => 'YouTube'),
                            'instagram' => array('icon' => 'dashicons-instagram', 'label' => 'Instagram'),
                        );
                        
                        foreach ($socials as $social => $data) {
                            $url = get_theme_mod('himalayanmart_footer_' . $social);
                            if ($url) {
                                echo '<a href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer" class="hm-social-btn hm-social-' . esc_attr($social) . '" title="' . esc_attr($data['label']) . '">';
                                echo '<span class="dashicons ' . esc_attr($data['icon']) . '"></span>';
                                echo '</a>';
                            }
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Copyright Bar -->
    <div class="hm-footer-bottom">
        <div class="hm-container">
            <div class="hm-copyright">
                <?php 
                $copyright = get_theme_mod('himalayanmart_footer_copyright', '© [year] [sitename]. All rights reserved.');
                $copyright = str_replace('[year]', date('Y'), $copyright);
                $copyright = str_replace('[sitename]', get_bloginfo('name'), $copyright);
                echo wp_kses_post($copyright); 
                ?>
            </div>
        </div>
    </div>
</footer>
