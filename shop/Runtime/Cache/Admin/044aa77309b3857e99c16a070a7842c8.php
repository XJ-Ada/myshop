<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Skiyo 后台管理工作平台 by Jessica</title>
<link rel="stylesheet" type="text/css" href="<?php echo (AD_CSS_URL); ?>style.css"/>
<script type="text/javascript" src="<?php echo (AD_JS_URL); ?>js.js"></script>
</head>
<body>
<div id="top">  </div>
<form id="login" name="login" action="/index.php/Admin/Manager/login" method="post">
  <div id="center">
    <div id="center_left"></div>
    <div id="center_middle">
      <div class="user">
        <label>用户名：
        <input type="text" name="admin_name" id="user" />
        </label>
      </div>
      <div class="user">
        <label>密　码：
        <input type="password" name="admin_pwd" id="pwd" />
        </label>
      </div>
      <div class="chknumber">
        <label>验证码：
        <input name="chknumber" type="text" id="chknumber" maxlength="4" class="chknumber_input" />
        </label>
        <img src="/index.php/Admin/Manager/verifyImg" width='55' height='20' id="safecode" onclick="this.src=this.src+'?'+Math.random()"/>
      </div>
    </div>
    <div id="center_middle_right"></div>
    <div id="center_submit">
      <div class="button"> <img src="<?php echo (AD_IMG_URL); ?>dl.gif" width="57" height="20" onclick="form_submit()" > </div>
      <div class="button"> <img src="<?php echo (AD_IMG_URL); ?>cz.gif" width="57" height="20" onclick="form_reset()"> </div>
    </div>
    <div id="center_right"></div>
  </div>
</form>
<div id="footer"></div>
</body>
</html>