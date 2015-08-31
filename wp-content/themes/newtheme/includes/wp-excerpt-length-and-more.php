<?php

/**
 * 这个文档用来处理文章在首页或列表页显示摘要（内容）的尾巴（more-link）
 */

// 摘要的长度
add_filter('excerpt_length','custom_excerpt_length',99);
function custom_excerpt_length($length){
  return 80;
}
// 摘要的末尾链接
add_filter('excerpt_more','new_excerpt_more',109);
function new_excerpt_more($more){
  return '... <a class="more-link" href="'.get_permalink(get_the_ID()).'" rel="nofollow">继续阅读 &raquo;</a>';
}

/** 处理首页文章内链接，一般首页文章内部不需要链接，从而提供SEO效果 **/
// 第一步，使用一个格式化的尾巴链接
add_filter('the_content_more_link','new_content_more',99);
function new_content_more($more){
  return '... {more-link}继续阅读 &raquo;{/more-link}';
}
// 第二步，把首页内容中的链接去除
add_filter('the_content','remove_content_link_tag',100);
function remove_content_link_tag($content){
  global $post;
  if(get_post_format($post->ID) != '' && $post->post_type == 'post')return $content;
  if(is_singular())return $content;
  return ereg_replace("<a[^>]*>|<\/a>","",$content);
}
// 第三步，把格式化的尾巴链接还原为真实的链接
add_filter('the_content','fix_content_more',101);
function fix_content_more($content){
  $content = str_replace('{more-link}','<a class="more-link" href="'.get_permalink(get_the_ID()).'#more-'.get_the_ID().'" rel="nofollow">',$content);
  $content = str_replace('{/more-link}','</a>',$content);
  return $content;
}
// 首页列表页等如果文章已经显示完整，则提供一个评论按钮（这个是可选的，因为有的时候提供这个评论链接影响美观）
//add_filter('the_content','add_content_comment_link',102);
function add_content_comment_link($content){
  global $post;
  if(strpos($post->post_content,'<!--more-->') === false && !is_singular() && $post->post_type == 'post'){
    $content .= '<a class="more-link" href="'.get_permalink(get_the_ID()).'#respond" rel="nofollow">点评该文 &raquo;</a>';
  }
  return $content;
}
