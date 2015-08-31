/*
 * 响应式
 */

// 添加导航菜单
$(window).resize(function(){
  var window_width = $(window).width(),$menu = $('#response-menu');
  if(window_width <= _options_.response_phone_width) {
    if($menu.length <= 0) {
      $('#menu').before('<a id="response-menu"></a>');
      $('#search-area').insertBefore('#menu');
      $menu = $('#response-menu');
    }
    $menu.show();
    $('#menu .sub-menu').show();
    $('#menu,#search-area').not('.phone-hidden').hide().addClass('phone-hidden');
  }
  else {
    $menu.hide();
  }
}).resize();
$('body').on('click','#response-menu',function(){
  $('#menu,#search-area').slideToggle();
});
// 显示边栏
$(window).resize(function(){
  if($(window).width() > _options_.response_phone_width) {
    $('.phone-hide-sidebar').remove();
  }
});


/*
 * 页面需要尽快加载的代码
 */

// 下拉菜单效果
$(window).resize(function(){
  if($(window).width() <= _options_.response_phone_width) {
    $('#menu .menu-item-has-children').unbind('mouseenter mouseleave');
    return;
  }
  $('#menu,#search-area').show().removeClass('phone-hidden');
  $('#menu .sub-menu').hide();
  var $timer = {};
  $timer.menu = false;
  $('#menu .menu-item-has-children').bind('mouseenter',function(){
    var $this = $(this),$child = $this.children('.sub-menu');
    $('#menu .menu-item-has-children .sub-menu').fadeOut(100);
    $child.hide();
    clearTimeout($timer.menu);
    $timer.menu = setTimeout(function(){
      $child.fadeIn(300);
    },200);
  }).bind('mouseleave',function(){
    var $this = $(this),$child = $this.children('.sub-menu');
    clearTimeout($timer.menu);
    $timer.menu = setTimeout(function(){
      $child.fadeOut(100);
    },100);
  });
}).resize();
// 响应式布局切换css
$(window).resize(function(){
  var window_width = $(window).width(),
      $response_base_style = $('#response-base-style'),
      $response_pend_style = $('#response-pend-style');
  if(window_width <= _options_.response_phone_width) {
    $response_base_style.attr('href',_options_.template_url + '/css/phone.css');
    $response_pend_style.attr('href',_options_.template_url + '/css/' + _options_.style_color + '/phone.css');
  }
  else if(window_width <= _options_.response_pad_width) {
    $response_base_style.attr('href',_options_.template_url + '/css/pad.css');
    $response_pend_style.attr('href',_options_.template_url + '/css/' + _options_.style_color + '/pad.css');
  }
  else if(window_width <= _options_.response_narrow_width) {
    $response_base_style.attr('href',_options_.template_url + '/css/narrow.css');
    $response_pend_style.attr('href',_options_.template_url + '/css/' + _options_.style_color + '/narrow.css');
  }
  else {
    $response_base_style.removeAttr('href');
    $response_pend_style.removeAttr('href');
  }
}).resize();
// 幻灯
if($('#slider').length > 0) {
  $(window).resize(function(){
    var window_width = $(window).width();
    if(window_width <= _options_.response_pad_width) {
      $('#slider').insertBefore('#main');
    }
    else {
      $('#slider').prependTo('#content');
    }
  }).resize();
}
if($('#slider .swiper-slide').length > 1) {
  var $slider = $('#slider'),
      slide_width = $slider.width(),
      slide_prop = 0.4625,
      slide_height = slide_width*slide_prop;
  $slider.height(slide_height);
  $('#slider .swiper-slide').show();
  $(window).resize(function(){
    slide_width = $slider.width();
    slide_height = slide_width*slide_prop;
    $slider.height(slide_height);
  });
  $('#load-page-scripts').before('<script src="' + _options_.template_url + '/js/idangerous.swiper.min.js">\x3C/script>');
  var swiper = new Swiper('#slider', {
    pagination : '#slider .swiper-pagination',
    loop : true,
    grabCursor: true,
    autoplay : '5000',
    paginationClickable : true
  });
}
// 弹出窗口
if($('.dialog').length > 0) {
  $('#load-page-scripts').before('<script src="' + _options_.template_url + '/js/dialog.js">\x3C/script>');
}

// 图片延时加载
if(_options_.img_lazyload && $('.post img').length > 0) {
  $('#load-page-scripts').before('<script src="' + _options_.template_url + '/js/jquery.lazyload.min.js">\x3C/script>');
  $('.post img').not('.pagenavi-loading-image').lazyload({effect:"fadeIn",threshold:200});
}
// 固定边栏
if($('#fixed-sidebar').length > 0 && $(window).width() > _options_.response_phone_width) {
  $('#load-page-scripts').before('<script src="' + _options_.template_url + '/js/fixed-widget.js">\x3C/script>');
  $.fixedwidget({
    fixedObj : '#fixed-sidebar',
    bottomObj : '#footer',
    fixedPos : 10
  });
}
// 无限加载
if($('#pagenavi').length > 0 && _options_.pagenavi_num > 0) {
  $('#load-page-scripts').before('<script src="' + _options_.template_url + '/js/pagenavi-ajax.js">\x3C/script>');
  $.pagenavajax({
    loading_html : '<img src="' + _options_.template_url + '/images/loading.gif" style="clear:both;display:block;margin:0 auto;text-align:center;" alt="正在加载..." class="pagenavi-loading-image" />',
    pagenav : '#pagenavi',
    container : '#post-list',
    pendObj : 'div.post',
    startPos : 50,
    currentNav : 'span.current',
    real_current_page : _options_.real_current_page,
    nav_page_num : _options_.pagenavi_num,
    is_forever_btn : false,
    call_before_fun : function() {
      if(_options_.img_lazyload && $('.post img').length > 0)$('.post img').addClass('lazyload');
    },
    call_back_fun : function(){
      if(_options_.img_lazyload && $('.post img').length > 0 && $('.post img').not('.lazyload').length > 0) {
        $('.post img').not('.lazyload').lazyload({effect:"fadeIn",threshold:200});
      }
    }
  });
}
// 返回顶部按钮
$('body').append('<a href="javascript:void(0);" class="to-top" id="to-top-btn"></a>');
$(document).on('click','#to-top-btn',function(){
  $('html,body').animate({scrollTop:0},500);
});
$(window).scroll(function(){
  var scrollTop = $(window).scrollTop();
  if(scrollTop > 200) {
    $('#to-top-btn').fadeIn(500);
  }
  else {
    $('#to-top-btn:visible').fadeOut(500);
  }
}).scroll();


// 主要区域的高度
function set_same_height() {
  if($('#sidebar').is(':hidden')) {
    $('#main').css('min-height','0');
  }
  else {
    var left = $('#content').outerHeight(true),
        right = $('#sidebar').outerHeight(true);
    if(right > left) $('#main').css('min-height',right + 100 + 'px');
  }
}
$(window).resize(function(){
  set_same_height();
}).resize();

// 评论脚本
if($('#respond').length > 0) {
  $('#load-page-scripts').before('<script src="' + _options_.site_url + '/wp-includes/js/comment-reply.js">\x3C/script>');
  $('#load-page-scripts').before('<script src="' + _options_.template_url + '/js/comment.js">\x3C/script>');
}

/*
 * 等到加载完才执行的代码
 */
jQuery(function($){
  // 非本站链接跳出
  $(document).on('click','a',function(e){
    var href = $(this).attr('href');
    if(href.indexOf('http://') >= 0 && $href.indexOf(window.location.host) < 0){
      window.open(href);
      return false;
    }
  });
  // 等加载完再调整一下高度
  $(window).load(function(){set_same_height();});
});
