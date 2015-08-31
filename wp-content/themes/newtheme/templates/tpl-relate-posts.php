<div class="relate-posts">
  <?php
  $num = 6;
  $post_id = get_the_ID();
  $cat_arr = array();
  $tag_arr = array();
  $cats = get_the_category();
  $tags = get_the_tags();
  foreach($cats as $cat){
    $cat_arr[] = $cat->cat_ID;
  }
  if($tags)foreach($tags as $tag){
    $tag_arr[] = $tag->term_id;
  }
  if(empty($tag_arr)){
    $tag_arr[0] = '不可能有的标签_'.COOKIEHASH;
  }
  query_posts(array(
    'posts_per_page' => $num,
    'ignore_sticky_posts' => 1,
    'caller_get_posts' => 1,
    'orderby' => 'date',
    'tag__in' => $tag_arr,
    'post__not_in' => array($post_id)
  ));
  if(have_posts()) : ?>
  <h3>相关文章</h3>
    <ul>
    <?php
    while(have_posts()):the_post();
      ?><li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li><?php
    endwhile;
    global $wp_query;
    if($wp_query->post_count < $num) :
      query_posts(array(
        'posts_per_page' => ($num - $wp_query->post_count),
        'ignore_sticky_posts' => 1,
        'caller_get_posts' => 1,
        'orderby' => 'date',
        'tag__not_in' => $tag_arr,
        'category__in' => $cat_arr,
        'post__not_in' => array($post_id)
      ));
      while(have_posts()):the_post(); 
        ?><li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li><?php
      endwhile;
    endif; ?>
    </ul>
  <?php else :
    query_posts(array(
      'posts_per_page' => $num,
      'ignore_sticky_posts' => 1,
      'caller_get_posts' => 1,
      'orderby' => 'date',
      'category__in' => $cat_arr,
      'post__not_in' => array($post_id)
    ));
    if(have_posts()): ?>
      <h3>相关文章</h3>
      <ul>
      <?php
      while(have_posts()):the_post(); 
        ?><li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li><?php
      endwhile; ?>
      </ul>
    <?php endif; ?>
  <?php endif; ?>
  <?php wp_reset_query(); ?>
</div>