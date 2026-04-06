/**
 * Customizer — Step Repeater Control
 * Handles add/remove items and serialization for the "How It Works" steps.
 */
/* global wp, jQuery */
(function ( $ ) {
    'use strict';

    function escAttr( str ) {
        return String( str )
            .replace( /&/g, '&amp;' )
            .replace( /"/g, '&quot;' )
            .replace( /'/g, '&#39;' )
            .replace( /</g, '&lt;' )
            .replace( />/g, '&gt;' );
    }

    function syncValue( $wrap ) {
        var items = [];
        $wrap.find( '.hm-step-item' ).each( function () {
            var $item = $( this );
            items.push( {
                title: $item.find( '.hm-step-title' ).val() || '',
                desc:  $item.find( '.hm-step-desc' ).val() || '',
                img_id:  parseInt($item.find('.hm-step-img-id').val(), 10) || 0,
                img_url: $item.find('.hm-step-img-preview').attr('src') || '',
                order: parseInt( $item.find( '.hm-step-order' ).val(), 10 ) || 0
            } );
        } );

        var json       = JSON.stringify( items );
        var $hidden    = $wrap.closest( '.customize-control' ).find( '.hm-step-repeater-value' );
        var settingId  = $wrap.data( 'setting' );

        $hidden.val( json ).trigger( 'change' );

        if ( wp.customize && wp.customize( settingId ) ) {
            wp.customize( settingId ).set( json );
        }
    }

    function buildItemRow( item ) {
        var imgSrc = item.img_url || '';
        var imgId  = item.img_id  || 0;

        var $item = $(
            '<div class="hm-step-item" style="' +
                'border:1px solid #ddd;padding:10px;margin-bottom:10px;' +
                'border-radius:4px;background:#fafafa;">' +

                '<div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">' +
                    '<span class="hm-step-drag-handle dashicons dashicons-menu" style="cursor:grab;color:#888;" title="Drag to reorder"></span>' +
                    '<strong style="flex:1;font-size:12px;color:#555;">Process Step</strong>' +
                    '<button type="button" class="button-link hm-step-remove" ' +
                        'style="color:#c0392b;font-size:11px;">✕ Remove</button>' +
                '</div>' +

                // Image Selection
                '<div style="margin:0 0 10px;">' +
                    '<label style="font-size:11px;font-weight:600;display:block;margin-bottom:4px;">Step Illustration/Image</label>' +
                    '<div style="display:flex;align-items:center;gap:8px;">' +
                        '<img class="hm-step-img-preview" ' +
                            'src="' + escAttr( imgSrc ) + '" ' +
                            'style="width:60px;height:60px;object-fit:cover;border-radius:4px;border:1px solid #ddd;' +
                                ( imgSrc ? '' : 'display:none;' ) + '" />' +
                        '<div style="flex:1;">' +
                            '<button type="button" class="button button-small hm-step-select-img">' +
                                ( imgSrc ? 'Change Image' : 'Select Image' ) +
                            '</button>' +
                            '<input type="hidden" class="hm-step-img-id" value="' + escAttr( imgId ) + '" />' +
                        '</div>' +
                    '</div>' +
                '</div>' +

                // Title
                '<p style="margin:0 0 6px;">' +
                    '<label style="font-size:11px;font-weight:600;display:block;margin-bottom:2px;">Step Title</label>' +
                    '<input type="text" class="widefat hm-step-title" ' +
                        'value="' + escAttr( item.title || '' ) + '" ' +
                        'placeholder="e.g. 1. Search for Stays" />' +
                '</p>' +

                // Description
                '<p style="margin:0 0 6px;">' +
                    '<label style="font-size:11px;font-weight:600;display:block;margin-bottom:2px;">Description</label>' +
                    '<textarea class="widefat hm-step-desc" rows="3" placeholder="Explain this step...">' + 
                        escAttr( item.desc || '' ) + 
                    '</textarea>' +
                '</p>' +

                '<input type="hidden" class="hm-step-order" value="' + escAttr( typeof item.order !== "undefined" ? item.order : 0 ) + '" />' +
            '</div>'
        );

        return $item;
    }

    wp.customize.controlConstructor.hm_step_repeater = wp.customize.Control.extend( {
        ready: function () {
            var control = this;
            var $wrap   = control.container.find( '.hm-step-repeater-wrap' );
            var $items  = $wrap.find( '.hm-step-repeater-items' );
            var val     = control.setting();

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

            $wrap.on( 'click', '.hm-step-add-item', function () {
                var order = $items.find( '.hm-step-item' ).length;
                $items.append( buildItemRow( { order: order } ) );
                syncValue( $wrap );
            } );

            $items.on( 'click', '.hm-step-remove', function () {
                if ( window.confirm( 'Remove this step?' ) ) {
                    $( this ).closest( '.hm-step-item' ).remove();
                    syncValue( $wrap );
                }
            } );

            // Image selection logic
            $items.on( 'click', '.hm-step-select-img', function ( e ) {
                e.preventDefault();
                var $btn = $( this );
                var frame = wp.media( {
                    title: 'Select Step Image',
                    multiple: false,
                    library: { type: 'image' }
                } );
                frame.on( 'select', function () {
                    var attachment = frame.state().get( 'selection' ).first().toJSON();
                    $btn.closest('.hm-step-item').find( '.hm-step-img-preview' ).attr( 'src', attachment.url ).show();
                    $btn.closest('.hm-step-item').find( '.hm-step-img-id' ).val( attachment.id );
                    $btn.text( 'Change Image' );
                    syncValue( $wrap );
                } );
                frame.open();
            } );

            $items.on( 'change keyup', 'input, textarea', function () {
                syncValue( $wrap );
            } );

            if ( $.fn.sortable ) {
                $items.sortable( {
                    handle: '.hm-step-drag-handle',
                    axis: 'y',
                    update: function () {
                        $items.find( '.hm-step-item' ).each( function ( index ) {
                            $( this ).find( '.hm-step-order' ).val( index );
                        } );
                        syncValue( $wrap );
                    }
                } );
            }
        }
    } );

} )( jQuery );
