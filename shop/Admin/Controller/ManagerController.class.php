<?php

namespace Admin\Controller;
//use Think\Controller;
use Tools\AdminController;

class ManagerController extends AdminController{
    //管理员登录系统
    function login(){
        layout(false); //去除默认布局
        if(IS_POST){
            $vry = new \Think\Verify();
            if($vry -> check($_POST['chknumber'])){
                $name = $_POST['admin_name'];
                $pwd = $_POST['admin_pwd'];
                //验证用户名、密码正确
                $info = D('Manager')
                    ->where(array('mg_name'=>$name,'mg_pwd'=>$pwd))
                    ->find();
                //$info: array一维 用户名/密码正确
                //       null  用户名/密码错误
                if($info !== null){
                    //session持久化用户信息
                    session('admin_id',$info['mg_id']);
                    session('admin_name',$info['mg_name']);
                    //页面跳转到后台首页面
                    $this -> redirect('Index/index'); //迅速发生跳转
                }else{
                    echo "用户名或密码错误";
                }
            }else{
                echo "验证码错误";
            }
        }
        $this -> display();
    }

    //退出系统
    function logout(){
        session(null); //销毁session
        $this -> redirect('login');
    }

    //输出验证码
    function verifyImg(){
        $cfg = array(
            'fontSize'  =>  9,              // 验证码字体大小(px)
            'imageH'    =>  25,               // 验证码图片高度
            'imageW'    =>  60,               // 验证码图片宽度
            'useNoise'  =>  false,            // 是否添加杂点
            'length'    =>  4,               // 验证码位数
            'fontttf'   =>  '4.ttf',              // 验证码字体，不设置随机获取
        );
        $very = new \Think\Verify($cfg);
        $very -> entry();
    }
}
