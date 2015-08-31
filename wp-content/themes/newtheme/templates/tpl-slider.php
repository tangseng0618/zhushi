<?php
global $admin_options;
if(!empty($admin_options['flash']) && is_home() && !is_paged()) {
  $flash_list = array_values($admin_options['flash']);
  echo '<div id="slider" class="swiper-container">';
  echo '<div class="swiper-wrapper">';
  foreach($flash_list as $i => $flash){
    $src = trim($flash[0]);
    if($src == '')continue;
    $link = trim($flash[1]);
    $code = stripslashes($flash[2]);
    echo '<div class="swiper-slide'.($i == 0 ? ' swiper-first-slide' : '').'">';
    if($link) echo '<a href="'.$link.'" class="swiper-slide-link" target="_blank">';
    echo '<img src="'.$src.'" class="swiper-slide-img">';
    if($code) echo '<div class="swiper-slide-desc">'.$code.'</div>';
    if($link) echo '</a>';
    echo '</div>';
  }
  echo '</div>';
  echo '<div class="swiper-pagination"></div>';
  echo '<div class="clear"></div>';
  echo '</div>';
}