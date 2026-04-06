<?php
/**
 * Custom Customizer Repeater Control — FAQs
 *
 * @package HimalayanMart
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'HM_FAQ_Repeater_Control' ) ) :

class HM_FAQ_Repeater_Control extends WP_Customize_Control {

    /** Control type identifier used by JS. */
    public $type = 'hm_faq_repeater';

    /** Enqueue the our repeater script. */
    public function enqueue() {
        wp_enqueue_script(
            'hm-faq-repeater',
            get_template_directory_uri() . '/assets/js/customizer-faq-repeater.js',
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

        <div class="hm-faq-repeater-wrap" data-setting="<?php echo esc_attr( $this->id ); ?>">
            <div class="hm-faq-repeater-items"></div>
            <button type="button" class="button hm-faq-add-item" style="margin-top:10px;width:100%;">
                ＋ Add FAQ
            </button>
        </div>

        <!-- Hidden input that WP Customizer reads as the setting value -->
        <input type="hidden" <?php $this->link(); ?> class="hm-faq-repeater-value" />
        <?php
    }
}

endif;
