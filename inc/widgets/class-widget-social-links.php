<?php
/**
 * HimalayanMart Social Links Widget
 *
 * Display social media icons with animations.
 *
 * @package HimalayanMart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class HM_Widget_Social_Links extends WP_Widget {

    /**
     * Available social networks
     */
    private $networks = array(
        'facebook'  => 'Facebook',
        'instagram' => 'Instagram',
        'twitter'   => 'Twitter/X',
        'youtube'   => 'YouTube',
        'linkedin'  => 'LinkedIn',
        'pinterest' => 'Pinterest',
        'tiktok'    => 'TikTok',
        'whatsapp'  => 'WhatsApp',
    );

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'hm_social_links_widget',
            __( 'HM: Social Links', 'himalayanmart' ),
            array(
                'description' => __( 'Display social media links with animated icons.', 'himalayanmart' ),
                'classname'   => 'hm-widget-social-container',
            )
        );
    }

    /**
     * Frontend display
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        $title       = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $icon_style  = ! empty( $instance['icon_style'] ) ? $instance['icon_style'] : 'filled';
        $icon_size   = ! empty( $instance['icon_size'] ) ? $instance['icon_size'] : 'medium';
        $animation   = ! empty( $instance['animation'] ) ? $instance['animation'] : 'none';
        $show_labels = ! empty( $instance['show_labels'] );
        $skin        = ! empty( $instance['skin'] ) ? $instance['skin'] : 'minimal';

        // Icon sizes
        $sizes = array(
            'small'  => 18,
            'medium' => 24,
            'large'  => 32,
        );
        $size = isset( $sizes[ $icon_size ] ) ? $sizes[ $icon_size ] : 24;

        // Widget classes
        $widget_class = 'hm-widget hm-widget-social';
        $widget_class .= ' hm-skin-' . esc_attr( $skin );
        $widget_class .= ' hm-icon-style-' . esc_attr( $icon_style );
        $widget_class .= ' hm-icon-size-' . esc_attr( $icon_size );
        $widget_class .= ' hm-anim-' . esc_attr( $animation );

        // Title
        if ( $title ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }

        // Collect active networks
        $active_networks = array();
        foreach ( $this->networks as $network => $label ) {
            $url = ! empty( $instance[ $network ] ) ? $instance[ $network ] : '';
            if ( $url ) {
                $active_networks[ $network ] = array(
                    'url'   => $url,
                    'label' => $label,
                );
            }
        }

        if ( empty( $active_networks ) ) {
            echo $args['after_widget'];
            return;
        }
        ?>
        <div class="<?php echo esc_attr( $widget_class ); ?>">
            <ul class="hm-social-list">
                <?php foreach ( $active_networks as $network => $data ) :
                    // Handle WhatsApp differently
                    $url = $data['url'];
                    if ( 'whatsapp' === $network && ! filter_var( $url, FILTER_VALIDATE_URL ) ) {
                        $url = 'https://wa.me/' . preg_replace( '/[^0-9]/', '', $url );
                    }
                ?>
                    <li class="hm-social-item hm-social-<?php echo esc_attr( $network ); ?>">
                        <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" title="<?php echo esc_attr( $data['label'] ); ?>">
                            <span class="hm-social-icon"><?php echo hm_get_widget_icon( $network, $size ); ?></span>
                            <?php if ( $show_labels ) : ?>
                                <span class="hm-social-label"><?php echo esc_html( $data['label'] ); ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Admin form
     */
    public function form( $instance ) {
        $title       = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Follow Us', 'himalayanmart' );
        $icon_style  = ! empty( $instance['icon_style'] ) ? $instance['icon_style'] : 'filled';
        $icon_size   = ! empty( $instance['icon_size'] ) ? $instance['icon_size'] : 'medium';
        $animation   = ! empty( $instance['animation'] ) ? $instance['animation'] : 'none';
        $show_labels = ! empty( $instance['show_labels'] );
        $skin        = ! empty( $instance['skin'] ) ? $instance['skin'] : 'minimal';
        ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'himalayanmart' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>

        <p><strong><?php esc_html_e( 'Social Network URLs:', 'himalayanmart' ); ?></strong></p>

        <?php foreach ( $this->networks as $network => $label ) :
            $url = ! empty( $instance[ $network ] ) ? $instance[ $network ] : '';
            $placeholder = 'whatsapp' === $network ? __( 'Phone number (e.g., 919876543210)', 'himalayanmart' ) : sprintf( __( '%s URL', 'himalayanmart' ), $label );
        ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( $network ) ); ?>"><?php echo esc_html( $label ); ?>:</label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $network ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $network ) ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>">
            </p>
        <?php endforeach; ?>

        <hr>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'skin' ) ); ?>"><?php esc_html_e( 'Skin:', 'himalayanmart' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'skin' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'skin' ) ); ?>">
                <?php foreach ( hm_get_widget_skin_options() as $value => $label ) : ?>
                    <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $skin, $value ); ?>><?php echo esc_html( $label ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'icon_style' ) ); ?>"><?php esc_html_e( 'Icon Style:', 'himalayanmart' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon_style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon_style' ) ); ?>">
                <option value="filled" <?php selected( $icon_style, 'filled' ); ?>><?php esc_html_e( 'Filled', 'himalayanmart' ); ?></option>
                <option value="outlined" <?php selected( $icon_style, 'outlined' ); ?>><?php esc_html_e( 'Outlined', 'himalayanmart' ); ?></option>
                <option value="circular" <?php selected( $icon_style, 'circular' ); ?>><?php esc_html_e( 'Circular', 'himalayanmart' ); ?></option>
                <option value="square" <?php selected( $icon_style, 'square' ); ?>><?php esc_html_e( 'Square', 'himalayanmart' ); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'icon_size' ) ); ?>"><?php esc_html_e( 'Icon Size:', 'himalayanmart' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon_size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon_size' ) ); ?>">
                <option value="small" <?php selected( $icon_size, 'small' ); ?>><?php esc_html_e( 'Small', 'himalayanmart' ); ?></option>
                <option value="medium" <?php selected( $icon_size, 'medium' ); ?>><?php esc_html_e( 'Medium', 'himalayanmart' ); ?></option>
                <option value="large" <?php selected( $icon_size, 'large' ); ?>><?php esc_html_e( 'Large', 'himalayanmart' ); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'animation' ) ); ?>"><?php esc_html_e( 'Hover Animation:', 'himalayanmart' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'animation' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'animation' ) ); ?>">
                <?php foreach ( hm_get_widget_animation_options() as $value => $label ) : ?>
                    <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $animation, $value ); ?>><?php echo esc_html( $label ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_labels' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_labels' ) ); ?>" <?php checked( $show_labels ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_labels' ) ); ?>"><?php esc_html_e( 'Show Labels', 'himalayanmart' ); ?></label>
        </p>
        <?php
    }

    /**
     * Save widget options
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title']       = sanitize_text_field( $new_instance['title'] ?? '' );
        $instance['icon_style']  = sanitize_text_field( $new_instance['icon_style'] ?? 'filled' );
        $instance['icon_size']   = sanitize_text_field( $new_instance['icon_size'] ?? 'medium' );
        $instance['animation']   = sanitize_text_field( $new_instance['animation'] ?? 'none' );
        $instance['show_labels'] = ! empty( $new_instance['show_labels'] );
        $instance['skin']        = sanitize_text_field( $new_instance['skin'] ?? 'minimal' );

        // Save network URLs
        foreach ( $this->networks as $network => $label ) {
            $url = $new_instance[ $network ] ?? '';
            if ( 'whatsapp' === $network ) {
                $instance[ $network ] = sanitize_text_field( $url );
            } else {
                $instance[ $network ] = esc_url_raw( $url );
            }
        }

        return $instance;
    }
}
