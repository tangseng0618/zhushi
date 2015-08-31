<div id="footer"><div class="container">
  <div class="widget-box"><?php dynamic_sidebar('footer-1'); ?></div>
  <div class="widget-box author-avatar-list"><?php dynamic_sidebar('footer-2'); ?></div>
  <div class="widget-box friend-link-list" style="margin-right:0;"><?php dynamic_sidebar('footer-3');if(is_home() && !is_paged())dynamic_sidebar('footer-4'); ?></div>
  <div class="clear"></div>
  <div id="copyright"><?php global $admin_options;$copyright = stripslashes($admin_options['copyright']);echo do_shortcode(wpautop($copyright)); ?></div>
  <div class="clear"></div>
</div></div>

<?php get_template_part('templates/load-script'); ?>

<?php wp_footer(); ?>

<?php echo stripslashes($admin_options['pend_code']); ?>
</body>
</html>
