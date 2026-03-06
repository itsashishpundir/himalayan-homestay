<?php
/**
 * Category Archive Template
 *
 * Redesigned via Google Stitch — orange gradient hero + 3-col card grid.
 *
 * @package HimalayanMart
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();

$queried     = get_queried_object();
$cat_name    = $queried->name ?? '';
$cat_desc    = $queried->description ?? '';
$cat_count   = $queried->count ?? 0;
$current_page = max(1, get_query_var('paged'));
?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@400,0&display=swap" rel="stylesheet">

<style>
  :root { --brand:#e85e30; --brand-light:#fef1ec; --bg:#f8f6f6; --border:#e2e8f0; --text:#1a1a2e; --muted:#64748b; }
  .hhm-cat *:not(.material-symbols-outlined) { box-sizing:border-box; font-family:'Inter',sans-serif; }
  .hhm-cat * { box-sizing:border-box; }
  .hhm-cat { background:var(--bg); }

  /* ── HERO ── */
  .hhm-cat-hero { background:linear-gradient(135deg,#c94d22 0%,#e85e30 50%,#f5825a 100%); padding:56px 24px 56px; text-align:center; position:relative; overflow:hidden; }
  .hhm-cat-hero::before { content:''; position:absolute; inset:0; background:url("data:image/svg+xml,%3Csvg width='60' height='60' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='30' cy='30' r='1' fill='rgba(255,255,255,0.08)'/%3E%3C/svg%3E") repeat; }
  .hhm-cat-hero-content { position:relative; z-index:1; max-width:600px; margin:0 auto; }
  .hhm-cat-icon { width:56px; height:56px; background:rgba(255,255,255,0.18); border:2px solid rgba(255,255,255,0.3); border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; backdrop-filter:blur(8px); }
  .hhm-cat-icon .material-symbols-outlined { font-size:28px; color:#fff; }
  .hhm-cat-hero h1 { font-size:clamp(28px,4vw,48px); font-weight:900; color:#fff; margin:0 0 10px; text-shadow:0 2px 12px rgba(0,0,0,0.1); }
  .hhm-cat-hero p { color:rgba(255,255,255,0.85); font-size:16px; margin:0 0 16px; }
  .hhm-cat-breadcrumb { color:rgba(255,255,255,0.65); font-size:13px; }
  .hhm-cat-breadcrumb a { color:rgba(255,255,255,0.85); text-decoration:none; }

  /* ── LAYOUT ── */
  .hhm-cat-body { max-width:1280px; margin:0 auto; padding:48px 24px 80px; display:grid; grid-template-columns:1fr 320px; gap:48px; align-items:start; }
  @media(max-width:960px) { .hhm-cat-body { grid-template-columns:1fr; } }

  /* ── CARDS GRID ── */
  .hhm-cat-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:24px; }
  @media(max-width:800px) { .hhm-cat-grid { grid-template-columns:repeat(2,1fr); } }
  @media(max-width:500px) { .hhm-cat-grid { grid-template-columns:1fr; } }
  .hhm-card { background:#fff; border-radius:16px; border:1px solid var(--border); overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,0.04); transition:all 0.3s; }
  .hhm-card:hover { transform:translateY(-5px); box-shadow:0 12px 36px rgba(0,0,0,0.1); }
  .hhm-card-img-wrap { position:relative; height:180px; overflow:hidden; }
  .hhm-card-img { width:100%; height:100%; object-fit:cover; transition:transform 0.5s; }
  .hhm-card:hover .hhm-card-img { transform:scale(1.06); }
  .hhm-card-category-badge { position:absolute; top:10px; left:10px; background:var(--brand); color:#fff; border-radius:6px; padding:3px 10px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.6px; }
  .hhm-card-body { padding:18px; }
  .hhm-card-title { font-size:15px; font-weight:700; color:var(--text); margin:0 0 8px; line-height:1.35; }
  .hhm-card-title a { color:inherit; text-decoration:none; }
  .hhm-card-title a:hover { color:var(--brand); }
  .hhm-card-meta { color:var(--muted); font-size:12px; margin-bottom:8px; }
  .hhm-card-excerpt { color:#374151; font-size:13px; line-height:1.7; margin-bottom:12px; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; }
  .hhm-card-link { color:var(--brand); font-weight:700; font-size:13px; text-decoration:none; }
  .hhm-card-link:hover { text-decoration:underline; }

  /* ── SIDEBAR ── */
  .hhm-sidebar { position:sticky; top:24px; }
  .hhm-sidebar-widget { background:#fff; border:1px solid var(--border); border-radius:16px; padding:24px; box-shadow:0 2px 10px rgba(0,0,0,0.04); margin-bottom:24px; }
  .hhm-widget-title { font-size:15px; font-weight:800; color:var(--text); margin:0 0 16px; padding-bottom:12px; border-bottom:2px solid var(--brand-light); display:flex; align-items:center; gap:8px; }
  .hhm-widget-title .material-symbols-outlined { color:var(--brand); font-size:18px; }
  .hhm-cat-pills { display:flex; flex-wrap:wrap; gap:8px; }
  .hhm-cat-pill { background:var(--bg); color:var(--text); border:1px solid var(--border); border-radius:50px; padding:5px 14px; font-size:12px; font-weight:600; text-decoration:none; transition:all 0.2s; }
  .hhm-cat-pill:hover, .hhm-cat-pill.active { background:var(--brand); color:#fff; border-color:var(--brand); }
  .hhm-recent-list { list-style:none; padding:0; margin:0; }
  .hhm-recent-list li { display:flex; gap:10px; align-items:flex-start; padding:10px 0; border-bottom:1px solid var(--border); }
  .hhm-recent-list li:last-child { border-bottom:none; }
  .hhm-recent-img { width:48px; height:40px; border-radius:6px; object-fit:cover; flex-shrink:0; }
  .hhm-recent-meta { font-size:12px; color:var(--muted); }
  .hhm-recent-title a { font-size:13px; font-weight:600; color:var(--text); text-decoration:none; display:block; margin-bottom:2px; }
  .hhm-recent-title a:hover { color:var(--brand); }
  .hhm-tags-cloud { display:flex; flex-wrap:wrap; gap:6px; }
  .hhm-tag-pill { background:var(--brand-light); color:var(--brand); border:1px solid rgba(232,94,48,0.2); border-radius:50px; padding:4px 12px; font-size:11px; font-weight:600; text-decoration:none; transition:all 0.2s; }
  .hhm-tag-pill:hover { background:var(--brand); color:#fff; }

  /* ── PAGINATION ── */
  .hhm-pagination { display:flex; justify-content:center; gap:8px; margin-top:40px; flex-wrap:wrap; }
  .hhm-pagination .page-numbers { display:flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:10px; border:1px solid var(--border); font-weight:600; font-size:14px; text-decoration:none; color:var(--text); background:#fff; transition:all 0.2s; }
  .hhm-pagination .current { background:var(--brand); color:#fff; border-color:var(--brand); }
  .hhm-pagination .page-numbers:hover:not(.current) { background:var(--brand-light); border-color:var(--brand); color:var(--brand); }
  .hhm-pagination .prev, .hhm-pagination .next { width:auto; padding:0 16px; }
</style>

<div class="hhm-cat">

  <!-- ── HERO ── -->
  <div class="hhm-cat-hero">
    <div class="hhm-cat-hero-content">
      <div class="hhm-cat-icon"><span class="material-symbols-outlined">folder_open</span></div>
      <h1><?php echo esc_html($cat_name); ?></h1>
      <?php if ($cat_desc) : ?>
        <p><?php echo esc_html($cat_desc); ?></p>
      <?php else : ?>
        <p><?php echo $cat_count; ?> article<?php echo $cat_count !== 1 ? 's' : ''; ?> in this category</p>
      <?php endif; ?>
      <div class="hhm-cat-breadcrumb">
        <a href="<?php echo home_url(); ?>">Home</a> ›
        <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>">Blog</a> ›
        <span><?php echo esc_html($cat_name); ?></span>
      </div>
    </div>
  </div>

  <!-- ── BODY ── -->
  <div class="hhm-cat-body">

    <!-- MAIN CONTENT -->
    <main>
      <?php if (have_posts()) : ?>
        <div class="hhm-cat-grid">
          <?php while (have_posts()) : the_post();
            $thumb = get_the_post_thumbnail_url(null,'medium_large') ?: 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800&q=80';
            $cats  = get_the_category();
            $cat   = $cats ? $cats[0] : null;
          ?>
            <article class="hhm-card">
              <div class="hhm-card-img-wrap">
                <a href="<?php the_permalink(); ?>">
                  <img class="hhm-card-img" src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                </a>
                <?php if ($cat) : ?>
                  <a href="<?php echo get_category_link($cat->term_id); ?>" class="hhm-card-category-badge"><?php echo esc_html($cat->name); ?></a>
                <?php endif; ?>
              </div>
              <div class="hhm-card-body">
                <h2 class="hhm-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div class="hhm-card-meta"><?php the_author(); ?> · <?php echo get_the_date('M j, Y'); ?></div>
                <p class="hhm-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18); ?></p>
                <a href="<?php the_permalink(); ?>" class="hhm-card-link">Read More →</a>
              </div>
            </article>
          <?php endwhile; ?>
        </div>

        <div class="hhm-pagination">
          <?php echo paginate_links(['type'=>'list','prev_text'=>'← Prev','next_text'=>'Next →']); ?>
        </div>

      <?php else : ?>
        <div style="text-align:center;padding:60px 24px;background:#fff;border-radius:16px;border:1px solid var(--border);">
          <span class="material-symbols-outlined" style="font-size:56px;color:#cbd5e1;">article</span>
          <h2>No Posts in This Category</h2>
        </div>
      <?php endif; ?>
    </main>

    <!-- SIDEBAR -->
    <aside class="hhm-sidebar">

      <!-- Browse Categories -->
      <div class="hhm-sidebar-widget">
        <h3 class="hhm-widget-title"><span class="material-symbols-outlined">grid_view</span>Browse Categories</h3>
        <div class="hhm-cat-pills">
          <?php $all_cats = get_categories(['hide_empty'=>false]);
          foreach ($all_cats as $c) : ?>
            <a href="<?php echo get_category_link($c->term_id); ?>"
               class="hhm-cat-pill<?php echo ($c->term_id == $queried->term_id) ? ' active' : ''; ?>">
              <?php echo esc_html($c->name); ?>
            </a>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Latest in this category -->
      <div class="hhm-sidebar-widget">
        <h3 class="hhm-widget-title"><span class="material-symbols-outlined">new_releases</span>Latest in <?php echo esc_html($cat_name); ?></h3>
        <ul class="hhm-recent-list">
          <?php $recent_cat = new WP_Query(['category_name'=>$queried->slug,'posts_per_page'=>5]);
          while ($recent_cat->have_posts()) : $recent_cat->the_post();
            $rt = get_the_post_thumbnail_url(null,'thumbnail') ?: 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=120&q=80';
          ?>
            <li>
              <img class="hhm-recent-img" src="<?php echo esc_url($rt); ?>" alt="">
              <div>
                <div class="hhm-recent-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                <div class="hhm-recent-meta"><?php echo get_the_date('M j'); ?></div>
              </div>
            </li>
          <?php endwhile; wp_reset_postdata(); ?>
        </ul>
      </div>

      <!-- Tags -->
      <div class="hhm-sidebar-widget">
        <h3 class="hhm-widget-title"><span class="material-symbols-outlined">label</span>Tags</h3>
        <div class="hhm-tags-cloud">
          <?php $tags = get_tags(['number'=>16,'orderby'=>'count','order'=>'DESC']);
          foreach ($tags as $tag) : ?>
            <a href="<?php echo get_tag_link($tag->term_id); ?>" class="hhm-tag-pill"><?php echo esc_html($tag->name); ?></a>
          <?php endforeach; ?>
        </div>
      </div>

    </aside>
  </div>
</div>

<?php get_footer(); ?>
