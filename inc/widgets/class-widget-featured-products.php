<?php
/**
 * HimalayanMart Featured Products Widget
 *
 * Displays a list or grid of products: latest, featured, on sale, or best selling.
 *
 * @package HimalayanMart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class HM_Widget_Featured_Products extends WP_Widget {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'hm_featured_products_widget',
            __( 'HM: Featured Products', 'himalayanmart' ),
            array(
                'description' => __( 'Display latest, featured, or on-sale products with multiple layouts.', 'himalayanmart' ),
                'classname'   => 'hm-widget-products-container',
            )
        );
    }

    /**
     * Frontend display
     */
    public function widget( $args, $instance ) {
        if ( ! class_exists( 'WooCommerce' ) ) {
            return;
        }

        echo $args['before_widget'];

        $title      = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $count      = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 5;
        $orderby    = ! empty( $instance['orderby'] ) ? $instance['orderby'] : 'date';
        $filter     = ! empty( $instance['filter'] ) ? $instance['filter'] : 'all';
        $layout     = ! empty( $instance['layout'] ) ? $instance['layout'] : 'list';
        $skin       = ! empty( $instance['skin'] ) ? $instance['skin'] : 'minimal';
        $animation  = ! empty( $instance['animation'] ) ? $instance['animation'] : 'none';
        $show_image = isset( $instance['show_image'] ) ? (bool) $instance['show_image'] : true;
        $show_price = isset( $instance['show_price'] ) ? (bool) $instance['show_price'] : true;
        $show_rating = isset( $instance['show_rating'] ) ? (bool) $instance['show_rating'] : true;

        // Query Args
        $query_args = array(
            'post_type'           => 'product',
            'post_status'         => 'publish',
            'ignore_sticky_posts' => 1,
            'posts_per_page'      => $count,
            'orderby'             => $orderby,
            'order'               => 'DESC',
        );

        if ( 'price' === $orderby ) {
            $query_args['orderby']  = 'meta_value_num';
            $query_args['meta_key'] = '_price';
        } elseif ( 'rand' === $orderby ) {
            $query_args['orderby'] = 'rand';
        }

        // Filters
        switch ( $filter ) {
            case 'featured':
                $query_args['tax_query'][] = array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured',
                    'operator' => 'IN',
                );
                break;
            case 'on_sale':
                $query_args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
                break;
            case 'best_selling':
                $query_args['meta_key'] = 'total_sales';
                $query_args['orderby']  = 'meta_value_num';
                break;
        }

        $products = new WP_Query( $query_args );

        // Widget classes
        $widget_class = 'hm-widget hm-widget-products';
        $widget_class .= ' hm-layout-' . esc_attr( $layout );
        $widget_class .= ' hm-skin-' . esc_attr( $skin );
        $widget_class .= ' hm-anim-' . esc_attr( $animation );

        if ( $title ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }

        if ( $products->have_posts() ) : ?>
            <div class="<?php echo esc_attr( $widget_class ); ?>">
                <div class="hm-products-list">
                    <?php while ( $products->have_posts() ) : $products->the_post();
                        global $product;
                    ?>
                        <div class="hm-product-widget-item">
                            <?php if ( $show_image && has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>" class="hm-item-image">
                                    <?php the_post_thumbnail( 'woocommerce_thumbnail' ); ?>
                                </a>
                            <?php endif; ?>

                            <div class="hm-item-content">
                                <h4 class="hm-item-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h4>

                                <?php if ( $show_rating && get_option( 'woocommerce_enable_review_rating' ) !== 'no' ) : ?>
                                    <div class="hm-item-rating">
                                        <?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ( $show_price ) : ?>
                                    <div class="hm-item-price">
                                        <?php echo $product->get_price_html(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php else : ?>
            <p><?php esc_html_e( 'No products found.', 'himalayanmart' ); ?></p>
        <?php endif;

        wp_reset_postdata();

        echo $args['after_widget'];
    }

    /**
     * Admin form
     */
    public function form( $instance ) {
        $title       = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Featured Products', 'himalayanmart' );
        $count       = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 5;
        $orderby     = ! empty( $instance['orderby'] ) ? $instance['orderby'] : 'date';
        $filter      = ! empty( $instance['filter'] ) ? $instance['filter'] : 'all';
        $layout      = ! empty( $instance['layout'] ) ? $instance['layout'] : 'list';
        $skin        = ! empty( $instance['skin'] ) ? $instance['skin'] : 'minimal';
        $animation   = ! empty( $instance['animation'] ) ? $instance['animation'] : 'none';
        $show_image  = isset( $instance['show_image'] ) ? (bool) $instance['show_image'] : true;
        $show_price  = isset( $instance['show_price'] ) ? (bool) $instance['show_price'] : true;
        $show_rating = isset( $instance['show_rating'] ) ? (bool) $instance['show_rating'] : true;
        ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'himalayanmart' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of Products:', 'himalayanmart' ); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $count ); ?>" size="3">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>"><?php esc_html_e( 'Filter By:', 'himalayanmart' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'filter' ) ); ?>">
                <option value="all" <?php selected( $filter, 'all' ); ?>><?php esc_html_e( 'All Products', 'himalayanmart' ); ?></option>
                <option value="featured" <?php selected( $filter, 'featured' ); ?>><?php esc_html_e( 'Featured Products', 'himalayanmart' ); ?></option>
                <option value="on_sale" <?php selected( $filter, 'on_sale' ); ?>><?php esc_html_e( 'On Sale Products', 'himalayanmart' ); ?></option>
                <option value="best_selling" <?php selected( $filter, 'best_selling' ); ?>><?php esc_html_e( 'Best Selling', 'himalayanmart' ); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_html_e( 'Order By:', 'himalayanmart' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
                <option value="date" <?php selected( $orderby, 'date' ); ?>><?php esc_html_e( 'Date (Newest First)', 'himalayanmart' ); ?></option>
                <option value="price" <?php selected( $orderby, 'price' ); ?>><?php esc_html_e( 'Price', 'himalayanmart' ); ?></option>
                <option value="rand" <?php selected( $orderby, 'rand' ); ?>><?php esc_html_e( 'Random', 'himalayanmart' ); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php esc_html_e( 'Layout:', 'himalayanmart' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>">
                <option value="list" <?php selected( $layout, 'list' ); ?>><?php esc_html_e( 'List (Stacked)', 'himalayanmart' ); ?></option>
                <option value="grid" <?php selected( $layout, 'grid' ); ?>><?php esc_html_e( 'Grid (2 Columns)', 'himalayanmart' ); ?></option>
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

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'animation' ) ); ?>"><?php esc_html_e( 'Animation:', 'himalayanmart' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'animation' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'animation' ) ); ?>">
                <option value="none" <?php selected( $animation, 'none' ); ?>><?php esc_html_e( 'None', 'himalayanmart' ); ?></option>
                <option value="slide" <?php selected( $animation, 'slide' ); ?>><?php esc_html_e( 'Slide', 'himalayanmart' ); ?></option>
                <option value="fade" <?php selected( $animation, 'fade' ); ?>><?php esc_html_e( 'Fade', 'himalayanmart' ); ?></option>
                <option value="bounce" <?php selected( $animation, 'bounce' ); ?>><?php esc_html_e( 'Bounce', 'himalayanmart' ); ?></option>
            </select>
        </p>

        <p>
            <input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_image' ) ); ?>" <?php checked( $show_image ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_image' ) ); ?>"><?php esc_html_e( 'Show Product Image', 'himalayanmart' ); ?></label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_price' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_price' ) ); ?>" <?php checked( $show_price ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_price' ) ); ?>"><?php esc_html_e( 'Show Price', 'himalayanmart' ); ?></label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_rating' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_rating' ) ); ?>" <?php checked( $show_rating ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_rating' ) ); ?>"><?php esc_html_e( 'Show Star Rating', 'himalayanmart' ); ?></label>
        </p>

        <?php
    }

    /**
     * Save widget options
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title']       = sanitize_text_field( $new_instance['title'] ?? '' );
        $instance['count']       = absint( $new_instance['count'] ?? 5 );
        $instance['filter']      = sanitize_text_field( $new_instance['filter'] ?? 'all' );
        $instance['orderby']     = sanitize_text_field( $new_instance['orderby'] ?? 'date' );
        $instance['layout']      = sanitize_text_field( $new_instance['layout'] ?? 'list' );
        $instance['skin']        = sanitize_text_field( $new_instance['skin'] ?? 'minimal' );
        $instance['animation']   = sanitize_text_field( $new_instance['animation'] ?? 'none' );
        $instance['show_image']  = ! empty( $new_instance['show_image'] );
        $instance['show_price']  = ! empty( $new_instance['show_price'] );
        $instance['show_rating'] = ! empty( $new_instance['show_rating'] );

        return $instance;
    }
}
