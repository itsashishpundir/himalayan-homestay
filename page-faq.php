<?php
/**
 * Template Name: FAQ Page
 *
 * FAQ page template, with customizable Hero banner and FAQ accordion.
 * Designed with Stitch MCP.
 *
 * @package HimalayanHomestay
 */

get_header();

// ── Customizer Values ──────────────────────────────────────────────
$hero_img      = get_theme_mod( 'hhb_faqpage_banner_image', 'https://images.unsplash.com/photo-1516575150278-77136aed6920?q=80&w=2940&auto=format&fit=crop' );
$hero_head     = get_theme_mod( 'hhb_faqpage_heading', 'Frequently Asked Questions' );
$hero_sub      = get_theme_mod( 'hhb_faqpage_subheading', 'Find quick answers to your most common questions before booking.' );

// Dedicated FAQs configured in the FAQ Page panel repeater
$faq_json = get_theme_mod( 'hhb_faqpage_items', '[]' );
$faqs_raw = json_decode( $faq_json, true );

$faqs = [];
if ( is_array( $faqs_raw ) && ! empty( $faqs_raw ) ) {
    // Sort array by order if present
    usort( $faqs_raw, function($a, $b) {
        return (int)($a['order'] ?? 0) <=> (int)($b['order'] ?? 0);
    });
    foreach ( $faqs_raw as $item ) {
        if ( ! empty( $item['q'] ) ) {
            $faqs[] = [
                'q' => $item['q'],
                'a' => $item['a'] ?? '',
            ];
        }
    }
}

// Fallback default FAQs if none have been configured yet
if ( empty( $faqs ) ) {
    $faqs = [
        [ 'q' => 'How do I book a homestay?', 'a' => 'Browse our listings, select your dates, and complete a quick booking request. Once the host confirms availability, you\'ll receive a secure payment link. Your booking is confirmed after payment.' ],
        [ 'q' => 'What is the cancellation policy?', 'a' => 'Free cancellation up to 7 days before check-in. For cancellations within 7 days, a 50% charge applies. No-shows are charged in full.' ],
        [ 'q' => 'Do you offer airport or bus stand transfers?', 'a' => 'Yes! Most of our homestays can arrange pickup from the nearest bus stand or airport. Contact us after booking to arrange transfers at a nominal additional cost.' ],
        [ 'q' => 'Are your homestays pet-friendly?', 'a' => 'Some of our properties welcome pets. Check individual property pages for pet-friendly badges, or contact us and we\'ll recommend the best options.' ],
        [ 'q' => 'What payment methods do you accept?', 'a' => 'We accept UPI, credit/debit cards, net banking via Razorpay, and international cards via Stripe. All payments are secured with bank-grade encryption.' ],
    ];
}
?>

<style>
/* ── Shared Hero Styles ────────────────────── */
.hhb-faq-hero {
    position: relative;
    min-height: 350px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.hhb-faq-hero-bg {
    position: absolute; inset: 0;
    background-size: cover;
    background-position: center;
}
.hhb-faq-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.6) 100%);
}

/* FAQ Accordion */
.hhb-faq-item {
    border: 1px solid #f1f1f1;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 12px;
    transition: box-shadow 0.3s;
    background: #fff;
}
.hhb-faq-item:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.04); }
.hhb-faq-item summary {
    padding: 24px 20px;
    cursor: pointer;
    font-weight: 700;
    font-size: 16px;
    color: #1e293b;
    list-style: none;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    user-select: none;
}
.hhb-faq-item summary::-webkit-details-marker { display: none; }
.hhb-faq-item summary::after {
    content: '+';
    font-size: 24px;
    font-weight: 300;
    color: #94a3b8;
    transition: transform 0.2s;
}
.hhb-faq-item[open] summary::after { content: '−'; color: #e85e30; }
.hhb-faq-answer {
    padding: 0 20px 24px;
    font-size: 15px;
    color: #64748b;
    line-height: 1.8;
}
</style>

<div class="relative flex min-h-screen w-full flex-col bg-[#f8f6f4]">

    <!-- Hero Section -->
    <section class="hhb-faq-hero">
        <div class="hhb-faq-hero-bg" style="background-image: url('<?php echo esc_url( $hero_img ); ?>')"></div>
        <div class="hhb-faq-hero-overlay"></div>
        <div class="relative z-10 text-center px-4 py-16">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-4 drop-shadow-lg"><?php echo esc_html( $hero_head ); ?></h1>
            <p class="text-white/90 text-lg md:text-xl max-w-2xl mx-auto"><?php echo esc_html( $hero_sub ); ?></p>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="container mx-auto px-4 lg:px-6 py-20 pb-32 max-w-4xl -mt-10 relative z-20">
        <div class="bg-white rounded-3xl p-6 md:p-12 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-primary/5">
            <?php foreach ( $faqs as $i => $faq ) : 
                if ( empty( $faq['q'] ) ) continue;
            ?>
                <details class="hhb-faq-item" <?php echo $i === 0 ? 'open' : ''; ?>>
                    <summary><?php echo esc_html( $faq['q'] ); ?></summary>
                    <div class="hhb-faq-answer"><?php echo esc_html( $faq['a'] ); ?></div>
                </details>
            <?php endforeach; ?>
        </div>
    </section>

</div>

<?php get_footer(); ?>
