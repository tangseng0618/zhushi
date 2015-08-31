<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>404页面_<?php bloginfo( 'name' ); ?></title>
<style>
html,body{
  width:100%;
  height:100%;
  overflow: hidden;
  margin:0;
  padding:0;
  color: #333;
  font-family: "Microsoft Yahei","微软雅黑";
}
.wrap{
  text-align:center;
  width: 70%;
  margin: 0 auto;
  margin-top: 5%;
  padding-bottom: 5%;
  border: #dedede solid 1px;
}
a{
  text-decoration:none;
}
img{
  border:0;
}
form{
  margin-top:1em;
}
input{
  width:600px;
  border:#CCC solid 1px;
  padding:5px;
}
button{
  border:#D9D9D9 solid 1px;
  background:#F4F4F4;
  color:#666666;
  font-family:"黑体";
  font-weight:bold;
  -moz-border-radius:1px;
  -webkit-border-radius:1px;
  border-radius:1px;
  padding:5px;
  cursor: pointer;
}
button:hover{
  border:#D9D9D9 solid 1px;
  background:#F7F7F7;
  color:#333333;
  -moz-box-shadow:0 1px 1px #ccc;
  -webkit-box-shadow:0 1px 1px #ccc;
  box-shadow:0 1px 1px #ccc;
}
.img{
  padding: 120px;
}
.warning {
  color: #EA633D;
}
</style>
</head>

<body>
<div class="wrap">
  <div class="img"><a href="<?php bloginfo('url'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png"></a></div>
  <div class="warning">对不起，没有找到你想要看的内容。通过下方的搜索功能搜一下吧。</div>
  <form id="search" action="<?php bloginfo('url'); ?>/" method="get">
    <p><input type="text" name="s" /></p>
    <p>
      <button type="submit">搜索一下</button>
      <button type="button" onclick="window.location.href='<?php bloginfo('url'); ?>';">返回首页</button>
  </form>
</div>
</body>
</html>