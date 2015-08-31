<?php

// 左侧菜单 data是用来做一个提示的作用，在view中便于调用
$admin_options_config['menu'] = array(
  array(
    'id' => 'global',
    'name' => '全局'
  ),
  array(
    'id' => 'flash',
    'name' => '幻灯',
    'data' => array(
      'img_size' => '800*370'
    )
  ),
  array(
    'id' => 'seo',
    'name' => 'SEO'
  ),
  array(
    'id' => 'metas',
    'name' => 'Post Metas'
  ),
  array(
    'id' => 'social',
    'name' => '社交媒体'
  ),
  array(
    'id' => 'ads',
    'name' => '广告'
  ),
  array(
    'id' => 'payfor',
    'name' => '付费使用'
  )
);

// 设置，用来作为系统的配置
$admin_options_config['settings'] = array(
  'page' => 'admin-options'
);

// 初始值，即$admin_options[key] = value的初始值
$admin_options_config['defaults'] = array(
  'style' => 'green',
  'response_phone_width' => 480,
  'response_pad_width' => 640,
  'response_narrow_width' => 1110
);
