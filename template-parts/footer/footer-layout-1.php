<?php if (!defined('ABSPATH')) exit; ?>
<footer class="hm-footer hm-footer--layout-1">
	<div class="hm-footer__widgets">
		<div class="hm-footer__grid">
			<?php if (is_active_sidebar('footer-1')) dynamic_sidebar('footer-1'); ?>
			<?php if (is_active_sidebar('footer-2')) dynamic_sidebar('footer-2'); ?>
			<?php if (is_active_sidebar('footer-3')) dynamic_sidebar('footer-3'); ?>
			<?php if (is_active_sidebar('footer-4')) dynamic_sidebar('footer-4'); ?>
		</div>
	</div>

	<div class="hm-footer__bottom">
		<p><?php echo wp_kses_post(get_theme_mod('himalayanmart_copyright_text', '&copy; ' . date('Y') . ' ' . get_bloginfo('name'))); ?></p>
	</div>
</footer>
