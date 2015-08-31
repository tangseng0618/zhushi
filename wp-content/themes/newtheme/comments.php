<?php if('open' == $post->comment_status) : ?>

<?php if(have_comments()) : ?>
  <div id="comments-title">已有<?php comments_number('0','1','%'); ?>条评论</div>
  <ol id="comments-lists">
  <?php wp_list_comments(array('callback' => 'mytheme_comment'));?>
  </ol>
  <?php if(get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>
  <div id="comment-navi">
    <div class="prev"><?php previous_comments_link(__('<< 旧的评论')); ?></div>
    <div class="next"><?php next_comments_link(__('近期评论 >>')); ?></div>
    <div class="clear"></div>
  </div>
  <?php endif; // check for comment navigation ?>
<?php endif; // end of comment list ?>

<div id="respond">
  <?php if(get_option('comment_registration') && !is_user_logged_in()) : //如果文章设置了必须登录才能评论 ?>
  <p><?php printf(__('你必须%s才能评论！'),'<a href="'.wp_login_url().'">'.__('登录')).'</a>'; ?></p>
  <?php else : //文章不用登录就能评论 ?>
  <form action="<?php bloginfo('url'); ?>/wp-comments-post.php" method="post" id="commentform" autocomplete="off">
    <p>
      <?php if(isset($_GET['replytocom']) && $_GET['replytocom'] != ''){
        echo '<strong style="color:#f00;">';
        _e('您正在回复');
        comment_author($_GET['replytocom']);
        echo '</strong>';
      } ?>
      <?php if(is_user_logged_in()) : //如果用户已经登录 ?>
      <?php printf(__('你已经以%s的角色登录'),'<a href="'.admin_url('profile.php').'">'.$user_identity.'</a>'); ?> 
      <a href="<?php echo wp_logout_url(); ?>"><?php _e('注销'); ?></a>
      <?php _e('留下您的评论吧~'); ?>
      <?php cancel_comment_reply_link(__('<span class="icon refresh"></span>取消')); ?>
    </p>
    <?php elseif($comment_author != ''): //如果用户没有登录，而之前又已经进行了评论，被记录的email信息 ?>
    <p>
      <?php _e('欢迎回来');echo $comment_author; ?>
      <a href="javascript:void(0)" id="toggle-comment-author-info"><?php _e('修改信息'); ?></a>
      <?php _e('留下您的评论吧~'); ?>
      <?php cancel_comment_reply_link(__('<span class="icon refresh"></span>取消')); ?>
    </p>
    <div id="comment-author-info" style="display:none;">
      <p>
        <label for="author"><?php _e('昵称'); ?><?php if ($req) echo " *"; ?> ：</label>
        <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" />
      </p>
      <p>
        <label for="email"><?php _e('邮箱'); ?><?php if ($req) echo " *"; ?> ：</label>
        <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" />
      </p>
      <p>
        <label for="url"><?php _e('个人主页'); ?> ：</label>
        <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" />
      </p>
    </div>
    <?php else : ?>
    <p><?php cancel_comment_reply_link(__('取消')); ?></p>
    <div id="comment-author-info">
      <p>
        <label for="author"><?php _e('昵称'); ?><?php if ($req) echo " *"; ?> ：</label>
        <input type="text" name="author" id="author">
      </p>
      <p>
        <label for="email"><?php _e('邮箱'); ?><?php if ($req) echo " *"; ?> ：</label>
        <input type="text" name="email" id="email">
      </p>
      <p>
        <label for="url"><?php _e('个人主页'); ?> ：</label>
        <input type="text" name="url" id="url">
      </p>
    </div>
    <?php endif; ?>
    <p id="comment-text"><textarea name="comment" id="comment"></textarea></p>  
    <p>
      <button name="submit" type="submit" class="btn btn-submit"><?php _e('提交'); ?></button>
      <input type="hidden" name="redirect_to" value="<?php the_permalink(); ?>" />
      <?php comment_id_fields(); ?>
      <?php do_action('comment_form', $post->ID); ?>
      <div class="clear"></div>
    </p>
  </form>
  <?php endif; //end of respond ?>
</div><!--//end of respond-->

<?php endif; //如果文章允许评论的话，到这里结束
