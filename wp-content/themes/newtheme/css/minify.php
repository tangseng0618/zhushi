<?php

header("Cache-Control: private, max-age=10800, pre-check=10800");
header("Pragma: private");
header("Expires: " . date(DATE_RFC822,strtotime("+2 days")));
if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])){
  header('Last-Modified: '.$_SERVER['HTTP_IF_MODIFIED_SINCE'],true,304);
  exit;
}

require(dirname(__FILE__).'/../../../../wp-load.php');

global $admin_options;
$style = $admin_options['style'] ? $admin_options['style'] : 'green';
//$style = isset($_GET['style']) && !empty($_GET['style']) ? $_GET['style'] : $style;
$narrow = (int)$admin_options['response_narrow_width'];
$pad = (int)$admin_options['response_pad_width'];
$phone = (int)$admin_options['response_phone_width'];

function get_file_content($file) {
  if(file_exists($file)){
   $fp = fopen($file,"r");
   $content = fread($fp,filesize($file));
   fclose($fp);
   $content = trim($content);
   if($content) {
     $find = array(
       "/\t|\r|\n|\r\n/",
       "/\/\*(.*?)\*\//is",
       "/ *{ */",
       "/ *} */",
       "/ *, */",
       "/ *: */",
       "/ *; */"
     );
     $replace = array(
       '',
       '',
       '{',
       '}',
       ',',
       ':',
       ';'
     );
     $content = preg_replace($find,$replace,$content);
     $content = str_replace('../..','..',$content);
     return $content;
   }
   else {
    return null;
   }
  }
  return false;
}


header('Content-type: text/css; charset=utf-8');

$base = dirname(__FILE__);

$file = $base."/base.css";
$content = get_file_content($file);
echo $content;

$file = $base."/$style/style.css";
$content = get_file_content($file);
echo $content;

if($narrow) {
  echo '@media screen and (max-width: '.$narrow.'px) {';
  $file = $base."/narrow.css";
  $content = get_file_content($file);
  if($content) {
    echo $content;
  }
  $file = $base."/$style/narrow.css";
  $content = get_file_content($file);
  if($content) {
    echo $content;
  }
  echo '}';
}

if($pad) {
  echo '@media screen and (max-width: '.$pad.'px) {';
  $file = $base."/pad.css";
  $content = get_file_content($file);
  if($content) {
    echo $content;
  }
  $file = $base."/$style/pad.css";
  $content = get_file_content($file);
  if($content) {
    echo $content;
  }
  echo '}';
}

if($phone) {
  echo '@media screen and (max-width: '.$phone.'px) {';
  $file = $base."/phone.css";
  $content = get_file_content($file);
  if($content) {
    echo $content;
  }
  $file = $base."/$style/phone.css";
  $content = get_file_content($file);
  if($content) {
    echo $content;
  }
  echo '}';
}