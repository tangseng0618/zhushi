<?php

function add_post_metas_box_arr() {
  return array(
    //'text' => '章节',
    'checkbox' => '不在列表中显示缩略图'
  );
}

// 添加后台界面meta_box
add_action('add_meta_boxes','add_post_metas_box_init');
function add_post_metas_box_init(){
	add_meta_box(
		'post-metas',
        '附加选项',
        'add_post_metas_box',
        'post',
        'side',
        'high'
	);
}
function add_post_metas_box($post){
	echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <ins class="adsbygoogle" style="display:inline-block;width:200px;height:200px" data-ad-client="ca-pub-0625745788201806" data-ad-slot="3579010425"></ins>
        <script>(adsbygoogle = window.adsbygoogle || []).push({});</script><small style="color:#ccc;float:right;">付费版主题去广告</small>';
  $metas = add_post_metas_box_arr();
	foreach($metas as $type => $meta) {
	  $meta_value = get_post_meta($post->ID,$meta,true);
	  if($type == 'text') {echo '<p><label>'.$meta.'：'.'<input type="text" class="regular-text" style="max-width:80%;" name="post_metas['.$meta.']" value="'.$meta_value.'"></label></p>';}
    elseif($type == 'checkbox') {echo '<p><label><input type="checkbox" name="post_metas['.$meta.']" value="1" '.checked($meta_value,1,false).'> '.$meta.'</label></p>';}
	}
	// 循环使用上面的代码，修改$meta_key就可以了
}

// 保存填写的meta信息
add_action('save_post','add_post_metas_box_save');
function add_post_metas_box_save($post_id){
	$metas = add_post_metas_box_arr();
  if(isset($_POST['post_metas']) && !empty($_POST['post_metas']))
		foreach($metas as $meta) {
      if(isset($_POST['post_metas'][$meta]) && trim($_POST['post_metas'][$meta])) {
        $value = trim($_POST['post_metas'][$meta]);
        if($value) update_post_meta($post_id,$meta,$value);
			  else delete_post_meta($post_id,$meta);
      }
      else {
        delete_post_meta($post_id,$meta);
      }
    }
}

// 添加meta短代码
add_shortcode('meta','add_meta_shortcode_in_post');
function add_meta_shortcode_in_post($atts){
	extract(shortcode_atts(array(
		'key' => ''
	),$atts));
	global $post;
	$value = get_post_meta($post->ID,$key,true);
	return $value;
}
