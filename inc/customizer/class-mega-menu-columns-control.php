<?php
/**
 * Custom Customizer Control — 3-Column Mega Menu Links (Tabbed, Icon + Color)
 *
 * Each link row now supports:
 *   - Label text
 *   - URL
 *   - Material Symbols icon (with live preview)
 *   - Per-link icon color
 *
 * Stored as JSON: { col1:[{name,link,icon,color},...], col2:[...], col3:[...] }
 *
 * @package HimalayanMart
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'HM_Mega_Columns_Control' ) ) :

class HM_Mega_Columns_Control extends WP_Customize_Control {

    public $type = 'hm_mega_columns';

    public function enqueue() {
        // Material Symbols in the customizer for icon previews
        wp_enqueue_style(
            'material-symbols-customizer',
            'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0',
            array(),
            null
        );
        wp_enqueue_script(
            'hm-mega-columns',
            get_template_directory_uri() . '/assets/js/customizer-mega-columns.js',
            array( 'jquery', 'customize-controls', 'jquery-ui-sortable' ),
            filemtime( get_template_directory() . '/assets/js/customizer-mega-columns.js' ),
            true
        );
        wp_enqueue_style(
            'hm-mega-columns-css',
            get_template_directory_uri() . '/assets/css/customizer-mega-columns.css',
            array(),
            filemtime( get_template_directory() . '/assets/css/customizer-mega-columns.css' )
        );
    }

    public function render_content() {
        ?>
        <label>
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif; ?>
            <?php if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
            <?php endif; ?>
        </label>

        <div class="hm-mega-columns-wrap" data-setting="<?php echo esc_attr( $this->id ); ?>">

            <!-- Tab buttons -->
            <div class="hm-mega-tab-bar" role="tablist">
                <?php for ( $c = 1; $c <= 3; $c++ ) : ?>
                <button type="button"
                        class="hm-mega-tab-btn<?php echo $c === 1 ? ' is-active' : ''; ?>"
                        data-tab="col<?php echo $c; ?>"
                        role="tab"
                        aria-selected="<?php echo $c === 1 ? 'true' : 'false'; ?>">
                    Col <?php echo $c; ?>
                    <span class="hm-tab-count" data-col="<?php echo $c; ?>">0</span>
                </button>
                <?php endfor; ?>
            </div>

            <!-- Tab panels -->
            <?php for ( $c = 1; $c <= 3; $c++ ) : ?>
            <div class="hm-mega-col-panel<?php echo $c === 1 ? ' is-active' : ''; ?>"
                 data-col="<?php echo $c; ?>"
                 role="tabpanel">

                <ul class="hm-mega-col-items"></ul>

                <button type="button" class="button button-secondary hm-mega-col-add" data-col="<?php echo $c; ?>">
                    + Add Link
                </button>
            </div>
            <?php endfor; ?>

        </div>

        <input type="hidden" <?php $this->link(); ?> class="hm-mega-columns-value" />
        <?php
    }
}

endif;
