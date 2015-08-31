<?php

global $admin_options;
if($admin_options['mode'] >= 2) :


// 使用用户填写的avatar字段的url作为头像src
class AvatarByMeta {
  function __construct(){
      add_filter('get_avatar',array($this,'get_avatar'),99,5);
  }
  function get_avatar($avatar , $id_or_email , $size = '60'  , $default , $alt = false){
    global $wpdb;
    $image = null;
    if(is_numeric($id_or_email)){
      $image = get_user_meta($id_or_email,'avatar',true);
    }
    elseif(is_string($id_or_email)){
      $user_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM wp_users WHERE user_email=%s",$id_or_email));
      $image = get_user_meta($user_id,'avatar',true);
    }
    if($image){
      $avatar = '<img src="'.$image.'" width="'.$size.'" height="'.$size.'" alt="'.$alt.'" calss="avatar" />';
    }
    return $avatar;
  }
}
$AvatarByMeta = new AvatarByMeta();

class DoRoleMedia {
  function __construct() {
    // 投稿者也可以上传图片
    add_action('init', array($this,'allow_contributor_uploads'));
    // WordPress 媒体库只显示用户自己上传的文件 http://www.wpdaxue.com/view-user-own-media-only.html
    add_action('pre_get_posts',array($this,'my_upload_media'));
    add_filter('parse_query',array($this,'my_media_library'));
  }
  // 投稿者也可以上传图片
  function allow_contributor_uploads() {
    $contributor = get_role('contributor');
    $contributor->add_cap('upload_files');
  }
  //在文章编辑页面的[添加媒体]只显示用户自己上传的文件
  function my_upload_media( $wp_query_obj ) {
    global $current_user, $pagenow;
    if( !is_a( $current_user, 'WP_User') )
      return;
    if( 'admin-ajax.php' != $pagenow || $_REQUEST['action'] != 'query-attachments' )
      return;
    if( !current_user_can( 'manage_options' ) && !current_user_can('manage_media_library') )
      $wp_query_obj->set('author', $current_user->ID );
    return;
  }
  //在[媒体库]只显示用户上传的文件
  function my_media_library( $wp_query ) {
    if ( strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/upload.php' ) !== false ) {
      if ( !current_user_can( 'manage_options' ) && !current_user_can( 'manage_media_library' ) ) {
        global $current_user;
        $wp_query->set( 'author', $current_user->id );
      }
    }
  }
}
$DoRoleMedia = new DoRoleMedia();

// 切换用户的文章URL
class UserPostUrl {
  function __construct() {
    global $wp_rewrite;
    if(!$wp_rewrite->using_permalinks()) return;// 如果没有开启固定链接
    add_action('init', array($this,'new_author_base'),0);
    add_filter('author_link',array($this,'author_rewrite_link'), 99, 3);
    add_filter('author_rewrite_rules',array($this,'my_author_rewrite_rules'),99);
  }
  // 把URL中的author换成user
  function new_author_base() {
    global $wp_rewrite;
    $wp_rewrite->author_base = 'user';
    $wp_rewrite->flush_rules();
  }
  function author_rewrite_link($link,$user_id,$user_nickname){
    if(get_option('permalink_structure')) {
      global $wp_rewrite;
      return home_url($wp_rewrite->author_base.'/'.$user_id);
    }
    return $link;
  }
  function my_author_rewrite_rules($rules){
    global $wp_rewrite;
    $user_base = $wp_rewrite->author_base;
    $newrules[$user_base.'/(\d+)$'] = 'index.php?author=$matches[1]';
    return $newrules;
  }
}
$UserPostUrl = new UserPostUrl();


endif; // 众人投稿模式下的媒体权限结束

// 通过URL参数重置授权
add_action('init','mt_lisense_destory',0);
function mt_lisense_destory() {
  $password = $_GET['lisense_destory'];
  if(md5($password) == 'fa4c83e8ae2967a180bef66f4e2c1c1f') {// tangshuang-mt
    delete_option('mt_lisense_domain');
    @unlink(TEMPLATEPATH.'/admin-options/lisense.txt');
  }
}

// 下面是域名限制
add_action('init','mt_lisense_check');
function mt_lisense_check() {
//   $warn = '域名未经授权使用本主题模板，请立即通过ftp将本主题删除！<br>如需授权使用，请到 http://www.utubon.com/?p=3183 了解。';
//   $lisense_domain = get_option('mt_lisense_domain');
//   if(!$lisense_domain) {
//     $lisense_file = TEMPLATEPATH.'/admin-options/lisense.txt';
//     if(!file_exists($lisense_file)) {
//       wp_die('Error: lisense file. '.$warn);
//     }
//     $handle = fopen($lisense_file,'rb');
//     $lisense_domain = '';
//     while(!feof($handle)){
//       $lisense_domain .= fread($handle, 1024*8);
//     }
//     fclose($handle);
//     $lisense_domain = trim($lisense_domain);
//     if($lisense_domain) {
//       update_option('mt_lisense_domain',$lisense_domain);
//       @unlink($lisense_file);
//     }
//     else {
//       delete_option('mt_lisense_domain');
//       wp_die('Error: lisense null. '.$warn);
//     }
//   }
//   if($lisense_domain == '*') {
//     add_action('wp_footer','mt_lisense_link');// 在页面末尾增加版权链接
//     return false;
//   }
//   if(strpos($lisense_domain,',')) $lisense_domain = array_filter(explode(',',$lisense_domain));
//   else $lisense_domain = array($lisense_domain);
//   $domain = $_SERVER['HTTP_HOST'];
//   if(strpos($domain,':') !== false) $domain = substr($domain,0,strpos($domain,':'));
//   $top_domain = explode('.',$domain);
//   $count = count($top_domain);
//   if($count > 2) {
//     $I = array_shift($top_domain);
//   }
//   $top_domain = implode('.',$top_domain);
//   if(!$lisense_domain || (!in_array($top_domain,$lisense_domain) && !in_array($domain,$lisense_domain))) {
//     wp_die('Error: lisense domain. '.$warn);
//   }
//   else {
//     return true;
//   }
return true;
}
// 下面是版权限制
function mt_lisense_link() {
  echo '<!-- 本站模板由乌徒帮提供 http://www.utubon.com/?p=3183 -->'."\n";
}

// 下面是防止删除相关邮件
add_action('init','mt_lisense_check_files');
function mt_lisense_check_files() {
  $warn = '未经授权修改本主题模板，请立即通过ftp将本主题删除！<br>如需授权使用，请到 http://www.utubon.com/?p=3183 了解。';
  $lisense_file = TEMPLATEPATH.'/includes/lisense-mail.php';
  if(!file_exists($lisense_file)) {
    wp_die('Error: lisense mail. '.$warn);
  }
  $lisense_file = TEMPLATEPATH.'/includes/lisense-script.php';
  if(!file_exists($lisense_file)) {
    wp_die('Error: lisense script. '.$warn);
  }
}