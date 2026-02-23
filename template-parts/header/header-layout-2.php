<?php if (!defined('ABSPATH')) exit; ?>
<header class="hm-header hm-header--layout-2">

	<div class="hm-topbar">
		<div class="hm-topbar__inner">
            <?php 
            // Get user settings
            $phone = get_theme_mod('himalayanmart_phone', ''); // Default empty to test check
            $email = get_theme_mod('himalayanmart_email', '');
            $note  = get_theme_mod('himalayanmart_notification_text', 'Welcome to our store! Get 20% off your first order.');
            
            // Check if right side is empty
            $has_contact = !empty($phone) || !empty($email);
            $center_class = $has_contact ? '' : 'hm-justify-center';
            ?>
			<div class="hm-topbar__left <?php echo esc_attr($center_class); ?>" style="<?php echo $has_contact ? '' : 'width: 100%; text-align: center;'; ?>">
				<span class="hm-notification"><?php echo esc_html($note); ?></span>
			</div>
            
            <?php if ( $has_contact ) : ?>
			<div class="hm-topbar__right">
                <?php if ($phone) : ?><span><?php echo esc_html($phone); ?></span><?php endif; ?>
                <?php if ($email) : ?><span><?php echo esc_html($email); ?></span><?php endif; ?>
			</div>
            <?php endif; ?>
		</div>
	</div>

	<div class="hm-header__main">
        <div class="hm-header__left">
            <?php the_custom_logo(); ?>
        </div>
        
        <div class="hm-header__center">
            <nav class="hm-header__nav <?php echo esc_attr('hm-hover-' . get_theme_mod('himalayanmart_menu_hover', 'underline')); ?>" aria-label="<?php esc_attr_e('Primary Menu', 'himalayanmart'); ?>">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'hm-menu hm-menu--primary',
                ));
                ?>
            </nav>
        </div>

        <div class="hm-header__right">
            <div class="hm-header__search <?php echo esc_attr(get_theme_mod('himalayanmart_search_style', 'style-1')); ?>">
                <?php get_search_form(); ?>
            </div>
            <?php get_template_part('template-parts/header/parts/icons'); ?>
        </div>
	</div>
</header>
<?php get_template_part('template-parts/header/parts/offcanvas-menu'); ?>
