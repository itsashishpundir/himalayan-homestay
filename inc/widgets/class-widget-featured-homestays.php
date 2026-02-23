<?php
/**
 * HimalayanMart Featured Homestays Widget
 *
 * Display homestay listings with multiple layout options.
 *
 * @package HimalayanMart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class HM_Widget_Featured_Homestays extends WP_Widget {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'hm_featured_homestays_widget',
            __( 'HM: Featured Homestays', 'himalayanmart' ),
            array(
                'description' => __( 'Display featured homestay listings.', 'himalayanmart' ),
                'classname'   => 'hm-widget-homestays-container',
            )
        );
    }

    /**
     * Frontend display
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        $title   = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $count   = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 3;
        $orderby = ! empty( $instance['orderby'] ) ? $instance['orderby'] : 'date';
        $layout  = ! empty( $instance['layout'] ) ? $instance['layout'] : 'list';
        $skin    = ! empty( $instance['skin'] ) ? $instance['skin'] : 'minimal';

        // Display options
        $show_image    = ! empty( $instance['show_image'] );
        $show_rating   = ! empty( $instance['show_rating'] );
        $show_price    = ! empty( $instance['show_price'] );
        $show_location = ! empty( $instance['show_location'] );

        // Widget classes
        $widget_class = 'hm-widget hm-widget-homestays';
        $widget_class .= ' hm-layout-' . esc_attr( $layout );
        $widget_class .= ' hm-skin-' . esc_attr( $skin );

        // Title
        if ( $title ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }

        // Query
        $query_args = array(
            'post_type'      => 'homestay',
            'posts_per_page' => $count,
            'orderby'        => 'rand' === $orderby ? 'rand' : 'date',
            'order'          => 'DESC',
        );

        if ( 'price_low' === $orderby ) {
            $query_args['meta_key'] = '_homestay_price';
            $query_args['orderby']  = 'meta_value_num';
            $query_args['order']    = 'ASC';
        } elseif ( 'price_high' === $orderby ) {
            $query_args['meta_key'] = '_homestay_price';
            $query_args['orderby']  = 'meta_value_num';
            $query_args['order']    = 'DESC';
        } elseif ( 'rating' === $orderby ) {
            $query_args['meta_key'] = '_homestay_rating';
            $query_args['orderby']  = 'meta_value_num';
            $query_args['order']    = 'DESC';
        }

        $homestays = new WP_Query( $query_args );

        if ( ! $homestays->have_posts() ) {
            echo '<p class="hm-no-items">' . esc_html__( 'No homestays found.', 'himalayanmart' ) . '</p>';
            echo $args['after_widget'];
            return;
        }
        ?>
        <div class="<?php echo esc_attr( $widget_class ); ?>">
            <div class="hm-homestays-list">
                <?php while ( $homestays->have_posts() ) : $homestays->the_post();
                    $price    = get_post_meta( get_the_ID(), '_homestay_price', true );
                    $rating   = get_post_meta( get_the_ID(), '_homestay_rating', true );
                    $city     = get_the_terms( get_the_ID(), 'homestay_city' );
                    $location = $city && ! is_wp_error( $city ) ? $city[0]->name : '';
                ?>
                    <div class="hm-homestay-widget-item">
                        <?php if ( $show_image && has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>" class="hm-item-image">
                                <?php the_post_thumbnail( 'thumbnail' ); ?>
                            </a>
                        <?php endif; ?>

                        <div class="hm-item-content">
                            <h4 class="hm-item-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>

                            <?php if ( $show_location && $location ) : ?>
                                <span class="hm-item-location">
                                    <?php echo hm_get_widget_icon( 'location', 14 ); ?>
                                    <?php echo esc_html( $location ); ?>
                                </span>
                            <?php endif; ?>

                            <div class="hm-item-meta">
                                <?php if ( $show_rating && $rating ) : ?>
                                    <span class="hm-item-rating">
                                        <?php echo hm_get_widget_icon( 'star', 14 ); ?>
                                        <?php echo esc_html( $rating ); ?>
                                    </span>
                                <?php endif; ?>

                                <?php if ( $show_price && $price ) : ?>
                                    <span class="hm-item-price">
                                        <?php echo esc_html( '₹' . number_format( $price ) ); ?>
                                        <small>/night</small>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Admin form
     */
    public function form( $instance ) {
        $title        = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Featured Homestays', 'himalayanmart' );
        $count        = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 3;
        $orderby      = ! empty( $instance['orderby'] ) ? $instance['orderby'] : 'date';
        $layout       = ! empty( $instance['layout'] ) ? $instance['layout'] : 'list';
        $skin         = ! empty( $instance['skin'] ) ? $instance['skin'] : 'minimal';
        $show_image   = isset( $instance['show_image'] ) ? $instance['show_image'] : true;
        $show_rating  = isset( $instance['show_rating'] ) ? $instance['show_rating'] : true;
        $show_price   = isset( $instance['show_price'] ) ? $instance['show_price'] : true;
        $show_location= isset( $instance['show_location'] ) ? $instance['show_location'] : true;
        ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'himalayanmart' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of items:', 'himalayanmart' ); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" min="1" max="10" value="<?php echo esc_attr( $count ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_html_e( 'Order by:', 'himalayanmart' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
                <option value="date" <?php selected( $orderby, 'date' ); ?>><?php esc_html_e( 'Date', 'himalayanmart' ); ?></option>
                <option value="rand" <?php selected( $orderby, 'rand' ); ?>><?php esc_html_e( 'Random', 'himalayanmart' ); ?></option>
                <option value="price_low" <?php selected( $orderby, 'price_low' ); ?>><?php esc_html_e( 'Price: Low to High', 'himalayanmart' ); ?></option>
                <option value="price_high" <?php selected( $orderby, 'price_high' ); ?>><?php esc_html_e( 'Price: High to Low', 'himalayanmart' ); ?></option>
                <option value="rating" <?php selected( $orderby, 'rating' ); ?>><?php esc_html_e( 'Rating', 'himalayanmart' ); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php esc_html_e( 'Layout:', 'himalayanmart' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>">
                <option value="list" <?php selected( $layout, 'list' ); ?>><?php esc_html_e( 'List', 'himalayanmart' ); ?></option>
                <option value="grid" <?php selected( $layout, 'grid' ); ?>><?php esc_html_e( 'Grid', 'himalayanmart' ); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'skin' ) ); ?>"><?php esc_html_e( 'Skin:', 'himalayanmart' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'skin' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'skin' ) ); ?>">
                <?php foreach ( hm_get_widget_skin_options() as $value => $label ) : ?>
                    <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $skin, $value ); ?>><?php echo esc_html( $label ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        <p><strong><?php esc_html_e( 'Display Options:', 'himalayanmart' ); ?></strong></p>

        <p>
            <input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_image' ) ); ?>" <?php checked( $show_image ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_image' ) ); ?>"><?php esc_html_e( 'Show Image', 'himalayanmart' ); ?></label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_rating' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_rating' ) ); ?>" <?php checked( $show_rating ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_rating' ) ); ?>"><?php esc_html_e( 'Show Rating', 'himalayanmart' ); ?></label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_price' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_price' ) ); ?>" <?php checked( $show_price ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_price' ) ); ?>"><?php esc_html_e( 'Show Price', 'himalayanmart' ); ?></label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_location' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_location' ) ); ?>" <?php checked( $show_location ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_location' ) ); ?>"><?php esc_html_e( 'Show Location', 'himalayanmart' ); ?></label>
        </p>
        <?php
    }

    /**
     * Save widget options
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title']         = sanitize_text_field( $new_instance['title'] ?? '' );
        $instance['count']         = absint( $new_instance['count'] ?? 3 );
        $instance['orderby']       = sanitize_text_field( $new_instance['orderby'] ?? 'date' );
        $instance['layout']        = sanitize_text_field( $new_instance['layout'] ?? 'list' );
        $instance['skin']          = sanitize_text_field( $new_instance['skin'] ?? 'minimal' );
        $instance['show_image']    = ! empty( $new_instance['show_image'] );
        $instance['show_rating']   = ! empty( $new_instance['show_rating'] );
        $instance['show_price']    = ! empty( $new_instance['show_price'] );
        $instance['show_location'] = ! empty( $new_instance['show_location'] );
        return $instance;
    }
}
