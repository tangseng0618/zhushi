<?php get_header(); ?>
<div role="main" id="main">
  <div id="content">
    <div class="place"><?php the_place('首页'); ?></div>
    <?php if(have_posts())the_post(); ?>
    <div class="archive-info">
    <?php if ( is_day() ) : ?>
      <h1><?php printf( __( '日期归档: %s' ), '<span>' . get_the_date() . '</span>' ); ?></h1>
    <?php elseif ( is_month() ) : ?>
      <h1><?php printf( __( '月份归档: %s' ), '<span>' . get_the_date( 'F Y' ) . '</span>' ); ?></h1>
    <?php elseif ( is_year() ) : ?>
      <h1><?php printf( __( '年度归档: %s' ), '<span>' . get_the_date( 'Y' ) . '</span>' ); ?></h1>
    <?php elseif ( is_tag() ) : ?>
      <h1><?php printf( __( '标签: %s' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1>
    <?php elseif(is_category()) : ?>
      <h1><?php single_cat_title('',true); ?></h1>
      <div class="category-description"><?php echo category_description(); ?></div>
      <?php
        global $cat;
        if(is_object($cat))$cat = $cat->cat_ID;
        $category = get_category($cat);
        $post_count = $category->count;
        $children = get_categories(array(
          'parent'    => $cat,
          'hide_empty'  => false
        ));
        if(!empty($children)) :
          echo '<div class="category-children">子栏目：';
          foreach ($children as $key => $child){
            echo '<a href="'.get_category_link($child->cat_ID).'">'.$child->name.'</a>'.($key == count($children)-1 ? '' : '、');
            $post_count += $child->count;
          }
          echo '</div>';
        endif;
        if($post_count != 0)echo '<div class="category-count">共有 '.$post_count.' 篇文章</div>';
        ?>
    <?php else : ?>
      <h1><?php _e( '归档' ); ?></h1>
    <?php endif; ?>
    </div>
    <?php rewind_posts(); ?>
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
  <aside role="sidebar">
    <?php get_sidebar(); ?>
  </aside>
</div>
<?php get_footer(); ?>