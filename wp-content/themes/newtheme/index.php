<?php get_header(); ?>
<div role="main" id="main">
  <div id="content">
    <?php get_template_part('templates/tpl-slider'); ?>
    <div id="post-list">
      <?php
      global $admin_options;
      if($admin_options['home_list_sticky'] == 1) {
        global $wp_query;
        $query_vars = $wp_query->query_vars;
        $query_vars['ignore_sticky_posts'] = 1;
        query_posts($query_vars);
      }
      while(have_posts()):the_post();
      $format = get_post_format();
      get_template_part('templates/tpl-loop',$format);
      endwhile;
      ?>
    </div>
    <?php get_template_part('templates/tpl-pagenavi'); ?>
  </div>
  <aside role="sidebar">
    <?php get_sidebar(); ?>
  </aside>
</div>
<?php get_footer(); ?>