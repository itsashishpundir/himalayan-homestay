/**
 * Customizer — Mega Menu Repeater Control
 * Handles add/remove items and wp.media image selection for extra mega-menu items.
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
        $wrap.find( '.hm-mega-item' ).each( function () {
            var $item = $( this );
            items.push( {
                name:    $item.find( '.hm-item-name' ).val(),
                link:    $item.find( '.hm-item-link' ).val(),
                order:   parseInt( $item.find( '.hm-item-order' ).val(), 10 ) || 0,
                img_id:  parseInt( $item.find( '.hm-item-img-id' ).val(), 10 ) || 0,
                img_url: $item.find( '.hm-item-img-preview' ).attr( 'src' ) || '',
                hover_desc: $item.find( '.hm-item-hover-desc' ).val() || '',
                hover_img_id: parseInt( $item.find( '.hm-item-hover-img-id' ).val(), 10 ) || 0,
                hover_img_url: $item.find( '.hm-item-hover-img-preview' ).attr( 'src' ) || ''
            } );
        } );

        var json       = JSON.stringify( items );
        var $hidden    = $wrap.closest( '.customize-control' ).find( '.hm-mega-repeater-value' );
        var settingId  = $wrap.data( 'setting' );

        $hidden.val( json ).trigger( 'change' );

        if ( wp.customize && wp.customize( settingId ) ) {
            wp.customize( settingId ).set( json );
        }
    }

    // ── Build one repeater row ────────────────────────────────────────────────

    function buildItemRow( item ) {
        var imgSrc = item.img_url || '';
        var imgId  = item.img_id  || 0;
        var hoverImgSrc = item.hover_img_url || '';
        var hoverImgId  = item.hover_img_id  || 0;

        var $item = $(
            '<div class="hm-mega-item" style="' +
                'border:1px solid #ddd;padding:10px;margin-bottom:10px;' +
                'border-radius:4px;background:#fafafa;">' +

                // Header row
                '<div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">' +
                    '<span class="hm-mega-drag-handle dashicons dashicons-menu" style="cursor:grab;color:#888;" title="Drag to reorder"></span>' +
                    '<strong style="flex:1;font-size:12px;color:#555;">Menu Item</strong>' +
                    '<button type="button" class="button-link hm-mega-remove" ' +
                        'style="color:#c0392b;font-size:11px;">✕ Remove</button>' +
                '</div>' +

                // Name
                '<p style="margin:0 0 6px;">' +
                    '<label style="font-size:11px;font-weight:600;display:block;margin-bottom:2px;">Display Name</label>' +
                    '<input type="text" class="widefat hm-item-name" ' +
                        'value="' + escAttr( item.name || '' ) + '" ' +
                        'placeholder="e.g. Cottages" />' +
                '</p>' +

                // Link
                '<p style="margin:0 0 6px;">' +
                    '<label style="font-size:11px;font-weight:600;display:block;margin-bottom:2px;">Link URL</label>' +
                    '<input type="url" class="widefat hm-item-link" ' +
                        'value="' + escAttr( item.link || '' ) + '" ' +
                        'placeholder="https://" />' +
                '</p>' +

                // Order
                '<div style="margin:0 0 6px;">' +
                    '<label style="font-size:11px;font-weight:600;display:block;margin-bottom:2px;">Order Index</label>' +
                    '<input type="number" class="widefat hm-item-order" ' +
                        'value="' + escAttr( typeof item.order !== "undefined" ? item.order : 0 ) + '" ' +
                        'placeholder="0" />' +
                '</div>' +

                // Image
                '<p style="margin:0 0 6px;">' +
                    '<label style="font-size:11px;font-weight:600;display:block;margin-bottom:4px;">Icon Image</label>' +
                    '<div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">' +
                        '<img class="hm-item-img-preview" ' +
                            'src="' + escAttr( imgSrc ) + '" ' +
                            'style="width:44px;height:44px;object-fit:cover;border-radius:6px;border:1px solid #ddd;' +
                                ( imgSrc ? '' : 'display:none;' ) + '" />' +
                        '<input type="hidden" class="hm-item-img-id" value="' + escAttr( String( imgId ) ) + '" />' +
                        '<button type="button" class="button hm-item-img-select" style="font-size:11px;">Choose Image</button>' +
                        '<button type="button" class="button-link hm-item-img-remove" ' +
                            'style="color:#666;font-size:11px;' + ( imgId ? '' : 'display:none;' ) + '">Remove</button>' +
                    '</div>' +
                '</p>' +

                // Hover Description
                '<p style="margin:0 0 6px; border-top:1px dashed #ccc; padding-top:6px;">' +
                    '<label style="font-size:11px;font-weight:600;display:block;margin-bottom:2px;">Hover Preview Description</label>' +
                    '<input type="text" class="widefat hm-item-hover-desc" ' +
                        'value="' + escAttr( item.hover_desc || '' ) + '" ' +
                        'placeholder="Short description for preview panel" />' +
                '</p>' +

                // Hover Preview Image
                '<p style="margin:0;">' +
                    '<label style="font-size:11px;font-weight:600;display:block;margin-bottom:4px;">Hover Preview Image</label>' +
                    '<div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">' +
                        '<img class="hm-item-hover-img-preview" ' +
                            'src="' + escAttr( hoverImgSrc ) + '" ' +
                            'style="width:80px;height:44px;object-fit:cover;border-radius:6px;border:1px solid #ddd;' +
                                ( hoverImgSrc ? '' : 'display:none;' ) + '" />' +
                        '<input type="hidden" class="hm-item-hover-img-id" value="' + escAttr( String( hoverImgId ) ) + '" />' +
                        '<button type="button" class="button hm-item-hover-img-select" style="font-size:11px;">Choose Hover Image</button>' +
                        '<button type="button" class="button-link hm-item-hover-img-remove" ' +
                            'style="color:#666;font-size:11px;' + ( hoverImgId ? '' : 'display:none;' ) + '">Remove</button>' +
                    '</div>' +
                '</p>' +

            '</div>'
        );

        // ── Event: remove row ────────────────────────────────────────────────
        $item.find( '.hm-mega-remove' ).on( 'click', function () {
            var $wrap = $item.closest( '.hm-mega-repeater-wrap' );
            $item.remove();
            syncValue( $wrap );
        } );

        // ── Event: choose image (wp.media) ───────────────────────────────────
        $item.find( '.hm-item-img-select' ).on( 'click', function () {
            var frame = wp.media( {
                title:    'Select Icon Image',
                button:   { text: 'Use this image' },
                multiple: false,
                library:  { type: 'image' }
            } );

            frame.on( 'select', function () {
                var attachment = frame.state().get( 'selection' ).first().toJSON();
                var thumb      = ( attachment.sizes && attachment.sizes.thumbnail )
                    ? attachment.sizes.thumbnail.url
                    : attachment.url;

                $item.find( '.hm-item-img-id' ).val( attachment.id );
                $item.find( '.hm-item-img-preview' ).attr( 'src', thumb ).show();
                $item.find( '.hm-item-img-remove' ).show();
                syncValue( $item.closest( '.hm-mega-repeater-wrap' ) );
            } );

            frame.open();
        } );

        // ── Event: remove image ──────────────────────────────────────────────
        $item.find( '.hm-item-img-remove' ).on( 'click', function () {
            $item.find( '.hm-item-img-id' ).val( 0 );
            $item.find( '.hm-item-img-preview' ).attr( 'src', '' ).hide();
            $( this ).hide();
            syncValue( $item.closest( '.hm-mega-repeater-wrap' ) );
        } );

        // ── Event: choose hover image (wp.media) ─────────────────────────────
        $item.find( '.hm-item-hover-img-select' ).on( 'click', function () {
            var frame = wp.media( {
                title:    'Select Hover Preview Image',
                button:   { text: 'Use this image' },
                multiple: false,
                library:  { type: 'image' }
            } );

            frame.on( 'select', function () {
                var attachment = frame.state().get( 'selection' ).first().toJSON();
                var thumb      = ( attachment.sizes && attachment.sizes.medium_large )
                    ? attachment.sizes.medium_large.url
                    : attachment.url;

                $item.find( '.hm-item-hover-img-id' ).val( attachment.id );
                $item.find( '.hm-item-hover-img-preview' ).attr( 'src', thumb ).show();
                $item.find( '.hm-item-hover-img-remove' ).show();
                syncValue( $item.closest( '.hm-mega-repeater-wrap' ) );
            } );

            frame.open();
        } );

        // ── Event: remove hover image ────────────────────────────────────────
        $item.find( '.hm-item-hover-img-remove' ).on( 'click', function () {
            $item.find( '.hm-item-hover-img-id' ).val( 0 );
            $item.find( '.hm-item-hover-img-preview' ).attr( 'src', '' ).hide();
            $( this ).hide();
            syncValue( $item.closest( '.hm-mega-repeater-wrap' ) );
        } );

        // ── Event: text input ────────────────────────────────────────────────
        $item.find( 'input[type=text], input[type=url], input[type=number]' ).on( 'input', function () {
            syncValue( $item.closest( '.hm-mega-repeater-wrap' ) );
        } );

        return $item;
    }

    // ── Init all repeaters on the page ───────────────────────────────────────

    function initRepeaters() {
        $( '.hm-mega-repeater-wrap' ).each( function () {
            var $wrap  = $( this );
            var $items = $wrap.find( '.hm-mega-repeater-items' );

            // Already initialised?
            if ( $wrap.data( 'hm-init' ) ) return;
            $wrap.data( 'hm-init', true );

            // Read current JSON value from the hidden input
            var $hidden = $wrap.closest( '.customize-control' ).find( '.hm-mega-repeater-value' );
            var stored  = [];
            try { stored = JSON.parse( $hidden.val() || '[]' ); } catch ( e ) {}

            // Render stored items
            $.each( stored, function ( i, item ) {
                $items.append( buildItemRow( item ) );
            } );

            // Init sortable for drag and drop reordering
            if ( $.fn.sortable ) {
                $items.sortable({
                    axis: 'y',
                    handle: '.hm-mega-drag-handle',
                    update: function () {
                        syncValue( $wrap );
                    }
                });
            }

            // Add-item button
            $wrap.find( '.hm-mega-add-item' ).on( 'click', function () {
                $items.append( buildItemRow( { name: '', link: '', img_id: 0, img_url: '', hover_img_id: 0, hover_img_url: '', hover_desc: '' } ) );
                syncValue( $wrap );
            } );
        } );
    }

    // Run after Customizer controls are ready
    $( document ).ready( function () {
        // Controls may render lazily when a section is opened
        $( document ).on( 'click', '.accordion-section-title', function () {
            setTimeout( initRepeaters, 300 );
        } );
        // Also try immediately
        initRepeaters();
    } );

    if ( typeof wp !== 'undefined' && wp.customize ) {
        wp.customize.bind( 'ready', function () {
            initRepeaters();
        } );
    }

}( jQuery ) );
