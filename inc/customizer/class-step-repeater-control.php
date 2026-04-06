<?php
/**
 * Custom Customizer Repeater Control — Steps/Process
 *
 * @package HimalayanMart
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'HM_Step_Repeater_Control' ) ) :

class HM_Step_Repeater_Control extends WP_Customize_Control {

    public $type = 'hm_step_repeater';

    public function enqueue() {
        wp_enqueue_media();
        wp_enqueue_script(
            'hm-step-repeater',
            get_template_directory_uri() . '/assets/js/customizer-step-repeater.js',
            array( 'jquery', 'customize-controls', 'jquery-ui-sortable' ),
            time(),
            true
        );
    }

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

        <div class="hm-step-repeater-wrap" data-setting="<?php echo esc_attr( $this->id ); ?>">
            <div class="hm-step-repeater-items"></div>
            <button type="button" class="button hm-step-add-item" style="margin-top:10px;width:100%;">
                ＋ Add Process Step
            </button>
        </div>

        <input type="hidden" <?php $this->link(); ?> class="hm-step-repeater-value" />
        <?php
    }
}

endif;
