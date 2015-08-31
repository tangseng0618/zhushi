// ctrl + enter提交
$('#comment').keypress(function(e){
  if(e.ctrlKey && e.which == 13 || e.which == 10) {
    $('#commentform').submit();
  }
});

// Ajax提交
$('#commentform').submit(function(e){
  e.preventDefault();
  var $this = $(this),
      $submit = $this.find('button.btn-submit'),
      submit = $submit.text(),
      $respond = $('#respond'),
      $comment = $('#comment'),
      comment_parent = $('#comment_parent').val();
  if($submit.attr('disabled')) return false;
  $.ajax({
    url : _options_.template_url + '/ajax/comment.php',
    data : $this.serialize(),
    dataType : 'html',
    type : 'POST',
    timeout : 80000,
    beforeSend : function(){
      $submit.text('正在提交').attr('disabled', true).fadeTo(500, 0.5);
    },
    success : function(data){
      var $comment_title = $('#comments-title'),
          $comment_list = $('#comments-lists'),
          title = '',
          html = '',
          amount = 0,
          wait = 15,
          $timer;
      if($comment_title.length <= 0) {
        $respond.before('<div id="comments-title"></div>');
      }
      if($comment_list.length <= 0){
        $respond.before('<ol id="comments-lists"></ol>');
      }
      else {
        amount = $comment_list.find('li').length;
      }
      amount ++;
      $('#comments-title').text('已有' + amount + '条评论');
      if(comment_parent == 0) {
        $(data).hide().appendTo('#comments-lists').fadeIn(500);
      }
      else {
        $(data).hide().insertBefore('#respond').fadeIn(500);
      }
      $comment.val('');
      $submit.text('回复成功');
      $submit.append('<span id="submit-stop" style="margin-left:10px;">(' + wait + ')</span>');
      $timer = setInterval(function(){
        wait --;
        if(wait <= 0){
          $('#submit-stop').remove();
          $submit.attr('disabled', false).fadeTo(500, 1).text(submit);
          clearInterval($timer);
        }
        else {
          $('#submit-stop').text('(' + wait + ')');
        }
      },1000);
    },
    error : function(xhr,textStatus){
      var error = '提交出错';
      if(textStatus == 'timeout')error = '连接超时';
      error += ' 稍后再试';
      $submit.text(error);
      setTimeout(function(){
        $submit.attr('disabled', false).fadeTo(500, 1).text(submit);
      },2000);
    }
  });
});

// 点击修改评论者信息
$('#toggle-comment-author-info').on('click',function(){
  var $this = $(this),
      $info_area = $('#comment-author-info'),
      changeMsg = '修改信息',
      closeMsg = '隐藏信息';
  $info_area.slideToggle(500,function(){
    if($info_area.is(':hidden')) {
      $this.text(changeMsg);
    }
    else {
      $this.text(closeMsg);
    }
  });
});