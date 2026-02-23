<?php
/**
 * HimalayanMart FAQ Accordion Widget
 *
 * A collapsible FAQ accordion with customizable icons, animations, and skins.
 *
 * @package HimalayanMart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class HM_Widget_FAQ extends WP_Widget {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'hm_faq_widget',
            __( 'HM: FAQ Accordion', 'himalayanmart' ),
            array(
                'description' => __( 'Collapsible FAQ accordion with animations and multiple skins.', 'himalayanmart' ),
                'classname'   => 'hm-widget-faq-container',
            )
        );
    }

    /**
     * Frontend display
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        $title         = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $faqs          = ! empty( $instance['faqs'] ) ? $instance['faqs'] : array();
        $icon_type     = ! empty( $instance['icon_type'] ) ? $instance['icon_type'] : 'chevron';
        $icon_position = ! empty( $instance['icon_position'] ) ? $instance['icon_position'] : 'right';
        $animation     = ! empty( $instance['animation'] ) ? $instance['animation'] : 'slide';
        $skin          = ! empty( $instance['skin'] ) ? $instance['skin'] : 'minimal';
        $allow_multi   = ! empty( $instance['allow_multiple'] );
        $first_open    = ! empty( $instance['first_open'] );
        $schema        = ! empty( $instance['schema_markup'] );

        // Widget classes
        $widget_class = 'hm-widget hm-widget-faq';
        $widget_class .= ' hm-skin-' . esc_attr( $skin );
        $widget_class .= ' hm-anim-' . esc_attr( $animation );
        $widget_class .= ' hm-icon-' . esc_attr( $icon_position );

        // Title
        if ( $title ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }

        if ( empty( $faqs ) ) {
            echo $args['after_widget'];
            return;
        }

        // Schema wrapper
        $schema_attr = $schema ? ' itemscope itemtype="https://schema.org/FAQPage"' : '';
        ?>
        <div class="<?php echo esc_attr( $widget_class ); ?>" data-allow-multiple="<?php echo $allow_multi ? 'true' : 'false'; ?>"<?php echo $schema_attr; ?>>
            <div class="hm-faq-list">
                <?php foreach ( $faqs as $index => $faq ) :
                    $is_open = $first_open && $index === 0;
                    $item_class = 'hm-faq-item' . ( $is_open ? ' is-open' : '' );
                    $question_schema = $schema ? ' itemscope itemprop="mainEntity" itemtype="https://schema.org/Question"' : '';
                    $answer_schema = $schema ? ' itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"' : '';
                ?>
                    <div class="<?php echo esc_attr( $item_class ); ?>"<?php echo $question_schema; ?>>
                        <button class="hm-faq-question" aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>">
                            <?php if ( 'left' === $icon_position ) : ?>
                                <span class="hm-faq-icon"><?php echo $this->get_icon( $icon_type, $is_open ); ?></span>
                            <?php endif; ?>
                            <span class="hm-faq-question-text"<?php echo $schema ? ' itemprop="name"' : ''; ?>><?php echo esc_html( $faq['question'] ); ?></span>
                            <?php if ( 'right' === $icon_position ) : ?>
                                <span class="hm-faq-icon"><?php echo $this->get_icon( $icon_type, $is_open ); ?></span>
                            <?php endif; ?>
                        </button>
                        <div class="hm-faq-answer"<?php echo $answer_schema; ?>>
                            <div class="hm-faq-answer-inner"<?php echo $schema ? ' itemprop="text"' : ''; ?>>
                                <?php echo wp_kses_post( wpautop( $faq['answer'] ) ); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Admin form
     */
    public function form( $instance ) {
        $title         = ! empty( $instance['title'] ) ? $instance['title'] : __( 'FAQ', 'himalayanmart' );
        $faqs          = ! empty( $instance['faqs'] ) ? $instance['faqs'] : array();
        $icon_type     = ! empty( $instance['icon_type'] ) ? $instance['icon_type'] : 'chevron';
        $icon_position = ! empty( $instance['icon_position'] ) ? $instance['icon_position'] : 'right';
        $animation     = ! empty( $instance['animation'] ) ? $instance['animation'] : 'slide';
        $skin          = ! empty( $instance['skin'] ) ? $instance['skin'] : 'minimal';
        $allow_multi   = ! empty( $instance['allow_multiple'] );
        $first_open    = ! empty( $instance['first_open'] );
        $schema        = ! empty( $instance['schema_markup'] );
        ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'himalayanmart' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
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
            <label for="<?php echo esc_attr( $this->get_field_id( 'icon_type' ) ); ?>"><?php esc_html_e( 'Icon Type:', 'himalayanmart' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon_type' ) ); ?>">
                <option value="chevron" <?php selected( $icon_type, 'chevron' ); ?>><?php esc_html_e( 'Chevron', 'himalayanmart' ); ?></option>
                <option value="plus-minus" <?php selected( $icon_type, 'plus-minus' ); ?>><?php esc_html_e( 'Plus/Minus', 'himalayanmart' ); ?></option>
                <option value="arrow" <?php selected( $icon_type, 'arrow' ); ?>><?php esc_html_e( 'Arrow', 'himalayanmart' ); ?></option>
                <option value="none" <?php selected( $icon_type, 'none' ); ?>><?php esc_html_e( 'None', 'himalayanmart' ); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'icon_position' ) ); ?>"><?php esc_html_e( 'Icon Position:', 'himalayanmart' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon_position' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon_position' ) ); ?>">
                <option value="right" <?php selected( $icon_position, 'right' ); ?>><?php esc_html_e( 'Right', 'himalayanmart' ); ?></option>
                <option value="left" <?php selected( $icon_position, 'left' ); ?>><?php esc_html_e( 'Left', 'himalayanmart' ); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'animation' ) ); ?>"><?php esc_html_e( 'Animation:', 'himalayanmart' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'animation' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'animation' ) ); ?>">
                <option value="slide" <?php selected( $animation, 'slide' ); ?>><?php esc_html_e( 'Slide', 'himalayanmart' ); ?></option>
                <option value="fade" <?php selected( $animation, 'fade' ); ?>><?php esc_html_e( 'Fade', 'himalayanmart' ); ?></option>
                <option value="none" <?php selected( $animation, 'none' ); ?>><?php esc_html_e( 'None', 'himalayanmart' ); ?></option>
            </select>
        </p>

        <p>
            <input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'allow_multiple' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'allow_multiple' ) ); ?>" <?php checked( $allow_multi ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'allow_multiple' ) ); ?>"><?php esc_html_e( 'Allow multiple items open', 'himalayanmart' ); ?></label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'first_open' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'first_open' ) ); ?>" <?php checked( $first_open ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'first_open' ) ); ?>"><?php esc_html_e( 'Open first item by default', 'himalayanmart' ); ?></label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'schema_markup' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'schema_markup' ) ); ?>" <?php checked( $schema ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'schema_markup' ) ); ?>"><?php esc_html_e( 'Add FAQ Schema (SEO)', 'himalayanmart' ); ?></label>
        </p>

        <hr>
        <p><strong><?php esc_html_e( 'FAQ Items:', 'himalayanmart' ); ?></strong></p>
        <p><small><?php esc_html_e( 'Fill in questions and answers. Empty items will be ignored. Save widget to add more slots.', 'himalayanmart' ); ?></small></p>

        <div class="hm-faq-items-admin" style="max-height: 400px; overflow-y: auto;">
            <?php
            // Show existing FAQs + 5 empty slots for new items
            $filled_count = count( $faqs );
            $total_slots = max( 5, $filled_count + 3 ); // Always show at least 5 slots, or existing + 3 more
            $total_slots = min( $total_slots, 20 ); // Cap at 20

            for ( $i = 0; $i < $total_slots; $i++ ) :
                $faq = isset( $faqs[ $i ] ) ? $faqs[ $i ] : array( 'question' => '', 'answer' => '' );
                $item_num = $i + 1;
            ?>
                <div class="hm-faq-item-admin" style="background: #f9f9f9; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px;">
                    <p style="margin: 0 0 8px; font-weight: 600; color: #666;">
                        <?php printf( esc_html__( 'FAQ #%d', 'himalayanmart' ), $item_num ); ?>
                    </p>
                    <p style="margin: 0 0 8px;">
                        <input class="widefat" type="text" name="<?php echo esc_attr( $this->get_field_name( 'faqs' ) ); ?>[<?php echo $i; ?>][question]" value="<?php echo esc_attr( $faq['question'] ); ?>" placeholder="<?php esc_attr_e( 'Question...', 'himalayanmart' ); ?>">
                    </p>
                    <p style="margin: 0;">
                        <textarea class="widefat" rows="2" name="<?php echo esc_attr( $this->get_field_name( 'faqs' ) ); ?>[<?php echo $i; ?>][answer]" placeholder="<?php esc_attr_e( 'Answer...', 'himalayanmart' ); ?>"><?php echo esc_textarea( $faq['answer'] ); ?></textarea>
                    </p>
                </div>
            <?php endfor; ?>
        </div>
        <?php
    }

    /**
     * Save widget options
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title']          = sanitize_text_field( $new_instance['title'] ?? '' );
        $instance['icon_type']      = sanitize_text_field( $new_instance['icon_type'] ?? 'chevron' );
        $instance['icon_position']  = sanitize_text_field( $new_instance['icon_position'] ?? 'right' );
        $instance['animation']      = sanitize_text_field( $new_instance['animation'] ?? 'slide' );
        $instance['skin']           = sanitize_text_field( $new_instance['skin'] ?? 'minimal' );
        $instance['allow_multiple'] = ! empty( $new_instance['allow_multiple'] );
        $instance['first_open']     = ! empty( $new_instance['first_open'] );
        $instance['schema_markup']  = ! empty( $new_instance['schema_markup'] );

        // Sanitize FAQs - only save items with questions
        $instance['faqs'] = array();
        if ( ! empty( $new_instance['faqs'] ) && is_array( $new_instance['faqs'] ) ) {
            foreach ( $new_instance['faqs'] as $faq ) {
                if ( ! empty( trim( $faq['question'] ?? '' ) ) ) {
                    $instance['faqs'][] = array(
                        'question' => sanitize_text_field( $faq['question'] ),
                        'answer'   => wp_kses_post( $faq['answer'] ?? '' ),
                    );
                }
            }
        }

        return $instance;
    }

    /**
     * Get icon HTML based on type
     */
    private function get_icon( $type, $is_open = false ) {
        if ( 'none' === $type ) {
            return '';
        }

        switch ( $type ) {
            case 'plus-minus':
                return $is_open ? hm_get_widget_icon( 'minus', 18 ) : hm_get_widget_icon( 'plus', 18 );
            case 'arrow':
                return hm_get_widget_icon( 'arrow-right', 18 );
            case 'chevron':
            default:
                return hm_get_widget_icon( 'chevron-down', 18 );
        }
    }
}
