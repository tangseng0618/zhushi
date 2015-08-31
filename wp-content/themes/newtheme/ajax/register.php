<?php

require(dirname(__FILE__).'/../../../../wp-load.php');

check_ajax_referer();

$name = trim($_POST['user_name']);
$email = trim($_POST['user_email']);
$pass = trim($_POST['user_pass']);
$pass2 = trim($_POST['user_pass_2']);
$captach = trim($_POST['user_captach']);

if(!get_option('users_can_register')) {
  echo json_encode(array(
    'error' => 1,
    'msg' => __('对不起，本站暂不开放注册。')
  ));
  exit;
}

if(!$name || !$email || !$pass || !$pass2) {
  echo json_encode(array(
    'error' => 1,
    'msg' => __('不能为空。')
  ));
  exit;
}

if(!is_email($email)) {
  echo json_encode(array(
    'error' => 1,
    'msg' => __('邮箱形式有问题，请检查或换一个通用邮箱。')
  ));
  exit;
}

if($pass != $pass2) {
  echo json_encode(array(
    'error' => 1,
    'msg' => __('两次输入的密码不同，请检查。')
  ));
  exit;
}

if(
  (isset($_COOKIE['HaveRegistered'.COOKIEHASH]) && $_COOKIE['HaveRegistered'.COOKIEHASH] == 'true')
  || (isset($_SESSION['HaveRegistered'.COOKIEHASH]) && $_SESSION['HaveRegistered'.COOKIEHASH] == 'true')
) {
  echo json_encode(array(
    'error' => 1,
    'msg' => __('你已经注册过账号了，今天不能再注册了。')
  ));
  exit;
}

$userdata = array(
  'user_login' => $name,
  'user_pass'  => $pass,
  'user_email' => $email
);
 
$user_reg = wp_insert_user( $userdata ) ;
 
if(is_wp_error($user_reg)) {
  echo json_encode(array(
    'error' => 1,
    'msg' => $user_reg->get_error_message()
  ));
  exit;
}
else {
  setcookie('HaveRegistered'.COOKIEHASH,'true',time()+43200,COOKIEPATH,COOKIE_DOMAIN,false);
  $_SESSION['HaveRegistered'.COOKIEHASH] = 'true';
  echo json_encode(array(
    'error' => 0,
    'msg' => $email
  ));
  exit;
}
