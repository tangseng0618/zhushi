<?php

// gravatar被墙
add_filter('get_avatar', 'get_ssl_avatar',10,5);
function get_ssl_avatar($avatar , $id_or_email , $size = '60'  , $default , $alt = false) {
   $avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/','<img src="https://secure.gravatar.com/avatar/$1?s=$2" class="avatar avatar-$2" height="'.$size.'" width="'.$size.'" alt="'.$alt.'">',$avatar);
   return $avatar;
}

/*
 * 修改默认头像，这样就不再从gavatar取头像，导致网页加载特别慢了
 */

add_filter('avatar_defaults','use_my_default_avatars');
function use_my_default_avatars($avatar_defaults) {
  $myavatar = 'my_default_avatars';
  $avatar_defaults[$myavatar] = "默认头像";
  return $avatar_defaults;
}

add_filter('get_avatar','get_my_default_avatars',10,5);// 注意，这个第三个参数必须小于99
function get_my_default_avatars($avatar , $id_or_email , $size = '60'  , $default , $alt = false) {
  if($default == 'my_default_avatars'){
    $rand = rand(1000,9999);
    $rand = $rand%5;// 这里的5是跟图片对应的，如果你准备了1000张图片，从0-999，这里就可以改为1000
    $image = get_template_directory_uri().'/images/avatar-'.$rand.'.png';
    $avatar = '<img src="'.$image.'" width="'.$size.'" height="'.$size.'" alt="'.$alt.'" class="avatar" />';
  }
  return $avatar;
}