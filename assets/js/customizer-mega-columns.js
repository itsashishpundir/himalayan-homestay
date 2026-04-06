/**
 * Customizer: 3-Column Mega Menu Control (Tabbed + Icon + Color)
 * Stores: { col1:[{name,link,icon,color},...], col2:[...], col3:[...] }
 */
(function ($) {
    'use strict';

    /* ── Icon library ─────────────────────────────────────────────── */
    var ICON_GROUPS = [
        { label: '— No Icon —', icons: [{ v: '', l: 'None' }] },
        { label: 'Accommodation', icons: [
            { v: 'home',           l: 'Home' },
            { v: 'cottage',        l: 'Cottage' },
            { v: 'cabin',          l: 'Cabin' },
            { v: 'villa',          l: 'Villa' },
            { v: 'apartment',      l: 'Apartment' },
            { v: 'house',          l: 'House' },
            { v: 'home_mini',      l: 'Mini Home' },
            { v: 'domain',         l: 'Building' },
            { v: 'hotel',          l: 'Hotel' },
            { v: 'bed',            l: 'Bed' },
        ]},
        { label: 'Nature', icons: [
            { v: 'landscape',      l: 'Landscape' },
            { v: 'beach_access',   l: 'Beach' },
            { v: 'eco',            l: 'Eco' },
            { v: 'forest',         l: 'Forest' },
            { v: 'water',          l: 'Water' },
            { v: 'park',           l: 'Park' },
            { v: 'terrain',        l: 'Mountain' },
            { v: 'grass',          l: 'Grass' },
            { v: 'wb_sunny',       l: 'Sunny' },
            { v: 'storm',          l: 'Storm' },
        ]},
        { label: 'Travel', icons: [
            { v: 'travel_explore', l: 'Explore Globe' },
            { v: 'explore',        l: 'Compass' },
            { v: 'map',            l: 'Map' },
            { v: 'location_on',    l: 'Location Pin' },
            { v: 'near_me',        l: 'Near Me' },
            { v: 'flight',         l: 'Flight' },
            { v: 'train',          l: 'Train' },
            { v: 'directions_car', l: 'Car' },
            { v: 'hiking',         l: 'Hiking' },
            { v: 'backpack',       l: 'Backpack' },
        ]},
        { label: 'Amenities', icons: [
            { v: 'restaurant',     l: 'Restaurant' },
            { v: 'local_cafe',     l: 'Café' },
            { v: 'spa',            l: 'Spa' },
            { v: 'pool',           l: 'Pool' },
            { v: 'fitness_center', l: 'Fitness' },
            { v: 'wifi',           l: 'WiFi' },
            { v: 'outdoor_grill',  l: 'Outdoor Grill' },
            { v: 'fireplace',      l: 'Fireplace' },
            { v: 'hot_tub',        l: 'Hot Tub' },
            { v: 'balcony',        l: 'Balcony' },
        ]},
        { label: 'People & Quality', icons: [
            { v: 'family_restroom',l: 'Family' },
            { v: 'group',          l: 'Group' },
            { v: 'person',         l: 'Person' },
            { v: 'pets',           l: 'Pets' },
            { v: 'star',           l: 'Star' },
            { v: 'verified',       l: 'Verified' },
            { v: 'thumb_up',       l: 'Thumb Up' },
            { v: 'favorite',       l: 'Heart' },
            { v: 'emoji_events',   l: 'Award' },
            { v: 'workspace_premium', l: 'Premium' },
        ]},
    ];

    var DEFAULT_COLOR = '#e85e30';

    /* ── Build icon <select> ─────────────────────────────────────── */
    function buildIconSelect(selectedIcon) {
        var html = '<select class="hm-item-icon">';
        ICON_GROUPS.forEach(function (group) {
            if (group.icons.length === 1 && group.icons[0].v === '') {
                // "No icon" option, not in optgroup
                html += '<option value=""' + (selectedIcon === '' ? ' selected' : '') + '>— No Icon —</option>';
            } else {
                html += '<optgroup label="' + _.escape(group.label) + '">';
                group.icons.forEach(function (ic) {
                    html += '<option value="' + _.escape(ic.v) + '"' + (ic.v === selectedIcon ? ' selected' : '') + '>' + _.escape(ic.l) + '</option>';
                });
                html += '</optgroup>';
            }
        });
        html += '</select>';
        return html;
    }

    /* ── Build a single link row ─────────────────────────────────── */
    function buildItemRow(name, link, icon, color) {
        name  = name  || '';
        link  = link  || '';
        icon  = icon  || '';
        color = color || DEFAULT_COLOR;

        var iconHtml = icon
            ? '<span class="material-symbols-outlined" style="font-size:18px;line-height:1;">' + _.escape(icon) + '</span>'
            : '<span style="font-size:11px;opacity:.45;">none</span>';

        return $(
            '<li class="hm-mega-col-item">' +
                '<span class="dashicons dashicons-move hm-drag-handle"></span>' +
                '<div class="hm-col-item-fields">' +

                    // Icon + color row
                    '<div class="hm-item-meta-row">' +
                        '<div class="hm-icon-preview" style="background:' + color + '22; color:' + color + ';">' +
                            iconHtml +
                        '</div>' +
                        buildIconSelect(icon) +
                        '<label class="hm-color-swatch-label" title="Icon Color">' +
                            '<span class="hm-color-dot" style="background:' + color + ';"></span>' +
                            '<input type="color" class="hm-item-color" value="' + _.escape(color) + '" />' +
                        '</label>' +
                    '</div>' +

                    // Label + URL
                    '<input type="text" placeholder="Label (e.g. Eco Stays)"  class="hm-item-name" value="' + _.escape(name) + '" />' +
                    '<input type="url"  placeholder="URL   (e.g. /eco-stays)" class="hm-item-link" value="' + _.escape(link) + '" />' +

                '</div>' +
                '<button type="button" class="hm-col-item-remove" title="Remove">&times;</button>' +
            '</li>'
        );
    }

    /* ── Read/write JSON ─────────────────────────────────────────── */
    function readValue($wrap) {
        var data = { col1: [], col2: [], col3: [] };
        [1, 2, 3].forEach(function (c) {
            $wrap.find('.hm-mega-col-panel[data-col="' + c + '"] .hm-mega-col-item').each(function () {
                var name  = $(this).find('.hm-item-name').val().trim();
                var link  = $(this).find('.hm-item-link').val().trim();
                var icon  = $(this).find('.hm-item-icon').val();
                var color = $(this).find('.hm-item-color').val();
                if (name || link) {
                    data['col' + c].push({ name: name, link: link, icon: icon, color: color });
                }
            });
        });
        return JSON.stringify(data);
    }

    function writeValue($wrap, jsonStr) {
        var data = {};
        try { data = JSON.parse(jsonStr) || {}; } catch (e) {}
        [1, 2, 3].forEach(function (c) {
            var $list = $wrap.find('.hm-mega-col-panel[data-col="' + c + '"] .hm-mega-col-items');
            $list.empty();
            (data['col' + c] || []).forEach(function (item) {
                $list.append(buildItemRow(item.name, item.link, item.icon, item.color));
            });
        });
        updateCounts($wrap);
    }

    /* ── Live icon / color preview update ───────────────────────── */
    function updateRowPreview($row) {
        var icon  = $row.find('.hm-item-icon').val();
        var color = $row.find('.hm-item-color').val() || DEFAULT_COLOR;
        var $preview = $row.find('.hm-icon-preview');
        var $dot     = $row.find('.hm-color-dot');

        $preview.css({ background: color + '22', color: color });
        $preview.html(icon
            ? '<span class="material-symbols-outlined" style="font-size:18px;line-height:1;">' + _.escape(icon) + '</span>'
            : '<span style="font-size:11px;opacity:.45;">none</span>');
        $dot.css('background', color);
    }

    /* ── Tab counts ─────────────────────────────────────────────── */
    function updateCounts($wrap) {
        [1, 2, 3].forEach(function (c) {
            var count = $wrap.find('.hm-mega-col-panel[data-col="' + c + '"] .hm-mega-col-item').length;
            $wrap.find('.hm-tab-count[data-col="' + c + '"]').text(count);
        });
    }

    /* ── Tabs ───────────────────────────────────────────────────── */
    function initTabs($wrap) {
        $wrap.find('.hm-mega-tab-btn').on('click', function () {
            var col = $(this).data('tab').replace('col', '');
            $wrap.find('.hm-mega-tab-btn').removeClass('is-active').attr('aria-selected', 'false');
            $wrap.find('.hm-mega-col-panel').removeClass('is-active');
            $(this).addClass('is-active').attr('aria-selected', 'true');
            $wrap.find('.hm-mega-col-panel[data-col="' + col + '"]').addClass('is-active');
        });
    }

    /* ── Main init ──────────────────────────────────────────────── */
    function initControl($wrap) {
        var $hidden = $wrap.siblings('.hm-mega-columns-value');
        var setting = $wrap.data('setting');

        if ($hidden.val()) writeValue($wrap, $hidden.val());

        initTabs($wrap);

        // Sortable
        $wrap.find('.hm-mega-col-items').sortable({
            handle      : '.hm-drag-handle',
            placeholder : 'hm-col-item-placeholder',
            opacity     : 0.75,
            update      : save,
        });

        function save() {
            var json = readValue($wrap);
            $hidden.val(json).trigger('change');
            updateCounts($wrap);
            if (window.wp && wp.customize) {
                wp.customize(setting, function (s) { s.set(json); });
            }
        }

        // Add link
        $wrap.on('click', '.hm-mega-col-add', function () {
            var col   = $(this).data('col');
            var $list = $wrap.find('.hm-mega-col-panel[data-col="' + col + '"] .hm-mega-col-items');
            var $row  = buildItemRow('', '', '', DEFAULT_COLOR);
            $list.append($row);
            $row.find('.hm-item-name').focus();
            save();
        });

        // Remove link
        $wrap.on('click', '.hm-col-item-remove', function () {
            $(this).closest('.hm-mega-col-item').remove();
            save();
        });

        // Live preview on icon/color change
        $wrap.on('change', '.hm-item-icon, .hm-item-color', function () {
            updateRowPreview($(this).closest('.hm-mega-col-item'));
            save();
        });

        // Text input debounce save
        $wrap.on('input', '.hm-item-name, .hm-item-link', _.debounce(save, 350));
    }

    /* ── Customizer hooks ───────────────────────────────────────── */
    wp.customize.bind('ready', function () {
        $('.hm-mega-columns-wrap').each(function () {
            if (!$(this).data('hm-cols-init')) {
                $(this).data('hm-cols-init', true);
                initControl($(this));
            }
        });
    });

    $(document).on('expanded', '.control-section', function () {
        $(this).find('.hm-mega-columns-wrap').each(function () {
            if (!$(this).data('hm-cols-init')) {
                $(this).data('hm-cols-init', true);
                initControl($(this));
            }
        });
    });

}(jQuery));
