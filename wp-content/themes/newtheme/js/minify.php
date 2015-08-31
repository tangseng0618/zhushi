<?php

require(dirname(__FILE__).'/../../../../wp-load.php');

global $admin_options;
$base = dirname(__FILE__);
$script_arr = isset($_GET['scripts']) && strpos($_GET['scripts'],',') !== false ? explode(',',$_GET['scripts']) : array();

header('Content-type: application/javascript; charset=utf-8');

function get_file_content($file) {
  if(file_exists($file)){
   $fp = fopen($file,"r");
   $content = fread($fp,filesize($file));
   fclose($fp);
   $content = trim($content);
   if($content) {
     $find = array(
       '/\/\*(.*?)\*\//is'
     );
     $replace = array(
       ''
     );
     $content = preg_replace($find,$replace,$content);
     return $content;
   }
   else {
    return null;
   }
  }
  return false;
}

$scripts = array();
$scripts[] = $base.'/jquery-2.1.1.min.js';
$scripts[] = $base.'/idangerous.swiper.min.js';
$scripts[] = $base.'/pagenavi-ajax.js';
if(in_array('fixed_widget',$script_arr)){
  $scripts[] = $base.'/fixed-widget.js';
}
if(in_array('img_lazyload',$script_arr)) {
  $scripts[] = $base.'/jquery.lazyload.min.js';
}
$scripts[] = $base.'/javascript.js';

if(in_array('dialog',$script_arr)) {
  $scripts[] = $base.'/dialog.js';
}
if(in_array('comment',$script_arr)) :
  $scripts[] = ABSPATH.'/wp-includes/js/comment-reply.js';
  $scripts[] = $base."/comment.js";
endif;


foreach($scripts as $script) {
  $content = get_file_content($script);
  echo $content."\n";
}

