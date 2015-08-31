<?php

class AdminOptionsAds {
  var $ads;
  function __construct() {
    $this->ads = array();
    add_shortcode('ad',array($this,'add_ad_shortcode'));
    add_filter('widget_text','do_shortcode');
  }
  function add_ad_shortcode($atts){
    global $admin_options;
    $ads = array_admin_options($admin_options['ads']);
    extract(shortcode_atts(array(
      'name' => ''
    ), $atts));
    if(isset($ads[$name])){
      $id = $name.'-'.rand(1000,9999);
      $this->ads[$id] = stripslashes($ads[$name]);
      add_action('wp_footer',array($this,'print_ad_code'));
      return '<div id="admin-options-ad-'.$id.'"></div>';
    }
  }
  function print_ad_code() {
    if(!empty($this->ads)) foreach($this->ads as $id => $code) {
      if(!$code) continue;
      echo '<div id="admin-options-ad-'.$id.'-pend" style="display:none;">'.$code.'</div>';
      echo '<script>jQuery("#admin-options-ad-'.$id.'").html(jQuery("#admin-options-ad-'.$id.'-pend").html())</script>'."\n";
    }
  }
}
$AdminOptionsAds = new AdminOptionsAds();