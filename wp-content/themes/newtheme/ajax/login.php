<?php

require(dirname(__FILE__).'/../../../../wp-load.php');

check_ajax_referer();

$info = array();
$info['user_login'] = trim($_POST['user_email']);
$info['user_password'] = trim($_POST['user_pass']);
$info['remember'] = true;
$captach = trim($_POST['user_captach']);

if(empty($info['user_login']) || empty($info['user_password'])) {
  echo json_encode(array(
    'error' => 1,
    'msg' => __('邮箱和密码都不能为空。')
  ));
  exit;
}

if(!filter_var($info['user_login'],FILTER_VALIDATE_EMAIL)){ // 如果不是邮件格式的话
  echo json_encode(array(
    'error' => 1,
    'msg' => __('请使用你的邮箱登录。')
  ));
  exit;
}

/*
$user = get_user_by('email',$info['user_login']);
if(isset($user->user_login,$user))$info['user_login'] = $user->user_login;
*/

$user_signon = wp_signon( $info, false );
if(is_wp_error($user_signon)) {
  echo json_encode(array(
    'error' => 1,
    'msg' => $user_signon->get_error_message()
  ));
  exit;
}
else {
  echo json_encode(array(
    'error' => 0,
    'msg' => __('登录成功。')
  ));
}
