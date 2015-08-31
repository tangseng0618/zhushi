<?php
class UserAvatarList extends WP_Widget{
  function UserAvatarList(){
    $widget_ops = array('classname'=>'user-avatar-list','description'=>'列出用户的头像列表');
    $control_ops = array('width'=>250,'height'=>300);
    $this->WP_Widget(false,'头像墙',$widget_ops,$control_ops);
  }
  function form($instance){
    $instance = wp_parse_args((array)$instance,array('title'=>'作者团队','count'=>18,'type'=>array('author')));
    $title = htmlspecialchars($instance['title']);
    $type = $instance['type'];
    echo '<p style="text-align:left;"><label>标题：<input name="'.$this->get_field_name('title').'" type="text" size="5" value="'.$title.'" /></label></p>';
    echo '<p>
      <label><input name="'.$this->get_field_name('type').'[]" type="checkbox" value="editor" '.(in_array('editor',$type) ? 'checked' : '').'>编辑</label>
      <label><input name="'.$this->get_field_name('type').'[]" type="checkbox" value="author" '.(in_array('author',$type) ? 'checked' : '').'>作者</label>
      <label><input name="'.$this->get_field_name('type').'[]" type="checkbox" value="contributor" '.(in_array('contributor',$type) ? 'checked' : '').'>投稿者</label>
      <label><input name="'.$this->get_field_name('type').'[]" type="checkbox" value="subscriber" '.(in_array('subscriber',$type) ? 'checked' : '').'>订阅者</label>
      <label><input name="'.$this->get_field_name('type').'[]" type="checkbox" value="commenter" '.(in_array('commenter',$type) ? 'checked' : '').'>评论者</label>
    </p>';
    echo '<p style="text-align:left;"><label>数量：<input name="'.$this->get_field_name('count').'" type="text" size="5" value="'.$instance['count'].'" /></label></p>';
    echo '<p>为安全起见，不列出管理员。如果勾选评论者，按回复量排序；否则按文章的发布量来排序。</p>';
  }
  function update($new_instance,$old_instance){
    $instance = $old_instance;
    $instance['title'] = strip_tags(stripslashes($new_instance['title']));
    $instance['count'] = strip_tags(stripslashes($new_instance['count']));
    $instance['type'] = $new_instance['type'];
    return $instance;
  }
  function widget($args,$instance){
    extract($args);
    $title = apply_filters('widget_title',$instance['title']);
    echo $before_widget;
    if($title)echo $before_title . $title . $after_title;
    $count = $instance['count'] ? $instance['count'] : 18;
    $type = $instance['type'] ? $instance['type'] : array('author');
    if(in_array('commenter',$type)) {
      global $wpdb;
      $admin_email = get_option('admin_email');
      $comments = $wpdb->get_results("
        SELECT COUNT(comment_author) AS cnt, comment_author, comment_author_url, comment_author_email
        FROM {$wpdb->prefix}comments
        WHERE comment_date > date_sub( NOW(), INTERVAL 1 YEAR ) 
          AND comment_approved = '1' 
          AND comment_author_email != '$admin_email'
          AND comment_type = ''
        GROUP BY comment_author_email
        ORDER BY cnt DESC
        LIMIT $count");
      if(!empty($comments)) {
        echo '<ul>';
        foreach($comments as $comment) {
          $name = $comment->comment_author;
          $avatar = get_avatar($comment->comment_author_email,50);
          $url = $comment->comment_author_url ? $comment->comment_author_url : 'javascript:void(0)';
          echo '<li><a href="'.$url.'" title="'.$name.' 发表'.$comment->cnt.'条评论">'.$avatar.'</a></li>';
        }
        echo '</ul>';
      }
    }
    else {
      // http://codex.wordpress.org/Function_Reference/get_users
      $includes = array();
      if(in_array('editor',$type)) {
        $users = get_users('role=editor');
        foreach($users as $user) {
          $includes[] = $user->ID;
        }
      }
      if(in_array('author',$type)) {
        $users = get_users('role=author');
        foreach($users as $user) {
          $includes[] = $user->ID;
        }
      }
      if(in_array('contributor',$type)) {
        $users = get_users('role=contributor');
        foreach($users as $user) {
          $includes[] = $user->ID;
        }
      }
      if(in_array('subscriber',$type)) {
        $users = get_users('role=subscriber');
        foreach($users as $user) {
          $includes[] = $user->ID;
        }
      }
      $args = array(
        'include'      => $includes,
        'orderby'      => 'post_count',
        'order'        => 'DESC',
        'number'       => $count
      );
      $users = get_users($args);
      if(!empty($users)) {
        echo '<ul>';
        foreach($users as $user) {
          $name = $user->data->display_name;
          $avatar = get_avatar($user->ID,50);
          $url = get_author_posts_url($user->ID);
          echo '<li><a href="'.$url.'" title="'.$name.'">'.$avatar.'</a></li>';
        }
        echo '</ul>';
      }
    }
    echo $after_widget;
  }
}
function UserAvatarListInit(){
  register_widget('UserAvatarList');
}
add_action('widgets_init','UserAvatarListInit');
