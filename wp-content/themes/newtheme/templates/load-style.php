<?php
global $admin_options;
$style = $admin_options['style'] ? $admin_options['style'] : 'green';
$type = (int)$admin_options['script_load_type'];
$narrow = (int)$admin_options['response_narrow_width'];
$pad = (int)$admin_options['response_pad_width'];
$phone = (int)$admin_options['response_phone_width'];
// 脚本动态加载
if($type == 2) {

?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/base.css">
<?php
$template_url = get_template_directory_uri();
$base_path = dirname(__FILE__).'/../css/'.$style.'/';
$base_url = $template_url.'/css/'.$style.'/';
$file = 'style.css';
if(file_exists($base_path.$file))echo '<link rel="stylesheet" href="'.$base_url.$file.'">';
if($narrow || $pad || $phone) {
?>
<script>
var window_width = window.innerWidth || document.documentElement.clientWidth || document.body.offsetWidth,
    $response_base_style = '<link rel="stylesheet" id="response-base-style"',
    $response_pend_style = '<link rel="stylesheet" id="response-pend-style"';
// 响应式样式
<?php if($narrow) { ?>
if(window_width <= _options_.response_phone_width) {
  $response_base_style += ' href="<?php echo $template_url; ?>/css/phone.css"';
  $response_pend_style += ' href="<?php echo $base_url; ?>/phone.css""';
}
<?php } if($pad) { ?>
else if(window_width <= _options_.response_pad_width) {
  $response_base_style += ' href="<?php echo $template_url; ?>/css/pad.css"';
  $response_pend_style += ' href="<?php echo $base_url; ?>/pad.css""';
}
<?php } if($phone) { ?>
else if(window_width <= _options_.response_narrow_width) {
  $response_base_style += ' href="<?php echo $template_url; ?>/css/narrow.css"';
  $response_pend_style += ' href="<?php echo $base_url; ?>/narrow.css""';
}
<?php } ?>
$response_base_style += '>';
$response_pend_style += '>';
document.write($response_base_style + $response_pend_style);
</script>
<?php //--
}// --

}
// PHP压缩加载
elseif($type == 1) {

?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/minify.php?style.css">
<?php //--

}
// 普通链入加载
else {

?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/base.css">
<?php
$template_url = get_template_directory_uri();
$base_path = dirname(__FILE__).'/../css/'.$style.'/';
$base_url = $template_url.'/css/'.$style.'/';
$file = 'style.css';
if(file_exists($base_path.$file))echo '<link rel="stylesheet" href="'.$base_url.$file.'">'."\n";
if($narrow){
  echo '<link rel="stylesheet" href="'.$template_url.'/css/narrow.css" media="screen and (max-width: '.$narrow.'px)">'."\n";
  $file = 'narrow.css';
  if(file_exists($base_path.$file)) echo '<link rel="stylesheet" href="'.$base_url.$file.'" media="screen and (max-width: '.$narrow.'px)">'."\n";
}
if($pad) {
  echo '<link rel="stylesheet" href="'.$template_url.'/css/pad.css" media="screen and (max-width: '.$pad.'px)">'."\n";
  $file = 'pad.css';
  if(file_exists($base_path.$file)) echo '<link rel="stylesheet" href="'.$base_url.$file.'" media="screen and (max-width: '.$pad.'px)">'."\n";
}
if($phone) {
  echo '<link rel="stylesheet" href="'.$template_url.'/css/phone.css" media="screen and (max-width: '.$phone.'px)">'."\n";
  $file = 'phone.css';
  if($phone && file_exists($base_path.$file)) echo '<link rel="stylesheet" href="'.$base_url.$file.'" media="screen and (max-width: '.$phone.'px)">'."\n";
}

}