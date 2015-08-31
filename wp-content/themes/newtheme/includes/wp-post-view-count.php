<?php

/**
* 文章浏览次数功能，即记录文章被浏览的次数
* 将set函数放置在文章循环内 setPostViews(get_the_ID());
* 将get函数放置想要显示浏览次数的地方 echo getPostViews(get_the_ID());
*/

function get_view_count($post_id = false){
	global $post;
	if(!$post_id)$post_id = $post->ID;
	$count_key = '查看次数';
	$count = get_post_meta($post_id,$count_key,true);
	if($count == ''){
		delete_post_meta($post_id,$count_key);
		add_post_meta($post_id,$count_key,'0');
		return 0;
	}
	return $count;
}
function the_view_count($post_id = ''){
	if($post_id == '')$post_id = get_the_ID();
	echo get_view_count($post_id);	
}
function set_view_count(){
	// Autosave, do nothing
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return;
	// AJAX? Not used here
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) 
			return;
	// Return if it's a post revision
	if ( false !== wp_is_post_revision( $post_id ) )
			return;
	if(!is_single())return;

	global $post;
	$post_id = $post->ID;
	$count_key = '查看次数';
	
	if(isset($_COOKIE['view_count_'.$post_id.'_'.COOKIEHASH]) && $_COOKIE['view_count_'.$post_id.'_'.COOKIEHASH] == '1')return;
	
	$count = get_post_meta($post_id,$count_key,true);
	if($count == ''){
		delete_post_meta($post_id,$count_key);
		add_post_meta($post_id,$count_key,'1');
	}else{
		$count ++ ;
		update_post_meta($post_id,$count_key,$count);
	}
	setcookie('view_count_'.$post_id.'_'.COOKIEHASH,'1',time() + 3600,COOKIEPATH,COOKIE_DOMAIN);
}

add_action('get_header','set_view_count',-99);