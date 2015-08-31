(function(jQuery) {

/***
jQuery pagenavi 无限拖翻页插件
作者：否子戈
插件页面：http://www.utubon.com/jquery-plugin-pagenav-ajax/
使用方法和注意事项在插件页面已经说明，可以联网查询。
***/

  // 插件的定义
  jQuery.pagenavajax = function(options) {    
    // 将插件的传递参数进行初始化
    var opts = jQuery.extend({}, jQuery.pagenavajax.defaults, options);
    // 监听窗口滚动事件，滚动条滚动时触发下面的动作
    jQuery(window).bind('scroll',function(){
      var $window = jQuery(window),$windowHeight = $window.height(),
        $scrollTop = $window.scrollTop(),
        $document = jQuery(document),$documentHeight = $document.height(),
        pagenav = opts.pagenav,container = opts.container,pendObj = opts.pendObj,
        startPos = opts.startPos,
        currentNav = opts.currentNav,
        loading_html = opts.loading_html,
        real_current_page = opts.real_current_page,
        nav_page_num = opts.nav_page_num,
        is_forever_btn = opts.is_forever_btn;
      // 如果传递过来的导航容器是存在的，才开始执行下面的动作
      if(jQuery(pagenav).length > 0){
        // 当滚动滚动条时，导航容器的顶部距离窗口底部小于规定的值时，才开始进行翻页动作
        if(jQuery(pagenav).offset().top - $scrollTop - $windowHeight < startPos){
          // 找到下一页的链接
          $nextPage = jQuery(pagenav).find(currentNav).next();
          // 如果找到的不是<a>标签，也就是说下面已经没有链接了，翻页结束
          if($nextPage.prop('tagName') != 'A'){
            //jQuery(pagenav).remove();
            return false;
          }
          // 如果规定nav_page_num大于0，设置为0或false为无限拖，且当前翻动的页面数大于了规定的数值时，停止翻页，把翻页导航显示出来
          if(nav_page_num > 0 && parseInt($nextPage.text()) - real_current_page > nav_page_num){
            return false;
          }
          // 如果翻页导航容器的data-loading属性为1，就不再继续往下执行
          if(jQuery(pagenav).attr('data-loading') == '1'){
            return false;
          }
          // 开始进行ajax加载
          $nextPageLink = $nextPage.attr('href');
          $ajax = jQuery.ajax({
            url : $nextPageLink,
            type : 'get',
            dataType : 'html',
            beforeSend : function(){
              // 把翻页导航容器的data-loading属性设为1，防止在翻页过程中多次加载，当ajax加载结束后，会自动把这个属性设置为0
              jQuery(pagenav).attr('data-loading','1');
              // 翻页开始，用规定的loading_html作为加载提示信息，并把翻页导航隐藏
              jQuery(pagenav).append(loading_html).find('span,a').hide();
              // 执行前置函数
              typeof opts.call_before_fun == 'function' && opts.call_before_fun.call(this);
           },
            success : function(data){
              $postList = jQuery(data).find(container + ' ' + pendObj);
              $postList.appendTo(container).hide().fadeIn();
              $pageNav = jQuery(data).find(pagenav).html();
              // 直接从找到的数据中找到新的翻页导航，替代原来的翻页导航容器内容
              jQuery(pagenav).html($pageNav);
              jQuery(pagenav).attr('data-loading','0');
              // 执行回调函数
              typeof opts.call_back_fun == 'function' && opts.call_back_fun.call(this);
              // 如果同意使用无限加载按钮，将在执行完成之后出现无限加载按钮
              if(is_forever_btn && nav_page_num > 0){
                jQuery(pagenav).append('<span style="display:none;padding-left:0;padding-right:0;" id="pagenavajax-forever"><a href="javascript:void(0);" style="border:0;color:#930E03;margin:0;">无限加载</a></span>')
                jQuery(pagenav + ' #pagenavajax-forever').css('display','inline');
              }
            }
          });
        }
      }
    }).scroll();
    // 点击无限加载按钮之后，设置的翻页数量将失效，只要往下拉将一直加载
    jQuery(document).ready(function(){
      jQuery('#pagenavajax-forever').delegate('a','click',function(){
        opts.nav_page_num = false;
        jQuery(window).scroll();
      });
    });
  };
  // 插件的defaults
  jQuery.pagenavajax.defaults = {    
    pagenav : '#pagenav', // 翻页导航的父容器
    currentNav : 'span.current', // 当前页面容器
    container : '#post-list', // 要进行处理的文章列表或内容的父容器，新加载的内容（如div.post）将被追加到该容器最后。注意，翻页导航父容器和这个容器一定要是兄弟节点，绝对不能是父子关系
    pendObj : 'div.post', // 要找的内容，例如文章列表中，要找的列表内容。注意，如果你把一些重要信息放在这个容器之外，那么将不能被加载进来
    startPos : 50, // 当翻页导航距离窗口的底部还有startPos像素时，开始执行动作
    real_current_page : 1, // 对于需要限制翻页的数量的时候（即下面的nav_page_num）必须要有一个当前为多少页，试想，如果没有这个值，程序怎么知道已经翻到第几页了呢？
    nav_page_num : 3, // 要翻的页数，注意，值为1时，翻一次就会停止无限拖，直接显示翻页导航，设置为0可以实现无限拖，且不会显示“无限加载”按钮
    is_forever_btn : true, // 是否显示无限加载按钮，如果显示，那么在翻完规定的页数之后，会增加这个按钮，点击之后将继续加载，而且是无限加载
    loading_html : '<div class="loading-pagenav">Loading...</div>', // 用来提示用户正在加载的HTML代码
    call_before_fun : null, // 前置函数，注意，没有传入参数，不能获得动作数据
    call_back_fun : null // 回调函数，注意，没有传入参数，不能获得动作数据，但因为这个函数是在加载完成之后执行，你可以直接抓取加载完成之后的数据
  };
})(jQuery);