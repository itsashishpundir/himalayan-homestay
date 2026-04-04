<?php
/**
 * Custom Customizer Repeater Control — Mega Menu Extra Items
 *
 * @package HimalayanMart
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'HM_Mega_Menu_Repeater_Control' ) ) :

class HM_Mega_Menu_Repeater_Control extends WP_Customize_Control {

    /** Control type identifier used by JS. */
    public $type = 'hm_mega_repeater';

    /** Enqueue the media library + our repeater script. */
    public function enqueue() {
        wp_enqueue_media();
        wp_enqueue_script(
            'hm-mega-repeater',
            get_template_directory_uri() . '/assets/js/customizer-mega-menu.js',
            array( 'jquery', 'customize-controls', 'jquery-ui-sortable' ),
            time(),
            true
        );
    }

    /** Render the control HTML. The hidden input carries the JSON value. */
    public function render_content() {
        ?>
        <label>
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif; ?>
            <?php if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
            <?php endif; ?>
        </label>

        <div class="hm-mega-repeater-wrap" data-setting="<?php echo esc_attr( $this->id ); ?>">
            <div class="hm-mega-repeater-items"></div>
            <button type="button" class="button hm-mega-add-item" style="margin-top:10px;width:100%;">
                ＋ Add Menu Item
            </button>
        </div>

        <!-- Hidden input that WP Customizer reads as the setting value -->
        <input type="hidden" <?php $this->link(); ?> class="hm-mega-repeater-value" />
        <?php
    }
}

endif;
