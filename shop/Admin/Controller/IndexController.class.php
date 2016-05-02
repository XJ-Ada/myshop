<?php

namespace Admin\Controller;
//use Think\Controller;
use Tools\AdminController;

class IndexController extends AdminController{
    function __construct(){
        parent::__construct();
        layout(false); //去除默认布局
    }
    function index(){
        C('SHOW_PAGE_TRACE',false);
        $this -> display();}
    function center(){
        C('SHOW_PAGE_TRACE',false);
        $this -> display();}
    function top(){
    C('SHOW_PAGE_TRACE',false);
    $this -> display();}
    function down(){
    C('SHOW_PAGE_TRACE',false);
    $this -> display();}
    
    function left(){
        C('SHOW_PAGE_TRACE',false);
        //根据管理员显示其权限

        $admin_id = session('admin_id');
        $admin_name = session('admin_name');

        //超级管理员admin需要获取并显示全部的权限信息
        if($admin_name==='admin'){
            $auth_infoA = D('Auth')
                ->where(array('auth_level'=>0))
                ->select();
            $auth_infoB = D('Auth')
                ->where(array('auth_level'=>1))
                ->select();
            //SELECT * FROM `sp_auth` WHERE `auth_level` = 0 [ RunTime:0.0003s ]
            //SELECT * FROM `sp_auth` WHERE `auth_level` = 1 [ RunTime:0.0003s ]
        }else{
            //管理员id---->role_id---->auth_ids
            //管理员的角色信息
            $auth_ids = D('Manager')
                ->alias('m')
                ->join('left join sp_role as r on m.role_id=r.role_id')
                ->where(array('m.mg_id'=>$admin_id))
                ->getField('r.role_auth_ids');
            //SELECT r.role_auth_ids FROM sp_manager m left join sp_role as r on m.role_id=r.role_id WHERE m.mg_id = '11' LIMIT 1
            //dump($auth_ids);//string(11) "102,107,108"

            //根据$auth_ids查询对应的权限信息
            //顶级、次级分别获取
            $auth_infoA = D('Auth')
                ->where(array('auth_level'=>0,'auth_id'=>array('in',$auth_ids)))
                ->select();
            //SELECT * FROM `sp_auth` WHERE `auth_level` = 0 AND `auth_id` IN ('101','105','102','109')
            $auth_infoB = D('Auth')
                ->where(array('auth_level'=>1,'auth_id'=>array('in',$auth_ids)))
                ->select();
            //SELECT * FROM `sp_auth` WHERE `auth_level` = 1 AND `auth_id` IN ('101','105','102','109') 
        }

        $this -> assign('auth_infoA',$auth_infoA);
        $this -> assign('auth_infoB',$auth_infoB);

        $this -> display();
    }


    function right(){$this -> display();}
}
