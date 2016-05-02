<?php
namespace Home\Controller;
use Think\Controller;

class UserController extends Controller {
    //登录系统
    function login(){
        $this -> display();
    }

    //会员注册
    function register(){
        $this -> display();
    }
}
