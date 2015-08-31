(function(jQuery) {    
  jQuery.fixedwidget = function(options) {    
    var opts = jQuery.extend({}, jQuery.fixedwidget.defaults, options);
    var $window = jQuery(window),$windowHeight = $window.height(),
      $document = jQuery(document),$documentHeight = $document.height(),
      fixedObj = opts.fixedObj,
      bottomObj = opts.bottomObj,
      fixedPos = opts.fixedPos,
      $this = jQuery(fixedObj),
      $height = $this.height(),
      $width = $this.width(),
      $top = $this.offset().top,
      $left = $this.offset().left,
      bottom = jQuery(bottomObj).offset().top,
      startPos = $top - fixedPos;
    jQuery(document).ready(function(){
      if(jQuery('#wpadminbar').length > 0 && jQuery('#wpadminbar').is(':visible'))startPos -= 25;
      if(jQuery('#wpadminbar').length > 0 && jQuery('#wpadminbar').is(':visible'))fixedPos += 25;      
    });
    jQuery(window).scroll(function(){
      var $window = jQuery(window),
          $scrollTop = $window.scrollTop(),
          bottom = jQuery(bottomObj).offset().top,$height = $this.height(),
          $is_fixed = false;
      if($scrollTop <= startPos){
        $this.css({'position':'static'});
        if($is_fixed)typeof opts.end_fun == 'function' && opts.end_fun.call(this);// 当从滑动固定返回到静态时
        $is_fixed = false;
        $top = jQuery(fixedObj).offset().top;// 当屏幕加载完，有些图片没有加载的时候，top初始值是有问题的，当返回静态的时候重新获取这个值
        startPos = $top - fixedPos;
        $left = $this.offset().left;
        jQuery(fixedObj).css('width','auto');
        $width = jQuery(fixedObj).width();
      }else if($scrollTop > startPos && ($scrollTop + fixedPos + $height) < bottom){
        if(!$is_fixed)typeof opts.pre_fun == 'function' && opts.pre_fun.call(this);// 当从顶部进入开始滑动固定时
        $is_fixed = true;
        $this.css({'position':'fixed',top:fixedPos,left:$left,'z-index':'999'});
      }else if(($scrollTop + fixedPos + $height) >= bottom){
        $fixTop = bottom - ($scrollTop + $height + fixedPos);
        $this.css({top:$fixTop});
      }
      $this.width($width);
    }).resize(function(){
      $this.css({'position':'static'});
      $left = jQuery(fixedObj).offset().left;
      $top = jQuery(fixedObj).offset().top;
      startPos = $top - fixedPos;
      jQuery(fixedObj).css('width','auto');
      $width = jQuery(fixedObj).width();
      jQuery(window).scroll();
    }).scroll().resize();
  };
  // 插件的defaults    
  jQuery.fixedwidget.defaults = {
    fixedObj : '#fixed-sidebar',
    bottomObj : '#footer',
    fixedPos : 0,
    pre_fun : null,
    end_fun : null
  };
})(jQuery); 