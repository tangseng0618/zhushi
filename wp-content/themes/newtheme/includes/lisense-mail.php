<?php

function mt_lisense_mail() {
  if(get_option('mt_lisense_mail')) return;
  $home_url = home_url();
  $home_url = str_replace('http://','',$home_url);
  $home_url = str_replace('https://','',$home_url);
  $admin_email = get_option('admin_email');
  $message = "网站地址：$home_url \n管理员邮箱：$admin_email \n版本：".MT_THEME_VERSION;
  $result = wp_mail('frustigor@qq.com',"[Magix Tech]有新网站使用了MT主题 $home_url ".MT_THEME_VERSION,$message);
  if($result) update_option('mt_lisense_mail',1);
}
add_action('after_setup_theme','mt_lisense_mail');
