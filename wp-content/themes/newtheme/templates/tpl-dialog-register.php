<div class="dialog" id="user-register-dialog">
  <div class="dialog-bg"></div>
  <div class="dialog-content">
    <div class="dialog-container">
      <a class="dialog-close close">&times;</a>
      <form method="post" name="user_register" action="<?php echo get_template_directory_uri(); ?>/ajax/register.php">
      <div class="dialog-title">用户注册</div>
      <div class="dialog-text">
        <p><label><span>用户名：</span><input type="text" name="user_name"></label></p>
        <p><label><span>登录邮箱：</span><input type="email" name="user_email"></label></p>
        <p><label><span>密码：</span><input type="password" name="user_pass"></label></p>
        <p><label><span>确认密码：</span><input type="password" name="user_pass_2"></label></p>
        <p class="dialog-warning">&nbsp;</p>
      </div>
      <div class="dialog-btns">
        <button type="submit" class="btn btn-submit">注册</button>
        <button type="button" class="close btn btn-cancel">取消</button>
        <span><a href="javascript:void(0)" onclick="setTimeout(function(){$('#user-area .login').trigger('click');},1000);$('#user-register-dialog .dialog-close').trigger('click');">登录</a></span>
        <span><a href="<?php echo wp_lostpassword_url(); ?>">忘记密码？</a></span>
        <?php wp_nonce_field(); ?>
      </div>
      </form>
    </div>
  </div>
</div>
