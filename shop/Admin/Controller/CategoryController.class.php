<?php
namespace Admin\Controller;
//use Think\Controller;
use Tools\AdminController;

class CategoryController extends AdminController{
    //分类列表
    function showlist(){
        $daohang = array(
            'first'=>'分类管理',
            'second'=>'分类列表',
            'third'=>'添加',
            'third_url'=>U('tianjia'),
        );
        $this -> assign('daohang',$daohang);

        //获得分类信息
        $info = D('Category')
            ->order('cat_path')
            ->select();
        $this -> assign('info',$info);

        $this -> display();
    }
    
    //添加分类
    function tianjia(){
        if(IS_POST){
            //dump($_POST);
            //1）先执行insert语句填充两个(name/pid)字段内容
            //2）再执行update语句把path/level给组好并更新过来
            //   具体在_after_insert()
            $category = new \Model\CategoryModel();
            $shuju = $category->create();
            if($category->add($shuju)){
                $this -> success('添加分类成功',U('showlist'),1);
            }else{
                $this -> error('添加分类失败',U('tianjia'),1);
            }
        }else{
            $daohang = array(
                'first'=>'分类管理',
                'second'=>'添加分类',
                'third'=>'返回',
                'third_url'=>U('showlist'),
            );
            $this -> assign('daohang',$daohang);
            /****获得供选取的上级(前两个级别)分类信息****/
            $catinfo = D('Category')
                ->where(array('cat_level'=>array('in','0,1')))
                ->order('cat_path')
                ->select();
            $this -> assign('catinfo',$catinfo);
            /****获得供选取的上级(前两个级别)分类信息****/

            $this -> display();
        }
    }

    //根据父级获得子级的分类信息
    function getCatByPid(){
        $cat_id = I('get.cat_id');

        //查询子级分类信息
        $catinfo = D('Category')
            -> where(array('cat_pid'=>$cat_id))
            -> select();
        echo json_encode($catinfo); //[json,json,json..]
    }
}