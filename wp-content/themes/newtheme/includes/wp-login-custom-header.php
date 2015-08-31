<?php

//自定义登录页面的LOGO图片
function my_custom_login_logo() {
    echo '<style type="text/css">
        h1 a {
          width: 100% !important;
          background-image : url('.get_bloginfo('template_url').'/images/logo.png) !important;
          background-size : auto auto !important;
        }
    </style>';
}
add_action('login_head', 'my_custom_login_logo');

//自定义登录页面的LOGO链接为首页链接
add_filter('login_headerurl', create_function(false,"return get_bloginfo('url');"));

//自定义登录页面的LOGO提示为网站名称
add_filter('login_headertitle', create_function(false,"return get_bloginfo('name');"));