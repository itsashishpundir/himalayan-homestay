<?php
/**
 * Template Name: About Us
 *
 * About page template, fully customizable via WordPress Customizer.
 * Designed with Stitch MCP.
 *
 * @package HimalayanHomestay
 */

get_header();

// ── Customizer Values ──────────────────────────────────────────────
$hero_img      = 'https://images.unsplash.com/photo-1544256718-3b61a34ca536?q=80&w=2940&auto=format&fit=crop';
$hero_head     = 'About Himalayan Homestay';
$hero_sub      = 'Connecting curious travelers with the heart of the mountains through local hospitality.';

// Story Narrative Chapters
$story_title   = 'Where Tradition Meets Travel';

$chapters = [
    1 => [
        'subtitle' => 'The Spark',
        'title'    => 'How It All Started',
        'text'     => 'Founded in the heart of the peaks, Himalayan Homestay was born from a simple realization: the most beautiful parts of the mountains aren\'t the views, but the people who call them home.',
        'image'    => 'https://images.unsplash.com/photo-1516575150278-77136aed6920?q=80&w=2940&auto=format&fit=crop',
    ],
    2 => [
        'subtitle' => 'The Journey',
        'title'    => 'Building the Bridge',
        'text'     => 'We bridge the gap between remote village communities and global travelers, ensuring that every stay supports local livelihoods while offering an unparalleled glimpse into ancient cultures.',
        'image'    => 'https://images.unsplash.com/photo-1533157497230-01dc481bb20f?q=80&w=2940&auto=format&fit=crop',
    ],
    3 => [
        'subtitle' => 'Today',
        'title'    => 'A Growing Community',
        'text'     => 'Today, we work with over 500 hosts across 5 states, empowering local economies and providing travelers with unforgettable memories.',
        'image'    => 'https://images.unsplash.com/photo-1513271169004-9497e7f6dff4?q=80&w=2940&auto=format&fit=crop',
    ]
];

$values_title  = 'Our Core Values';
$values_sub    = 'Guided by the spirit of the mountains';

$v1_icon       = 'verified_user';
$v1_title      = 'Authenticity';
$v1_desc       = 'Real homes, real families, and real experiences. No staged performances, just genuine Himalayan life.';

$v2_icon       = 'eco';
$v2_title      = 'Sustainability';
$v2_desc       = 'Preserving the fragile mountain ecosystem and supporting slow travel that leaves a positive footprint.';

$v3_icon       = 'groups';
$v3_title      = 'Community';
$v3_desc       = 'Empowering local hosts through fair trade and direct economic opportunities for remote villages.';

$quote         = '"Our mission is to ensure that the majesty of the Himalayas is preserved through the wisdom of its people."';
$cta_text      = 'Meet Our Hosts';
$cta_link      = '/hosts';
?>

<style>
/* ── Shared Hero Styles (from Contact Page) ────────────────────── */
.hhb-contact-hero {
    position: relative;
    min-height: 280px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.hhb-contact-hero-bg {
    position: absolute; inset: 0;
    background-size: cover;
    background-position: center;
}
.hhb-contact-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.6) 100%);
}

/* ── Storytelling Timeline Styles ────────────────────── */
.hhb-timeline {
    position: relative;
}
/* Optional Connecting Line (hidden on mobile) */
@media (min-width: 1024px) {
    .hhb-timeline::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 50%;
        width: 2px;
        background: rgba(232, 94, 48, 0.1);
        transform: translateX(-50%);
        z-index: 0;
    }
}
.hhb-chapter {
    position: relative;
    z-index: 1;
}
</style>

<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">

    <!-- Hero Section -->
    <section class="hhb-contact-hero">
        <div class="hhb-contact-hero-bg" style="background-image: url('<?php echo esc_url( $hero_img ); ?>')"></div>
        <div class="hhb-contact-hero-overlay"></div>
        <div class="relative z-10 text-center px-4 py-16">
            <h1 class="text-4xl md:text-5xl font-black text-white mb-3 drop-shadow-lg"><?php echo esc_html( $hero_head ); ?></h1>
            <p class="text-white/80 text-base md:text-lg max-w-xl mx-auto"><?php echo esc_html( $hero_sub ); ?></p>
        </div>
    </section>

    <!-- Narrative Story Timeline -->
    <section class="container mx-auto px-4 lg:px-6 py-20 md:py-32">
        <div class="text-center mb-16 md:mb-24">
            <h2 class="font-serif text-3xl md:text-5xl font-bold text-slate-900 dark:text-slate-100 leading-tight"><?php echo esc_html( $story_title ); ?></h2>
            <div class="w-20 h-1.5 bg-primary rounded-full mx-auto mt-6"></div>
        </div>

        <div class="hhb-timeline space-y-20 lg:space-y-32">
            <?php foreach ( $chapters as $i => $chap ) : 
                if ( empty( $chap['title'] ) ) continue; 
                
                // Determine if Image is on Left or Right based on completely alternating logic (evens flip)
                $is_even = ($i % 2 === 0);
                $img_order  = $is_even ? 'lg:order-first' : 'lg:order-last';
                $text_order = $is_even ? 'lg:order-last' : 'lg:order-first';
                // Adjust text alignment slightly towards the center line
                $text_align = $is_even ? 'lg:pl-16 lg:pr-8' : 'lg:pr-16 lg:pl-8 text-left';
            ?>
            <div class="hhb-chapter grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-0 items-center">
                
                <!-- Text Block -->
                <div class="space-y-4 <?php echo esc_attr( $text_order . ' ' . $text_align ); ?>">
                    <?php if ( $chap['subtitle'] ) : ?>
                        <span class="inline-block px-4 py-1.5 bg-primary/10 text-primary text-xs font-bold uppercase tracking-widest rounded-full mb-2 border border-primary/20">
                            <?php echo esc_html( $chap['subtitle'] ); ?>
                        </span>
                    <?php endif; ?>
                    
                    <h3 class="font-serif text-3xl md:text-4xl font-bold text-slate-900 dark:text-white leading-tight">
                        <?php echo esc_html( $chap['title'] ); ?>
                    </h3>
                    
                    <div class="text-slate-600 dark:text-slate-400 text-base md:text-lg leading-relaxed">
                        <?php echo wp_kses_post( wpautop( $chap['text'] ) ); ?>
                    </div>
                </div>

                <!-- Image Block -->
                <div class="p-4 <?php echo esc_attr( $img_order ); ?>">
                    <div class="rounded-3xl overflow-hidden shadow-xl aspect-square lg:aspect-[4/3] w-full hover:scale-[1.03] transition-transform duration-700 ease-out will-change-transform bg-slate-200 ring-8 ring-white dark:ring-slate-900" 
                         style="background-image: url('<?php echo esc_url( $chap['image'] ); ?>'); background-size: cover; background-position: center;">
                    </div>
                </div>
                
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Core Values Section -->
    <section class="bg-primary/5 px-4 lg:px-6 py-24">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h3 class="font-serif text-3xl md:text-4xl font-bold mb-4 text-slate-900 dark:text-slate-100"><?php echo esc_html( $values_title ); ?></h3>
                <p class="text-slate-500 md:text-lg font-medium tracking-wide"><?php echo esc_html( $values_sub ); ?></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Value 1 -->
                <div class="bg-white p-8 md:p-10 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(232,94,48,0.1)] border border-primary/5 transition-all duration-300 hover:-translate-y-2">
                    <div class="flex size-16 items-center justify-center bg-primary/10 text-primary rounded-2xl mb-6">
                        <span class="material-symbols-outlined text-3xl"><?php echo esc_attr( $v1_icon ); ?></span>
                    </div>
                    <h4 class="font-bold text-xl md:text-2xl mb-4 text-slate-900"><?php echo esc_html( $v1_title ); ?></h4>
                    <p class="text-base text-slate-600 leading-relaxed"><?php echo esc_html( $v1_desc ); ?></p>
                </div>

                <!-- Value 2 -->
                <div class="bg-white p-8 md:p-10 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(232,94,48,0.1)] border border-primary/5 transition-all duration-300 hover:-translate-y-2">
                    <div class="flex size-16 items-center justify-center bg-primary/10 text-primary rounded-2xl mb-6">
                        <span class="material-symbols-outlined text-3xl"><?php echo esc_attr( $v2_icon ); ?></span>
                    </div>
                    <h4 class="font-bold text-xl md:text-2xl mb-4 text-slate-900"><?php echo esc_html( $v2_title ); ?></h4>
                    <p class="text-base text-slate-600 leading-relaxed"><?php echo esc_html( $v2_desc ); ?></p>
                </div>

                <!-- Value 3 -->
                <div class="bg-white p-8 md:p-10 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(232,94,48,0.1)] border border-primary/5 transition-all duration-300 hover:-translate-y-2">
                    <div class="flex size-16 items-center justify-center bg-primary/10 text-primary rounded-2xl mb-6">
                        <span class="material-symbols-outlined text-3xl"><?php echo esc_attr( $v3_icon ); ?></span>
                    </div>
                    <h4 class="font-bold text-xl md:text-2xl mb-4 text-slate-900"><?php echo esc_html( $v3_title ); ?></h4>
                    <p class="text-base text-slate-600 leading-relaxed"><?php echo esc_html( $v3_desc ); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA/Quote -->
    <section class="container mx-auto px-4 lg:px-6 py-24 md:py-32 text-center max-w-4xl">
        <span class="material-symbols-outlined text-primary/20 text-[80px] leading-none block mb-8">format_quote</span>
        <p class="font-serif text-2xl md:text-4xl italic text-slate-800 leading-snug mb-12">
            <?php echo wp_kses_post( $quote ); ?>
        </p>
        <?php if ( $cta_text && $cta_link ) : ?>
            <a href="<?php echo esc_url( $cta_link ); ?>" class="inline-block bg-primary hover:bg-primary/90 text-white px-10 py-5 rounded-full font-bold shadow-xl shadow-primary/30 transition-transform hover:-translate-y-1 text-lg">
                <?php echo esc_html( $cta_text ); ?>
            </a>
        <?php endif; ?>
    </section>

</div>

<?php get_footer(); ?>
