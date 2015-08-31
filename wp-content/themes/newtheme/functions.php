<?php
/**
 * @package WordPress
 * @subpackage UTUBON
 * @since UTUBON 2.0
 */

define('MT_THEME_VERSION','1.0.5');

/**
* 初始化
*/
//add_theme_support('post-formats',array('image','quote','video'));
add_theme_support('post-thumbnails');
set_post_thumbnail_size(600,371,true);
update_option('medium_size_w',600);
//update_option('medium_size_h',371);
//update_option('thumbnail_size_w',150);
//update_option('thumbnail_size_h',93);

add_editor_style('css/editor-style.css');
remove_filter('the_content', 'wptexturize');
remove_filter('the_excerpt', 'wptexturize');
remove_filter('the_title', 'wptexturize');

add_filter('pre_option_link_manager_enabled', '__return_true' );
if(!is_admin()){
  add_filter( 'show_admin_bar', '__return_false' );
  remove_action('init','_wp_admin_bar_init',9);
}

register_nav_menu('primary','主导航');

register_sidebar(array(
  'name'=>'全局边栏',
  'id' => 'sidebar-1',
  'description' => '',
  'before_widget' => '<div class="widget %2$s" id="%1$s">',
  'after_widget' => '<div class="clear"></div></div>',
  'before_title' => '<div class="widget-title"><h3>',
  'after_title' => '</h3><div class="clear"></div></div>'
));
register_sidebar(array(
  'name'=>'首页边栏',
  'id' => 'sidebar-2',
  'description' => '',
  'before_widget' => '<div class="widget %2$s" id="%1$s">',
  'after_widget' => '<div class="clear"></div></div>',
  'before_title' => '<div class="widget-title"><h3>',
  'after_title' => '</h3><div class="clear"></div></div>'
));
register_sidebar(array(
  'name' => '内页边栏',
      'id' => 'sidebar-3',
  'before_widget' => '<div class="widget %2$s" id="%1$s">',
  'after_widget' => '<div class="clear"></div></div>',
  'before_title' => '<div class="widget-title"><h3>',
  'after_title' => '</h3><div class="clear"></div></div>'
));
register_sidebar(array(
  'name'=>'全站边栏',
  'id' => 'sidebar-4',
  'description' => '',
  'before_widget' => '<div class="widget %2$s" id="%1$s">',
  'after_widget' => '<div class="clear"></div></div>',
  'before_title' => '<div class="widget-title"><h3>',
  'after_title' => '</h3><div class="clear"></div></div>'
));
register_sidebar(array(
  'name' => '固定边栏',
  'id' => 'sidebar-fixed',
  'before_widget' => '<div class="widget %2$s" id="%1$s">',
  'after_widget' => '<div class="clear"></div></div>',
  'before_title' => '<div class="widget-title"><h3>',
  'after_title' => '</h3><div class="clear"></div></div>'
));
register_sidebar(array(
  'name' => '底部左',
  'id' => 'footer-1',
  'before_widget' => '<div class="widget %2$s" id="%1$s">',
  'after_widget' => '<div class="clear"></div></div>',
  'before_title' => '<div class="widget-title">',
  'after_title' => '</div>'
));
register_sidebar(array(
  'name' => '底部中',
  'id' => 'footer-2',
  'before_widget' => '<div class="widget %2$s" id="%1$s">',
  'after_widget' => '<div class="clear"></div></div>',
  'before_title' => '<div class="widget-title">',
  'after_title' => '</div>'
));
register_sidebar(array(
  'name' => '底部右-全局链接',
  'id' => 'footer-3',
  'before_widget' => '<div class="widget %2$s" id="%1$s">',
  'after_widget' => '<div class="clear"></div></div>',
  'before_title' => '<div class="widget-title">',
  'after_title' => '</div>'
));
register_sidebar(array(
  'name' => '底部右-首页链接',
  'id' => 'footer-4',
  'before_widget' => '<div class="widget %2$s" id="%1$s">',
  'after_widget' => '<div class="clear"></div></div>',
  'before_title' => '<div class="widget-title">',
  'after_title' => '</div>'
));

include(dirname(__FILE__)."/admin-options/admin-options.php");
// 引入扩展库
$function_files_path = dirname(__FILE__).'/includes';
if(file_exists($function_files_path)):
$function_files = scandir($function_files_path);
if($function_files){
  foreach($function_files as $function_file)
    if(substr($function_file,-4) == '.php')
      include_once($function_files_path.'/'.$function_file);
}
endif;

/**
* 回复列表 用wp_list_comments()函数打印出来
*/
function mytheme_comment($comment, $args, $depth){
  $GLOBALS['comment'] = $comment; ?>
  <li <?php comment_class(); ?>>
  <div id="comment-<?php comment_ID() ?>" class="comment-box">
    <?php echo get_avatar($comment,'50'); ?>
    <div class="comment-content">
      <div class="comment-info">
        <span class="info"><?php echo get_comment_author_link(); ?></span>
        <span class="info"><?php echo get_comment_time('Y-m-d H:i:s'); ?></span>
        <span class="float-right"><?php comment_reply_link(array_merge(
            $args, array('depth' => $depth, 'max_depth' => $args['max_depth'],'reply_text' => __('<span class="icon reply"></span>回复'))
          ));
        ?></span>
        <span class="float-right comment-eidt-link"><?php edit_comment_link('<span class="icon edit"></span>编辑','','') ?></span>
      </div>
      <div class="comment-text">
      <?php comment_text(); ?>
      <?php if ($comment->comment_approved == '0')
        printf('<p class="approve">%s</p>',__('您的回复正在审核中，很快就会出现在回复列表~~')); ?>
      </div>
    </div>
  </div>
<?php }
