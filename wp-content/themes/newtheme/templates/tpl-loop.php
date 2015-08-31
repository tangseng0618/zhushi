<?php global $admin_options;global $wp_query; ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php if(get_post_thumb() && !get_post_meta($post->ID,'不在列表中显示缩略图')){ ?><div class="post-thumb"><a href="<?php the_permalink(); ?>"><?php the_post_thumb(); ?></a></div><?php } ?>
  <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  <div class="post-info">
    <?php if($admin_options['mode'] > 0) { ?><span class="post-meta"><span class="icon author"></span><a href="<?php echo get_author_posts_url($post->post_author); ?>"><?php the_author(); ?></a></span><?php } ?>
    <span class="post-meta"><span class="icon cate"></span><?php the_category(','); ?></span>
    <span class="post-meta"><span class="icon date"></span><?php echo get_the_date('Y-m-d H:i'); ?></span>
    <?php comments_popup_link('<span class="post-comment post-meta"><span class="icon comment"></span> 0</span>','<span class="post-comment post-meta"><span class="icon comment"></span> 1</span>','<span class="post-comment post-meta"><span class="icon comment"></span> %</span>'); ?>
    <span class="post-meta"><span class="icon view"></span><?php the_view_count(); ?></span>
    <?php edit_post_link('<span class="post-meta"><span class="icon edit"></span>编辑</span>'); ?>
  </div>
  <div class="post-excerpt">
    <?php the_excerpt(); ?>
  </div>
  <div class="post-opt">
    <?php if(get_the_tags()): ?><span class="icon tag"></span><?php the_tags('',' '); ?><?php endif; ?>
    <?php get_template_part('templates/tpl-social-btns'); ?>
  </div>
<div class="clear"></div>
</div>
<?php if($wp_query->current_post == 2) {
  echo do_shortcode('[ad name="列表中第三篇文章后的广告720x60"]');
} ?>
