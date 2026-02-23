<?php
/**
 * HimalayanMart Contact Info Widget
 *
 * Display business contact information with icons.
 *
 * @package HimalayanMart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class HM_Widget_Contact_Info extends WP_Widget {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'hm_contact_info_widget',
            __( 'HM: Contact Info', 'himalayanmart' ),
            array(
                'description' => __( 'Display business contact information with icons.', 'himalayanmart' ),
                'classname'   => 'hm-widget-contact-container',
            )
        );
    }

    /**
     * Frontend display
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        $title      = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $address    = ! empty( $instance['address'] ) ? $instance['address'] : '';
        $phone      = ! empty( $instance['phone'] ) ? $instance['phone'] : '';
        $email      = ! empty( $instance['email'] ) ? $instance['email'] : '';
        $hours      = ! empty( $instance['hours'] ) ? $instance['hours'] : '';
        $show_icons = isset( $instance['show_icons'] ) ? (bool) $instance['show_icons'] : true;
        $layout     = ! empty( $instance['layout'] ) ? $instance['layout'] : 'stacked';
        $skin       = ! empty( $instance['skin'] ) ? $instance['skin'] : 'minimal';
        $icon_color = ! empty( $instance['icon_color'] ) ? $instance['icon_color'] : '#3b82f6';

        // Widget classes
        $widget_class = 'hm-widget hm-widget-contact';
        $widget_class .= ' hm-layout-' . esc_attr( $layout );
        $widget_class .= ' hm-skin-' . esc_attr( $skin );

        // Title
        if ( $title ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }

        // Check if any contact data exists
        if ( ! $address && ! $phone && ! $email && ! $hours ) {
            echo '<p class="hm-no-items">' . esc_html__( 'Please add contact details in widget settings.', 'himalayanmart' ) . '</p>';
            echo $args['after_widget'];
            return;
        }
        ?>
        <div class="<?php echo esc_attr( $widget_class ); ?>" style="--hm-icon-color: <?php echo esc_attr( $icon_color ); ?>">
            <ul class="hm-contact-list">
                <?php if ( $address ) : ?>
                    <li class="hm-contact-item hm-contact-address">
                        <?php if ( $show_icons ) : ?>
                            <span class="hm-contact-icon"><?php echo hm_get_widget_icon( 'location', 20 ); ?></span>
                        <?php endif; ?>
                        <span class="hm-contact-text"><?php echo nl2br( esc_html( $address ) ); ?></span>
                    </li>
                <?php endif; ?>

                <?php if ( $phone ) : ?>
                    <li class="hm-contact-item hm-contact-phone">
                        <?php if ( $show_icons ) : ?>
                            <span class="hm-contact-icon"><?php echo hm_get_widget_icon( 'phone', 20 ); ?></span>
                        <?php endif; ?>
                        <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" class="hm-contact-text">
                            <?php echo esc_html( $phone ); ?>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ( $email ) : ?>
                    <li class="hm-contact-item hm-contact-email">
                        <?php if ( $show_icons ) : ?>
                            <span class="hm-contact-icon"><?php echo hm_get_widget_icon( 'email', 20 ); ?></span>
                        <?php endif; ?>
                        <a href="mailto:<?php echo esc_attr( $email ); ?>" class="hm-contact-text">
                            <?php echo esc_html( $email ); ?>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ( $hours ) : ?>
                    <li class="hm-contact-item hm-contact-hours">
                        <?php if ( $show_icons ) : ?>
                            <span class="hm-contact-icon"><?php echo hm_get_widget_icon( 'clock', 20 ); ?></span>
                        <?php endif; ?>
                        <span class="hm-contact-text"><?php echo esc_html( $hours ); ?></span>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Admin form
     */
    public function form( $instance ) {
        $title      = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Contact Us', 'himalayanmart' );
        $address    = ! empty( $instance['address'] ) ? $instance['address'] : '';
        $phone      = ! empty( $instance['phone'] ) ? $instance['phone'] : '';
        $email      = ! empty( $instance['email'] ) ? $instance['email'] : '';
        $hours      = ! empty( $instance['hours'] ) ? $instance['hours'] : '';
        $show_icons = isset( $instance['show_icons'] ) ? $instance['show_icons'] : true;
        $layout     = ! empty( $instance['layout'] ) ? $instance['layout'] : 'stacked';
        $skin       = ! empty( $instance['skin'] ) ? $instance['skin'] : 'minimal';
        $icon_color = ! empty( $instance['icon_color'] ) ? $instance['icon_color'] : '#3b82f6';
        ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'himalayanmart' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>"><?php esc_html_e( 'Address:', 'himalayanmart' ); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'address' ) ); ?>" rows="3"><?php echo esc_textarea( $address ); ?></textarea>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>"><?php esc_html_e( 'Phone:', 'himalayanmart' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'phone' ) ); ?>" type="text" value="<?php echo esc_attr( $phone ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"><?php esc_html_e( 'Email:', 'himalayanmart' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" type="email" value="<?php echo esc_attr( $email ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'hours' ) ); ?>"><?php esc_html_e( 'Business Hours:', 'himalayanmart' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'hours' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hours' ) ); ?>" type="text" value="<?php echo esc_attr( $hours ); ?>" placeholder="<?php esc_attr_e( 'e.g., Mon-Fri: 9AM - 6PM', 'himalayanmart' ); ?>">
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

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'icon_color' ) ); ?>"><?php esc_html_e( 'Icon Color:', 'himalayanmart' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon_color' ) ); ?>" type="color" value="<?php echo esc_attr( $icon_color ); ?>">
        </p>

        <p>
            <input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_icons' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_icons' ) ); ?>" <?php checked( $show_icons ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_icons' ) ); ?>"><?php esc_html_e( 'Show Icons', 'himalayanmart' ); ?></label>
        </p>
        <?php
    }

    /**
     * Save widget options
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title']      = sanitize_text_field( $new_instance['title'] ?? '' );
        $instance['address']    = sanitize_textarea_field( $new_instance['address'] ?? '' );
        $instance['phone']      = sanitize_text_field( $new_instance['phone'] ?? '' );
        $instance['email']      = sanitize_email( $new_instance['email'] ?? '' );
        $instance['hours']      = sanitize_text_field( $new_instance['hours'] ?? '' );
        $instance['show_icons'] = ! empty( $new_instance['show_icons'] );
        $instance['layout']     = sanitize_text_field( $new_instance['layout'] ?? 'stacked' );
        $instance['skin']       = sanitize_text_field( $new_instance['skin'] ?? 'minimal' );
        $instance['icon_color'] = sanitize_hex_color( $new_instance['icon_color'] ?? '#3b82f6' );
        return $instance;
    }
}
