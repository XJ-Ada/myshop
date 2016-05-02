<?php

namespace Admin\Controller;
//use Think\Controller;
use Tools\AdminController;

class AuthController extends AdminController{
    //列表展示
    function showlist(){
        //获得全部的权限信息
        //根据auth_path排序获得权限信息(作用：权限有上下级关系体现)
        $info = D('Auth')->order('auth_path')->select();
        $this -> assign('info',$info);

        $daohang = array(
            'first'=>'权限管理',
            'second'=>'权限列表',
            'third'=>'添加',
            'third_url'=>U('tianjia'),
        );
        $this -> assign('daohang',$daohang);

        $this -> display();
    }
    //添加权限
    function tianjia(){
        $auth = new \Model\AuthModel();
        if(IS_POST){
            //dump($_POST);
            $shuju = $auth -> create();
            //auth_path和auth_level两个字段在瞻前顾后机制维护
            //具体是_after_insert()数据添加之后
            //权限添加总的战略：先执行一个insert语句，填充5个字段
            //                  在执行一个update语句，更新2个字段
            if($auth->add($shuju)){
                $this -> success('添加权限成功',U('showlist'),1);
            }else{
                $this -> error('添加权限失败',U('tianjia'),1);
            }
        }else{
            //获取供选择的上级权限信息
            $authinfo = D('Auth')->order('auth_path')->select();
            $this -> assign('authinfo',$authinfo);

            $daohang = array(
                'first'=>'权限管理',
                'second'=>'添加权限',
                'third'=>'返回',
                'third_url'=>U('showlist'),
            );
            $this -> assign('daohang',$daohang);
            $this -> display();
        }
    }
}
