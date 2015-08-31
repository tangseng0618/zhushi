<?php global $author;$userdata = get_userdata($author);get_header(); ?>
<div role="main" id="main">
  <div id="content">
    <div class="place"><?php the_place('首页'); ?></div>
    <div class="article-author archive-info">
      <?php echo get_avatar($author,'60'); ?>
      <div><?php _e('作者：');echo $userdata->display_name; ?> <?php get_template_part('templates/tpl-guanzhu'); ?></div>
      <div><?php _e(sprintf('共有%s篇文章',count_user_posts($author))); ?></div>
      <div class="article-author-description"><?php echo $userdata->description; ?></div>
      <div class="clear"></div>
    </div>
    <?php if(have_posts()) : ?>
    <div id="post-list">
      <?php
      while(have_posts()):the_post();
      $format = get_post_format();
      get_template_part('templates/tpl-loop',$format);
      endwhile;
      ?>
    </div>
    <?php get_template_part('templates/tpl-pagenavi'); ?>
    <?php else : ?>
    <h3>该用户还没有发布文章！</h3>
    <?php endif; ?>
  </div>
  <aside role="sidebar">
    <?php get_sidebar(); ?>
  </aside>
</div>
<?php get_footer(); ?>
