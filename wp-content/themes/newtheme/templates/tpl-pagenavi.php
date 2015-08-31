<?php
if($wp_query->max_num_pages > 1) : 
?>
<div class="pagenav" id="pagenavi">
	<?php if(function_exists('the_pagenavi'))the_pagenavi();else{ ?>
	<div class="prev"><?php next_posts_link(get_interpret('<< 旧的文章')); ?></div>
	<div class="next"><?php previous_posts_link(get_interpret('新的文章 >>')); ?></div>
	<?php } ?>
</div>
<?php
endif;