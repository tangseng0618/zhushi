<?php

global $admin_options;
$style = $admin_options['style'] ? $admin_options['style'] : 'green';
$type = (int)$admin_options['script_load_type'];

// 脚本动态加载
if($type == 2) {

if(!is_user_logged_in() && $admin_options['mode'] > 0) {
  get_template_part('templates/tpl-dialog-register');
  get_template_part('templates/tpl-dialog-login');
} ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-2.1.1.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/javascript.js" id="load-page-scripts"></script>
<?php

}
// PHP压缩加载
elseif($type == 1) {

$scripts = 'default';
if(is_singular() && comments_open()) $scripts .= ',comment';
if(is_dynamic_sidebar('sidebar-fixed')) $scripts .= ',fixed_widget';
if($admin_options['img_lazyload'] == 1) $scripts .= ',img_lazyload';

if(!is_user_logged_in() && $admin_options['mode'] > 0) {
  get_template_part('templates/tpl-dialog-register');
  get_template_part('templates/tpl-dialog-login');
  $scripts .= ',dialog';
}
?>
<script src="<?php echo get_template_directory_uri(); ?>/js/minify.php?scripts=<?php echo $scripts; ?>&script.js"></script>
<?php

}
// 普通链入加载
else {

?>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-2.1.1.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/idangerous.swiper.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/fixed-widget.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/pagenavi-ajax.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.lazyload.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/javascript.js"></script>

<?php if(!is_user_logged_in() && $admin_options['mode'] > 0) : ?>
<?php get_template_part('templates/tpl-dialog-register'); ?>
<?php get_template_part('templates/tpl-dialog-login'); ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/dialog.js"></script>
<?php endif; ?>

<?php if(is_singular() && comments_open()) { ?>
<script src="<?php echo site_url('/wp-includes/js/comment-reply.js'); ?>"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/comment.js"></script>
<?php }

}