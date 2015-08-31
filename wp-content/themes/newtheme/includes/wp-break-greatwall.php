<?php

if(!class_exists('WP_BREAK_GREATWALL')) :
class WP_BREAK_GREATWALL {
  function __construct() {
    add_filter('gettext_with_context',array($this,'disable_open_sans'),888,4);
    add_filter('get_avatar',array($this,'get_ssl_avatar'));
    add_action('wp_enqueue_scripts',array($this,'replace_open_sans'),999);
    add_action('admin_enqueue_scripts',array($this,'replace_open_sans'),999);
  }
  function disable_open_sans($translations,$text,$context,$domain) {
    if('Open Sans font: on or off' == $context && 'on' == $text) {
      $translations = 'off';
    }
    return $translations;
  }
  function get_ssl_avatar($avatar) {
    $avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/','<img src="https://secure.gravatar.com/avatar/$1?s=$2" class="avatar avatar-$2" height="$2" width="$2">',$avatar);
    return $avatar;
  }
  function replace_open_sans() {
	  wp_deregister_style('open-sans');
	  wp_register_style('open-sans','//fonts.useso.com/css?family=Open+Sans:300italic,400italic,600italic,300,400,600');
	  wp_enqueue_style('open-sans');
  }
}
$WP_BREAK_GREATWALL = new WP_BREAK_GREATWALL();
endif;
