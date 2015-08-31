<?php
global $post,$admin_options;
if($post->ID == $admin_options['page_for_tougao'] && $admin_options['mode'] >= 2) {
  include("page-tougao.php");
  exit;
}
elseif($post->ID == $admin_options['page_for_usercenter'] && $admin_options['mode'] >= 2) {
  include("page-usercenter.php");
  exit;
}

get_header(); ?>
<div id="main">
  <div id="content">
    <div class="place"><?php the_place('首页'); ?> <?php edit_post_link('<span class="icon edit"></span>编辑'); ?></div>
    <article role="article" id="post-<?php the_ID(); ?>">
    <div id="article" <?php post_class('post'); ?>>
      <?php the_post(); ?>
      <h1 class="article-title post-title"><?php the_title(); ?></h1>
      <div class="article-content">
        <?php the_content(); ?>
      </div>
      <div class="clear"></div>
      <div id="comments"><?php comments_template('',true); ?></div>
    </div>
    </article>
  </div>
  <aside role="sidebar">
    <?php get_sidebar(); ?>
  </aside>
</div>
<?php get_footer(); ?>
