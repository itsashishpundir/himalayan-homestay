<?php
/**
 * Tag Archive Template
 *
 * Redesigned via Google Stitch — dark hero with # tag branding +
 * horizontal article card stack + sidebar with related tags.
 *
 * @package HimalayanMart
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();

$tag         = get_queried_object();
$tag_name    = $tag->name ?? '';
$tag_count   = $tag->count ?? 0;
?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@400,0&display=swap" rel="stylesheet">

<style>
  :root { --brand:#e85e30; --brand-light:#fef1ec; --bg:#f8f6f6; --border:#e2e8f0; --text:#1a1a2e; --muted:#64748b; }
  .hhm-tag *:not(.material-symbols-outlined) { box-sizing:border-box; font-family:'Inter',sans-serif; }
  .hhm-tag * { box-sizing:border-box; }
  .hhm-tag { background:var(--bg); }

  /* ── HERO ── */
  .hhm-tag-hero { position:relative; padding:56px 24px 56px; text-align:center; overflow:hidden; background:linear-gradient(135deg,#141414 0%,#1f1f1f 60%,#2a1a10 100%); }
  .hhm-tag-hero::before { content:''; position:absolute; inset:0; background:url("data:image/svg+xml,%3Csvg width='80' height='80' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='40' cy='40' r='1.5' fill='rgba(255,255,255,0.04)'/%3E%3C/svg%3E") repeat; }
  .hhm-tag-hero-content { position:relative; z-index:1; max-width:560px; margin:0 auto; }
  .hhm-tag-label { font-size:clamp(40px,6vw,72px); font-weight:900; color:#fff; line-height:1; margin:0 0 12px; }
  .hhm-tag-label span { color:var(--brand); }
  .hhm-tag-sub { color:rgba(255,255,255,0.6); font-size:16px; margin:0 0 16px; }
  .hhm-tag-breadcrumb { color:rgba(255,255,255,0.45); font-size:13px; }
  .hhm-tag-breadcrumb a { color:rgba(255,255,255,0.65); text-decoration:none; }

  /* ── LAYOUT ── */
  .hhm-tag-body { max-width:1280px; margin:0 auto; padding:48px 24px 80px; display:grid; grid-template-columns:1fr 320px; gap:48px; align-items:start; }
  @media(max-width:960px) { .hhm-tag-body { grid-template-columns:1fr; } }

  /* ── HORIZONTAL ARTICLE CARDS ── */
  .hhm-h-card { background:#fff; border-radius:16px; border:1px solid var(--border); overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,0.04); display:flex; margin-bottom:20px; transition:all 0.3s; }
  .hhm-h-card:hover { transform:translateY(-3px); box-shadow:0 12px 32px rgba(0,0,0,0.09); }
  .hhm-h-card-img-wrap { position:relative; width:280px; flex-shrink:0; overflow:hidden; }
  .hhm-h-card-img { width:100%; height:100%; object-fit:cover; min-height:180px; transition:transform 0.5s; }
  .hhm-h-card:hover .hhm-h-card-img { transform:scale(1.06); }
  .hhm-h-card-cat { position:absolute; top:12px; left:12px; background:var(--brand); color:#fff; border-radius:6px; padding:3px 10px; font-size:11px; font-weight:700; text-transform:uppercase; }
  .hhm-h-card-body { padding:24px; flex:1; display:flex; flex-direction:column; justify-content:center; }
  .hhm-h-card-title { font-size:20px; font-weight:700; color:var(--text); margin:0 0 8px; line-height:1.3; }
  .hhm-h-card-title a { color:inherit; text-decoration:none; }
  .hhm-h-card-title a:hover { color:var(--brand); }
  .hhm-h-card-meta { display:flex; align-items:center; gap:8px; color:var(--muted); font-size:13px; margin-bottom:10px; }
  .hhm-h-card-meta img { width:24px; height:24px; border-radius:50%; object-fit:cover; }
  .hhm-h-card-excerpt { color:#374151; font-size:14px; line-height:1.7; margin-bottom:14px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
  .hhm-h-card-link { color:var(--brand); font-weight:700; font-size:14px; text-decoration:none; display:inline-flex; align-items:center; gap:4px; align-self:flex-start; }
  .hhm-h-card-link:hover { gap:8px; }
  @media(max-width:640px) { .hhm-h-card { flex-direction:column; } .hhm-h-card-img-wrap { width:100%; height:200px; } }

  /* ── SIDEBAR ── */
  .hhm-sidebar { position:sticky; top:24px; }
  .hhm-sidebar-widget { background:#fff; border:1px solid var(--border); border-radius:16px; padding:24px; box-shadow:0 2px 10px rgba(0,0,0,0.04); margin-bottom:24px; }
  .hhm-widget-title { font-size:15px; font-weight:800; color:var(--text); margin:0 0 16px; padding-bottom:12px; border-bottom:2px solid var(--brand-light); display:flex; align-items:center; gap:8px; }
  .hhm-widget-title .material-symbols-outlined { color:var(--brand); font-size:18px; }
  .hhm-tags-cloud { display:flex; flex-wrap:wrap; gap:8px; }
  .hhm-tag-pill { background:var(--bg); color:var(--text); border:1px solid var(--border); border-radius:50px; padding:5px 14px; font-size:12px; font-weight:600; text-decoration:none; transition:all 0.2s; }
  .hhm-tag-pill:hover, .hhm-tag-pill.active { background:var(--brand); color:#fff; border-color:var(--brand); }
  .hhm-popular-post { display:flex; gap:12px; align-items:flex-start; margin-bottom:14px; padding-bottom:14px; border-bottom:1px solid var(--border); }
  .hhm-popular-post:last-child { margin-bottom:0; padding-bottom:0; border-bottom:none; }
  .hhm-popular-img { width:56px; height:48px; border-radius:8px; object-fit:cover; flex-shrink:0; }
  .hhm-popular-title a { font-size:13px; font-weight:600; color:var(--text); text-decoration:none; }
  .hhm-popular-title a:hover { color:var(--brand); }
  .hhm-popular-meta { font-size:11px; color:var(--muted); margin-top:2px; }
  .hhm-newsletter-card { background:linear-gradient(135deg,#c94d22,#e85e30); border-radius:14px; padding:24px; text-align:center; }
  .hhm-newsletter-card h4 { color:#fff; margin:0 0 8px; font-size:16px; font-weight:800; }
  .hhm-newsletter-card p { color:rgba(255,255,255,0.85); font-size:13px; margin:0 0 16px; }
  .hhm-newsletter-input { width:100%; padding:10px 14px; border-radius:8px; border:none; font-family:'Inter',sans-serif; font-size:14px; margin-bottom:8px; }
  .hhm-newsletter-btn { width:100%; padding:10px; background:var(--text); color:#fff; border:none; border-radius:8px; font-weight:700; font-size:14px; cursor:pointer; font-family:'Inter',sans-serif; transition:background 0.2s; }
  .hhm-newsletter-btn:hover { background:#000; }

  /* ── PAGINATION ── */
  .hhm-pagination { display:flex; justify-content:center; gap:8px; margin-top:36px; flex-wrap:wrap; }
  .hhm-pagination .page-numbers { display:flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:10px; border:1px solid var(--border); font-weight:600; font-size:14px; text-decoration:none; color:var(--text); background:#fff; transition:all 0.2s; }
  .hhm-pagination .current { background:var(--brand); color:#fff; border-color:var(--brand); }
  .hhm-pagination .page-numbers:hover:not(.current) { background:var(--brand-light); border-color:var(--brand); color:var(--brand); }
  .hhm-pagination .prev, .hhm-pagination .next { width:auto; padding:0 16px; }
</style>

<div class="hhm-tag">

  <!-- ── HERO ── -->
  <div class="hhm-tag-hero">
    <div class="hhm-tag-hero-content">
      <h1 class="hhm-tag-label"><span>#</span><?php echo esc_html($tag_name); ?></h1>
      <p class="hhm-tag-sub"><?php echo $tag_count; ?> article<?php echo $tag_count !== 1 ? 's' : ''; ?> tagged with #<?php echo esc_html($tag_name); ?></p>
      <div class="hhm-tag-breadcrumb">
        <a href="<?php echo home_url(); ?>">Home</a> ›
        <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>">Blog</a> ›
        <span>#<?php echo esc_html($tag_name); ?></span>
      </div>
    </div>
  </div>

  <!-- ── BODY ── -->
  <div class="hhm-tag-body">

    <!-- MAIN CONTENT -->
    <main>
      <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post();
          $thumb = get_the_post_thumbnail_url(null,'medium_large') ?: 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800&q=80';
          $cats  = get_the_category();
          $cat   = $cats ? $cats[0] : null;
          $avt   = get_avatar_url(get_the_author_meta('ID'),['size'=>28]);
        ?>
          <article class="hhm-h-card">
            <div class="hhm-h-card-img-wrap">
              <a href="<?php the_permalink(); ?>">
                <img class="hhm-h-card-img" src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
              </a>
              <?php if ($cat) : ?>
                <a href="<?php echo get_category_link($cat->term_id); ?>" class="hhm-h-card-cat"><?php echo esc_html($cat->name); ?></a>
              <?php endif; ?>
            </div>
            <div class="hhm-h-card-body">
              <h2 class="hhm-h-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
              <div class="hhm-h-card-meta">
                <img src="<?php echo esc_url($avt); ?>" alt="">
                <span><?php the_author(); ?></span>
                <span>·</span>
                <span><?php echo get_the_date('M j, Y'); ?></span>
                <span>·</span>
                <span><?php echo ceil(str_word_count(strip_tags(get_the_content())) / 200); ?> min read</span>
              </div>
              <p class="hhm-h-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 22); ?></p>
              <a href="<?php the_permalink(); ?>" class="hhm-h-card-link">
                Read Article <span class="material-symbols-outlined" style="font-size:15px;">arrow_forward</span>
              </a>
            </div>
          </article>
        <?php endwhile; ?>

        <div class="hhm-pagination">
          <?php echo paginate_links(['type'=>'list','prev_text'=>'← Prev','next_text'=>'Next →']); ?>
        </div>

      <?php else : ?>
        <div style="text-align:center;padding:60px 24px;background:#fff;border-radius:16px;border:1px solid var(--border);">
          <span class="material-symbols-outlined" style="font-size:56px;color:#cbd5e1;">label_off</span>
          <h2>No Articles Tagged #<?php echo esc_html($tag_name); ?></h2>
        </div>
      <?php endif; ?>
    </main>

    <!-- SIDEBAR -->
    <aside class="hhm-sidebar">

      <!-- Related Tags -->
      <div class="hhm-sidebar-widget">
        <h3 class="hhm-widget-title"><span class="material-symbols-outlined">tag</span>Related Tags</h3>
        <div class="hhm-tags-cloud">
          <?php $all_tags = get_tags(['number'=>20,'orderby'=>'count','order'=>'DESC']);
          foreach ($all_tags as $t) : ?>
            <a href="<?php echo get_tag_link($t->term_id); ?>"
               class="hhm-tag-pill<?php echo ($t->term_id == $tag->term_id) ? ' active' : ''; ?>">
              <?php echo esc_html($t->name); ?>
            </a>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Popular Posts -->
      <div class="hhm-sidebar-widget">
        <h3 class="hhm-widget-title"><span class="material-symbols-outlined">trending_up</span>Popular Stories</h3>
        <?php $popular = new WP_Query(['post_type'=>'post','posts_per_page'=>4,'orderby'=>'comment_count','order'=>'DESC','post_status'=>'publish','ignore_sticky_posts'=>true]);
        while ($popular->have_posts()) : $popular->the_post();
          $pt = get_the_post_thumbnail_url(null,'thumbnail') ?: 'https://images.unsplash.com/photo-1432408806534-c14a64d1bce9?w=120&q=80';
        ?>
          <div class="hhm-popular-post">
            <img class="hhm-popular-img" src="<?php echo esc_url($pt); ?>" alt="">
            <div>
              <div class="hhm-popular-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
              <div class="hhm-popular-meta"><?php echo get_the_date('M j, Y'); ?></div>
            </div>
          </div>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>

      <!-- Newsletter -->
      <div class="hhm-newsletter-card">
        <h4>✈️ Stay Inspired</h4>
        <p>Get the latest travel stories in your inbox.</p>
        <form>
          <input type="email" class="hhm-newsletter-input" placeholder="your@email.com">
          <button type="submit" class="hhm-newsletter-btn">Subscribe</button>
        </form>
      </div>

    </aside>
  </div>
</div>

<?php get_footer(); ?>
