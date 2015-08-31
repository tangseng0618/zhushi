<div class="dialog" id="user-login-dialog">
  <div class="dialog-bg"></div>
  <div class="dialog-content">
    <div class="dialog-container">
      <a class="dialog-close close">&times;</a>
      <form method="post" name="user_login" action="<?php echo get_template_directory_uri(); ?>/ajax/login.php">
      <div class="dialog-title">用户登录</div>
      <div class="dialog-text">
        <p><label><span>邮箱：</span><input type="email" name="user_email"></label></p>
        <p><label><span>密码：</span><input type="password" name="user_pass"></label></p>
        <p class="dialog-warning">&nbsp;</p>
      </div>
      <div class="dialog-btns">
        <button type="submit" class="btn btn-submit">登录</button>
        <button type="button" class="close btn btn-cancel">取消</button>
        <span><a href="javascript:void(0)" onclick="setTimeout(function(){$('#user-area .register').trigger('click');},1000);$('#user-register-dialog .dialog-close').trigger('click');">注册</a></span>
        <span><a href="<?php echo wp_lostpassword_url(); ?>">忘记密码？</a></span>
        <?php wp_nonce_field(); ?>
      </div>
      </form>
    </div>
  </div>
</div>
