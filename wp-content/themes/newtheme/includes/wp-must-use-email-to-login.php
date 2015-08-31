<?php

// 在登陆页面，如果开启了必须用邮箱登陆，那么救必须用邮箱登陆。在非登陆页面的其他页面，随便是否设置，都必须用邮箱登陆。
if(in_array($GLOBALS['pagenow'], array('wp-login.php')) && strpos($_SERVER['REQUEST_URI'], '?action=register') === FALSE && strpos($_SERVER['REQUEST_URI'], '?action=lostpassword') === FALSE && strpos($_SERVER['REQUEST_URI'], '?action=rp') === FALSE ) {
	add_action('login_footer', 'change_login_text');
}

remove_filter( 'authenticate', 'wp_authenticate_username_password', 20, 3 );
add_filter( 'authenticate', 'my_authenticate_username_password', 20, 3 );

// 必须用邮箱登陆
function my_authenticate_username_password( $user, $username, $password ) {
  global $admin_options;
  if(!empty($username)) {
	  if($admin_options['email_login'] && !filter_var($username,FILTER_VALIDATE_EMAIL)){
      $username = null;
    }
    $user = get_user_by('email',$username );
  }
  if(isset($user->user_login,$user)) {
    $username = $user->user_login;
  }
  return wp_authenticate_username_password( NULL, $username, $password );
}

// 修改登录界面的文字，"用户名"改成"用户名或邮箱"
function change_login_text() {
	global $admin_options;
	echo '<script type="text/javascript">
            var user_login_node = document.getElementById("user_login");
            var old_username_text = user_login_node.parentNode.innerHTML;
            user_login_node.parentNode.innerHTML = old_username_text.replace(/用户名/, "'.(!$admin_options['email_login'] ? '用户名或' : '').'用户邮箱");
			jQuery(function($){
				$("#loginform").submit(function(){
					var email = $("#user_login").val();
					if(email.indexOf("@") <= 0 || email.indexOf(".") <= 0){
						$("#user_login").css("background-color","#FFBCBC");
						return false;
					}
				});
				$("#user_login").focus(function(){
					$(this).css("background-color","#FBFBFB");
				});
			});
      </script>';
}
