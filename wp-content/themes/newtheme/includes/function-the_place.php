<?php


// 面包屑导航

function the_place($homeName = false){
	?>
	<a href="<?php echo home_url('/'); ?>" title="返回 <?php bloginfo('name'); ?> 首页" rel="home"><?php if($homeName)echo $homeName;else bloginfo('name'); ?></a> &rsaquo; <?php
	if(is_category()):
		global $cat,$wp_query;
		$cat_id = $wp_query->queried_object_id;
		//$cat_id = get_query_var('cat');
		$category = get_category($cat_id);
		$output = '';$seperator = ' &rsaquo; ';
		while($category->parent){
			$category = get_category($category->parent);
			$output = '<a href="'.get_category_link($category->term_id).'" title="'.$category->cat_name.'">'.$category->cat_name.'</a>'.$seperator.$output;
		}
		echo $output;
		single_cat_title();
	endif;
	if(is_archive()){
		if(is_year())echo get_the_date('Y年');
		if(is_month())echo get_the_date('Y年n月');
		if(is_day())echo get_the_date('Y年n月d日');
	}
	if(is_tag())echo single_tag_title('',false);
	if(is_author()):global $author;$userdata = get_userdata($author);echo '作者：'.$userdata->display_name;endif;
	if(is_search() && isset($_GET['s']) && $_GET['s'] != '')echo '搜索：'.$_GET['s'];
	if(is_page()):
		global $post;$parent = $post;
		while($parent->post_parent){
			$parent = get_post($parent->post_parent);
			echo '<a href="'.get_permalink($parent->ID).'">'.$parent->post_title.'</a> &rsaquo; ';
		}
		the_title();
	endif;
	if(is_single()):
		global $post;
		if(is_attachment()):
			$parent = get_post($post->post_parent);
			$parent_title = $parent->post_title;
			$parent_id = $parent->ID;
			$parent_url = get_permalink($parent_id);
			$categories = get_the_category($parent_id);
			rewind_posts();
			$output = '';$seperator = ' &rsaquo; ';$category = $categories[0];$category->parent = $category->term_id;
			do{
				$category = get_category($category->parent);
				$output = '<a href="'.get_category_link($category->term_id).'" title="'.$category->cat_name.'">'.$category->cat_name.'</a>'.$seperator.$output;
			}while($category->parent);
			$output .= '<a href="'.$parent_url.'">'.$parent_title.'</a>'.$seperator;
			echo $output;
			the_title();
		else :
			$output = '';$seperator = ' &rsaquo; ';
			if($post->post_type != 'post'){
				$post_type_object = get_post_type_object($post->post_type);
				$post_type_name = $post_type_object->labels->singular_name;
				$post_type_link = get_post_type_archive_link($post->post_type);
				$output  = '<a href="'.$post_type_link.'" title="'.$post_type_name.'">'.$post_type_name.'</a>'.$seperator.$output;
			}else{
				$categories = get_the_category();
				if(count($categories) > 1 && 0){ // 如果需要使用到多栏目列出，去掉&& 0
					$t = '';
					foreach($categories as $category):
						$category->parent = $category->term_id;
						do{
							$category = get_category($category->parent);
							$output = '<a href="'.get_category_link($category->term_id).'" title="'.$category->cat_name.'">'.$category->cat_name.'</a>'.$seperator.$output;
						}while($category->parent);
						$t .= ' & '.substr($output,0,-10);$output = '';
					endforeach;
					$output = ' ( '.substr($t,3).' ) '.$seperator;
				}else{
					$category = $categories[0];
					do{
						$output = '<a href="'.get_category_link($category->term_id).'" title="'.$category->cat_name.'">'.$category->cat_name.'</a>'.$seperator.$output;
						$category = get_category($category->parent);
					}while($category->term_id);
				}			
			}
			echo $output;
			the_title();
		endif;
	endif;// end of single
}
