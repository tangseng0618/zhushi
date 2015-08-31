<?php

//remove_action('wp_head','wp_enqueue_scripts',1);
remove_action('wp_head','feed_links',2);
remove_action('wp_head','feed_links_extra',3);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
//remove_action('wp_head','index_rel_link');
//remove_action('wp_head','parent_post_rel_link',10,0);
//remove_action('wp_head','start_post_rel_link',10,0);
//remove_action('wp_head','adjacent_posts_rel_link_wp_head',10,0);
//remove_action('wp_head','locale_stylesheet');
//remove_action('publish_future_post','check_and_publish_future_post',10,1);
//remove_action('wp_head','noindex',1);
//remove_action('wp_head','wp_print_styles',8);
//remove_action('wp_head','wp_print_head_scripts',9);
//remove_action('wp_footer','wp_print_footer_scripts');
remove_action('wp_head', 'wp_generator');
//remove_action('wp_head','rel_canonical');
//remove_action('wp_head','wp_shortlink_wp_head',10,0);
//remove_action('template_redirect','wp_shortlink_header',11,0);

// 去除头部中的版本
add_filter('the_generator', '__remove_wordpress_version');
function __remove_wordpress_version() { return NULL; }

// 去除最近评论的样式,2.8-
add_filter('wp_head','__remove_wp_widget_recent_comments_style',1);
function __remove_wp_widget_recent_comments_style() {
  if(has_filter('wp_head','wp_widget_recent_comments_style')){
    remove_filter('wp_head','wp_widget_recent_comments_style');
  }
}
// 去除最近评论的样式,2.9+
add_action('widgets_init','__remove_recent_comments_style');
function __remove_recent_comments_style() {
  global $wp_widget_factory;
  remove_action('wp_head',array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'],'recent_comments_style'));
}
