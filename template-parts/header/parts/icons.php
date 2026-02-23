<?php if (!defined('ABSPATH')) exit; ?>

<div class="hm-header-icons">
	<a class="hm-icon" href="<?php echo esc_url(wp_login_url()); ?>" aria-label="<?php esc_attr_e('Account', 'himalayanmart'); ?>">👤</a>

	<?php if (class_exists('WooCommerce')) : ?>
		<a class="hm-icon hm-icon--cart" href="<?php echo esc_url(wc_get_cart_url()); ?>" aria-label="<?php esc_attr_e('Cart', 'himalayanmart'); ?>">
			🛒
			<span class="hm-cart-count">
				<?php echo esc_html(WC()->cart ? WC()->cart->get_cart_contents_count() : 0); ?>
			</span>
		</a>
	<?php endif; ?>
</div>
