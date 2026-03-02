<?php
/**
 * Host Dashboard — Edit/Create Property View
 *
 * A multi-tab frontend form for creating or updating a homestay.
 *
 * @package Himalayan\Homestay
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$property_id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;
$is_new      = ( $property_id === 0 );

// Verify ownership if editing
if ( ! $is_new ) {
    $post_author = (int) get_post_field( 'post_author', $property_id );
    if ( $post_author !== get_current_user_id() && ! current_user_can( 'manage_options' ) ) {
        wp_die( 'You do not have permission to edit this property.' );
    }
}

// Get data for form population
$title       = $is_new ? '' : get_the_title( $property_id );
$description = $is_new ? '' : get_post_field( 'post_content', $property_id );
$base_price  = $is_new ? '' : get_post_meta( $property_id, 'base_price_per_night', true );
$max_guests  = $is_new ? '2' : get_post_meta( $property_id, 'max_guests', true );
$bedrooms    = $is_new ? '1' : get_post_meta( $property_id, 'hhb_bedrooms', true );
$bathrooms   = $is_new ? '1' : get_post_meta( $property_id, 'hhb_bathrooms', true );
$lat         = $is_new ? '' : get_post_meta( $property_id, 'lat', true );
$lng         = $is_new ? '' : get_post_meta( $property_id, 'lng', true );
$min_nights  = $is_new ? '1' : get_post_meta( $property_id, 'hhb_min_nights', true );
$max_nights  = $is_new ? '30' : get_post_meta( $property_id, 'hhb_max_nights', true );
$buffer_days = $is_new ? '0' : get_post_meta( $property_id, 'hhb_buffer_days', true );
$deposit     = $is_new ? '0' : get_post_meta( $property_id, 'hhb_deposit_percent', true );
$extra_fee   = $is_new ? '0' : get_post_meta( $property_id, 'hhb_extra_guest_fee', true );
$dos         = $is_new ? '' : get_post_meta( $property_id, 'hhb_dos', true );
$donts       = $is_new ? '' : get_post_meta( $property_id, 'hhb_donts', true );
$attractions = $is_new ? [] : get_post_meta( $property_id, 'hhb_attractions', true );
if ( ! is_array( $attractions ) ) $attractions = [];

$host_mode   = $is_new ? 'user' : get_post_meta( $property_id, 'hhb_host_mode', true );
$host_user   = $is_new ? get_current_user_id() : get_post_meta( $property_id, 'hhb_host_user_id', true );
$host_name   = $is_new ? '' : get_post_meta( $property_id, 'hhb_host_name', true );
$host_email  = $is_new ? '' : get_post_meta( $property_id, 'hhb_host_email', true );
$host_phone  = $is_new ? '' : get_post_meta( $property_id, 'hhb_host_phone', true );
$host_avatar = $is_new ? '' : get_post_meta( $property_id, 'hhb_host_avatar_url', true );
$host_bio    = $is_new ? '' : get_post_meta( $property_id, 'hhb_host_bio', true );
?>

<style>
/* Tab Navigation */
.hhb-tabs { display: flex; gap: 32px; border-bottom: 1px solid #e2e8f0; margin-bottom: 32px; }
.hhb-tab-btn { background: none; border: none; padding: 0 0 12px; font-size: 15px; font-weight: 600; color: #64748b; cursor: pointer; border-bottom: 2px solid transparent; transition: all 0.2s; position: relative; top: 1px; }
.hhb-tab-btn:hover { color: #0f172a; }
.hhb-tab-btn.active { color: #2563eb; border-bottom-color: #2563eb; }

/* Form Elements */
.hhb-form-section { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
.hhb-field-group { margin-bottom: 24px; }
.hhb-field-group label { display: block; font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 8px; }
.hhb-field-group input[type="text"], 
.hhb-field-group input[type="number"], 
.hhb-field-group select, 
.hhb-field-group textarea { width: 100%; border: 1px solid #cbd5e1; border-radius: 8px; padding: 12px 16px; font-size: 15px; color: #0f172a; transition: border-color 0.2s; background: #f8fafc; font-family: inherit; }
.hhb-field-group input:focus, 
.hhb-field-group select:focus, 
.hhb-field-group textarea:focus { outline: none; border-color: #3b82f6; background: #fff; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
.select2-container--default .select2-selection--multiple { border: 1px solid #cbd5e1; border-radius: 8px; padding: 6px 10px; background: #f8fafc; }
.select2-container--default.select2-container--focus .select2-selection--multiple { border-color: #3b82f6; background: #fff; }
.hhb-row { display: flex; gap: 24px; }
.hhb-col { flex: 1; }
</style>

<!-- Tabs -->
<div class="hhb-tabs" id="hhb-form-tabs" style="overflow-x: auto; white-space: nowrap; -webkit-overflow-scrolling: touch;">
    <button type="button" class="hhb-tab-btn active" data-target="tab-basics">Basic Info</button>
    <button type="button" class="hhb-tab-btn" data-target="tab-pricing">Pricing & Capacity</button>
    <button type="button" class="hhb-tab-btn" data-target="tab-location">Location</button>
    <button type="button" class="hhb-tab-btn" data-target="tab-media">Photos</button>
    <button type="button" class="hhb-tab-btn" data-target="tab-amenities">Amenities</button>
    <button type="button" class="hhb-tab-btn" data-target="tab-rules">Rules & Info</button>
    <button type="button" class="hhb-tab-btn" data-target="tab-host">Host Profile</button>
</div>

<!-- Forms Container -->
<form id="hhb-property-form" style="max-width: 800px;">
    <?php wp_nonce_field( 'hhb_save_property', 'security' ); ?>
    <input type="hidden" name="action" value="hhb_save_property">
    <input type="hidden" name="property_id" value="<?php echo esc_attr( $property_id ); ?>">

    <!-- TAB: Basics -->
    <div id="tab-basics" class="hhb-form-section hhb-tab-content">
        <h2 style="margin: 0 0 24px; font-size: 18px; color: #0f172a;">Property Details</h2>
        
        <div class="hhb-field-group">
            <label>Property Name</label>
            <input type="text" name="post_title" value="<?php echo esc_attr( $title ); ?>" required placeholder="e.g. Modern Villa with Mountain View">
        </div>
        
        <div class="hhb-field-group">
            <label>Description</label>
            <?php 
            wp_editor( $description, 'post_content', [
                'media_buttons' => false,
                'textarea_rows' => 10,
                'teeny'         => true,
            ] ); 
            ?>
        </div>
        
        <div class="hhb-field-group">
            <label>Location / City (Tags)</label>
            <select name="hhb_locations[]" multiple class="hhb-select2" style="width: 100%;" data-placeholder="Select existing or type new locations (e.g., Manali, Himachal)...">
                <?php
                $locations = get_terms([ 'taxonomy' => 'hhb_location', 'hide_empty' => false ]);
                $selected_locs = $is_new ? [] : wp_get_post_terms( $property_id, 'hhb_location', ['fields' => 'ids'] );
                
                if ( ! is_wp_error( $locations ) && ! empty( $locations ) ) {
                    foreach ( $locations as $loc ) {
                        $selected = in_array( $loc->term_id, $selected_locs ) ? 'selected' : '';
                        echo '<option value="' . esc_attr( $loc->term_id ) . '" ' . $selected . '>' . esc_html( $loc->name ) . '</option>';
                    }
                }
                ?>
            </select>
            <p style="font-size:13px; color:#64748b; margin-top:8px;">You can select existing locations or type to create new ones.</p>
        </div>
    </div>

<?php $offer_price = $is_new ? '' : get_post_meta( $property_id, 'offer_price_per_night', true ); ?>
    <!-- TAB: Pricing -->
    <div id="tab-pricing" class="hhb-form-section hhb-tab-content" style="display:none;">
        <h2 style="margin: 0 0 24px; font-size: 18px; color: #0f172a;">Pricing & Capacity</h2>
        
        <div class="hhb-row">
            <div class="hhb-col">
                <div class="hhb-field-group">
                    <label>Base Price per Night</label>
                    <div style="position:relative;">
                        <span style="position:absolute; left:16px; top:12px; color:#64748b; font-weight:600;">₹</span>
                        <input type="number" name="base_price_per_night" value="<?php echo esc_attr( $base_price ); ?>" required style="padding-left:36px;" min="0">
                    </div>
                </div>
            </div>
            <div class="hhb-col">
                <div class="hhb-field-group">
                    <label>Offer Price (Optional)</label>
                    <div style="position:relative;">
                        <span style="position:absolute; left:16px; top:12px; color:#64748b; font-weight:600;">₹</span>
                        <input type="number" name="offer_price_per_night" value="<?php echo esc_attr( $offer_price ); ?>" style="padding-left:36px;" min="0">
                    </div>
                </div>
            </div>
        </div>

        <div class="hhb-row">
            <div class="hhb-col">
                <div class="hhb-field-group">
                    <label>Max Guests</label>
                    <input type="number" name="max_guests" value="<?php echo esc_attr( $max_guests ); ?>" required min="1">
                </div>
            </div>
            <div class="hhb-col">
                <div class="hhb-field-group">
                    <label>Bedrooms</label>
                    <input type="number" name="hhb_bedrooms" value="<?php echo esc_attr( $bedrooms ); ?>" min="0">
                </div>
            </div>
        </div>

        <div class="hhb-row">
            <div class="hhb-col">
                <div class="hhb-field-group">
                    <label>Bathrooms</label>
                    <input type="number" name="hhb_bathrooms" value="<?php echo esc_attr( $bathrooms ); ?>" min="0" step="0.5">
                </div>
            </div>
            <div class="hhb-col">
            </div>
        </div>
    </div>
    
    <!-- TAB: Photos -->
    <?php
        $cover_id = $is_new ? 0 : get_post_thumbnail_id( $property_id );
        $cover_url = $cover_id ? wp_get_attachment_image_url( $cover_id, 'medium' ) : '';
        $gallery_meta = $is_new ? [] : get_post_meta( $property_id, 'hhb_gallery_images', true );
        if ( ! is_array( $gallery_meta ) ) $gallery_meta = [];
        $gallery_str = implode(',', $gallery_meta);
    ?>
    <div id="tab-media" class="hhb-form-section hhb-tab-content" style="display:none;">
        <h2 style="margin: 0 0 24px; font-size: 18px; color: #0f172a;">Photos</h2>

        <div class="hhb-field-group">
            <label>Cover Photo (Featured Image)</label>
            <div id="hhb-cover-preview" style="margin-bottom:12px;">
                <?php if ( $cover_url ) : ?>
                    <img src="<?php echo esc_url($cover_url); ?>" style="max-width:300px; border-radius:8px; display:block;">
                <?php endif; ?>
            </div>
            <input type="hidden" name="cover_image_id" id="hhb-cover-image-id" value="<?php echo esc_attr($cover_id); ?>">
            <button type="button" class="hhb-btn hhb-btn-outline" id="hhb-upload-cover" style="background:#fff; border:1px solid #cbd5e1; color:#0f172a;">Select Cover Photo</button>
        </div>

        <div class="hhb-field-group" style="margin-top:32px;">
            <label>Gallery Images</label>
            <div id="hhb-gallery-preview" style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:12px;">
                <?php foreach ( $gallery_meta as $g_id ) : 
                    $g_url = wp_get_attachment_image_url( $g_id, 'thumbnail' );
                    if ( $g_url ) {
                        echo '<img src="'.esc_url($g_url).'" style="width:100px; height:100px; object-fit:cover; border-radius:8px;" data-id="'.esc_attr($g_id).'">';
                    }
                endforeach; ?>
            </div>
            <input type="hidden" name="gallery_image_ids" id="hhb-gallery-image-ids" value="<?php echo esc_attr($gallery_str); ?>">
            <button type="button" class="hhb-btn hhb-btn-outline" id="hhb-upload-gallery" style="background:#fff; border:1px solid #cbd5e1; color:#0f172a;">Select Gallery Images</button>
            <p style="font-size:13px; color:#64748b; margin-top:8px;">Hold CTRL/CMD to select multiple images.</p>
        </div>
    </div>

    <!-- TAB: Amenities -->
    <div id="tab-amenities" class="hhb-form-section hhb-tab-content" style="display:none;">
        <h2 style="margin: 0 0 24px; font-size: 18px; color: #0f172a;">Amenities & Features</h2>
        
        <div class="hhb-field-group">
            <label>Property Types / Tags</label>
            <select name="hhb_property_types[]" multiple class="hhb-select2" style="width: 100%;" data-placeholder="Select property tags...">
                <?php
                $types = get_terms([ 'taxonomy' => 'hhb_property_type', 'hide_empty' => false ]);
                $selected_types = $is_new ? [] : wp_get_post_terms( $property_id, 'hhb_property_type', ['fields' => 'ids'] );
                if ( ! is_wp_error( $types ) && ! empty( $types ) ) {
                    foreach ( $types as $type ) {
                        $selected = in_array( $type->term_id, $selected_types ) ? 'selected' : '';
                        echo '<option value="' . esc_attr( $type->term_id ) . '" ' . $selected . '>' . esc_html( $type->name ) . '</option>';
                    }
                }
                ?>
            </select>
            <p style="font-size:13px; color:#64748b; margin-top:8px;">You can select existing tags or type to create new ones.</p>
        </div>

        <div class="hhb-field-group" style="margin-top:32px;">
            <label>Available Amenities</label>
            <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap:16px;">
                <?php
                $amenities = get_terms([ 'taxonomy' => 'hhb_amenity', 'hide_empty' => false ]);
                $selected_amenities = $is_new ? [] : wp_get_post_terms( $property_id, 'hhb_amenity', ['fields' => 'ids'] );

                if ( ! is_wp_error( $amenities ) && ! empty( $amenities ) ) {
                    foreach ( $amenities as $amenity ) {
                        $checked = in_array( $amenity->term_id, $selected_amenities ) ? 'checked' : '';
                        echo '<label style="font-weight:400; font-size:15px; display:inline-flex; align-items:center; gap:8px;">
                              <input type="checkbox" name="hhb_amenity_terms[]" value="' . esc_attr( $amenity->term_id ) . '" ' . $checked . '>
                              ' . esc_html( $amenity->name ) . '
                              </label>';
                    }
                }
                ?>
            </div>
        </div>

        <div class="hhb-field-group" style="margin-top:32px; padding-top:24px; border-top:1px solid #e2e8f0;">
            <label>Included Facilities (Icons on Single Page)</label>
            <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap:16px;">
                <?php
                $all_amenities_keys = [
                    'wifi' => 'WiFi', 'parking' => 'Free Parking', 'kitchen' => 'Kitchen', 
                    'ac' => 'Air Conditioning', 'tv' => 'TV', 'washing_machine' => 'Washing Machine', 
                    'hot_water' => 'Hot Water', 'garden' => 'Garden', 'balcony' => 'Balcony', 
                    'fireplace' => 'Fireplace', 'gym' => 'Gym', 'pool' => 'Swimming Pool'
                ];
                $saved_amenity_keys = $is_new ? [] : (array) get_post_meta( $property_id, 'hhb_amenities', true );

                foreach ( $all_amenities_keys as $key => $label ) {
                    $checked = in_array( $key, $saved_amenity_keys ) ? 'checked' : '';
                    echo '<label style="font-weight:400; font-size:15px; display:inline-flex; align-items:center; gap:8px;">
                            <input type="checkbox" name="hhb_amenities[]" value="' . esc_attr( $key ) . '" ' . $checked . '>
                            ' . esc_html( $label ) . '
                            </label>';
                }
                ?>
            </div>
        </div>
    </div>
    
    <!-- TAB: Location -->
    <div id="tab-location" class="hhb-form-section hhb-tab-content" style="display:none;">
        <h2 style="margin: 0 0 24px; font-size: 18px; color: #0f172a;">Location & Map</h2>
        
        <div class="hhb-row">
            <div class="hhb-col">
                <div class="hhb-field-group">
                    <label>Latitude</label>
                    <input type="text" name="lat" value="<?php echo esc_attr( $lat ); ?>" placeholder="e.g. 32.2396">
                </div>
            </div>
            <div class="hhb-col">
                <div class="hhb-field-group">
                    <label>Longitude</label>
                    <input type="text" name="lng" value="<?php echo esc_attr( $lng ); ?>" placeholder="e.g. 77.1887">
                </div>
            </div>
        </div>
        <p style="font-size:13px; color:#64748b;">Enter coordinates to display a map on the property page.</p>
    </div>

    <!-- TAB: Rules & Info -->
    <div id="tab-rules" class="hhb-form-section hhb-tab-content" style="display:none;">
        <h2 style="margin: 0 0 24px; font-size: 18px; color: #0f172a;">Rules, Info & Booking Constraints</h2>
        
        <div class="hhb-row">
            <div class="hhb-col">
                <div class="hhb-field-group">
                    <label>Minimum Nights</label>
                    <input type="number" name="hhb_min_nights" value="<?php echo esc_attr( $min_nights ); ?>" min="1">
                </div>
            </div>
            <div class="hhb-col">
                <div class="hhb-field-group">
                    <label>Maximum Nights</label>
                    <input type="number" name="hhb_max_nights" value="<?php echo esc_attr( $max_nights ); ?>" min="1">
                </div>
            </div>
        </div>

        <div class="hhb-row">
            <div class="hhb-col">
                <div class="hhb-field-group">
                    <label>Buffer Days (Between Bookings)</label>
                    <input type="number" name="hhb_buffer_days" value="<?php echo esc_attr( $buffer_days ); ?>" min="0">
                </div>
            </div>
            <div class="hhb-col">
                <div class="hhb-field-group">
                    <label>Deposit % (0 for full payment)</label>
                    <input type="number" name="hhb_deposit_percent" value="<?php echo esc_attr( $deposit ); ?>" min="0" max="100">
                </div>
            </div>
        </div>

        <div class="hhb-field-group">
            <label>Extra Guest Fee (Per Night)</label>
            <div style="position:relative; max-width:50%;">
                <span style="position:absolute; left:16px; top:12px; color:#64748b; font-weight:600;">₹</span>
                <input type="number" name="hhb_extra_guest_fee" value="<?php echo esc_attr( $extra_fee ); ?>" min="0" style="padding-left:36px;">
            </div>
        </div>

        <div class="hhb-row" style="margin-top: 32px; padding-top: 24px; border-top: 1px solid #e2e8f0;">
            <div class="hhb-col">
                <div class="hhb-field-group">
                    <label>The Dos (Things to do)</label>
                    <textarea name="hhb_dos" rows="5" placeholder="One item per line..."><?php echo esc_textarea( $dos ); ?></textarea>
                </div>
            </div>
            <div class="hhb-col">
                <div class="hhb-field-group">
                    <label>The Don'ts (Strictly Prohibited)</label>
                    <textarea name="hhb_donts" rows="5" placeholder="One item per line..."><?php echo esc_textarea( $donts ); ?></textarea>
                </div>
            </div>
        </div>

        <div class="hhb-field-group">
            <label>Nearby Attractions (One per line)</label>
            <textarea name="hhb_attractions" rows="4" placeholder="e.g. Mall Road (2km)"><?php echo esc_textarea( implode("\n", $attractions) ); ?></textarea>
        </div>
    </div>

    <!-- TAB: Host Profile -->
    <div id="tab-host" class="hhb-form-section hhb-tab-content" style="display:none;">
        <h2 style="margin: 0 0 24px; font-size: 18px; color: #0f172a;">Host Profile Configuration</h2>
        
        <div class="hhb-field-group" style="display:flex; gap:16px;">
            <label style="display:inline-flex; align-items:center; gap:8px; font-weight:400;">
                <input type="radio" name="hhb_host_mode" value="user" <?php checked( $host_mode, 'user' ); ?> onchange="document.getElementById('host-manual-fields').style.display='none'; document.getElementById('host-user-fields').style.display='block';">
                Link to WordPress User
            </label>
            <label style="display:inline-flex; align-items:center; gap:8px; font-weight:400;">
                <input type="radio" name="hhb_host_mode" value="manual" <?php checked( $host_mode, 'manual' ); ?> onchange="document.getElementById('host-manual-fields').style.display='block'; document.getElementById('host-user-fields').style.display='none';">
                Manual Entry
            </label>
        </div>

        <div id="host-user-fields" style="<?php echo $host_mode === 'user' ? 'display:block;' : 'display:none;'; ?>">
            <div class="hhb-field-group">
                <label>Select User</label>
                <select name="hhb_host_user_id">
                    <option value="">— Select User —</option>
                    <?php
                    $users = get_users(['role__in' => ['administrator', 'subscriber', 'author', 'editor']]);
                    foreach ($users as $u) {
                        echo '<option value="' . esc_attr($u->ID) . '" ' . selected($host_user, $u->ID, false) . '>' . esc_html($u->display_name . ' (' . $u->user_email . ')') . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <div id="host-manual-fields" style="<?php echo $host_mode === 'manual' ? 'display:block;' : 'display:none;'; ?>">
            <div class="hhb-row">
                <div class="hhb-col">
                    <div class="hhb-field-group">
                        <label>Host Name</label>
                        <input type="text" name="hhb_host_name" value="<?php echo esc_attr( $host_name ); ?>">
                    </div>
                </div>
                <div class="hhb-col">
                    <div class="hhb-field-group">
                        <label>Host Email</label>
                        <input type="email" name="hhb_host_email" value="<?php echo esc_attr( $host_email ); ?>">
                    </div>
                </div>
            </div>
            
            <div class="hhb-row">
                <div class="hhb-col">
                    <div class="hhb-field-group">
                        <label>Host Phone</label>
                        <input type="text" name="hhb_host_phone" value="<?php echo esc_attr( $host_phone ); ?>">
                    </div>
                </div>
                <div class="hhb-col">
                    <div class="hhb-field-group">
                        <label>Host Avatar</label>
                        <div style="display: flex; gap: 12px; align-items: center;">
                            <input type="text" name="hhb_host_avatar_url" id="hhb-property-avatar-url" value="<?php echo esc_url( $host_avatar ); ?>" placeholder="https://..." style="flex:1;">
                            <button type="button" id="hhb-upload-property-avatar" style="padding: 10px 16px; background: #fff; border: 1px solid #cbd5e1; border-radius: 6px; cursor: pointer; color: #475569; font-weight: 500;">Select Image</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="hhb-field-group">
                <label>Host Bio</label>
                <textarea name="hhb_host_bio" rows="3"><?php echo esc_textarea( $host_bio ); ?></textarea>
            </div>
        </div>
    </div>
    
    <!-- Next Steps Footer -->
    <div style="margin-top: 32px; display: flex; justify-content: flex-end; gap: 16px;">
        <a href="?view=properties" style="color: #64748b; font-weight: 600; text-decoration: none; padding: 12px 16px;">Cancel</a>
        <button type="submit" class="hhb-btn" id="hhb-save-prop-btn">Save Property</button>
    </div>
    <div id="hhb-prop-messages" style="margin-top: 16px;"></div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof jQuery !== 'undefined' && jQuery.fn.select2) {
        jQuery('.hhb-select2').select2({
            tags: true,
            tokenSeparators: [',']
        });
    }
    // 1. Tab Switching
    const tabs = document.querySelectorAll('.hhb-tab-btn');
    const contents = document.querySelectorAll('.hhb-tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.style.display = 'none');
            
            tab.classList.add('active');
            document.getElementById(tab.dataset.target).style.display = 'block';
        });
    });

    // 2. Media Uploaders
    let coverFrame;
    document.getElementById('hhb-upload-cover').addEventListener('click', function(e) {
        e.preventDefault();
        if ( coverFrame ) { coverFrame.open(); return; }
        
        coverFrame = wp.media({
            title: 'Select Cover Photo',
            button: { text: 'Use this image' },
            multiple: false
        });

        coverFrame.on('select', function() {
            const attachment = coverFrame.state().get('selection').first().toJSON();
            document.getElementById('hhb-cover-image-id').value = attachment.id;
            const url = attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;
            document.getElementById('hhb-cover-preview').innerHTML = `<img src="${url}" style="max-width:300px; border-radius:8px; display:block;">`;
        });

        coverFrame.open();
    });

    let galleryFrame;
    document.getElementById('hhb-upload-gallery').addEventListener('click', function(e) {
        e.preventDefault();
        if ( galleryFrame ) { galleryFrame.open(); return; }
        
        galleryFrame = wp.media({
            title: 'Select Gallery Images',
            button: { text: 'Add to gallery' },
            multiple: 'add'
        });

        galleryFrame.on('select', function() {
            const selection = galleryFrame.state().get('selection');
            const preview = document.getElementById('hhb-gallery-preview');
            const input = document.getElementById('hhb-gallery-image-ids');
            
            let currentIds = input.value ? input.value.split(',') : [];
            
            selection.map(function(attachment) {
                attachment = attachment.toJSON();
                if ( ! currentIds.includes(attachment.id.toString()) ) {
                    currentIds.push(attachment.id);
                    const url = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                    preview.innerHTML += `<img src="${url}" style="width:100px; height:100px; object-fit:cover; border-radius:8px;" data-id="${attachment.id}">`;
                }
            });
            
            input.value = currentIds.join(',');
        });

        galleryFrame.open();
    });

    let propAvatarFrame;
    document.getElementById('hhb-upload-property-avatar').addEventListener('click', function(e) {
        e.preventDefault();
        if ( propAvatarFrame ) { propAvatarFrame.open(); return; }
        
        propAvatarFrame = wp.media({
            title: 'Select Host Avatar',
            button: { text: 'Use this image' },
            multiple: false
        });

        propAvatarFrame.on('select', function() {
            const attachment = propAvatarFrame.state().get('selection').first().toJSON();
            const url = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
            document.getElementById('hhb-property-avatar-url').value = url;
        });

        propAvatarFrame.open();
    });

    // 3. AJAX Save Form    // 2. AJAX Save Form
    const form = document.getElementById("hhb-property-form");
    const saveBtn = document.getElementById("hhb-save-prop-btn");
    const msgDiv = document.getElementById("hhb-prop-messages");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        saveBtn.textContent = "Saving...";
        saveBtn.disabled = true;
        
        // Sync WP Editor content
        if (typeof tinyMCE !== 'undefined' && tinyMCE.get('post_content')) {
            tinyMCE.get('post_content').save();
        }

        const formData = new FormData(form);
        
        try {
            const res = await fetch("<?php echo admin_url('admin-ajax.php'); ?>", {
                method: "POST",
                body: formData
            });
            const data = await res.json();
            
            if (data.success) {
                msgDiv.innerHTML = `<div style="background:#dcfce7; color:#166534; padding:12px 16px; border-radius:8px; font-weight:600;">Property saved successfully! Redirecting...</div>`;
                setTimeout(() => window.location.href = '?view=properties', 1500);
            } else {
                msgDiv.innerHTML = `<div style="background:#fee2e2; color:#991b1b; padding:12px 16px; border-radius:8px; font-weight:600;">Error: ${data.data || "Could not save."}</div>`;
                saveBtn.textContent = "Save Property";
                saveBtn.disabled = false;
            }
        } catch (err) {
            msgDiv.innerHTML = `<div style="background:#fee2e2; color:#991b1b; padding:12px 16px; border-radius:8px; font-weight:600;">Network error.</div>`;
            saveBtn.textContent = "Save Property";
            saveBtn.disabled = false;
        }
    });
});
</script>
