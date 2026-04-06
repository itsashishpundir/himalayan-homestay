/**
 * Customizer — FAQ Repeater Control
 * Handles add/remove items and serialization for the FAQ list.
 */
/* global wp, jQuery */
(function ( $ ) {
    'use strict';

    // ── Helpers ──────────────────────────────────────────────────────────────

    function escAttr( str ) {
        return String( str )
            .replace( /&/g, '&amp;' )
            .replace( /"/g, '&quot;' )
            .replace( /'/g, '&#39;' )
            .replace( /</g, '&lt;' )
            .replace( />/g, '&gt;' );
    }

    // Serialize all items in the repeater back to the hidden input + WP setting.
    function syncValue( $wrap ) {
        var items = [];
        $wrap.find( '.hm-faq-item' ).each( function () {
            var $item = $( this );
            items.push( {
                q: $item.find( '.hm-faq-q' ).val() || '',
                a: $item.find( '.hm-faq-a' ).val() || '',
                order: parseInt( $item.find( '.hm-faq-order' ).val(), 10 ) || 0
            } );
        } );

        var json       = JSON.stringify( items );
        var $hidden    = $wrap.closest( '.customize-control' ).find( '.hm-faq-repeater-value' );
        var settingId  = $wrap.data( 'setting' );

        $hidden.val( json ).trigger( 'change' );

        if ( wp.customize && wp.customize( settingId ) ) {
            wp.customize( settingId ).set( json );
        }
    }

    // ── Build one repeater row ────────────────────────────────────────────────

    function buildItemRow( item ) {
        var $item = $(
            '<div class="hm-faq-item" style="' +
                'border:1px solid #ddd;padding:10px;margin-bottom:10px;' +
                'border-radius:4px;background:#fafafa;">' +

                // Header row
                '<div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">' +
                    '<span class="hm-faq-drag-handle dashicons dashicons-menu" style="cursor:grab;color:#888;" title="Drag to reorder"></span>' +
                    '<strong style="flex:1;font-size:12px;color:#555;">FAQ Item</strong>' +
                    '<button type="button" class="button-link hm-faq-remove" ' +
                        'style="color:#c0392b;font-size:11px;">✕ Remove</button>' +
                '</div>' +

                // Question
                '<p style="margin:0 0 6px;">' +
                    '<label style="font-size:11px;font-weight:600;display:block;margin-bottom:2px;">Question</label>' +
                    '<input type="text" class="widefat hm-faq-q" ' +
                        'value="' + escAttr( item.q || '' ) + '" ' +
                        'placeholder="e.g. How do I book?" />' +
                '</p>' +

                // Answer
                '<p style="margin:0 0 6px;">' +
                    '<label style="font-size:11px;font-weight:600;display:block;margin-bottom:2px;">Answer</label>' +
                    '<textarea class="widefat hm-faq-a" rows="3" placeholder="Enter answer here...">' + 
                        escAttr( item.a || '' ) + 
                    '</textarea>' +
                '</p>' +

                // Order (hidden or shown, usually you hide the explicit order input, but let's keep it consistent)
                '<input type="hidden" class="hm-faq-order" value="' + escAttr( typeof item.order !== "undefined" ? item.order : 0 ) + '" />' +

            '</div>'
        );

        return $item;
    }

    // ── Initialization & Events ──────────────────────────────────────────────

    wp.customize.controlConstructor.hm_faq_repeater = wp.customize.Control.extend( {
        ready: function () {
            var control = this;
            var $wrap   = control.container.find( '.hm-faq-repeater-wrap' );
            var $items  = $wrap.find( '.hm-faq-repeater-items' );
            var val     = control.setting();

            // 1. Initial Load
            var currentItems = [];
            try {
                currentItems = JSON.parse( val );
            } catch ( e ) {}

            if ( Array.isArray( currentItems ) ) {
                currentItems.sort( function ( a, b ) {
                    return ( a.order || 0 ) - ( b.order || 0 );
                } );
                $.each( currentItems, function ( i, item ) {
                    $items.append( buildItemRow( item ) );
                } );
            }

            // 2. Add Item
            $wrap.on( 'click', '.hm-faq-add-item', function () {
                var order = $items.find( '.hm-faq-item' ).length;
                $items.append( buildItemRow( { order: order } ) );
                syncValue( $wrap );
            } );

            // 3. Remove Item
            $items.on( 'click', '.hm-faq-remove', function () {
                if ( window.confirm( 'Remove this FAQ?' ) ) {
                    $( this ).closest( '.hm-faq-item' ).slideUp( 200, function () {
                        $( this ).remove();
                        syncValue( $wrap );
                    } );
                }
            } );

            // 4. Update on input blur/keyup
            $items.on( 'change keyup', 'input, textarea', function () {
                syncValue( $wrap );
            } );

            // 5. Drag and Drop Sorting
            if ( $.fn.sortable ) {
                $items.sortable( {
                    handle: '.hm-faq-drag-handle',
                    axis: 'y',
                    update: function () {
                        // Recalculate order values
                        $items.find( '.hm-faq-item' ).each( function ( index ) {
                            $( this ).find( '.hm-faq-order' ).val( index );
                        } );
                        syncValue( $wrap );
                    }
                } );
            }
        }
    } );

} )( jQuery );
