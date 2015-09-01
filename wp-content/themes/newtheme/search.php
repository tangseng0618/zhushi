<?php get_header(); ?>
<div role="main" id="main">
  <div id="content-box">
  <div id="content">
    <div class="place"><?php the_place('首页'); ?></div>
    <div class="archive-info">
      <h1><?php _e( '搜索结果：' );echo urldecode($_GET['s']); ?></h1>
    </div>
    <div id="post-list">
      <?php
      while(have_posts()):the_post();
      $format = get_post_format();
      get_template_part('templates/tpl-loop',$format);
      endwhile;
      ?>
    </div>
    <?php get_template_part('templates/tpl-pagenavi'); ?>
  </div>
  </div>
  <aside role="sidebar">
    <?php get_sidebar(); ?>
  </aside>
</div>
<?php get_footer(); ?>