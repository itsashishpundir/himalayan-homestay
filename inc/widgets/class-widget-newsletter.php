<?php
/**
 * HimalayanMart Newsletter Widget
 *
 * Email subscription form widget.
 *
 * @package HimalayanMart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class HM_Widget_Newsletter extends WP_Widget {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'hm_newsletter_widget',
            __( 'HM: Newsletter Signup', 'himalayanmart' ),
            array(
                'description' => __( 'Email subscription form for newsletter signups.', 'himalayanmart' ),
                'classname'   => 'hm-widget-newsletter-container',
            )
        );
    }

    /**
     * Frontend display
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        $title       = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $description = ! empty( $instance['description'] ) ? $instance['description'] : '';
        $button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : __( 'Subscribe', 'himalayanmart' );
        $form_action = ! empty( $instance['form_action'] ) ? $instance['form_action'] : '';
        $placeholder = ! empty( $instance['placeholder'] ) ? $instance['placeholder'] : __( 'Enter your email', 'himalayanmart' );
        $layout      = ! empty( $instance['layout'] ) ? $instance['layout'] : 'stacked';
        $skin        = ! empty( $instance['skin'] ) ? $instance['skin'] : 'minimal';

        // Widget classes
        $widget_class = 'hm-widget hm-widget-newsletter';
        $widget_class .= ' hm-layout-' . esc_attr( $layout );
        $widget_class .= ' hm-skin-' . esc_attr( $skin );

        // Title
        if ( $title ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }
        ?>
        <div class="<?php echo esc_attr( $widget_class ); ?>">
            <?php if ( $description ) : ?>
                <p class="hm-newsletter-description"><?php echo esc_html( $description ); ?></p>
            <?php endif; ?>

            <form class="hm-newsletter-form" action="<?php echo esc_url( $form_action ); ?>" method="POST" target="_blank">
                <div class="hm-newsletter-fields">
                    <div class="hm-newsletter-input-wrap">
                        <?php echo hm_get_widget_icon( 'email', 18 ); ?>
                        <input type="email" name="EMAIL" class="hm-newsletter-input" placeholder="<?php echo esc_attr( $placeholder ); ?>" required>
                    </div>
                    <button type="submit" class="hm-newsletter-button">
                        <?php echo hm_get_widget_icon( 'send', 16 ); ?>
                        <span><?php echo esc_html( $button_text ); ?></span>
                    </button>
                </div>
            </form>

            <p class="hm-newsletter-privacy">
                <small><?php esc_html_e( 'We respect your privacy. Unsubscribe anytime.', 'himalayanmart' ); ?></small>
            </p>
        </div>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Admin form
     */
    public function form( $instance ) {
        $title       = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Newsletter', 'himalayanmart' );
        $description = ! empty( $instance['description'] ) ? $instance['description'] : __( 'Subscribe to get the latest updates.', 'himalayanmart' );
        $button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : __( 'Subscribe', 'himalayanmart' );
        $form_action = ! empty( $instance['form_action'] ) ? $instance['form_action'] : '';
        $placeholder = ! empty( $instance['placeholder'] ) ? $instance['placeholder'] : __( 'Enter your email', 'himalayanmart' );
        $layout      = ! empty( $instance['layout'] ) ? $instance['layout'] : 'stacked';
        $skin        = ! empty( $instance['skin'] ) ? $instance['skin'] : 'minimal';
        ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'himalayanmart' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Description:', 'himalayanmart' ); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" rows="2"><?php echo esc_textarea( $description ); ?></textarea>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'form_action' ) ); ?>"><?php esc_html_e( 'Form Action URL:', 'himalayanmart' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'form_action' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'form_action' ) ); ?>" type="url" value="<?php echo esc_attr( $form_action ); ?>" placeholder="<?php esc_attr_e( 'Mailchimp or other form URL', 'himalayanmart' ); ?>">
            <small><?php esc_html_e( 'Leave empty for default WordPress handling.', 'himalayanmart' ); ?></small>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'placeholder' ) ); ?>"><?php esc_html_e( 'Input Placeholder:', 'himalayanmart' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'placeholder' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'placeholder' ) ); ?>" type="text" value="<?php echo esc_attr( $placeholder ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"><?php esc_html_e( 'Button Text:', 'himalayanmart' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" type="text" value="<?php echo esc_attr( $button_text ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'skin' ) ); ?>"><?php esc_html_e( 'Skin:', 'himalayanmart' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'skin' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'skin' ) ); ?>">
                <?php foreach ( hm_get_widget_skin_options() as $value => $label ) : ?>
                    <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $skin, $value ); ?>><?php echo esc_html( $label ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php esc_html_e( 'Layout:', 'himalayanmart' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>">
                <option value="stacked" <?php selected( $layout, 'stacked' ); ?>><?php esc_html_e( 'Stacked', 'himalayanmart' ); ?></option>
                <option value="inline" <?php selected( $layout, 'inline' ); ?>><?php esc_html_e( 'Inline', 'himalayanmart' ); ?></option>
            </select>
        </p>
        <?php
    }

    /**
     * Save widget options
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title']       = sanitize_text_field( $new_instance['title'] ?? '' );
        $instance['description'] = sanitize_text_field( $new_instance['description'] ?? '' );
        $instance['button_text'] = sanitize_text_field( $new_instance['button_text'] ?? __( 'Subscribe', 'himalayanmart' ) );
        $instance['form_action'] = esc_url_raw( $new_instance['form_action'] ?? '' );
        $instance['placeholder'] = sanitize_text_field( $new_instance['placeholder'] ?? '' );
        $instance['layout']      = sanitize_text_field( $new_instance['layout'] ?? 'stacked' );
        $instance['skin']        = sanitize_text_field( $new_instance['skin'] ?? 'minimal' );
        return $instance;
    }
}
