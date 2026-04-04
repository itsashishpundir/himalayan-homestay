<?php
/**
 * Front Page Template
 *
 * Redesigned following Emil Kowalski's design engineering philosophy:
 * custom easing curves, specific transitions, hover guards, active states,
 * animated dropdowns, stagger reveals, and proper spring-like drawer.
 *
 * @package HimalayanHomestay
 */

get_header();

/* ── Customizer values (with defaults) ──────────────────────────── */
$hero_img   = get_theme_mod( 'hhb_home_hero_image', 'https://images.unsplash.com/photo-1516575150278-77136aed6920?q=80&w=2940&auto=format&fit=crop' );
$hero_h1    = get_theme_mod( 'hhb_home_hero_heading', 'Stay in the Heart of the Himalayas' );
$hero_sub   = get_theme_mod( 'hhb_home_hero_subheading', 'Handpicked homestays with local hospitality — breathtaking views, warm hosts, unforgettable mornings.' );

$trust_cards = [
    [ 'icon' => 'verified_user',   'title' => get_theme_mod( 'hhb_trust_1_title', 'Verified Properties' ),    'desc' => get_theme_mod( 'hhb_trust_1_desc', 'Every stay personally inspected by our team.' ) ],
    [ 'icon' => 'sell',            'title' => get_theme_mod( 'hhb_trust_2_title', 'Transparent Pricing' ),     'desc' => get_theme_mod( 'hhb_trust_2_desc', 'What you see is what you pay. No hidden fees.' ) ],
    [ 'icon' => 'handshake',       'title' => get_theme_mod( 'hhb_trust_3_title', 'Direct Booking' ),          'desc' => get_theme_mod( 'hhb_trust_3_desc', 'Book directly with hosts. No middlemen, no commission markup.' ) ],
    [ 'icon' => 'support_agent',   'title' => get_theme_mod( 'hhb_trust_4_title', 'Local Support' ),           'desc' => get_theme_mod( 'hhb_trust_4_desc', 'Our team is based in the mountains, always reachable.' ) ],
    [ 'icon' => 'king_bed',        'title' => get_theme_mod( 'hhb_trust_5_title', 'Clean & Comfortable' ),     'desc' => get_theme_mod( 'hhb_trust_5_desc', 'Quality beds, hot water, clean linens — guaranteed.' ) ],
];

$steps = [
    [ 'icon' => 'search',         'title' => get_theme_mod( 'hhb_step_1_title', 'Choose Your Stay' ),       'desc' => get_theme_mod( 'hhb_step_1_desc', 'Browse our curated collection of verified mountain homestays.' ) ],
    [ 'icon' => 'event_available','title' => get_theme_mod( 'hhb_step_2_title', 'Confirm Availability' ),   'desc' => get_theme_mod( 'hhb_step_2_desc', 'Pick your dates and check real-time availability.' ) ],
    [ 'icon' => 'lock',           'title' => get_theme_mod( 'hhb_step_3_title', 'Secure Payment' ),         'desc' => get_theme_mod( 'hhb_step_3_desc', 'Pay safely online. Your money is protected.' ) ],
    [ 'icon' => 'landscape',      'title' => get_theme_mod( 'hhb_step_4_title', 'Enjoy Your Trip' ),        'desc' => get_theme_mod( 'hhb_step_4_desc', 'Pack your bags and enjoy authentic mountain living.' ) ],
];

$locations      = get_terms( [ 'taxonomy' => 'hhb_location',      'hide_empty' => false ] );
$prop_types     = get_terms( [ 'taxonomy' => 'hhb_property_type', 'hide_empty' => false ] );
$locations_top5 = get_terms( [ 'taxonomy' => 'hhb_location', 'hide_empty' => false, 'orderby' => 'id', 'order' => 'DESC', 'number' => 5 ] );

$featured_count = (int) get_theme_mod( 'hhb_featured_item_count', 6 );
$featured_cols  = esc_attr( get_theme_mod( 'hhb_featured_grid_cols', '4' ) );

$featured_args = [
    'post_type'      => 'hhb_homestay',
    'posts_per_page' => $featured_count,
    'post_status'    => 'publish',
    'meta_query'     => [ [ 'key' => '_is_best_seller', 'value' => '1' ] ],
];
$featured_query = new WP_Query( $featured_args );
if ( ! $featured_query->have_posts() ) {
    $featured_query = new WP_Query( [
        'post_type'      => 'hhb_homestay',
        'posts_per_page' => $featured_count,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ] );
}

global $wpdb;
$reviews_table = $wpdb->prefix . 'hhb_reviews';
$table_exists  = $wpdb->get_var( "SHOW TABLES LIKE '{$reviews_table}'" );
?>

<style>
/* ═══════════════════════════════════════════════════════════════
   DESIGN SYSTEM — Emil Kowalski principles
   ═══════════════════════════════════════════════════════════════ */

:root {
    /* Custom easing curves — built-in CSS easings are too weak */
    --ease-out:    cubic-bezier(0.23, 1, 0.32, 1);
    --ease-in-out: cubic-bezier(0.77, 0, 0.175, 1);
    --ease-drawer: cubic-bezier(0.32, 0.72, 0, 1);   /* iOS-like drawer */

    /* Colours */
    --hhb-primary:     #e85e30;
    --hhb-primary-dk:  #c94b22;
    --hhb-dark:        #100e0b;
    --hhb-surface:     #f8f6f4;
    --hhb-border:      #f0ece8;
}

/* ═══════════════════════════════════════════════════════════════
   REVEAL ANIMATION SYSTEM
   ═══════════════════════════════════════════════════════════════ */

.hhb-reveal {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 550ms var(--ease-out),
                transform 550ms var(--ease-out);
}
.hhb-reveal.is-visible {
    opacity: 1;
    transform: translateY(0);
}
/* Stagger delays for grid children */
.hhb-stagger > *:nth-child(1) { transition-delay:   0ms; }
.hhb-stagger > *:nth-child(2) { transition-delay:  60ms; }
.hhb-stagger > *:nth-child(3) { transition-delay: 120ms; }
.hhb-stagger > *:nth-child(4) { transition-delay: 180ms; }
.hhb-stagger > *:nth-child(5) { transition-delay: 240ms; }
.hhb-stagger > *:nth-child(6) { transition-delay: 300ms; }
.hhb-stagger > *:nth-child(7) { transition-delay: 360ms; }
.hhb-stagger > *:nth-child(8) { transition-delay: 420ms; }

@media (prefers-reduced-motion: reduce) {
    .hhb-reveal,
    .hhb-reveal.is-visible {
        opacity: 1;
        transform: none;
        transition: none;
    }
    .hhb-stagger > * { transition-delay: 0ms !important; }
}

/* ═══════════════════════════════════════════════════════════════
   HERO
   ═══════════════════════════════════════════════════════════════ */

.hhb-fp-hero {
    position: relative;
    min-height: 92vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-top: 140px;
    padding-bottom: 80px;
    box-sizing: border-box;
    overflow: hidden;
}

/* Cinematic slow-zoom — marketing animation, long duration is intentional */
@keyframes hhb-cinematic-zoom {
    from { transform: scale(1); }
    to   { transform: scale(1.12); }
}
.hhb-fp-hero-zoom {
    position: absolute;
    inset: -8%;
    animation: hhb-cinematic-zoom 24s ease-in-out infinite alternate;
    transform-origin: center center;
}
@media (prefers-reduced-motion: reduce) {
    .hhb-fp-hero-zoom { animation: none; }
}

.hhb-fp-hero-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center 30%;
}

/* Dot particle texture */
.hhb-fp-hero-dots {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(255,181,159,0.07) 1px, transparent 1px);
    background-size: 44px 44px;
    pointer-events: none;
}

/* Multi-layer atmospheric overlay */
.hhb-fp-hero-overlay {
    position: absolute;
    inset: 0;
    background:
        linear-gradient(to top,  rgba(28,8,3,0.93) 0%, rgba(100,35,10,0.52) 18%, rgba(55,18,5,0.18) 36%, transparent 58%),
        linear-gradient(to bottom, rgba(8,18,38,0.40) 0%, rgba(15,25,50,0.15) 30%, transparent 55%),
        radial-gradient(ellipse 110% 90% at 50% 50%, transparent 38%, rgba(0,0,0,0.52) 100%);
}

.hhb-fp-hero-glow {
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse 65% 45% at 50% 62%, rgba(200,80,20,0.11) 0%, rgba(232,94,48,0.04) 45%, transparent 70%);
    pointer-events: none;
}
.hhb-fp-hero-mist {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 38%;
    background: linear-gradient(to top, rgba(220,200,185,0.05) 0%, transparent 100%);
    pointer-events: none;
}

/* Snow particles */
@keyframes hhb-snowfall {
    0%   { transform: translateY(-30px) translateX(0); opacity: 0; }
    8%   { opacity: 0.75; }
    88%  { opacity: 0.3; }
    100% { transform: translateY(95vh) translateX(20px); opacity: 0; }
}
.hhb-snow-wrap { position: absolute; inset: 0; pointer-events: none; overflow: hidden; }
.hhb-snow-p {
    position: absolute;
    top: -10px;
    border-radius: 50%;
    background: rgba(255,255,255,0.68);
    animation: hhb-snowfall linear infinite;
}
@media (prefers-reduced-motion: reduce) {
    .hhb-snow-p { animation: none; opacity: 0; }
}

/* Hero badge */
.hhb-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    color: rgba(255,255,255,0.88);
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    padding: 10px 22px 10px 16px;
    border-radius: 999px;
    border: 1px solid rgba(255,255,255,0.14);
    margin-bottom: 28px;
    opacity: 0;
    transform: scale(0.96) translateY(8px);
    animation: hhb-hero-in 600ms var(--ease-out) 200ms forwards;
}
.hhb-hero-badge-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--hhb-primary);
    box-shadow: 0 0 8px rgba(232,94,48,0.60);
    flex-shrink: 0;
}

@keyframes hhb-hero-in {
    to { opacity: 1; transform: scale(1) translateY(0); }
}
@media (prefers-reduced-motion: reduce) {
    .hhb-hero-badge { animation: none; opacity: 1; transform: none; }
}

/* Hero heading — editorial split-line style */
.hhb-fp-hero h1 {
    font-family: 'Outfit', sans-serif;
    font-weight: 700;
    line-height: 1.08;
    text-shadow: 0 2px 30px rgba(0,0,0,0.35);
    letter-spacing: -0.025em;
    opacity: 0;
    transform: translateY(14px);
    animation: hhb-hero-in 700ms var(--ease-out) 320ms forwards;
}
.hhb-hero-h1-accent {
    display: block;
    font-style: italic;
    color: var(--hhb-primary);
    filter: drop-shadow(0 2px 12px rgba(232,94,48,0.25));
}
@media (prefers-reduced-motion: reduce) {
    .hhb-fp-hero h1 { animation: none; opacity: 1; transform: none; }
}

/* Hero subtitle */
.hhb-fp-hero-sub {
    font-family: 'Inter', sans-serif;
    font-size: clamp(0.9rem, 1.5vw, 1.075rem);
    color: rgba(255,255,255,0.72);
    line-height: 1.70;
    font-weight: 400;
    letter-spacing: 0.015em;
    text-shadow: 0 1px 10px rgba(0,0,0,0.30);
    max-width: 34rem;
    margin: 0 auto 2.5rem;
    opacity: 0;
    transform: translateY(10px);
    animation: hhb-hero-in 700ms var(--ease-out) 450ms forwards;
}
@media (prefers-reduced-motion: reduce) {
    .hhb-fp-hero-sub { animation: none; opacity: 1; transform: none; }
}

/* Hero stat strip — social proof below subtitle */
.hhb-hero-stats {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 32px;
    margin-bottom: 2rem;
    opacity: 0;
    transform: translateY(8px);
    animation: hhb-hero-in 600ms var(--ease-out) 540ms forwards;
}
.hhb-hero-stat {
    text-align: center;
}
.hhb-hero-stat-num {
    display: block;
    font-family: 'Outfit', sans-serif;
    font-size: 28px;
    font-weight: 700;
    color: #fff;
    line-height: 1;
    letter-spacing: -0.02em;
}
.hhb-hero-stat-label {
    font-size: 10px;
    font-weight: 600;
    color: rgba(255,255,255,0.45);
    text-transform: uppercase;
    letter-spacing: 0.10em;
    margin-top: 4px;
}
.hhb-hero-stat-divider {
    width: 1px;
    height: 32px;
    background: rgba(255,255,255,0.15);
}
@media (max-width: 479px) {
    .hhb-hero-stats { gap: 20px; }
    .hhb-hero-stat-num { font-size: 22px; }
}
@media (prefers-reduced-motion: reduce) {
    .hhb-hero-stats { animation: none; opacity: 1; transform: none; }
}

/* ── Search bar ── */
.hhb-fp-search-bar {
    position: relative;
    z-index: 50;
    background: rgba(255,255,255,0.11);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.20);
    box-shadow: 0 8px 32px rgba(0,0,0,0.16), inset 0 1px 0 rgba(255,255,255,0.13);
    opacity: 0;
    transform: translateY(10px);
    animation: hhb-hero-in 700ms var(--ease-out) 650ms forwards;
}
@media (prefers-reduced-motion: reduce) {
    .hhb-fp-search-bar { animation: none; opacity: 1; transform: none; }
}
.hhb-fp-search-bar input {
    background: transparent;
    border: none;
    color: #fff;
    font-weight: 600;
    font-size: 14px;
    outline: none;
    width: 100%;
    cursor: pointer;
}
.hhb-fp-search-bar input::placeholder { color: rgba(255,255,255,0.50); }
.hhb-fp-search-bar input::-webkit-calendar-picker-indicator { filter: invert(1); cursor: pointer; }

/* ── Front-page location suggestions ── */
.hhb-fp-loc-drop {
    position: absolute;
    top: calc(100% + 12px);
    left: -60px;
    min-width: 240px;
    background: rgba(8,14,28,0.92);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1px solid rgba(255,255,255,0.10);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 16px 40px rgba(0,0,0,0.55);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-6px);
    transition: opacity .2s, transform .2s, visibility .2s;
    z-index: 200;
}
.hhb-fp-loc-drop.is-open { opacity: 1; visibility: visible; transform: translateY(0); }
.hhb-fp-sug-label {
    padding: 10px 14px 5px;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.3);
}
.hhb-fp-sug-item {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    padding: 10px 14px;
    background: transparent;
    border: none;
    color: rgba(255,255,255,0.8);
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    text-align: left;
    transition: background .15s, color .15s;
}
.hhb-fp-sug-item:hover { background: rgba(255,255,255,0.07); color: #fff; }
.hhb-fp-sug-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: #f45c25;
    flex-shrink: 0;
}

/* Search field label */
.hhb-search-label {
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.50);
    display: block;
    margin-bottom: 2px;
}

/* ── Custom location / guests dropdown ── */
.hhb-custom-select-btn {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: transparent;
    border: none;
    color: #fff;
    font-weight: 600;
    font-size: 14px;
    outline: none;
    padding: 0;
    cursor: pointer;
    text-align: left;
    width: 100%;
    gap: 4px;
    /* Buttons must feel responsive to press */
    transition: opacity 120ms var(--ease-out);
}
.hhb-custom-select-btn:active { opacity: 0.75; }
.hhb-custom-select-btn .hhb-select-label-text {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    flex: 1;
    min-width: 0;
}
.hhb-select-arrow {
    color: rgba(255,255,255,0.50);
    flex-shrink: 0;
    /* Specify exact property — never animate 'all' */
    transition: transform 200ms var(--ease-out);
}
.hhb-location-open .hhb-select-arrow { transform: rotate(180deg); }

/* Dropdown — animated with opacity + scale, not display:none */
.hhb-custom-select-drop {
    position: absolute;
    top: calc(100% + 10px);
    left: -56px;
    min-width: 200px;
    width: max-content;
    background: rgba(12,16,14,0.97);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1px solid rgba(255,255,255,0.10);
    border-radius: 14px;
    box-shadow: 0 20px 48px rgba(0,0,0,0.50), inset 0 1px 0 rgba(255,255,255,0.05);
    z-index: 200;
    max-height: 260px;
    overflow-y: auto;
    padding: 6px;
    scrollbar-width: thin;
    scrollbar-color: rgba(232,94,48,0.35) transparent;
    /* Animated — popovers scale from their trigger, not center */
    opacity: 0;
    visibility: hidden;
    transform: scale(0.95) translateY(-6px);
    transform-origin: top left;
    transition: opacity 160ms var(--ease-out),
                transform 160ms var(--ease-out),
                visibility 160ms;
}
.hhb-custom-select-drop.is-open {
    opacity: 1;
    visibility: visible;
    transform: scale(1) translateY(0);
}
#hhb-guests-drop {
    left: auto;
    right: 0;
    transform-origin: top right;
}
.hhb-select-opt {
    display: block;
    width: 100%;
    text-align: left;
    background: transparent;
    border: none;
    color: rgba(255,255,255,0.78);
    font-size: 13px;
    font-weight: 500;
    padding: 10px 14px;
    border-radius: 9px;
    cursor: pointer;
    font-family: inherit;
    letter-spacing: 0.01em;
    transition: background 120ms var(--ease-out),
                color 120ms var(--ease-out);
}
@media (hover: hover) and (pointer: fine) {
    .hhb-select-opt:hover {
        background: rgba(232,94,48,0.14);
        color: #fff;
    }
}
.hhb-select-opt:active { background: rgba(232,94,48,0.22); }
.hhb-select-opt.is-active {
    background: rgba(232,94,48,0.20);
    color: #ffb59f;
    font-weight: 700;
}
.hhb-select-opt-placeholder { color: rgba(255,255,255,0.35); font-size: 12px; }

/* Search submit button */
.hhb-hero-btn-primary {
    transition: background 150ms var(--ease-out),
                transform 140ms var(--ease-out),
                box-shadow 150ms var(--ease-out);
}
/* Press feedback — buttons must feel responsive */
.hhb-hero-btn-primary:active { transform: scale(0.97); }
@media (hover: hover) and (pointer: fine) {
    .hhb-hero-btn-primary:hover { box-shadow: 0 6px 20px rgba(232,94,48,0.40); }
}

.hhb-hero-btn-outline {
    transition: background 150ms var(--ease-out),
                border-color 150ms var(--ease-out),
                transform 140ms var(--ease-out);
}
.hhb-hero-btn-outline:active { transform: scale(0.97); }
@media (hover: hover) and (pointer: fine) {
    .hhb-hero-btn-outline:hover {
        background: rgba(255,255,255,0.10);
        border-color: rgba(255,255,255,0.90);
    }
}

/* CTA wrapper animate in */
.hhb-hero-ctas {
    opacity: 0;
    transform: translateY(8px);
    animation: hhb-hero-in 600ms var(--ease-out) 780ms forwards;
}
@media (prefers-reduced-motion: reduce) {
    .hhb-hero-ctas { animation: none; opacity: 1; transform: none; }
}

/* Scroll hint */
@keyframes hhb-bounce-down {
    0%, 100% { transform: translateX(-50%) translateY(0);   opacity: 0.55; }
    50%       { transform: translateX(-50%) translateY(6px); opacity: 0.90; }
}
.hhb-scroll-hint {
    position: absolute;
    bottom: 28px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    color: rgba(255,255,255,0.50);
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.10em;
    text-transform: uppercase;
    animation: hhb-bounce-down 2.2s ease-in-out infinite;
    cursor: pointer;
    z-index: 10;
    user-select: none;
}
.hhb-scroll-hint svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2; }
@media (prefers-reduced-motion: reduce) {
    .hhb-scroll-hint { animation: none; opacity: 0.5; }
}

/* ═══════════════════════════════════════════════════════════════
   MOBILE SEARCH
   ═══════════════════════════════════════════════════════════════ */

.hhb-mobile-search-pill { display: none; }

@media (max-width: 767px) {
    .hhb-fp-search-bar      { display: none; }
    .hhb-mobile-search-pill {
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(255,255,255,0.14);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.26);
        border-radius: 999px;
        padding: 12px 14px 12px 20px;
        width: 100%;
        max-width: 360px;
        margin: 0 auto 20px;
        cursor: pointer;
        box-shadow: 0 4px 24px rgba(0,0,0,0.22);
        text-align: left;
        /* Press feedback */
        transition: transform 130ms var(--ease-out), opacity 130ms;
    }
    .hhb-mobile-search-pill:active { transform: scale(0.98); opacity: 0.90; }
    .hhb-mobile-search-pill .pill-text {
        flex: 1;
        color: rgba(255,255,255,0.70);
        font-size: 14px;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .hhb-mobile-search-pill .pill-icon {
        width: 36px; height: 36px;
        background: var(--hhb-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #fff;
    }
}

/* Mobile search overlay */
.hhb-search-overlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 2000;
    background: rgba(8,8,8,0.60);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    align-items: flex-end;
}
.hhb-search-overlay.is-open { display: flex; }

/* Drawer uses iOS-like easing — not ease-in which feels sluggish */
.hhb-search-overlay-panel {
    background: #fff;
    border-radius: 24px 24px 0 0;
    padding: 28px 20px 48px;
    width: 100%;
    animation: hhb-drawer-up 360ms var(--ease-drawer);
}
@keyframes hhb-drawer-up {
    from { transform: translateY(100%); }
    to   { transform: translateY(0); }
}
@media (prefers-reduced-motion: reduce) {
    .hhb-search-overlay-panel { animation: none; }
}

.hhb-overlay-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 28px;
}
.hhb-overlay-title {
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.02em;
}
.hhb-overlay-close {
    width: 38px; height: 38px;
    border-radius: 50%;
    background: #f1f5f9;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #475569;
    flex-shrink: 0;
    transition: background 120ms var(--ease-out), transform 120ms var(--ease-out);
}
.hhb-overlay-close:active { transform: scale(0.93); }
@media (hover: hover) and (pointer: fine) {
    .hhb-overlay-close:hover { background: #e2e8f0; }
}

.hhb-overlay-field { margin-bottom: 14px; }
.hhb-overlay-label {
    display: block;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #94a3b8;
    margin-bottom: 8px;
    padding-left: 4px;
}
.hhb-overlay-field-inner {
    display: flex;
    align-items: center;
    gap: 12px;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    padding: 15px 18px;
    transition: border-color 180ms var(--ease-out);
}
.hhb-overlay-field-inner:focus-within { border-color: var(--hhb-primary); }
.hhb-overlay-field-inner .material-symbols-outlined { color: var(--hhb-primary); font-size: 20px; flex-shrink: 0; }
.hhb-overlay-field-inner select,
.hhb-overlay-field-inner input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    font-size: 15px;
    font-weight: 600;
    color: #0f172a;
    font-family: inherit;
    min-width: 0;
    appearance: none;
    -webkit-appearance: none;
}
.hhb-overlay-field-inner select option { color: #0f172a; }

.hhb-overlay-submit {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 17px;
    background: var(--hhb-primary);
    color: #fff;
    font-size: 15px;
    font-weight: 800;
    border: none;
    border-radius: 14px;
    cursor: pointer;
    margin-top: 8px;
    letter-spacing: 0.01em;
    transition: background 150ms var(--ease-out),
                transform 130ms var(--ease-out);
}
.hhb-overlay-submit:active { transform: scale(0.98); background: var(--hhb-primary-dk); }
@media (hover: hover) and (pointer: fine) {
    .hhb-overlay-submit:hover { background: var(--hhb-primary-dk); }
}

/* ═══════════════════════════════════════════════════════════════
   SECTION LAYOUT
   ═══════════════════════════════════════════════════════════════ */

.hhb-fp-section     { padding: 80px 24px; }
.hhb-fp-section-alt { background: var(--hhb-surface); }

@media (max-width: 767px) {
    .hhb-fp-section { padding: 52px 20px; }
}

/* Section heading system — editorial with accent line */
.hhb-section-label {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: var(--hhb-primary);
    margin-bottom: 14px;
}
.hhb-section-label::before {
    content: '';
    display: inline-block;
    width: 24px;
    height: 2px;
    background: var(--hhb-primary);
    border-radius: 1px;
}
.hhb-section-heading {
    font-family: 'Outfit', sans-serif !important;
    letter-spacing: -0.025em !important;
    font-weight: 800 !important;
    line-height: 1.15 !important;
}
/* Subtitle under heading */
.hhb-section-sub {
    font-size: 15px;
    color: #64748b;
    line-height: 1.6;
    max-width: 32rem;
}
/* Center-aligned variant */
.text-center .hhb-section-label { justify-content: center; }
.text-center .hhb-section-sub { margin-left: auto; margin-right: auto; }

/* Dark section heading overrides */
.hhb-fp-section-dark .hhb-section-label { color: var(--hhb-primary); }
.hhb-fp-section-dark .hhb-section-label::before { background: var(--hhb-primary); }
.hhb-fp-section-dark .hhb-section-sub { color: rgba(240,235,228,0.45); }

/* ═══════════════════════════════════════════════════════════════
   TRUST CARDS
   ═══════════════════════════════════════════════════════════════ */

.hhb-trust-card {
    text-align: center;
    padding: 32px 20px;
    border-radius: 20px;
    background: #fff;
    border: 1px solid var(--hhb-border);
    /* Only transition the properties that will animate */
    transition: transform 220ms var(--ease-out),
                box-shadow 220ms var(--ease-out);
}
@media (hover: hover) and (pointer: fine) {
    .hhb-trust-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 36px rgba(0,0,0,0.07);
    }
}
.hhb-trust-icon {
    width: 56px; height: 56px;
    border-radius: 16px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #fff5f0 0%, #fde8df 100%);
    color: var(--hhb-primary);
    margin-bottom: 16px;
    font-size: 26px;
}

/* Mobile: horizontal scroll */
@media (max-width: 767px) {
    .hhb-trust-grid {
        display: flex !important;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        gap: 12px;
        padding-bottom: 16px;
        margin-left: -20px;
        margin-right: -20px;
        padding-left: 20px;
        padding-right: 20px;
        scrollbar-width: none;
    }
    .hhb-trust-grid::-webkit-scrollbar { display: none; }
    .hhb-trust-grid > .hhb-trust-card { flex: 0 0 200px; scroll-snap-align: start; }
}

/* ═══════════════════════════════════════════════════════════════
   PROPERTY CARDS (Featured + Newly Listed)
   ═══════════════════════════════════════════════════════════════ */

/* ═══════════════════════════════════════════════════════════════
   FUTURISTIC PROPERTY CARDS (Apple TV / Netflix style)
   ═══════════════════════════════════════════════════════════════ */

/* Sibling fade effect on grid */
/* ═══════════════════════════════════════════════════════════════
   FEATURED PROPERTY CARDS (Static Overlay Layout)
   ═══════════════════════════════════════════════════════════════ */

.hhb-prop-card-futuristic {
    position: relative;
    border-radius: 4px; /* subtle border radius like normal cards */
    background: #fff;
    overflow: hidden;
    cursor: pointer;
    text-decoration: none;
    aspect-ratio: 4/5;
    transition: box-shadow 0.4s ease, transform 0.4s ease;
    border: 1px solid rgba(255,255,255,0.1);
}

.hhb-prop-card-futuristic:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.15);
}

/* Card Image Wrapper */
.hhb-prop-card-img-wrap {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
    background: #e2e8f0;
}
.hhb-prop-card-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.8s ease;
}
.hhb-prop-card-futuristic:hover .hhb-prop-card-img-wrap img {
    transform: scale(1.05); /* very subtle pan/zoom on hover */
}

/* Gradient Overlay for Text Readability */
.hhb-prop-card-gradient {
    position: absolute;
    inset: 0;
    z-index: 2;
    background: linear-gradient(to top, rgba(15,23,42,0.95) 0%, rgba(15,23,42,0.5) 45%, transparent 100%);
    opacity: 0.95;
    transition: background 0.4s ease, opacity 0.4s ease, backdrop-filter 0.4s ease;
}
.hhb-prop-card-futuristic:hover .hhb-prop-card-gradient {
    background: rgba(255, 255, 255, 0.4); /* Frosty white overlay */
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    opacity: 1;
}

/* Glassmorphism Text Inversion on Hover */
.hhb-prop-card-futuristic * {
    transition: color 0.4s ease, border-color 0.4s ease, background-color 0.4s ease;
}
.hhb-prop-card-futuristic:hover h3,
.hhb-prop-card-futuristic:hover .text-white { color: #0f172a !important; }
.hhb-prop-card-futuristic:hover .text-slate-300,
.hhb-prop-card-futuristic:hover .text-white\/90 { color: #334155 !important; }
.hhb-prop-card-futuristic:hover .text-white\/60,
.hhb-prop-card-futuristic:hover .text-white\/50 { color: #64748b !important; }
.hhb-prop-card-futuristic:hover .border-t { border-top-color: rgba(0,0,0,0.1) !important; }
.hhb-prop-card-futuristic:hover a.border-white\/20 { border-color: rgba(0,0,0,0.15) !important; }
.hhb-prop-card-futuristic:hover a.bg-white\/10 { 
    background-color: transparent !important; 
    color: #0f172a !important; 
}
.hhb-prop-card-futuristic:hover a.bg-white\/10:hover { 
    background-color: var(--hhb-primary) !important; 
    border-color: var(--hhb-primary) !important; 
    color: #fff !important; 
}

/* Content wrapper fixed to bottom */
.hhb-prop-card-content {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 24px;
    z-index: 3;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
}

/* Details ALWAYS visible now */
.hhb-prop-card-details {
    display: block;
    margin-top: 8px;
}
    background: var(--hhb-surface);
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    color: #475569;
}
.hhb-prop-card-meta-item .material-symbols-outlined { font-size: 15px; color: var(--hhb-primary); }

/* View details — prominent CTA */
.hhb-view-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    width: 100%;
    padding: 14px;
    background: var(--hhb-primary);
    color: #fff;
    font-weight: 700;
    font-size: 13px;
    text-align: center;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    letter-spacing: 0.02em;
    text-decoration: none;
    transition: background 140ms var(--ease-out),
                transform 120ms var(--ease-out),
                box-shadow 140ms var(--ease-out);
}
.hhb-view-btn:active { transform: scale(0.97); }
.hhb-view-btn .material-symbols-outlined { font-size: 16px; transition: transform 160ms var(--ease-out); }
@media (hover: hover) and (pointer: fine) {
    .hhb-view-btn:hover {
        background: var(--hhb-primary-dk);
        box-shadow: 0 6px 20px rgba(232,94,48,0.30);
    }
    .hhb-view-btn:hover .material-symbols-outlined { transform: translateX(3px); }
}

/* Mobile: horizontal scroll for featured cards */
@media (max-width: 767px) {
    .hhb-featured-grid {
        display: flex !important;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        gap: 16px;
        padding-bottom: 20px;
        margin-left: -20px;
        margin-right: -20px;
        padding-left: 20px;
        padding-right: 20px;
        scrollbar-width: none;
    }
    .hhb-featured-grid::-webkit-scrollbar { display: none; }
    .hhb-featured-grid > article {
        flex: 0 0 82vw;
        max-width: 320px;
        scroll-snap-align: start;
        min-width: 0;
    }
    .hhb-scroll-hint-dots {
        display: flex;
        justify-content: center;
        gap: 6px;
        margin-top: 16px;
    }
    .hhb-scroll-hint-dots span {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: #e2e8f0;
        /* Specify exact property */
        transition: background 200ms var(--ease-out),
                    width 200ms var(--ease-out),
                    border-radius 200ms var(--ease-out);
    }
    .hhb-scroll-hint-dots span.active { background: var(--hhb-primary); width: 18px; border-radius: 3px; }
}
@media (min-width: 768px) { .hhb-scroll-hint-dots { display: none; } }

/* ═══════════════════════════════════════════════════════════════
   NEWLY LISTED — compact card
   ═══════════════════════════════════════════════════════════════ */

.hhb-new-card {
    display: block;
    background: var(--hhb-surface);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid rgba(240,236,232,0.60);
    text-decoration: none;
    transition: transform 220ms var(--ease-out),
                box-shadow 220ms var(--ease-out);
}
@media (hover: hover) and (pointer: fine) {
    .hhb-new-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 18px 36px rgba(0,0,0,0.07);
    }
}
.hhb-new-card-img {
    position: relative;
    aspect-ratio: 4/3;
    overflow: hidden;
    background: #dde1e7;
}
.hhb-new-card-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 480ms var(--ease-out);
}
@media (hover: hover) and (pointer: fine) {
    .hhb-new-card:hover .hhb-new-card-img img { transform: scale(1.05); }
}
.hhb-new-card-body { padding: 18px; }
.hhb-new-card-title {
    font-weight: 700;
    font-size: 16px;
    color: #0f172a;
    line-height: 1.35;
    margin-bottom: 4px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.hhb-new-card-loc { font-size: 13px; color: #64748b; margin-bottom: 12px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.hhb-new-card-meta { display: flex; gap: 12px; font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 14px; }
.hhb-new-card-meta span { display: flex; align-items: center; gap: 4px; }
.hhb-new-card-meta .material-symbols-outlined { font-size: 15px; color: var(--hhb-primary); }
.hhb-new-card-footer {
    padding-top: 14px;
    border-top: 1px dashed #e2e8f0;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
}
.hhb-new-card-price { font-size: 17px; font-weight: 800; color: #0f172a; line-height: 1; }
.hhb-new-card-price-label { font-size: 9px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.07em; }
.hhb-new-card-arrow {
    width: 32px; height: 32px;
    border-radius: 50%;
    background: #fff;
    border: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--hhb-primary);
    transition: background 140ms var(--ease-out),
                border-color 140ms var(--ease-out),
                color 140ms var(--ease-out);
}
.hhb-new-card-arrow .material-symbols-outlined { font-size: 14px; }
@media (hover: hover) and (pointer: fine) {
    .hhb-new-card:hover .hhb-new-card-arrow {
        background: var(--hhb-primary);
        border-color: var(--hhb-primary);
        color: #fff;
    }
}

/* ═══════════════════════════════════════════════════════════════
   DESTINATION CARDS
   ═══════════════════════════════════════════════════════════════ */

.hhb-dest-card {
    position: relative;
    border-radius: 18px;
    overflow: hidden;
    aspect-ratio: 4/3;
    cursor: pointer;
    display: block;
    background: #1a1a1a;
    text-decoration: none;
    transition: transform 220ms var(--ease-out),
                box-shadow 220ms var(--ease-out);
}
@media (hover: hover) and (pointer: fine) {
    .hhb-dest-card:hover {
        transform: scale(1.02);
        box-shadow: 0 16px 40px rgba(0,0,0,0.20);
    }
}
.hhb-dest-card img {
    width: 100%; height: 100%;
    object-fit: cover;
    opacity: 0.80;
    transition: transform 500ms var(--ease-out),
                opacity 300ms var(--ease-out);
}
@media (hover: hover) and (pointer: fine) {
    .hhb-dest-card:hover img { transform: scale(1.08); opacity: 0.92; }
}
.hhb-dest-card-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 35%, rgba(0,0,0,0.75) 100%);
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 20px;
}
.hhb-dest-card-name {
    color: #fff;
    font-weight: 800;
    font-size: 18px;
    line-height: 1.2;
    letter-spacing: -0.01em;
}
.hhb-dest-card-count {
    color: rgba(255,255,255,0.72);
    font-size: 12px;
    font-weight: 600;
    margin-top: 3px;
}

/* ═══════════════════════════════════════════════════════════════
   HOW IT WORKS — dark section
   ═══════════════════════════════════════════════════════════════ */

.hhb-fp-section-dark {
    background: var(--hhb-dark);
    position: relative;
    overflow: hidden;
}
.hhb-fp-section-dark::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 70% 50% at 50% 0%, rgba(232,94,48,0.09) 0%, transparent 65%),
        radial-gradient(ellipse 40% 40% at 0% 100%, rgba(232,94,48,0.04) 0%, transparent 60%);
    pointer-events: none;
}
.hhb-fp-section-dark .hhb-section-heading,
.hhb-fp-section-dark h2 { color: #f0ebe4 !important; }
.hhb-fp-section-dark .hhb-dark-sub { color: rgba(240,235,228,0.50) !important; }

.hhb-step-card-dark {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 20px;
    padding: 28px 24px;
    position: relative;
    overflow: hidden;
    /* Specific properties — not all */
    transition: background 240ms var(--ease-out),
                border-color 240ms var(--ease-out),
                transform 240ms var(--ease-out);
}
@media (hover: hover) and (pointer: fine) {
    .hhb-step-card-dark:hover {
        background: rgba(232,94,48,0.07);
        border-color: rgba(232,94,48,0.18);
        transform: translateY(-4px);
    }
}
.hhb-step-card-dark-num {
    position: absolute;
    top: 10px; right: 18px;
    font-size: 80px;
    font-weight: 900;
    line-height: 1;
    color: rgba(232,94,48,0.07);
    font-family: 'Outfit', sans-serif;
    pointer-events: none;
    user-select: none;
}
.hhb-step-card-dark-icon {
    width: 48px; height: 48px;
    border-radius: 14px;
    background: rgba(232,94,48,0.13);
    color: var(--hhb-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 18px;
    flex-shrink: 0;
}
.hhb-step-card-dark-title { font-size: 16px; font-weight: 700; color: #f0ebe4; margin-bottom: 8px; }
.hhb-step-card-dark-desc  { font-size: 13px; color: rgba(240,235,228,0.48); line-height: 1.65; }

@media (max-width: 767px) {
    .hhb-steps-dark-grid {
        display: flex !important;
        flex-direction: column;
        gap: 0;
        position: relative;
        padding-left: 20px;
    }
    .hhb-steps-dark-grid::before {
        content: '';
        position: absolute;
        left: 44px; top: 24px; bottom: 24px;
        width: 1px;
        background: linear-gradient(to bottom, rgba(232,94,48,0.45), rgba(232,94,48,0.05));
    }
    .hhb-step-card-dark {
        display: flex;
        gap: 18px;
        align-items: flex-start;
        background: transparent;
        border: none;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        border-radius: 0;
        padding: 24px 0;
        transform: none !important;
    }
    .hhb-step-card-dark:last-child { border-bottom: none; }
    @media (hover: hover) and (pointer: fine) {
        .hhb-step-card-dark:hover { background: transparent; border-color: transparent; border-bottom-color: rgba(255,255,255,0.05); }
    }
    .hhb-step-card-dark-icon { flex-shrink: 0; margin-bottom: 0; position: relative; z-index: 1; }
    .hhb-step-card-dark-num  { display: none; }
    .hhb-step-card-dark-body { flex: 1; }
}
@media (min-width: 768px) {
    .hhb-step-card-dark-body { display: contents; }
}

/* ═══════════════════════════════════════════════════════════════
   REVIEW CARDS
   ═══════════════════════════════════════════════════════════════ */

.hhb-review-card {
    background: #fff;
    border-radius: 20px;
    padding: 28px;
    border: 1px solid var(--hhb-border);
    transition: box-shadow 200ms var(--ease-out);
}
@media (hover: hover) and (pointer: fine) {
    .hhb-review-card:hover { box-shadow: 0 10px 28px rgba(0,0,0,0.06); }
}
.hhb-review-stars { color: #f59e0b; font-size: 15px; letter-spacing: 2px; }
.hhb-review-quote {
    font-size: 40px;
    line-height: 1;
    color: rgba(232,94,48,0.12);
    font-family: Georgia, serif;
    margin-bottom: -10px;
}

/* ═══════════════════════════════════════════════════════════════
   BLOG CARDS
   ═══════════════════════════════════════════════════════════════ */

.hhb-blog-card {
    display: flex;
    flex-direction: column;
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--hhb-border);
    text-decoration: none;
    height: 100%;
    transition: transform 220ms var(--ease-out),
                box-shadow 220ms var(--ease-out);
}
@media (hover: hover) and (pointer: fine) {
    .hhb-blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 18px 36px rgba(0,0,0,0.08);
    }
}
.hhb-blog-card-img {
    width: 100%;
    aspect-ratio: 16/10;
    overflow: hidden;
    background: #f1f5f9;
    flex-shrink: 0;
    position: relative;
}
.hhb-blog-card-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 480ms var(--ease-out);
}
@media (hover: hover) and (pointer: fine) {
    .hhb-blog-card:hover .hhb-blog-card-img img { transform: scale(1.05); }
}
.hhb-blog-cat-badge {
    position: absolute;
    top: 12px; left: 12px;
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(8px);
    color: var(--hhb-primary);
    font-size: 9px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.10em;
    padding: 4px 10px;
    border-radius: 999px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
.hhb-blog-card-body { padding: 20px; display: flex; flex-direction: column; flex: 1; }
.hhb-blog-date { font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 8px; }
.hhb-blog-title {
    font-weight: 700;
    font-size: 15px;
    color: #0f172a;
    line-height: 1.45;
    margin-bottom: auto;
    padding-bottom: 16px;
    transition: color 140ms var(--ease-out);
}
@media (hover: hover) and (pointer: fine) {
    .hhb-blog-card:hover .hhb-blog-title { color: var(--hhb-primary); }
}
.hhb-blog-read-more {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 800;
    color: var(--hhb-primary);
    text-transform: uppercase;
    letter-spacing: 0.10em;
    transition: gap 160ms var(--ease-out);
}
@media (hover: hover) and (pointer: fine) {
    .hhb-blog-card:hover .hhb-blog-read-more { gap: 8px; }
}
.hhb-blog-read-more .material-symbols-outlined { font-size: 15px; }
</style>

<!-- ═══════════════════════════════════════════════════════════════
     SECTION 1 — HERO
     ═══════════════════════════════════════════════════════════════ -->
<section class="hhb-fp-hero">

    <!-- Background photo with cinematic zoom wrapper -->
    <div class="hhb-fp-hero-zoom">
        <div class="hhb-fp-hero-bg" style="background-image: url('<?php echo esc_url( $hero_img ); ?>')"></div>
    </div>

    <!-- Atmospheric overlays -->
    <div class="hhb-fp-hero-overlay"></div>
    <div class="hhb-fp-hero-dots" aria-hidden="true"></div>
    <div class="hhb-fp-hero-glow"></div>
    <div class="hhb-fp-hero-mist"></div>

    <!-- Snow particles (pure CSS) -->
    <div class="hhb-snow-wrap" aria-hidden="true"><?php
        $particles = [
            ['left'=>'8%',  'size'=>'2px',   'dur'=>'14s', 'delay'=>'0s'],
            ['left'=>'15%', 'size'=>'1.5px', 'dur'=>'18s', 'delay'=>'3s'],
            ['left'=>'23%', 'size'=>'2.5px', 'dur'=>'12s', 'delay'=>'1.5s'],
            ['left'=>'31%', 'size'=>'1px',   'dur'=>'20s', 'delay'=>'5s'],
            ['left'=>'40%', 'size'=>'2px',   'dur'=>'15s', 'delay'=>'2.5s'],
            ['left'=>'47%', 'size'=>'1.5px', 'dur'=>'17s', 'delay'=>'7s'],
            ['left'=>'55%', 'size'=>'3px',   'dur'=>'11s', 'delay'=>'0.8s'],
            ['left'=>'62%', 'size'=>'1px',   'dur'=>'22s', 'delay'=>'4s'],
            ['left'=>'70%', 'size'=>'2px',   'dur'=>'13s', 'delay'=>'6s'],
            ['left'=>'78%', 'size'=>'1.5px', 'dur'=>'16s', 'delay'=>'1s'],
            ['left'=>'85%', 'size'=>'2.5px', 'dur'=>'19s', 'delay'=>'3.5s'],
            ['left'=>'91%', 'size'=>'1px',   'dur'=>'14s', 'delay'=>'8s'],
        ];
        foreach ( $particles as $p ) {
            echo '<span class="hhb-snow-p" style="left:' . $p['left'] . ';width:' . $p['size'] . ';height:' . $p['size'] . ';animation-duration:' . $p['dur'] . ';animation-delay:' . $p['delay'] . ';"></span>';
        }
    ?></div>

    <!-- Hero content -->
    <div class="relative z-10 text-center px-4 max-w-5xl mx-auto w-full">

        <!-- Badge — subtle glass pill with glowing dot -->
        <div class="flex justify-center">
            <span class="hhb-hero-badge">
                <span class="hhb-hero-badge-dot"></span>
                Curated Mountain Stays
            </span>
        </div>

        <!-- Heading — editorial split with accent italic line -->
        <?php
        // Split heading: first phrase normal, last word(s) italic accent
        $h1_words = explode( ' ', $hero_h1 );
        $accent_count = min( 2, max( 1, (int) ceil( count( $h1_words ) / 3 ) ) );
        $main_part   = implode( ' ', array_slice( $h1_words, 0, count( $h1_words ) - $accent_count ) );
        $accent_part = implode( ' ', array_slice( $h1_words, -$accent_count ) );
        ?>
        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl text-white mb-5 sm:mb-6">
            <?php echo esc_html( $main_part ); ?>
            <span class="hhb-hero-h1-accent"><?php echo esc_html( $accent_part ); ?></span>
        </h1>

        <!-- Subtitle -->
        <p class="hhb-fp-hero-sub">
            <?php echo esc_html( $hero_sub ); ?>
        </p>

        <!-- Social proof stat strip -->
        <?php
        $total_homestays = wp_count_posts( 'hhb_homestay' )->publish ?? 0;
        $total_locations = $locations && ! is_wp_error( $locations ) ? count( $locations ) : 0;
        ?>
        <?php if ( $total_homestays > 0 ) : ?>
        <div class="hhb-hero-stats">
            <div class="hhb-hero-stat">
                <span class="hhb-hero-stat-num"><?php echo esc_html( $total_homestays ); ?>+</span>
                <span class="hhb-hero-stat-label">Verified Stays</span>
            </div>
            <div class="hhb-hero-stat-divider"></div>
            <div class="hhb-hero-stat">
                <span class="hhb-hero-stat-num"><?php echo esc_html( max( $total_locations, 5 ) ); ?>+</span>
                <span class="hhb-hero-stat-label">Destinations</span>
            </div>
            <div class="hhb-hero-stat-divider"></div>
            <div class="hhb-hero-stat">
                <span class="hhb-hero-stat-num">4.8</span>
                <span class="hhb-hero-stat-label">Guest Rating</span>
            </div>
        </div>
        <?php endif; ?>

        <!-- Mobile search pill -->
        <button type="button" class="hhb-mobile-search-pill" id="hhb-open-search-overlay" aria-label="Search stays">
            <span class="pill-text">Where are you going?</span>
            <span class="pill-icon">
                <span class="material-symbols-outlined" style="font-size:18px;">search</span>
            </span>
        </button>

        <!-- Desktop search bar -->
        <div class="hhb-fp-search-bar p-2 sm:p-3 rounded-2xl max-w-3xl mx-auto mb-5 sm:mb-6">
            <form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'hhb_homestay' ) ); ?>" class="flex flex-col md:flex-row items-stretch md:items-center gap-1 md:gap-0">

                <!-- Location -->
                <div class="flex items-center gap-3 px-4 py-2.5 w-full">
                    <span class="material-symbols-outlined text-primary text-xl flex-shrink-0">location_on</span>
                    <div class="flex-1 min-w-0 relative" id="hhb-fp-loc-wrap">
                        <span class="hhb-search-label">Location</span>
                        <input type="text" name="location" id="hhb-fp-loc-input" placeholder="Where are you going?" class="block w-full bg-transparent border-none focus:outline-none text-sm font-medium placeholder-slate-400" autocomplete="off">
                    </div>
                </div>

                <div class="hidden md:block w-px h-8 bg-white/20 flex-shrink-0 self-center"></div>

                <!-- Dates -->
                <div class="flex items-center gap-3 px-4 py-2.5 w-full">
                    <span class="material-symbols-outlined text-primary text-xl flex-shrink-0">calendar_month</span>
                    <div class="flex-1 min-w-0">
                        <span class="hhb-search-label">Check-in</span>
                        <input type="date" name="checkin" class="block w-full">
                    </div>
                </div>

                <div class="hidden md:block w-px h-8 bg-white/20 flex-shrink-0 self-center"></div>

                <!-- Guests -->
                <div class="flex items-center gap-3 px-4 py-2.5 w-full">
                    <span class="material-symbols-outlined text-primary text-xl flex-shrink-0">group</span>
                    <div class="flex-1 min-w-0 relative" id="hhb-guests-wrap">
                        <span class="hhb-search-label">Guests</span>
                        <input type="hidden" name="guests" id="hhb-guests-val" autocomplete="off">
                        <button type="button" id="hhb-guests-btn" class="hhb-custom-select-btn" aria-expanded="false" aria-haspopup="listbox">
                            <span class="hhb-select-label-text" id="hhb-guests-text">Add guests</span>
                            <svg class="hhb-select-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                        <div id="hhb-guests-drop" class="hhb-custom-select-drop" role="listbox" aria-label="Number of guests">
                            <button type="button" data-value="" class="hhb-select-opt hhb-select-opt-placeholder" role="option">Add guests</button>
                            <?php for ( $i = 1; $i <= 10; $i++ ) : ?>
                                <button type="button" data-value="<?php echo $i; ?>" class="hhb-select-opt" role="option"><?php echo $i; ?> Guest<?php echo $i > 1 ? 's' : ''; ?></button>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>

                <!-- Search submit -->
                <button type="submit" class="hhb-hero-btn-primary flex-shrink-0 w-full md:w-auto mt-2 md:mt-0 flex items-center justify-center gap-2 px-7 py-4 bg-primary text-white font-bold rounded-xl text-sm shadow-lg">
                    <span class="material-symbols-outlined text-lg">search</span>
                    <span>Search</span>
                </button>
            </form>
        </div>

        <!-- CTA buttons -->
        <div class="hhb-hero-ctas flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'hhb_homestay' ) ); ?>"
               class="hhb-hero-btn-primary w-full sm:w-auto text-center px-8 py-3.5 bg-primary text-white font-bold rounded-xl text-xs shadow-lg tracking-wide uppercase">
                Browse Stays
            </a>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'hhb_homestay' ) ); ?>"
               class="hhb-hero-btn-outline w-full sm:w-auto text-center px-8 py-3.5 bg-transparent border-2 border-white/70 text-white font-bold rounded-xl text-xs tracking-wide uppercase">
                Check Availability
            </a>
        </div>

    </div>

    <!-- Scroll hint -->
    <div class="hhb-scroll-hint" onclick="window.scrollBy({top: window.innerHeight * 0.8, behavior:'smooth'})" aria-hidden="true">
        <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
        Scroll
    </div>

</section>

<script>
(function () {
    /* ── Animated dropdown system ──
       Uses is-open class (opacity+scale) instead of display:none
       so transitions can run properly.                           */
    function initDrop(wrapId, btnId, dropId, valId, txtId, placeholder) {
        var wrap = document.getElementById(wrapId);
        if (!wrap) return;
        var btn  = document.getElementById(btnId);
        var drop = document.getElementById(dropId);
        var val  = document.getElementById(valId);
        var txt  = document.getElementById(txtId);

        function open() {
            drop.classList.add('is-open');
            wrap.classList.add('hhb-location-open');
            btn.setAttribute('aria-expanded', 'true');
        }
        function close() {
            drop.classList.remove('is-open');
            wrap.classList.remove('hhb-location-open');
            btn.setAttribute('aria-expanded', 'false');
        }
        function isOpen() { return drop.classList.contains('is-open'); }

        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            /* Close all other dropdowns first */
            document.querySelectorAll('.hhb-custom-select-drop').forEach(function (d) {
                if (d !== drop && d.classList.contains('is-open')) {
                    d.classList.remove('is-open');
                    var w = d.closest('[id$="-wrap"]');
                    if (w) w.classList.remove('hhb-location-open');
                    var b = w ? w.querySelector('[aria-expanded]') : null;
                    if (b) b.setAttribute('aria-expanded', 'false');
                }
            });
            isOpen() ? close() : open();
        });

        drop.querySelectorAll('.hhb-select-opt').forEach(function (opt) {
            opt.addEventListener('click', function () {
                val.value = this.dataset.value;
                txt.textContent = this.dataset.value ? this.textContent.trim() : placeholder;
                drop.querySelectorAll('.hhb-select-opt').forEach(function (o) { o.classList.remove('is-active'); });
                if (this.dataset.value) this.classList.add('is-active');
                close();
            });
        });

        document.addEventListener('click', function (e) {
            if (!wrap.contains(e.target)) close();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && isOpen()) { close(); btn.focus(); }
        });
    }

    initDrop('hhb-guests-wrap', 'hhb-guests-btn', 'hhb-guests-drop', 'hhb-guests-val', 'hhb-guests-text', 'Add guests');

    // ── Front-page location suggestions ──
    (function() {
        var input  = document.getElementById('hhb-fp-loc-input');
        var panel  = document.getElementById('hhb-fp-suggestions');
        if (!input || !panel) return;

        function openSug() { panel.classList.add('is-open'); }
        function closeSug() { panel.classList.remove('is-open'); }

        input.addEventListener('focus', openSug);
        input.addEventListener('input', openSug);

        panel.querySelectorAll('.hhb-fp-sug-item').forEach(function(btn) {
            btn.addEventListener('mousedown', function(e) {
                e.preventDefault();
                input.value = this.dataset.value;
                closeSug();
                input.closest('form').submit();
            });
        });

        document.addEventListener('click', function(e) {
            if (!input.contains(e.target) && !panel.contains(e.target)) closeSug();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') { closeSug(); input.blur(); }
        });
    }());
}());
</script>

<!-- Mobile Search Overlay -->
<div class="hhb-search-overlay" id="hhb-search-overlay" role="dialog" aria-modal="true" aria-label="Search stays">
    <div class="hhb-search-overlay-panel">
        <div class="hhb-overlay-header">
            <span class="hhb-overlay-title">Find your stay</span>
            <button type="button" class="hhb-overlay-close" id="hhb-close-search-overlay" aria-label="Close search">
                <span class="material-symbols-outlined" style="font-size:20px;">close</span>
            </button>
        </div>
        <form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'hhb_homestay' ) ); ?>">
            <div class="hhb-overlay-field">
                <label class="hhb-overlay-label">Location</label>
                <div class="hhb-overlay-field-inner">
                    <span class="material-symbols-outlined">location_on</span>
                    <input type="text" name="location" placeholder="Where are you going?" style="background:transparent;border:none;outline:none;width:100%;font-size:14px;font-weight:600;" autocomplete="off">
                </div>
            </div>
            <div class="hhb-overlay-field">
                <label class="hhb-overlay-label">Check-in Date</label>
                <div class="hhb-overlay-field-inner">
                    <span class="material-symbols-outlined">calendar_month</span>
                    <input type="date" name="checkin" placeholder="Select date">
                </div>
            </div>
            <div class="hhb-overlay-field">
                <label class="hhb-overlay-label">Guests</label>
                <div class="hhb-overlay-field-inner">
                    <span class="material-symbols-outlined">group</span>
                    <select name="guests">
                        <option value="">Add guests</option>
                        <?php for ( $i = 1; $i <= 10; $i++ ) : ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?> Guest<?php echo $i > 1 ? 's' : ''; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="hhb-overlay-submit">
                <span class="material-symbols-outlined" style="font-size:20px;">search</span>
                Search Stays
            </button>
        </form>
    </div>
</div>

<script>
(function () {
    var overlay  = document.getElementById('hhb-search-overlay');
    var openBtn  = document.getElementById('hhb-open-search-overlay');
    var closeBtn = document.getElementById('hhb-close-search-overlay');
    if (!overlay || !openBtn || !closeBtn) return;

    function openOverlay()  { overlay.classList.add('is-open');    document.body.style.overflow = 'hidden'; openBtn.setAttribute('aria-expanded', 'true'); }
    function closeOverlay() { overlay.classList.remove('is-open'); document.body.style.overflow = '';       openBtn.setAttribute('aria-expanded', 'false'); }

    openBtn.addEventListener('click', openOverlay);
    closeBtn.addEventListener('click', closeOverlay);
    overlay.addEventListener('click', function (e) { if (e.target === overlay) closeOverlay(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeOverlay(); });
}());
</script>


<!-- ═══════════════════════════════════════════════════════════════
     SECTION 2 — WHY CHOOSE US
     ═══════════════════════════════════════════════════════════════ -->
<section class="hhb-fp-section hhb-fp-section-alt">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-14 hhb-reveal">
            <span class="hhb-section-label">Why Himalayan Homestay</span>
            <h2 class="text-3xl md:text-4xl text-slate-900 mb-4 hhb-section-heading">
                <?php echo esc_html( get_theme_mod( 'hhb_trust_heading', 'Why Book With Us' ) ); ?>
            </h2>
            <p class="hhb-section-sub">
                <?php echo esc_html( get_theme_mod( 'hhb_trust_subheading', 'We do things differently — no middlemen, no inflated prices, just honest mountain hospitality.' ) ); ?>
            </p>
        </div>
        <div class="hhb-trust-grid hhb-stagger grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
            <?php foreach ( $trust_cards as $card ) : ?>
                <div class="hhb-trust-card hhb-reveal">
                    <div class="hhb-trust-icon">
                        <span class="material-symbols-outlined"><?php echo esc_html( $card['icon'] ); ?></span>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 mb-2"><?php echo esc_html( $card['title'] ); ?></h3>
                    <p class="text-xs text-slate-500 leading-relaxed"><?php echo esc_html( $card['desc'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════
     SECTION 3 — FEATURED STAYS
     ═══════════════════════════════════════════════════════════════ -->
<section class="hhb-fp-section">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-end justify-between mb-24 mt-8">
            <div class="hhb-reveal">
                <span class="hhb-section-label"><?php echo esc_html( get_theme_mod( 'hhb_featured_label', 'Best Sellers' ) ); ?></span>
                <h2 class="text-3xl md:text-4xl text-slate-900 mb-2 hhb-section-heading"><?php echo esc_html( get_theme_mod( 'hhb_featured_heading', 'Featured Stays' ) ); ?></h2>
                <p class="hhb-section-sub"><?php echo esc_html( get_theme_mod( 'hhb_featured_subheading', 'Handpicked properties loved by our guests' ) ); ?></p>
            </div>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'hhb_homestay' ) ); ?>"
               class="text-primary font-bold text-sm hover:underline hidden md:block hhb-reveal"
               style="transition-delay: 200ms;">
                View All →
            </a>
        </div>

        <?php if ( $featured_query->have_posts() ) : ?>
            <div class="hhb-featured-grid hhb-stagger grid grid-cols-1 md:grid-cols-2 lg:grid-cols-<?php echo esc_attr( $featured_cols ); ?> gap-6">
                <?php $card_i = 0; while ( $featured_query->have_posts() ) : $featured_query->the_post(); $card_i++;
                    $price_range  = hhb_get_price_range( get_the_ID() );
                    $max_guests   = get_post_meta( get_the_ID(), 'hhb_max_guests', true ) ?: '2';
                    $bedrooms     = get_post_meta( get_the_ID(), 'hhb_total_bedrooms', true ) ?: '1';
                    $locs         = get_the_terms( get_the_ID(), 'hhb_location' );
                    $types        = get_the_terms( get_the_ID(), 'hhb_property_type' );
                    $city         = get_post_meta( get_the_ID(), 'hhb_city', true );
                    $avg_rating   = 0;
                    $review_count = 0;
                    if ( $table_exists ) {
                        $rating_row = $wpdb->get_row( $wpdb->prepare(
                            "SELECT AVG(rating) AS avg_r, COUNT(*) AS cnt FROM {$reviews_table} WHERE homestay_id = %d AND status = 'approved'",
                            get_the_ID()
                        ) );
                        if ( $rating_row && $rating_row->cnt > 0 ) {
                            $avg_rating   = round( (float) $rating_row->avg_r, 1 );
                            $review_count = (int) $rating_row->cnt;
                        }
                    }
                ?>
                    <?php
                        $loc_name    = ( $locs && ! is_wp_error( $locs ) ) ? $locs[0]->name : '';
                        $display_loc = $city ? $city . ( $loc_name ? ', ' . $loc_name : '' ) : $loc_name;
                    ?>
                    <article class="hhb-prop-card-futuristic hhb-reveal">
                        <!-- Image that slides on hover -->
                        <div class="hhb-prop-card-img-wrap">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'large', [ 'class' => 'w-full h-full object-cover', 'loading' => 'lazy' ] ); ?>
                            <?php else : ?>
                                <div class="flex items-center justify-center w-full h-full" style="background:#e2e8f0;">
                                    <span class="material-symbols-outlined text-4xl text-slate-300">landscape</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Gradient Overlay -->
                        <div class="hhb-prop-card-gradient"></div>

                        <!-- Top Badges Always Visible -->
                        <div class="absolute top-4 left-4 right-4 z-10 flex items-start justify-between">
                            <div class="flex flex-col gap-2">
                                <?php if ( $types && ! is_wp_error( $types ) ) : ?>
                                    <span class="bg-white/90 backdrop-blur-md text-slate-900 text-[10px] font-bold uppercase tracking-wider px-3 py-1.5 rounded-full shadow-sm w-fit">
                                        <?php echo esc_html( $types[0]->name ); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ( $review_count > 0 ) : ?>
                                <span class="flex items-center gap-1 bg-black/50 backdrop-blur-md text-white text-xs font-bold px-2.5 py-1.5 rounded-full">
                                    <span class="material-symbols-outlined text-[13px] text-yellow-400">star</span>
                                    <?php echo esc_html( $avg_rating ); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Floating Content -->
                        <div class="hhb-prop-card-content">
                            <!-- Title & Location -->
                            <div class="mb-1 pointer-events-none">
                                <?php if ( $display_loc ) : ?>
                                    <div class="text-slate-300 text-xs font-medium flex items-center gap-1 mb-1">
                                        📍 <?php echo esc_html( $display_loc ); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <h3 class="text-white text-2xl font-bold leading-tight" style="font-family: 'Outfit', sans-serif;">
                                    <?php the_title(); ?>
                                </h3>
                            </div>

                            <!-- Hidden details revealed on hover -->
                            <div class="hhb-prop-card-details">
                                <div class="text-white/90 text-xs leading-snug mb-4 flex flex-wrap items-center gap-x-1.5 gap-y-1 font-medium">
                                    <span>👥 Up to <?php echo esc_html($max_guests); ?> Guests</span>
                                    <span class="text-white/50">·</span> <span>🏔️ Mountain View</span>
                                    <span class="text-white/50">·</span> <span>📶 Wi-Fi</span>
                                </div>

                                <div class="flex items-center justify-between border-t border-white/20 pt-4 mb-4">
                                    <div class="flex items-center gap-1 text-white">
                                        <span>⭐</span>
                                        <span class="font-bold"><?php echo esc_html( $avg_rating > 0 ? $avg_rating : 'New' ); ?></span>
                                        <?php if ( $review_count > 0 ) : ?>
                                            <span class="text-white/60 text-xs font-medium">(<?php echo esc_html( $review_count ); ?>)</span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="text-white font-bold text-lg">
                                        <?php if ( $price_range ) : ?>
                                            <?php echo esc_html( $price_range['formatted'] ); ?> <span class="text-white/60 text-xs font-normal">/ Night</span>
                                        <?php else : ?>
                                            <span class="text-sm">Price on request</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <a href="<?php the_permalink(); ?>" class="flex items-center justify-center gap-2 w-full py-3 bg-white/10 hover:bg-primary text-white hover:text-white border border-white/20 font-bold rounded-xl transition-colors backdrop-blur-md">
                                    Explore Stay
                                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>

            <!-- Scroll dots (mobile only) -->
            <div class="hhb-scroll-hint-dots" id="hhb-featured-dots" aria-hidden="true">
                <span class="active"></span><span></span><span></span><span></span><span></span><span></span>
            </div>

            <!-- Mobile "View All" -->
            <div class="mt-8 text-center md:hidden">
                <a href="<?php echo esc_url( get_post_type_archive_link( 'hhb_homestay' ) ); ?>" class="text-primary font-bold text-sm hover:underline">
                    View All Stays →
                </a>
            </div>
        <?php else : ?>
            <p class="text-slate-500 text-center py-12">No homestays published yet. Check back soon!</p>
        <?php endif; ?>
    </div>
</section>

<script>
/* Carousel scroll-dot sync */
(function () {
    var grid = document.querySelector('.hhb-featured-grid');
    var dots = document.querySelectorAll('#hhb-featured-dots span');
    if (!grid || !dots.length) return;
    var total = grid.querySelectorAll('article').length;
    grid.addEventListener('scroll', function () {
        var cardW = grid.querySelector('article') ? grid.querySelector('article').offsetWidth + 16 : 1;
        var idx   = Math.round(grid.scrollLeft / cardW);
        idx = Math.max(0, Math.min(idx, total - 1));
        dots.forEach(function (d, i) { d.classList.toggle('active', i === idx); });
    }, { passive: true });
}());
</script>


<!-- ═══════════════════════════════════════════════════════════════
     SECTION 4 — EXPLORE DESTINATIONS
     ═══════════════════════════════════════════════════════════════ -->
<?php
$dest_title    = get_theme_mod( 'hhb_dest_section_title',    'Explore Destinations' );
$dest_subtitle = get_theme_mod( 'hhb_dest_section_subtitle', 'Find your perfect mountain escape by location' );

$featured_destinations = [];
for ( $i = 1; $i <= 8; $i++ ) {
    $term_id      = get_theme_mod( 'hhb_featured_dest_' . $i, '' );
    $custom_image = get_theme_mod( 'hhb_featured_dest_image_' . $i, '' );
    if ( $term_id ) {
        $term = get_term( $term_id, 'hhb_location' );
        if ( $term && ! is_wp_error( $term ) ) {
            $term->custom_image = $custom_image;
            $featured_destinations[] = $term;
        }
    }
}
if ( empty( $featured_destinations ) && $locations && ! is_wp_error( $locations ) ) {
    $featured_destinations = array_slice( $locations, 0, 8 );
}
?>
<?php if ( ! empty( $featured_destinations ) ) : ?>
<section class="hhb-fp-section hhb-fp-section-alt">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-14 hhb-reveal">
            <span class="hhb-section-label">By Location</span>
            <h2 class="text-3xl md:text-4xl text-slate-900 mb-4 hhb-section-heading"><?php echo esc_html( $dest_title ); ?></h2>
            <p class="hhb-section-sub"><?php echo esc_html( $dest_subtitle ); ?></p>
        </div>
        <div class="hhb-stagger grid grid-cols-2 md:grid-cols-4 gap-4">
            <?php foreach ( $featured_destinations as $loc ) :
                $loc_link   = get_term_link( $loc );
                $image_id   = get_term_meta( $loc->term_id, 'hhb_term_image', true );
                $term_image = $image_id ? wp_get_attachment_image_url( $image_id, 'large' ) : 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=800&auto=format&fit=crop';
                $loc_image  = ! empty( $loc->custom_image ) ? $loc->custom_image : $term_image;
            ?>
                <a href="<?php echo esc_url( is_wp_error( $loc_link ) ? '#' : $loc_link ); ?>" class="hhb-dest-card hhb-reveal">
                    <img src="<?php echo esc_url( $loc_image ); ?>" alt="<?php echo esc_attr( $loc->name ); ?>" loading="lazy">
                    <div class="hhb-dest-card-overlay">
                        <div class="hhb-dest-card-name"><?php echo esc_html( $loc->name ); ?></div>
                        <div class="hhb-dest-card-count"><?php echo esc_html( $loc->count ); ?> stay<?php echo $loc->count !== 1 ? 's' : ''; ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>


<!-- ═══════════════════════════════════════════════════════════════
     SECTION 4.1 — NEWLY LISTED
     ═══════════════════════════════════════════════════════════════ -->
<?php
$new_homestays_query = new WP_Query( [
    'post_type'      => 'hhb_homestay',
    'posts_per_page' => 4,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
] );
?>
<?php if ( $new_homestays_query->have_posts() ) : ?>
<section class="hhb-fp-section bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-end justify-between mb-12">
            <div class="hhb-reveal">
                <span class="hhb-section-label">Fresh Arrivals</span>
                <h2 class="text-3xl md:text-4xl text-slate-900 mb-2 hhb-section-heading">Newly Listed</h2>
                <p class="hhb-section-sub">Fresh mountain retreats just added to our collection</p>
            </div>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'hhb_homestay' ) ) . '?orderby=date'; ?>"
               class="text-primary font-bold text-sm hover:underline hidden md:block hhb-reveal"
               style="transition-delay:200ms;">
                View All New →
            </a>
        </div>

        <div class="hhb-stagger grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php while ( $new_homestays_query->have_posts() ) : $new_homestays_query->the_post();
                $price_range = hhb_get_price_range( get_the_ID() );
                $max_guests  = get_post_meta( get_the_ID(), 'hhb_max_guests', true ) ?: '2';
                $bedrooms    = get_post_meta( get_the_ID(), 'hhb_total_bedrooms', true ) ?: '1';
                $locs        = get_the_terms( get_the_ID(), 'hhb_location' );
                $types       = get_the_terms( get_the_ID(), 'hhb_property_type' );
                $type_name   = ( $types && ! is_wp_error( $types ) ) ? $types[0]->name : 'Homestay';
                $city        = get_post_meta( get_the_ID(), 'hhb_city', true );
                $loc_name    = ( $locs && ! is_wp_error( $locs ) ) ? $locs[0]->name : '';
                $display_loc = $city ? $city . ( $loc_name ? ', ' . $loc_name : '' ) : $loc_name;
            ?>
                <a href="<?php the_permalink(); ?>" class="hhb-new-card hhb-reveal">
                    <div class="hhb-new-card-img">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'large', [ 'class' => '', 'loading' => 'lazy' ] ); ?>
                        <?php else : ?>
                            <div class="flex items-center justify-center w-full h-full" style="min-height:180px;">
                                <span class="material-symbols-outlined text-4xl text-slate-300">landscape</span>
                            </div>
                        <?php endif; ?>
                        <span class="hhb-prop-type-badge"><?php echo esc_html( $type_name ); ?></span>
                    </div>
                    <div class="hhb-new-card-body">
                        <div class="hhb-new-card-title"><?php the_title(); ?></div>
                        <?php if ( $display_loc ) : ?>
                            <div class="hhb-new-card-loc" style="margin-bottom:6px;">📍 <?php echo esc_html( $display_loc ); ?></div>
                        <?php endif; ?>
                        
                        <div class="flex flex-wrap items-center gap-x-1.5 gap-y-1 text-slate-500 text-[11px] font-medium mb-4">
                            <span>👥 Up to <?php echo esc_html( $max_guests ); ?> Guests</span>
                            <span class="text-slate-300">·</span> <span>🏔️ Mountain View</span>
                            <span class="text-slate-300">·</span> <span>📶 Wi-Fi</span>
                        </div>
                        
                        <div class="hhb-new-card-footer flex items-center justify-between border-t border-slate-100 pt-3">
                            <div class="flex items-center gap-1 text-slate-800 text-xs font-bold w-1/3">
                                <span>⭐</span> New
                            </div>
                            
                            <div class="flex-1 text-right">
                                <?php if ( $price_range ) : ?>
                                    <span class="text-slate-900 font-bold text-[15px]"><?php echo esc_html( $price_range['formatted'] ); ?></span> <span class="text-slate-400 text-[10px] font-medium">/ Night</span>
                                <?php else : ?>
                                    <span class="text-sm font-semibold text-slate-400">Price TBD</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
<?php endif; ?>


<!-- ═══════════════════════════════════════════════════════════════
     SECTION 4.2 — RECENT TRAVEL GUIDES
     ═══════════════════════════════════════════════════════════════ -->
<?php
$recent_posts = new WP_Query( [
    'post_type'      => 'post',
    'posts_per_page' => 4,
    'post_status'    => 'publish',
] );
?>
<?php if ( $recent_posts->have_posts() ) : ?>
<section class="hhb-fp-section hhb-fp-section-alt">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-end justify-between mb-12">
            <div class="hhb-reveal">
                <span class="hhb-section-label">Travel Guides</span>
                <h2 class="text-3xl md:text-4xl text-slate-900 mb-2 hhb-section-heading">Recent Travel Guides</h2>
                <p class="hhb-section-sub">Stories, tips, and guides from the Himalayas</p>
            </div>
            <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"
               class="text-primary font-bold text-sm hover:underline hidden md:block hhb-reveal"
               style="transition-delay:200ms;">
                Read Blog →
            </a>
        </div>

        <div class="hhb-stagger grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php while ( $recent_posts->have_posts() ) : $recent_posts->the_post();
                $categories = get_the_category();
                $cat_name   = ! empty( $categories ) ? $categories[0]->name : 'Travel';
            ?>
                <a href="<?php the_permalink(); ?>" class="hhb-blog-card hhb-reveal">
                    <div class="hhb-blog-card-img">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'medium_large', [ 'class' => '', 'loading' => 'lazy' ] ); ?>
                        <?php else : ?>
                            <div class="flex items-center justify-center w-full h-full" style="min-height:160px;background:#fef3ee;">
                                <span class="material-symbols-outlined text-4xl" style="color:rgba(232,94,48,0.3);">auto_stories</span>
                            </div>
                        <?php endif; ?>
                        <span class="hhb-blog-cat-badge"><?php echo esc_html( $cat_name ); ?></span>
                    </div>
                    <div class="hhb-blog-card-body">
                        <div class="hhb-blog-date"><?php echo get_the_date(); ?></div>
                        <div class="hhb-blog-title"><?php the_title(); ?></div>
                        <div class="hhb-blog-read-more">
                            Read More <span class="material-symbols-outlined">arrow_right_alt</span>
                        </div>
                    </div>
                </a>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
<?php endif; ?>


<!-- ═══════════════════════════════════════════════════════════════
     SECTION 5 — HOW IT WORKS (Dark)
     ═══════════════════════════════════════════════════════════════ -->
<section class="hhb-fp-section hhb-fp-section-dark">
    <div class="max-w-5xl mx-auto relative z-10">
        <div class="text-center mb-14 hhb-reveal">
            <span class="hhb-section-label">Simple Process</span>
            <h2 class="text-3xl md:text-4xl mb-4 hhb-section-heading">How It Works</h2>
            <p class="hhb-section-sub hhb-dark-sub">Book your perfect mountain stay in four steps</p>
        </div>

        <div class="hhb-steps-dark-grid hhb-stagger grid grid-cols-2 md:grid-cols-4 gap-5">
            <?php foreach ( $steps as $i => $step ) : ?>
                <div class="hhb-step-card-dark hhb-reveal">
                    <span class="hhb-step-card-dark-num"><?php echo $i + 1; ?></span>
                    <div class="hhb-step-card-dark-body">
                        <div class="hhb-step-card-dark-icon">
                            <span class="material-symbols-outlined" style="font-size:22px;"><?php echo esc_html( $step['icon'] ); ?></span>
                        </div>
                        <div class="hhb-step-card-dark-title"><?php echo esc_html( $step['title'] ); ?></div>
                        <div class="hhb-step-card-dark-desc"><?php echo esc_html( $step['desc'] ); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════
     SECTION 6 — GUEST REVIEWS (lazy-loaded)
     ═══════════════════════════════════════════════════════════════ -->
<?php if ( $table_exists ) : ?>
<section id="hhb-reviews-section" class="hhb-fp-section hhb-fp-section-alt">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-14 hhb-reveal">
            <span class="hhb-section-label">Guest Experiences</span>
            <h2 class="text-3xl md:text-4xl text-slate-900 mb-4 hhb-section-heading">What Our Guests Say</h2>
            <p class="hhb-section-sub">Real experiences from real travelers</p>
        </div>

        <div id="hhb-reviews-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php for ( $i = 0; $i < 3; $i++ ) : ?>
                <div class="hhb-review-card animate-pulse opacity-50">
                    <div class="h-4 bg-slate-200 rounded w-1/3 mb-4"></div>
                    <div class="h-4 bg-slate-200 rounded w-full mb-2"></div>
                    <div class="h-4 bg-slate-200 rounded w-5/6 mb-6"></div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-200"></div>
                        <div class="flex-1">
                            <div class="h-3 bg-slate-200 rounded w-1/2 mb-1.5"></div>
                            <div class="h-2 bg-slate-200 rounded w-1/3"></div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var reviewSection = document.getElementById('hhb-reviews-section');
    var reviewGrid    = document.getElementById('hhb-reviews-grid');
    if (!reviewSection || !reviewGrid) return;

    var observer = new IntersectionObserver(function (entries, obs) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            var fd = new FormData();
            fd.append('action', 'hhb_load_reviews');
            fetch('<?php echo admin_url( 'admin-ajax.php' ); ?>', { method: 'POST', body: fd })
                .then(function (r) { return r.json(); })
                .then(function (res) {
                    if (res.success && res.data) {
                        reviewGrid.innerHTML = res.data;
                        /* Trigger reveal — AJAX returns Tailwind opacity-0 translate-y-4 classes */
                        requestAnimationFrame(function () {
                            reviewGrid.querySelectorAll('.opacity-0').forEach(function (el) {
                                el.classList.remove('opacity-0', 'translate-y-4');
                            });
                        });
                    } else {
                        reviewSection.style.display = 'none';
                    }
                })
                .catch(function () { reviewSection.style.display = 'none'; });
            obs.unobserve(entry.target);
        });
    }, { rootMargin: '200px' });

    observer.observe(reviewSection);
});
</script>
<?php endif; ?>


<!-- ═══════════════════════════════════════════════════════════════
     SCROLL REVEAL — IntersectionObserver
     Uses CSS transitions (off main thread) — not JS animation
     ═══════════════════════════════════════════════════════════════ -->
<script>
(function () {
    if (!('IntersectionObserver' in window)) {
        /* Graceful fallback — show everything */
        document.querySelectorAll('.hhb-reveal').forEach(function (el) {
            el.classList.add('is-visible');
        });
        return;
    }

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { rootMargin: '0px 0px -60px 0px', threshold: 0.05 });

    document.querySelectorAll('.hhb-reveal').forEach(function (el) {
        observer.observe(el);
    });
}());
</script>

<?php get_footer(); ?>
