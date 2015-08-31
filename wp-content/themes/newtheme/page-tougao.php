<?php

// 如果没有开启众人投稿模式
global $admin_options;
if($admin_options['mode'] < 2) {
  include("page.php");
  exit;
}

// 抛出异常变量
$error = '';

// 提交文章
if(isset($_POST['action']) && $_POST['action'] == 'post-article') :
  if(!wp_verify_nonce($_POST['_wpnonce'])) {
  $error = '权限过时，请刷新页面重新提交。';
  }
  elseif(!is_user_logged_in()) {
  $error = '您还没有登录，请先登录。';
  }
  else {
  $article_id = $_POST['article_id'];
  $article_title = trim($_POST['article_title']);
  $article_content = trim($_POST['article_content']);
  $article_cat = $_POST['article_cat'];

  if(!$article_title) {
    $error = '文章标题不能为空。';
  }
  elseif(!$article_content) {
    $error = '文章内容不能为空。';
  }

  if(is_numeric($article_id) && $article_id > 0 && !$error) {
    $article->ID = $article_id;
    $article->post_title = $article_title;
    $article->post_content = $article_content;
    $article->post_status = 'pending';
    $article->post_category = array($article_cat);
    $result = wp_update_post($article,true);
    if(is_wp_error($result))$error = $result->get_error_message();
  }
  elseif(!$error) {
    $article = array(
    'post_title' => $article_title,
    'post_content' => $article_content,
    'post_status' => 'pending',
    'post_category' => array($article_cat)
    );
    $result = wp_insert_post($article,true);
    if(is_wp_error($result)) $error = $result->get_error_message();
    else {
      $article_id = $result;
      // 像网站管理员投递邮件，告诉管理员有新的投稿
      $mailMessage = '<p>亲爱的站长，您好！</p><p>您的网站“'.get_bloginfo('name').'”有新的投稿，点击<a href="'.admin_url('post.php?post='.$article_id.'&action=edit').'">'.admin_url('post.php?post='.$article_id.'&action=edit').'</a>审查<！</p><p>使用Megix Tech主题的同时，欢迎前来<a href="http://www.utubon.com">乌徒帮</a>做客！</p>';
      wp_mail($admin_email,'您的网站“'.get_bloginfo('name').'”有新的投稿',$mailMessage,"content-type: text/html");
    }
  }

  if(!$error) {
    wp_redirect(add_query_arg(array(
    'id' => $article_id,
    'saved' => 'true',
    '_wpnonce' => wp_create_nonce()
    )));
    exit();
  }
  }// end else
endif;

// 编辑文章
if(isset($_GET['id']) && !empty($_GET['id'])){
  if(!wp_verify_nonce($_GET['_wpnonce'])) {
  $error = '权限过时，请刷新页面重新提交。';
  }
  else {
  $article = get_post($_GET['id']);
  if($article->post_author != get_current_user_id()) {
    $error = '你没有权限编辑这篇文章。';
  }
  elseif($article->post_status != 'pending') {
    $error = '该文已经被本站编辑处理过，不能再编辑了。';
  }
  else {
    $warning = '你正在编辑投稿文章。';
  }
  }
}
// 普通投稿者只能每天一投
elseif(!current_user_can('author')) {
  global $wpdb;
  $today_begin = date('Y-m-d 00:00:00');
  $today_end = date('Y-m-d 23:59:59');
  $user_id = get_current_user_id();
  $peding = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_author=$user_id AND post_date>'$today_begin' AND post_date<'$today_end' AND post_status='pending'");
  if($pending) {
    $error = '你今天已投了文章，还在审稿中。你还可以<a href="'.add_query_arg(array('id' => $pending,'_wpnonce' => wp_create_nonce())).'">编辑</a>它。';
  }
}

// 如果是刚刚提交了的文章，可以编辑
if(isset($_GET['saved']) && $_GET['saved'] == 'true') {
  $error = '投稿成功。在本站编辑审阅之前，你还可以对它进行<a href="'.add_query_arg('saved').'">编辑</a>。';
}


if($article) {
  $article_cats = get_the_category($article->ID);
  $article_cat = $article_cats[0];
  $article_cat = $article_cat->cat_ID;
}

// http://codex.wordpress.org/Function_Reference/wp_dropdown_categories
$args = array(
  'name'      => 'article_cat',
  'id'        => 'article-cat',
  'hierarchical'  => 1,
  'hide_empty'    => 0,
  'selected'    => $article_cat
); 

$settings = array(
  'wpautop' => false,
  'textarea_name' => 'article_content',
  'textarea_rows' => 20,
  'tinymce' => array(
  'content_css' => get_template_directory_uri().'/css/editor-style.css' 
  )
);

if($admin_options['mode'] < 2) $error = '本站尚未开通投稿通道。';

get_header(); ?>
<div id="main">
  <div id="page-tougao" class="single-page">
  <form method="post" action="<?php echo add_query_arg('time',time()); ?>">
    <h1>投稿</h1>
    <?php if($error) : ?>
    <p class="warn"><?php echo $error; ?></p>
    <?php else : ?>
    <?php if(!is_user_logged_in()) {
    echo '<p class="warn">请先登录。</p>';
    }
    elseif($warning) {
    echo '<p class="warn">'.$warning.'</p>';
    } ?>
    <p class="info"><label><span>标题：</span><input type="text" name="article_title" value="<?php echo $article->post_title; ?>"></label></p>
    <p class="info"><label><span>分类：</span><?php wp_dropdown_categories($args); ?></label></p>
    <?php wp_editor(stripslashes($article->post_content),'article-content',$settings); ?>
    <?php if(!current_user_can('upload_files')) : ?><p class="warn">您当前为普通用户，还不能上传图片，升级为专栏供稿人或团队作者之后才可以上传图片。</p><?php endif; ?>
    <p class="btns">
    <button type="submit" class="btn btn-submit btn-large float-right">投稿</button>
    <div class="clear"></div>
    </p>
    <input type="hidden" name="article_id" value="<?php echo $article->ID; ?>">
    <input type="hidden" name="action" value="post-article">
    <?php wp_nonce_field(); ?>
    <?php endif; ?>
  </form>
  </div>
</div>
<?php 

// 未登录的情况下不允许投稿
if(!is_user_logged_in()){
  add_action('wp_footer','user_must_login_script');
  function user_must_login_script() {
?>
<script>
$('#page-tougao form').on('submit',function(e){
  e.preventDefault();
  $('#user-area .login').trigger('click');
});
</script>
<?php
  }
}

add_action('wp_footer','remember_content_script');
function remember_content_script() {
  $set_cookie = date('Y-m-d H:i:s');
?>
<script>
jQuery.cookie = function(name, value, options) {
  if (typeof value != 'undefined') { // name and value given, set cookie
    options = options || {};
    if (value === null) {
      value = '';
      options.expires = -1;
    }
    var expires = '';
    if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
      var date;
      if (typeof options.expires == 'number') {
        date = new Date();
        date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
      } else {
        date = options.expires;
      }
      expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
    }
    var path = options.path ? '; path=' + options.path : '';
    var domain = options.domain ? '; domain=' + options.domain : '';
    var secure = options.secure ? '; secure' : '';
    document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
  } else { // only name given, get cookie
    var cookieValue = null;
    if (document.cookie && document.cookie != '') {
      var cookies = document.cookie.split(';');
      for (var i = 0; i < cookies.length; i++) {
        var cookie = jQuery.trim(cookies[i]);
        // Does this cookie string begin with the name we want?
        if (cookie.substring(0, name.length + 1) == (name + '=')) {
          cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
          break;
        }
      }
    }
    return cookieValue;
  }
};

function check_remember_cookie() {
  var $title = $('#page-tougao input[name=article_title]'),title = $title.val(),
    $cat = $('#page-tougao select[name=article_cat]'),cat = $cat.find('option[selected]').val(),
    $content = $('#page-tougao textarea[name=article_content]'),content = $content.val();
  if($.trim(title) == '')$title.val($.cookie('article_title'));
  if($.cookie('article_cat') != null)$cat.prop('value',$.cookie('article_cat'));
  if($.trim(content) == '')$content.val($.cookie('article_content'));
}
check_remember_cookie();

$('#page-tougao form').on('submit',function(e){
  setTimeout(function(){
    var $title = $('#page-tougao input[name=article_title]'),title = $title.val(),
      $cat = $('#page-tougao select[name=article_cat]'),cat = $cat.val(),
      $content = $('#page-tougao textarea[name=article_content]'),content = $content.val();
    if($.trim(title) != '')$.cookie('article_title',title);
    if(cat != '')$.cookie('article_cat',cat);
    if($.trim(content) != '')$.cookie('article_content',content);
  },500);
});
$(window).on('beforeunload',function(){
  setTimeout(function(){
    var $title = $('#page-tougao input[name=article_title]'),title = $title.val(),
      $cat = $('#page-tougao select[name=article_cat]'),cat = $cat.val(),
      $content = $('#page-tougao textarea[name=article_content]'),content = $content.val();
    if($.trim(title) != '')$.cookie('article_title',title);
    if(cat != '')$.cookie('article_cat',cat);
    if($.trim(content) != '')$.cookie('article_content',content);
  },500);
});
</script>
<?php
}

get_footer(); ?>
