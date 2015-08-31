<div class="option-box" id="admin-options-<?php echo $ctrl_id; ?>">
  <form method="post" enctype="multipart/form-data">
  <h2>全局设置</h2>
  <div class="metabox-holder">
  <div class="postbox">
    <h3 class="hndle">核心设置</h3>
    <div class="inside">
      <p>色调：<select name="options[style]">
          <option value="green" <?php selected($admin_options['style'],'green'); ?>>绿色</option>
          <option value="blue" <?php selected($admin_options['style'],'blue'); ?>>蓝色</option>
        </select>
        网页的主色调。
      </p>
    </div>
    <div class="inside">
      <p>首页文章不置顶：<select name="options[home_list_sticky]">
        <option value="0">关闭</option>
        <option value="1" <?php selected($admin_options['home_list_sticky'],1); ?>>开启</option>
      </select> <small>注意，是开启的情况下才<b>不</b>置顶</small></p>
    </div>
    <div class="inside">
      <p><label>Phone版式 ≤ <input type="text" name="options[response_phone_width]" class="regular-text short-text" value="<?php echo $admin_options['response_phone_width']; ?>">px</label>，<label>Pad版式 ≤ <input type="text" name="options[response_pad_width]" class="regular-text short-text" value="<?php echo $admin_options['response_pad_width']; ?>">px</label>，<label>窄屏版式 ≤ <input type="text" name="options[response_narrow_width]" class="regular-text short-text" value="<?php echo $admin_options['response_narrow_width']; ?>">px</label>。<br><small>设置好之后用pad或手机浏览你的网站检查效果。推荐为800和480。窄屏是指在一些屏幕比较小的电脑上（平板横屏时）显示的不同的排版。留空时不使用自适应屏幕功能。</small></p>
    </div>
    <div class="inside">
      <p><label>自动加载<input type="text" name="options[pagenavi]" class="regular-text short-text" value="<?php echo $admin_options['pagenavi']; ?>">页后停止自动加载，显示页数导航。<small>不是指第几页，而是打算往后加载几页。</small></label></p>
    </div>
    <div class="inside">
      <p>$('.post img')图片延时加载：<select name="options[img_lazyload]">
        <option value="0">关闭</option>
        <option value="1" <?php selected($admin_options['img_lazyload'],1); ?>>开启</option>
      </select></p>
    </div>
  </div>
  <div class="postbox">
    <h3 class="hndle">撰稿模式设置</h3>
    <div class="inside">
      <p>撰稿模式：<select name="options[mode]">
          <option value="0">个人独撰</option>
          <option value="1" <?php selected($admin_options['mode'],1); ?>>多人合作</option>
          <option value="2" <?php selected($admin_options['mode'],2); ?>>众人投稿</option>
        </select>
        如果打算让别人注册，还需要在<a href="<?php echo admin_url('options-general.php'); ?>">常规设置</a>中开放成员注册。
      </p>
    </div>
    <div class="inside">
      <p><?php wp_dropdown_pages(array(
        'selected'              => $admin_options['page_for_tougao'],
        'name'                  => 'options[page_for_tougao]'
      )); ?> 用来作为投稿页面。</p>
    </div>
    <div class="inside">
      <p><?php wp_dropdown_pages(array(
        'selected'              => $admin_options['page_for_usercenter'],
        'name'                  => 'options[page_for_usercenter]'
      )); ?> 用来作为用户中心。</p>
    </div>
    <div class="inside">
      <p>必须使用邮箱作为账号登陆后台吗？<select name="options[email_login]">
        <option value="0">否</option>
        <option value="1" <?php selected($admin_options['email_login'],1); ?>>是</option>
      </select> <small>如选择“是”，你下次必须用邮箱登陆后台。（无论怎么选择，前台用户必须使用邮箱登陆。）</small></p>
    </div>
  </div>
  <div class="postbox">
    <h3 class="hndle">Logo 设置</h3>
    <div class="inside">
      <p><input type="text" name="options[logo]" class="regular-text" value="<?php echo $admin_options['logo']; ?>"> <a class="button upload-media">上传</a></p>
    </div>
  </div>
  <div class="postbox">
    <h3 class="hndle">版权设置</h3>
    <div class="inside">
      <?php wp_editor(stripslashes($admin_options['copyright']),'admin-options-copyright',$settings = array(
        'textarea_name' => 'options[copyright]',
        'textarea_rows' => 3
      )); ?>
    </div>
  </div>
  <div class="postbox">
    <h3 class="hndle">附加代码设置</h3>
    <div class="inside">
      <p>这里的代码会加载在body的最底部，你可以把网页统计代码、分享组件代码等放在这里。</p>
      <textarea name="options[pend_code]" class="large-text code"><?php echo stripslashes($admin_options['pend_code']); ?></textarea>
    </div>
  </div>
  <div class="postbox">
    <h3 class="hndle">css、js加载设置</h3>
    <div class="inside">
      <p>这是一个高级设置，你可以通过前台源代码来观察修改设置后的变化。</p>
      <p><select name="options[script_load_type]">
        <option value="0">普通链入加载</option>
        <option value="1" <?php selected($admin_options['script_load_type'],1); ?>>PHP压缩加载</option>
        <option value="2" <?php selected($admin_options['script_load_type'],2); ?>>脚本异步加载</option>
      </select></p>
      <ul>
        <li>普通链入加载：就跟正常的网站样式脚本加载一样，优点是稳定，缺点是加载慢，消耗流量多</li>
        <li>PHP压缩加载：通过PHP处理和显示样式和脚本，优点是把所有的脚本放到一个文档里，省流量，缺点是稍慢，稳定性欠佳</li>
        <li>脚本异步加载：通过javascript来判断是否加载某些文件，优点是省流量，在IE下也可以实现响应式，加载快，缺点是稳定性差</li>
      </ul>
    </div>
  </div>
  </div>
  <p class="submit">
    <input name="save" type="submit" class="button-primary" value="提交" />
  </p>
  <input type="hidden" name="save_admin_options" value="1" />
  <?php wp_nonce_field(); ?>
  </form>
</div>
<!-- 如果使用checkbox，很有可能在没有勾选的情况下不提交数据，导致更新失败，所以一般用select来代替checkbox -->
