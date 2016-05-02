<?php



//给引入的静态资源文件设置"常量"
define('SITE_URL','http://web.shop44.com/');
//前台
define('CSS_URL',SITE_URL."Public/Home/style/");
define('JS_URL',SITE_URL."Public/Home/js/");
define('IMG_URL',SITE_URL."Public/Home/images/");
//后台
define('AD_CSS_URL',SITE_URL."Public/Admin/css/");
define('AD_JS_URL',SITE_URL."Public/Admin/js/");
define('AD_IMG_URL',SITE_URL."Public/Admin/images/");

//插件Plugin
define('PLUGIN_URL',SITE_URL."Common/Plugin/");


//开启调试模式
define('APP_DEBUG',true);




//引入框架的接口程序文件
include("../ThinkPHP/ThinkPHP.php");
