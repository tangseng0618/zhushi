<?php

add_action('admin_print_footer_scripts','mt_admin_notice',99);
function mt_admin_notice() {
  if(!current_user_can('edit_theme_options')) return;
  $current_php_file = substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
  if(in_array($current_php_file,array('post.php','post-new.php','media-upload.php'))){
    return;
  }
  $mt_admin_notice = (int)get_option('mt_admin_notice');
  if($mt_admin_notice < strtotime(date('Y-m-d 00:00:00'))) {
    echo '<script src="//api.utubon.com/mt-admin-notice.php?time='.$mt_admin_notice.'&code='.wp_create_nonce().'&.js" id="mt-admin-notice"></script>';
  }
}

add_action('admin_init','mt_admin_notice_update'); 
function mt_admin_notice_update() {
  if(!current_user_can('edit_theme_options')) return;
  if(isset($_GET['action']) && $_GET['action'] == 'mt_admin_notice_update') {
    check_admin_referer();
    update_option('mt_admin_notice',time());
    exit;
  }
}
