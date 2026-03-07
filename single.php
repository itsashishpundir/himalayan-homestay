<?php
/**
 * Single Blog Post Template
 *
 * Redesigned via Google Stitch — cinematic hero image, editorial content
 * layout, sticky Table-of-Contents sidebar, author bio, related posts.
 *
 * @package HimalayanMart
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
the_post();

$post_id    = get_the_ID();
$content    = get_the_content();
$word_count = str_word_count( strip_tags( $content ) );
$read_time  = max( 1, ceil( $word_count / 200 ) );
$thumbnail  = get_the_post_thumbnail_url( $post_id, 'full' ) ?: 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1920&q=80';
$cats       = get_the_category();
$cat        = $cats ? $cats[0] : null;
$author_id  = get_the_author_meta( 'ID' );
$avatar     = get_avatar_url( $author_id, [ 'size' => 80 ] );
$author_bio = get_the_author_meta( 'description' );
$tags       = get_the_tags();
$nonce      = wp_create_nonce( 'hhb_newsletter' );
$share_url  = urlencode( get_permalink() );
$share_title = urlencode( get_the_title() );
?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@400,0&display=swap" rel="stylesheet">

<style>
  :root { --brand:#e85e30; --brand-light:#fef1ec; --bg:#f8f6f6; --border:#e2e8f0; --text:#1a1a2e; --muted:#64748b; }
  .hhm-single *:not(.material-symbols-outlined) { box-sizing:border-box; font-family:'Inter',sans-serif; }
  .hhm-single * { box-sizing:border-box; }
  .hhm-single { background:var(--bg); }

  /* ── HERO IMAGE ── */
  .hhm-post-hero { position:relative; overflow:hidden; border-radius: 12px; margin-bottom: 32px; height: 300px; }
  .hhm-post-hero-img { width:100%; height:100%; object-fit:cover; display:block; }
  @media(min-width:768px) { .hhm-post-hero { height: 450px; } }

  /* ── BODY LAYOUT ── */
  .hhm-post-wrap { max-width:1280px; margin:0 auto; padding:0 24px; }
  .hhm-post-breadcrumb { padding:16px 0; font-size:13px; color:var(--muted); border-bottom:1px solid var(--border); margin-bottom:40px; }
  .hhm-post-breadcrumb a { color:var(--muted); text-decoration:none; }
  .hhm-post-breadcrumb a:hover { color:var(--brand); }
  .hhm-post-body { display:grid; grid-template-columns:1fr 320px; gap:56px; align-items:start; padding-bottom:80px; }
  @media(max-width:960px) { .hhm-post-body { grid-template-columns:1fr; } .hhm-post-sidebar { display:none; } }

  /* ── ARTICLE ── */
  .hhm-article-header { margin-bottom:32px; }
  .hhm-author-card { display:flex; align-items:center; gap:14px; padding:16px 0; border-top:1px solid var(--border); border-bottom:1px solid var(--border); margin-bottom:28px; }
  .hhm-author-avatar { width:48px; height:48px; border-radius:50%; object-fit:cover; border:2px solid var(--brand-light); }
  .hhm-author-name { font-size:15px; font-weight:700; color:var(--text); }
  .hhm-author-meta { font-size:13px; color:var(--muted); display:flex; gap:10px; flex-wrap:wrap; margin-top:2px; }
  .hhm-share-row { display:flex; align-items:center; gap:8px; margin-bottom:32px; flex-wrap:wrap; }
  .hhm-share-label { font-size:13px; font-weight:600; color:var(--muted); margin-right:4px; }
  .hhm-share-btn { display:inline-flex; align-items:center; gap:6px; padding:9px 10px; border-radius:8px; font-size:13px; font-weight:600; text-decoration:none; transition:all 0.2s; white-space:nowrap; }
  @media(min-width:480px) { .hhm-share-btn { padding:8px 14px; } }
  .hhm-share-btn .hhm-btn-label { display:none; }
  @media(min-width:480px) { .hhm-share-btn .hhm-btn-label { display:inline; } }
  .hhm-share-fb { background:#1877f2; color:#fff; }
  .hhm-share-tw { background:#1da1f2; color:#fff; }
  .hhm-share-wa { background:#25d366; color:#fff; }
  .hhm-share-copy { background:var(--bg); color:var(--text); border:1px solid var(--border); cursor:pointer; }
  .hhm-share-btn:hover { opacity:0.88; transform:translateY(-1px); }

  /* ── POST CONTENT STYLES ── */
  .hhm-post-content { font-size:16px; line-height:1.85; color:#374151; }
  @media(min-width:768px) { .hhm-post-content { font-size:17px; } }
  .hhm-post-content p { margin:0 0 24px; }
  .hhm-post-content p:first-of-type::first-letter { font-size:80px; font-weight:900; color:var(--brand); float:left; line-height:0.68; margin:8px 12px -4px 0; font-family:'Inter',sans-serif; }
  .hhm-post-content h2 { font-size:22px; font-weight:800; color:var(--text); margin:36px 0 16px; padding-bottom:10px; border-bottom:2px solid var(--brand-light); position:relative; }
  @media(min-width:768px) { .hhm-post-content h2 { font-size:26px; margin:40px 0 18px; } }
  .hhm-post-content h2::after { content:''; position:absolute; bottom:-2px; left:0; width:48px; height:2px; background:var(--brand); }
  .hhm-post-content h3 { font-size:18px; font-weight:700; color:var(--text); margin:28px 0 12px; }
  @media(min-width:768px) { .hhm-post-content h3 { font-size:20px; margin:30px 0 14px; } }
  .hhm-post-content blockquote { margin:24px 0; padding:16px 18px 16px 22px; border-left:4px solid var(--brand); background:var(--brand-light); border-radius:0 12px 12px 0; font-size:16px; font-style:italic; color:var(--text); font-weight:500; }
  @media(min-width:768px) { .hhm-post-content blockquote { margin:32px 0; padding:20px 24px 20px 28px; font-size:18px; } }
  .hhm-post-content blockquote cite { display:block; font-size:13px; font-style:normal; color:var(--muted); margin-top:10px; font-weight:600; }
  .hhm-post-content img { max-width:100%; height:auto; border-radius:12px; margin:24px 0; display:block; }
  .hhm-post-content figcaption { text-align:center; color:var(--muted); font-size:13px; margin-top:-16px; margin-bottom:24px; }
  .hhm-post-content ul, .hhm-post-content ol { padding-left:24px; margin-bottom:24px; }
  .hhm-post-content li { margin-bottom:8px; }
  .hhm-post-content ul li::marker { color:var(--brand); }
  .hhm-post-content a { color:var(--brand); text-decoration:underline; }
  .hhm-post-content a:hover { color:#c94d22; }
  .hhm-post-content code { background:#f1f5f9; border:1px solid var(--border); border-radius:4px; padding:2px 6px; font-size:13px; font-family:monospace; color:#c94d22; }
  .hhm-post-content pre { background:#1e293b; color:#e2e8f0; border-radius:12px; padding:16px; overflow-x:auto; margin:24px 0; font-size:13px; line-height:1.7; }
  @media(min-width:768px) { .hhm-post-content pre { padding:24px; font-size:14px; } }
  /* Table: scrollable on mobile */
  .hhm-post-content .hhm-table-wrap { overflow-x:auto; -webkit-overflow-scrolling:touch; margin:24px 0; border-radius:8px; border:1px solid var(--border); }
  .hhm-post-content table { width:100%; border-collapse:collapse; font-size:14px; margin:0; }
  .hhm-post-content th { background:var(--brand); color:#fff; padding:10px 14px; text-align:left; white-space:nowrap; }
  .hhm-post-content td { padding:10px 14px; border-bottom:1px solid var(--border); }
  .hhm-post-content tr:nth-child(even) td { background:#f8fafc; }

  /* Tags */
  .hhm-post-tags { display:flex; flex-wrap:wrap; gap:8px; margin-top:36px; padding-top:28px; border-top:1px solid var(--border); }
  .hhm-post-tags a { background:var(--bg); border:1px solid var(--border); border-radius:50px; padding:5px 14px; font-size:12px; font-weight:600; color:var(--text); text-decoration:none; transition:all 0.2s; }
  .hhm-post-tags a:hover { background:var(--brand); color:#fff; border-color:var(--brand); }

  /* Author Bio */
  .hhm-author-bio { margin:40px 0; background:#fff; border:1px solid var(--border); border-radius:20px; padding:20px; box-shadow:0 2px 12px rgba(0,0,0,0.04); display:flex; flex-direction:column; gap:16px; align-items:center; text-align:center; }
  @media(min-width:480px) { .hhm-author-bio { flex-direction:row; align-items:flex-start; text-align:left; gap:20px; padding:28px; } }
  .hhm-author-bio-avatar { width:72px; height:72px; border-radius:50%; object-fit:cover; border:3px solid var(--brand); flex-shrink:0; }
  @media(min-width:480px) { .hhm-author-bio-avatar { width:80px; height:80px; } }
  .hhm-author-bio-name { font-size:18px; font-weight:800; color:var(--text); margin:0 0 4px; }
  .hhm-author-bio-role { font-size:12px; font-weight:700; color:var(--brand); text-transform:uppercase; letter-spacing:0.8px; margin-bottom:10px; }
  .hhm-author-bio-text { font-size:14px; color:#374151; line-height:1.7; margin:0; }

  /* Post Navigation */
  .hhm-post-nav { display:grid; grid-template-columns:1fr; gap:12px; margin:40px 0; }
  @media(min-width:600px) { .hhm-post-nav { grid-template-columns:1fr 1fr; gap:20px; } }
  .hhm-post-nav a { background:#fff; border:1px solid var(--border); border-radius:14px; padding:16px; text-decoration:none; display:flex; align-items:center; gap:12px; box-shadow:0 2px 8px rgba(0,0,0,0.04); transition:all 0.2s; }
  @media(min-width:600px) { .hhm-post-nav a { padding:20px; } }
  .hhm-post-nav a:hover { border-color:var(--brand); box-shadow:0 6px 20px rgba(232,94,48,0.1); }
  .hhm-post-nav .hhm-nav-next { justify-content:flex-end; text-align:right; }
  .hhm-post-nav img { width:52px; height:44px; border-radius:8px; object-fit:cover; flex-shrink:0; }
  .hhm-post-nav-direction { font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:0.8px; margin-bottom:4px; }
  .hhm-post-nav-title { font-size:13px; font-weight:700; color:var(--text); line-height:1.3; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }

  /* Related Posts */
  .hhm-related { margin-top:40px; padding-top:40px; border-top:1px solid var(--border); }
  .hhm-related h2 { font-size:20px; font-weight:800; color:var(--text); margin:0 0 20px; }
  @media(min-width:600px) { .hhm-related h2 { font-size:22px; margin:0 0 24px; } }
  .hhm-related-grid { display:grid; grid-template-columns:1fr; gap:16px; }
  @media(min-width:480px) { .hhm-related-grid { grid-template-columns:repeat(2,1fr); } }
  @media(min-width:900px) { .hhm-related-grid { grid-template-columns:repeat(3,1fr); gap:20px; } }
  .hhm-rel-card { background:#fff; border-radius:14px; border:1px solid var(--border); overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.04); transition:all 0.3s; }
  .hhm-rel-card:hover { transform:translateY(-4px); box-shadow:0 10px 28px rgba(0,0,0,0.09); }
  .hhm-rel-card img { width:100%; height:160px; object-fit:cover; display:block; }
  .hhm-rel-card-body { padding:16px; }
  .hhm-rel-card-title { font-size:14px; font-weight:700; color:var(--text); margin:0 0 6px; line-height:1.4; }
  .hhm-rel-card-title a { color:inherit; text-decoration:none; }
  .hhm-rel-card-title a:hover { color:var(--brand); }
  .hhm-rel-card-meta { font-size:12px; color:var(--muted); }

  /* ── SIDEBAR ── */
  .hhm-post-sidebar { position:sticky; top:24px; }
  .hhm-sidebar-widget { background:#fff; border:1px solid var(--border); border-radius:16px; padding:22px; box-shadow:0 2px 10px rgba(0,0,0,0.04); margin-bottom:20px; }
  .hhm-widget-title { font-size:14px; font-weight:800; color:var(--text); margin:0 0 16px; padding-bottom:10px; border-bottom:2px solid var(--brand-light); display:flex; align-items:center; gap:7px; text-transform:uppercase; letter-spacing:0.5px; }
  .hhm-widget-title .material-symbols-outlined { color:var(--brand); font-size:17px; }
  .hhm-toc { list-style:none; padding:0; margin:0; }
  .hhm-toc li { margin-bottom:4px; }
  .hhm-toc a { display:block; padding:7px 10px; border-radius:8px; font-size:13px; color:var(--muted); text-decoration:none; transition:all 0.2s; border-left:2px solid transparent; }
  .hhm-toc a:hover, .hhm-toc a.active { background:var(--brand-light); color:var(--brand); border-left-color:var(--brand); font-weight:600; }
  .hhm-sidebar-share { display:flex; flex-direction:column; gap:8px; }
  .hhm-sidebar-share a { display:flex; align-items:center; gap:10px; padding:10px 14px; border-radius:10px; font-size:13px; font-weight:600; text-decoration:none; transition:all 0.2s; }
  .hhm-sidebar-share .fb { background:#1877f2; color:#fff; }
  .hhm-sidebar-share .tw { background:#1da1f2; color:#fff; }
  .hhm-sidebar-share .wa { background:#25d366; color:#fff; }
  .hhm-sidebar-share a:hover { opacity:0.88; }
  .hhm-newsletter-card { background:linear-gradient(135deg,#1a1a2e 0%,#2d1a3e 60%,#c94d22 100%); border-radius:16px; padding:24px; text-align:center; }
  .hhm-nl-icon { width:44px; height:44px; background:rgba(255,255,255,.12); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 12px; }
  .hhm-nl-icon .material-symbols-outlined { color:#fff; font-size:22px; }
  .hhm-newsletter-card h4 { color:#fff; margin:0 0 6px; font-size:16px; font-weight:800; }
  .hhm-newsletter-card p { color:rgba(255,255,255,0.75); font-size:12px; margin:0 0 16px; }
  .hhm-newsletter-input { width:100%; padding:10px 13px; border-radius:8px; border:none; font-family:'Inter',sans-serif; font-size:13px; margin-bottom:8px; outline:none; }
  .hhm-newsletter-input:focus { box-shadow:0 0 0 2px #e85e30; }
  .hhm-newsletter-btn { width:100%; padding:11px; background:#e85e30; color:#fff; border:none; border-radius:8px; font-weight:700; font-size:13px; cursor:pointer; font-family:'Inter',sans-serif; transition:background .2s; }
  .hhm-newsletter-btn:hover { background:#c94d22; }
  .hhm-newsletter-btn:disabled { background:#888; cursor:not-allowed; }
  .hhm-popular-post { display:flex; gap:10px; align-items:flex-start; margin-bottom:13px; padding-bottom:13px; border-bottom:1px solid var(--border); }
  .hhm-popular-post:last-child { margin-bottom:0; padding-bottom:0; border-bottom:none; }
  .hhm-popular-img { width:52px; height:44px; border-radius:6px; object-fit:cover; flex-shrink:0; }
  .hhm-popular-title a { font-size:12px; font-weight:600; color:var(--text); text-decoration:none; line-height:1.4; display:block; }
  .hhm-popular-title a:hover { color:var(--brand); }
  .hhm-popular-meta { font-size:11px; color:var(--muted); margin-top:2px; }
</style>

<div class="hhm-single bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100">

  <main class="max-w-7xl mx-auto px-4 md:px-10 lg:px-20 py-6">

    <!-- Breadcrumb & Category -->
    <div class="mb-4 text-xs md:text-sm font-medium text-slate-500 dark:text-slate-400 flex flex-wrap items-center gap-2">
      <a href="<?php echo home_url(); ?>" class="hover:text-primary transition">Home</a>
      <span class="material-symbols-outlined text-[14px]">chevron_right</span>
      <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="hover:text-primary transition">Travel Stories</a>
      <?php if ($cat) : ?>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <a href="<?php echo get_category_link($cat->term_id); ?>" class="hover:text-primary transition"><?php echo esc_html($cat->name); ?></a>
      <?php endif; ?>
    </div>

    <!-- Title -->
    <div class="mb-6">
      <h1 class="text-2xl md:text-4xl lg:text-5xl font-bold mb-4 leading-tight"><?php the_title(); ?></h1>
    </div>

    <!-- ── FEATURED IMAGE ── -->
    <div class="hhm-post-hero">
      <img class="hhm-post-hero-img" src="<?php echo esc_url($thumbnail); ?>" alt="<?php the_title_attribute(); ?>">
    </div>

    <!-- ── BODY ── -->
    <div class="hhm-post-body mt-8">

      <!-- ARTICLE -->
      <article>

        <!-- Author card + share -->
        <div class="hhm-article-header">
          <div class="hhm-author-card">
            <img class="hhm-author-avatar" src="<?php echo esc_url($avatar); ?>" alt="<?php the_author(); ?>">
            <div>
              <div class="hhm-author-name"><?php the_author(); ?></div>
              <div class="hhm-author-meta">
                <span><?php echo get_the_date('M j, Y'); ?></span>
                <span>·</span>
                <span><?php echo $read_time; ?> min read</span>
                <span>·</span>
                <span><?php echo number_format($word_count); ?> words</span>
              </div>
            </div>
          </div>

          <div class="hhm-share-row">
            <span class="hhm-share-label">Share:</span>
            <a class="hhm-share-btn hhm-share-fb" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" target="_blank" rel="noopener" aria-label="Share on Facebook">
              <span class="material-symbols-outlined" style="font-size:16px;">share</span><span class="hhm-btn-label">Facebook</span>
            </a>
            <a class="hhm-share-btn hhm-share-tw" href="https://twitter.com/intent/tweet?text=<?php echo $share_title; ?>&url=<?php echo $share_url; ?>" target="_blank" rel="noopener" aria-label="Share on Twitter">
              <span class="material-symbols-outlined" style="font-size:16px;">chat_bubble</span><span class="hhm-btn-label">Twitter</span>
            </a>
            <a class="hhm-share-btn hhm-share-wa" href="https://wa.me/?text=<?php echo $share_title; ?>%20<?php echo $share_url; ?>" target="_blank" rel="noopener" aria-label="Share on WhatsApp">
              <span class="material-symbols-outlined" style="font-size:16px;">forum</span><span class="hhm-btn-label">WhatsApp</span>
            </a>
            <button class="hhm-share-btn hhm-share-copy" onclick="navigator.clipboard.writeText('<?php echo esc_js( get_permalink() ); ?>');this.innerHTML='<span class=\'material-symbols-outlined\' style=\'font-size:16px;\'>check</span><span class=\'hhm-btn-label\'>Copied!</span>'" aria-label="Copy link">
              <span class="material-symbols-outlined" style="font-size:16px;">link</span><span class="hhm-btn-label">Copy Link</span>
            </button>
          </div>
        </div>

        <!-- Post Content -->
        <div class="hhm-post-content" id="hhm-post-content">
          <?php the_content(); ?>
        </div>

        <!-- Tags -->
        <?php if ($tags) : ?>
          <div class="hhm-post-tags">
            <?php foreach ($tags as $tag) : ?>
              <a href="<?php echo get_tag_link($tag->term_id); ?>">#<?php echo esc_html($tag->name); ?></a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <!-- Author Bio -->
        <div class="hhm-author-bio">
          <img class="hhm-author-bio-avatar" src="<?php echo esc_url(get_avatar_url($author_id,['size'=>80])); ?>" alt="<?php the_author(); ?>">
          <div>
            <div class="hhm-author-bio-name"><?php the_author(); ?></div>
            <div class="hhm-author-bio-role">Travel Writer &amp; Host</div>
            <p class="hhm-author-bio-text"><?php echo $author_bio ?: 'Passionate traveler and storyteller exploring the beauty of the Himalayas, sharing authentic homestay experiences and travel guides.'; ?></p>
          </div>
        </div>

        <!-- Post Navigation -->
        <div class="hhm-post-nav">
          <?php $prev = get_previous_post(); if ($prev) : ?>
            <a href="<?php echo get_permalink($prev->ID); ?>">
              <span class="material-symbols-outlined" style="font-size:24px;color:var(--muted);">chevron_left</span>
              <?php $pi = get_the_post_thumbnail_url($prev->ID,'thumbnail'); if($pi): ?><img src="<?php echo esc_url($pi); ?>" alt=""><?php endif; ?>
              <div>
                <div class="hhm-post-nav-direction">← Previous</div>
                <div class="hhm-post-nav-title"><?php echo esc_html($prev->post_title); ?></div>
              </div>
            </a>
          <?php else: ?>
            <div></div>
          <?php endif; ?>
          <?php $next = get_next_post(); if ($next) : ?>
            <a href="<?php echo get_permalink($next->ID); ?>" class="hhm-nav-next">
              <div>
                <div class="hhm-post-nav-direction">Next →</div>
                <div class="hhm-post-nav-title"><?php echo esc_html($next->post_title); ?></div>
              </div>
              <?php $ni = get_the_post_thumbnail_url($next->ID,'thumbnail'); if($ni): ?><img src="<?php echo esc_url($ni); ?>" alt=""><?php endif; ?>
              <span class="material-symbols-outlined" style="font-size:24px;color:var(--muted);">chevron_right</span>
            </a>
          <?php endif; ?>
        </div>

        <!-- Related Posts -->
        <?php
        $related_args = ['post_type'=>'post','posts_per_page'=>3,'post__not_in'=>[$post_id],'ignore_sticky_posts'=>true];
        if ($cat) $related_args['category__in'] = [$cat->term_id];
        $related = new WP_Query($related_args);
        if ($related->have_posts()) : ?>
          <div class="hhm-related">
            <h2>You Might Also Enjoy</h2>
            <div class="hhm-related-grid">
              <?php while ($related->have_posts()) : $related->the_post();
                $rt = get_the_post_thumbnail_url(null,'medium') ?: 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=400&q=80';
              ?>
                <div class="hhm-rel-card">
                  <img src="<?php echo esc_url($rt); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                  <div class="hhm-rel-card-body">
                    <h3 class="hhm-rel-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <div class="hhm-rel-card-meta"><?php the_author(); ?> · <?php echo get_the_date('M j, Y'); ?></div>
                  </div>
                </div>
              <?php endwhile; wp_reset_postdata(); ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- Comments -->
        <?php if (comments_open() || get_comments_number()) : ?>
          <div style="margin-top:40px;padding-top:32px;border-top:1px solid var(--border);">
            <?php comments_template(); ?>
          </div>
        <?php endif; ?>

      </article>

      <!-- ── SIDEBAR ── -->
      <aside class="hhm-post-sidebar">

        <!-- Table of Contents -->
        <div class="hhm-sidebar-widget">
          <h3 class="hhm-widget-title"><span class="material-symbols-outlined">menu_book</span>In This Article</h3>
          <ul class="hhm-toc" id="hhm-toc"></ul>
        </div>

        <!-- Share -->
        <div class="hhm-sidebar-widget">
          <h3 class="hhm-widget-title"><span class="material-symbols-outlined">share</span>Share This Story</h3>
          <div class="hhm-sidebar-share">
            <a class="fb" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" target="_blank">
              <span class="material-symbols-outlined" style="font-size:18px;">share</span> Share on Facebook
            </a>
            <a class="tw" href="https://twitter.com/intent/tweet?text=<?php echo $share_title; ?>&url=<?php echo $share_url; ?>" target="_blank">
              <span class="material-symbols-outlined" style="font-size:18px;">chat_bubble</span> Share on Twitter
            </a>
            <a class="wa" href="https://wa.me/?text=<?php echo $share_title; ?>%20<?php echo $share_url; ?>" target="_blank">
              <span class="material-symbols-outlined" style="font-size:18px;">forum</span> Share on WhatsApp
            </a>
          </div>
        </div>

        <!-- Popular Posts -->
        <div class="hhm-sidebar-widget">
          <h3 class="hhm-widget-title"><span class="material-symbols-outlined">trending_up</span>Popular Stories</h3>
          <?php $popular = new WP_Query(['post_type'=>'post','posts_per_page'=>4,'orderby'=>'comment_count','order'=>'DESC','post__not_in'=>[$post_id],'ignore_sticky_posts'=>true]);
          while ($popular->have_posts()) : $popular->the_post();
            $pp = get_the_post_thumbnail_url(null,'thumbnail') ?: 'https://images.unsplash.com/photo-1432408806534-c14a64d1bce9?w=120&q=80';
          ?>
            <div class="hhm-popular-post">
              <img class="hhm-popular-img" src="<?php echo esc_url($pp); ?>" alt="">
              <div>
                <div class="hhm-popular-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                <div class="hhm-popular-meta"><?php echo get_the_date('M j, Y'); ?></div>
              </div>
            </div>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <!-- Newsletter -->
        <div class="hhm-newsletter-card" id="hhm-newsletter-widget">
          <div class="hhm-nl-icon"><span class="material-symbols-outlined">mail</span></div>
          <h4>Travel Inspiration</h4>
          <p>Himalayan stories &amp; hidden gems, straight to your inbox.</p>
          <form id="hhm-nl-form" novalidate onsubmit="return false;">
            <input type="text" class="hhm-newsletter-input" id="hhm-nl-name" placeholder="Your name (optional)">
            <input type="email" class="hhm-newsletter-input" id="hhm-nl-email" placeholder="your@email.com" required>
            <button type="button" class="hhm-newsletter-btn" id="hhm-nl-btn">Subscribe Free</button>
            <input type="hidden" id="hhm-nl-nonce" value="<?php echo esc_attr( $nonce ); ?>">
          </form>
          <div id="hhm-nl-msg" style="display:none;margin-top:12px;padding:10px 14px;border-radius:8px;font-size:13px;text-align:center;"></div>
          <p style="font-size:11px;color:rgba(255,255,255,.5);margin:10px 0 0;text-align:center;">No spam ever. Unsubscribe anytime.</p>
        </div>

      </aside>
    </div>
  </main>
</div>

<script>
(function() {
  // ── Wrap tables for horizontal scroll on mobile ───────────────────────────
  const content = document.getElementById('hhm-post-content');
  if (content) {
    content.querySelectorAll('table').forEach(function(table) {
      if (table.parentElement.classList.contains('hhm-table-wrap')) return;
      const wrapper = document.createElement('div');
      wrapper.className = 'hhm-table-wrap';
      table.parentNode.insertBefore(wrapper, table);
      wrapper.appendChild(table);
    });
  }

  // ── Auto-build Table of Contents from H2 headings ─────────────────────────
  const toc     = document.getElementById('hhm-toc');
  const headings = content ? content.querySelectorAll('h2, h3') : [];

  headings.forEach((h, i) => {
    const id = 'hhm-h-' + i;
    h.id = id;
    const li = document.createElement('li');
    li.style.paddingLeft = h.tagName === 'H3' ? '16px' : '0';
    const a = document.createElement('a');
    a.href = '#' + id;
    a.textContent = h.textContent;
    li.appendChild(a);
    toc.appendChild(li);
    a.addEventListener('click', (e) => {
      e.preventDefault();
      h.scrollIntoView({ behavior:'smooth', block:'start' });
    });
  });

  // ── Highlight active ToC item on scroll ───────────────────────────────────
  const tocLinks = toc.querySelectorAll('a');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        tocLinks.forEach(a => a.classList.remove('active'));
        const active = toc.querySelector(`a[href="#${entry.target.id}"]`);
        if (active) active.classList.add('active');
      }
    });
  }, { rootMargin:'-20% 0px -70% 0px' });

  headings.forEach(h => observer.observe(h));
})();

// ── Newsletter Subscribe ──────────────────────────────────────────────────────
(function() {
  const form  = document.getElementById('hhm-nl-form');
  const msg   = document.getElementById('hhm-nl-msg');
  const btn   = document.getElementById('hhm-nl-btn');
  if ( ! btn ) return;

  btn.addEventListener('click', function() {
    const email = document.getElementById('hhm-nl-email').value.trim();
    const name  = document.getElementById('hhm-nl-name').value.trim();
    const nonce = document.getElementById('hhm-nl-nonce').value;

    if ( ! email ) {
      showMsg('Please enter your email address.', false);
      return;
    }

    btn.disabled    = true;
    btn.textContent = 'Subscribing…';

    const data = new FormData();
    data.append('action', 'hhb_newsletter_subscribe');
    data.append('nonce',  nonce);
    data.append('email',  email);
    data.append('name',   name);

    fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
      method: 'POST',
      body: data,
      credentials: 'same-origin',
    })
    .then( r => r.json() )
    .then( res => {
      showMsg( res.data ? res.data.message : 'Something went wrong.', res.success );
      if ( res.success ) {
        form.reset();
      }
    })
    .catch( () => showMsg('Network error. Please try again.', false) )
    .finally( () => {
      btn.disabled    = false;
      btn.textContent = 'Subscribe Free';
    });
  });

  function showMsg(text, success) {
    msg.textContent    = text;
    msg.style.display  = 'block';
    msg.style.background = success ? 'rgba(255,255,255,.15)' : 'rgba(220,38,38,.3)';
    msg.style.color    = '#fff';
    msg.style.border   = success ? '1px solid rgba(255,255,255,.3)' : '1px solid rgba(220,38,38,.5)';
  }
})();
</script>

<?php get_footer(); ?>
