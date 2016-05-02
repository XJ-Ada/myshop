<?php

namespace Admin\Controller;
//use Think\Controller;
use Tools\AdminController;
class TypeController extends AdminController{
    //列表展示
    function showlist(){
        $daohang = array(
            'first'=>'类型管理',
            'second'=>'类型列表',
            'third'=>'添加',
            'third_url'=>U('tianjia'),
        );
        $this -> assign('daohang',$daohang);

        //获得并传递商品类型列表信息到模板
        $info = D('Type')->select();
        $this -> assign('info',$info);

        $this -> display();
    }
    function tianjia(){
        if(IS_POST){
            $type = D('Type');
            $shuju = $type -> create();
            if($type->add($shuju)){
                $this -> success('添加类型成功',U('showlist'));
            }else{
                $this -> error('添加类型失败',U('tianjia'));
            }
        }else{
            $daohang = array(
                'first'=>'类型管理',
                'second'=>'添加类型',
                'third'=>'返回',
                'third_url'=>U('showlist'),
            );
            $this -> assign('daohang',$daohang);

            $this -> display();
        }
    }
}
