<?php
/**
 * HimalayanMart Homestay Card Carousel Widget
 *
 * Displays homestay cards in an auto-rotating carousel for the blog sidebar.
 * Card design matches the FuturaStays design system.
 *
 * @package HimalayanMart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class HM_Widget_Homestay_Carousel extends WP_Widget {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'hm_homestay_carousel',
            __( '🏔️ Homestay Card Carousel', 'himalayanmart' ),
            array(
                'description'                 => __( 'Auto-rotating homestay cards for the sidebar.', 'himalayanmart' ),
                'customize_selective_refresh' => true,
            )
        );
    }

    /**
     * Frontend display
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        $title    = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Featured Stays', 'himalayanmart' );
        $count    = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 5;
        $orderby  = ! empty( $instance['orderby'] ) ? $instance['orderby'] : 'date';
        $autoplay = isset( $instance['autoplay'] ) ? (bool) $instance['autoplay'] : true;
        $interval = ! empty( $instance['interval'] ) ? absint( $instance['interval'] ) : 4000;
        $show_cta = isset( $instance['show_cta'] ) ? (bool) $instance['show_cta'] : true;

        if ( $title ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }

        // Query homestays
        $query_args = array(
            'post_type'      => 'hhb_homestay',
            'posts_per_page' => $count,
            'post_status'    => 'publish',
        );

        switch ( $orderby ) {
            case 'rand':
                $query_args['orderby'] = 'rand';
                break;
            case 'price_low':
                $query_args['meta_key'] = 'base_price_per_night';
                $query_args['orderby']  = 'meta_value_num';
                $query_args['order']    = 'ASC';
                break;
            case 'price_high':
                $query_args['meta_key'] = 'base_price_per_night';
                $query_args['orderby']  = 'meta_value_num';
                $query_args['order']    = 'DESC';
                break;
            default:
                $query_args['orderby'] = 'date';
                $query_args['order']   = 'DESC';
        }

        $homestays = new WP_Query( $query_args );

        if ( ! $homestays->have_posts() ) {
            echo '<p class="hm-no-items">' . esc_html__( 'No homestays found.', 'himalayanmart' ) . '</p>';
            echo $args['after_widget'];
            return;
        }

        $uid = 'hm-carousel-' . $this->id;
        ?>
        <div class="hm-carousel-wrap" id="<?php echo esc_attr( $uid ); ?>" data-autoplay="<?php echo $autoplay ? '1' : '0'; ?>" data-interval="<?php echo esc_attr( $interval ); ?>">
            <div class="hm-carousel-track">
                <?php while ( $homestays->have_posts() ) : $homestays->the_post();
                    $price       = get_post_meta( get_the_ID(), 'base_price_per_night', true );
                    $offer_price = get_post_meta( get_the_ID(), 'offer_price_per_night', true );
                    $display_price = $offer_price ? $offer_price : $price;
                    $is_featured = is_sticky();

                    // Location from taxonomy
                    $locations = get_the_terms( get_the_ID(), 'hhb_location' );
                    $types = get_the_terms( get_the_ID(), 'hhb_property_type' );
                ?>
                <div class="hm-carousel-card">
                    <div class="hm-card-img">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); ?>
                            </a>
                        <?php else : ?>
                            <a href="<?php the_permalink(); ?>" style="display:block;width:100%;height:100%;background:#f1f5f9;"></a>
                        <?php endif; ?>
                        
                        <div style="position:absolute;top:12px;left:12px;display:flex;flex-wrap:wrap;gap:8px;pointer-events:none;z-index:20;">
                            <?php if ($types && !is_wp_error($types)) : foreach(array_slice($types, 0, 1) as $term) : ?>
                                <a href="<?php echo esc_url(add_query_arg('type', $term->slug, get_post_type_archive_link('hhb_homestay'))); ?>" style="background:rgba(255,255,255,0.9);backdrop-filter:blur(4px);color:#334155;padding:4px 12px;border-radius:9999px;font-size:10px;font-weight:900;text-transform:uppercase;letter-spacing:0.05em;pointer-events:auto;text-decoration:none;box-shadow:0 1px 2px 0 rgba(0,0,0,0.05);">
                                    <?php echo esc_html($term->name); ?>
                                </a>
                            <?php endforeach; endif; ?>
                        </div>

                        <?php if ( $is_featured ) : ?>
                            <span class="hm-card-badge"><?php esc_html_e( 'Featured', 'himalayanmart' ); ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="hm-card-body">
                        <h4 class="hm-card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>

                        <div class="hm-card-footer">
                            <?php if ( $display_price ) : ?>
                            <div class="hm-card-price">
                                <span class="price-amount">₹<?php echo esc_html( number_format( $display_price ) ); ?></span>
                                <span class="price-unit">/ night</span>
                            </div>
                            <?php endif; ?>
                        </div>

                        <?php if ( $show_cta ) : ?>
                        <a href="<?php the_permalink(); ?>" class="hm-card-cta">
                            <?php esc_html_e( 'Book Now', 'himalayanmart' ); ?>
                            <span class="material-symbols-outlined" style="font-size:18px;vertical-align:middle;margin-left:4px">arrow_forward</span>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>

            <!-- Dots / Indicators -->
            <div class="hm-carousel-dots">
                <?php for ( $i = 0; $i < $homestays->post_count; $i++ ) : ?>
                <button class="hm-dot <?php echo $i === 0 ? 'active' : ''; ?>" data-idx="<?php echo $i; ?>" aria-label="<?php printf( esc_attr__( 'Slide %d', 'himalayanmart' ), $i + 1 ); ?>"></button>
                <?php endfor; ?>
            </div>
        </div>

        <style>
        .hm-carousel-wrap { position: relative; overflow: hidden; border-radius: 1rem; }
        .hm-carousel-track { display: flex; transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1); }
        .hm-carousel-card { min-width: 100%; box-sizing: border-box; }

        .hm-card-img { display: block; position: relative; overflow: hidden; border-radius: 0.75rem 0.75rem 0 0; aspect-ratio: 4/3; }
        .hm-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
        .hm-card-img:hover img { transform: scale(1.05); }
        .hm-card-badge { position: absolute; top: 12px; right: 12px; background: #e85e30; color: #fff; font-size: 0.7rem; font-weight: 700; padding: 4px 12px; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.5px; }

        .hm-card-body { padding: 1.25rem; background: #fff; border-radius: 0 0 0.75rem 0.75rem; border: 1px solid #f0f0f0; border-top: 0; }
        .hm-card-title { margin: 0 0 6px; font-size: 1.1rem; font-weight: 800; line-height: 1.3; }
        .hm-card-title a { color: #1e293b; text-decoration: none; transition: color 0.2s; }
        .hm-card-title a:hover { color: #e85e30; }
        .hm-card-location { margin: 0 0 12px; font-size: 0.82rem; color: #64748b; display: flex; align-items: center; gap: 2px; }

        .hm-card-footer { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
        .hm-card-price .price-amount { font-size: 1.25rem; font-weight: 900; color: #e85e30; }
        .hm-card-price .price-unit { font-size: 0.75rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; }

        .hm-card-cta { display: flex; align-items: center; justify-content: center; gap: 4px; width: 100%; padding: 0.75rem; background: #e85e30; color: #fff; text-decoration: none; font-weight: 800; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; border-radius: 0.5rem; transition: transform 0.2s, box-shadow 0.2s; }
        .hm-card-cta:hover { transform: scale(1.02); box-shadow: 0 6px 20px rgba(232, 94, 48, 0.35); color: #fff; text-decoration: none; }

        .hm-carousel-dots { display: flex; justify-content: center; gap: 6px; padding: 12px 0 4px; }
        .hm-dot { width: 8px; height: 8px; border-radius: 50%; border: none; background: #ddd; cursor: pointer; padding: 0; transition: all 0.3s; }
        .hm-dot.active { background: #e85e30; width: 20px; border-radius: 4px; }
        </style>

        <script>
        (function(){
            var wrap = document.getElementById('<?php echo esc_js( $uid ); ?>');
            if (!wrap) return;
            var track = wrap.querySelector('.hm-carousel-track');
            var cards = wrap.querySelectorAll('.hm-carousel-card');
            var dots  = wrap.querySelectorAll('.hm-dot');
            var total = cards.length;
            var idx   = 0;
            var autoplay = wrap.dataset.autoplay === '1';
            var interval = parseInt(wrap.dataset.interval) || 4000;
            var timer;

            function goTo(i) {
                idx = ((i % total) + total) % total;
                track.style.transform = 'translateX(-' + (idx * 100) + '%)';
                dots.forEach(function(d,j){ d.classList.toggle('active', j === idx); });
            }
            function next(){ goTo(idx + 1); }

            dots.forEach(function(d){
                d.addEventListener('click', function(){
                    goTo(parseInt(d.dataset.idx));
                    stopAuto(); startAuto();
                });
            });

            // Touch / Swipe support
            var startX = 0;
            wrap.addEventListener('touchstart', function(e){ startX = e.touches[0].clientX; stopAuto(); }, {passive:true});
            wrap.addEventListener('touchend', function(e){
                var diff = startX - e.changedTouches[0].clientX;
                if (Math.abs(diff) > 40) { diff > 0 ? goTo(idx+1) : goTo(idx-1); }
                startAuto();
            });

            function startAuto(){ if (autoplay && total > 1) timer = setInterval(next, interval); }
            function stopAuto(){ clearInterval(timer); }

            wrap.addEventListener('mouseenter', stopAuto);
            wrap.addEventListener('mouseleave', startAuto);

            startAuto();
        })();
        </script>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Admin form
     */
    public function form( $instance ) {
        $title    = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Featured Stays', 'himalayanmart' );
        $count    = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 5;
        $orderby  = ! empty( $instance['orderby'] ) ? $instance['orderby'] : 'date';
        $autoplay = isset( $instance['autoplay'] ) ? (bool) $instance['autoplay'] : true;
        $interval = ! empty( $instance['interval'] ) ? absint( $instance['interval'] ) : 4000;
        $show_cta = isset( $instance['show_cta'] ) ? (bool) $instance['show_cta'] : true;
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'himalayanmart' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of cards:', 'himalayanmart' ); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" min="1" max="10" value="<?php echo esc_attr( $count ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_html_e( 'Order by:', 'himalayanmart' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
                <option value="date" <?php selected( $orderby, 'date' ); ?>><?php esc_html_e( 'Latest', 'himalayanmart' ); ?></option>
                <option value="rand" <?php selected( $orderby, 'rand' ); ?>><?php esc_html_e( 'Random', 'himalayanmart' ); ?></option>
                <option value="price_low" <?php selected( $orderby, 'price_low' ); ?>><?php esc_html_e( 'Price: Low to High', 'himalayanmart' ); ?></option>
                <option value="price_high" <?php selected( $orderby, 'price_high' ); ?>><?php esc_html_e( 'Price: High to Low', 'himalayanmart' ); ?></option>
            </select>
        </p>
        <p>
            <input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'autoplay' ) ); ?>" <?php checked( $autoplay ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); ?>"><?php esc_html_e( 'Auto-rotate cards', 'himalayanmart' ); ?></label>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'interval' ) ); ?>"><?php esc_html_e( 'Rotation interval (ms):', 'himalayanmart' ); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'interval' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'interval' ) ); ?>" type="number" min="2000" max="10000" step="500" value="<?php echo esc_attr( $interval ); ?>" style="width:80px">
        </p>
        <p>
            <input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_cta' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_cta' ) ); ?>" <?php checked( $show_cta ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_cta' ) ); ?>"><?php esc_html_e( 'Show "Book Now" button', 'himalayanmart' ); ?></label>
        </p>
        <?php
    }

    /**
     * Save widget options
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title']    = sanitize_text_field( $new_instance['title'] );
        $instance['count']    = absint( $new_instance['count'] );
        $instance['orderby']  = sanitize_text_field( $new_instance['orderby'] );
        $instance['autoplay'] = ! empty( $new_instance['autoplay'] );
        $instance['interval'] = absint( $new_instance['interval'] );
        $instance['show_cta'] = ! empty( $new_instance['show_cta'] );
        return $instance;
    }
}
