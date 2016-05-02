<?php

namespace Admin\Controller;
//use Think\Controller;
use Tools\AdminController;

class RoleController extends AdminController{
    //列表展示
    function showlist(){
        $daohang = array(
            'first'=>'角色管理',
            'second'=>'角色列表',
            'third'=>'添加',
            'third_url'=>U('tianjia'),
        );
        $this -> assign('daohang',$daohang);
        //获得并传递角色列表信息到模板
        $info = D('Role')->select();
        $this -> assign('info',$info);

        $this -> display();
    }
    //分配权限
    function distribute(){
        $role_id = I('get.role_id');
        $role = new \Model\RoleModel();
        if(IS_POST){
            //dump($_POST);
            $shuju = $role -> create();
            $shuju['role_auth_ids'] = implode(',',$_POST['authid']);
            if($role->save($shuju)){
                $this -> success('分配权限成功',U('showlist'),1);
            }else{
                $this -> error('分配权限失败',U('distribute',array('role_id'=>$role_id)),1);
            }
        }else{
            $daohang = array(
                'first'=>'角色管理',
                'second'=>'分配权限',
                'third'=>'返回',
                'third_url'=>U('showlist'),
            );
            $this -> assign('daohang',$daohang);
            //获得被分配权限的角色信息
            $roleinfo = D('Role')->find($role_id);
            $this -> assign('roleinfo',$roleinfo);
            /****获得被分配的权限信息(顶级/次级)****/
            $auth_infoA = D('Auth')
                    ->where(array('auth_level'=>0))
                    ->select();
            $auth_infoB = D('Auth')
                    ->where(array('auth_level'=>1))
                    ->select();
            $this -> assign('auth_infoA',$auth_infoA);
            $this -> assign('auth_infoB',$auth_infoB);
            /****获得被分配的权限信息(顶级/次级)****/
            $this -> display();
        }
    }
}
