<?php

namespace Admin\Controller;
//use Think\Controller;
use Tools\AdminController;

class GoodsController extends AdminController{
    //商品列表
    function showlist(){
        $daohang = array(
            'first'=>'商品管理',
            'second'=>'商品列表',
            'third'=>'添加',
            'third_url'=>U('tianjia'),
        );
        $this -> assign('daohang',$daohang);

        //获取商品列表信息
        $goods = D('Goods');
        $info = $goods ->order('goods_id desc')-> select();

        $this -> assign('info',$info);
        $this -> display();
    }
    
    //添加商品
    function tianjia(){
        
        //分支：① 展示表单  ② 收集表单信息入库
        if(IS_POST){

            $goods = new \Model\GoodsModel();
            $shuju = $goods -> create();//作用之一 防止xss攻击
            //$shuju = $_POST;
            $shuju['add_time'] = time();
            $shuju['upd_time'] = time();

            //富文本编辑器的内容不要经过create()方法处理
            $shuju['goods_introduce'] = \fanXSS($_POST['goods_introduce']);

            $this -> deal_logo($shuju); //实现商品logo图片处理

            if($newid = $goods->add($shuju)){
                //把新增商品的主键id值传递给deal_pics使用
                $this -> deal_pics($newid); //实现相册图片上传处理
                $this -> success('添加商品成功',U('showlist'),2);
            }else{
                $this -> error('添加商品失败',U('tianjia'),1);
            }
        }else{
            $daohang = array(
                'first'=>'商品管理',
                'second'=>'添加商品',
                'third'=>'返回',
                'third_url'=>U('showlist'),
            );
            $this -> assign('daohang',$daohang);

            /****获得“类型”并传递给模板****/
            $typeinfo = D('Type')->select();
            $this -> assign('typeinfo',$typeinfo);
            /****获得“类型”并传递给模板****/

            /****获得“第一级分类信息”并传递给模板****/
            $catinfoA = D('Category')
                ->where(array('cat_level'=>0))
                ->select();
            $this -> assign('catinfoA',$catinfoA);
            /****获得“第一级分类信息”并传递给模板****/

            $this -> display();
        }
    }

    //制作私有方法，专门实现商品logo图片附件的上传处理
    //参数"&$data"是一个引用传递
    //作用是方法内部对$data的改变，会使得外部也感知到
    //函数调用：deal_logo($shuju)  
    //函数声明：deal_logo(&$data)
    //实参$shuju  与  形参$data 是同一个变量的两个名称
    private function deal_logo(&$data){
        //dump($_FILES); //输出判断是否有附件上传
        if($_FILES['goods_logo']['error']===0){
            //C. 判断出来当前是"修改"、"添加"动作
            if(!empty($data['goods_id'])){
                //找到商品旧的logo图片，并删除之
                $oldinfo = D('goods')->find($data['goods_id']);
                if(!empty($oldinfo['goods_big_logo'])){
                    unlink($oldinfo['goods_big_logo']);
                }
                if(!empty($oldinfo['goods_small_logo'])){
                    unlink($oldinfo['goods_small_logo']);
                }
            }

            //A. 商品原图logo上传处理
            //图片没有问题(有上传并且附件没有任何错误)才处理
            //通过Upload类实现附件上传
            $cfg = array(
                'rootPath'      =>  './Public/Upd/', //保存根路径
            );
            $up = new \Think\Upload($cfg);
            $z = $up -> uploadOne($_FILES['goods_logo']); //单个附件上传
            //通过$z可以知道当前附件的上传情况
            //例如可以获得 附件在服务器保存的路径名、名字信息

            //把上传的logo图片"路径名"保存到数据库中
            //./Public/Upd/2016-04-22/57198e932ddab.jpg
            $bigname = $up->rootPath.$z['savepath'].$z['savename'];
            $data['goods_big_logo'] = $bigname;

            //B. 给原图logo实现缩略图制作
            $im = new \Think\Image();
            $im -> open($bigname);//打开原图
            //$im -> thumb(200,200);//制作缩略图,等比例缩放
            $im -> thumb(200,200,6);//严格比例缩放
            //./Public/Upd/2016-04-22/57198e932ddab.jpg[原图地址]
            //./Public/Upd/2016-04-22/s_57198e932ddab.jpg[缩略图地址]
            //保存缩略图到服务器
            $smallname = $up->rootPath.$z['savepath'].'s_'.$z['savename'];
            $im -> save($smallname);

            $data['goods_small_logo'] = $smallname;//缩略图保存到数据库中

        }
    }

    //实现商品相册图片的上传处理
    private function deal_pics($goods_id){
        //dump($_FILES);
        //A. 多个相册上传处理
        $cfg = array(
            'rootPath'      =>  './Public/Pics/', //保存根路径
        );
        $up = new \Think\Upload($cfg);
        //$up -> upload(array('pics'=>array(    
        //    name=xxx,
        //    tmp_name=xxx,
        //    error=xxx,
        //    size=xxx,
        //    type=xxx))); //多个附件上传
        // x是数组中的一个元素
        $z = $up ->upload(array($_FILES['goods_pics']));
        //$z 其是一个二维数组，内部包含了每个上传好的附件在服务器上
        //   存储的"路径"和"名字"信息
        //dump($z);

        //B.给上传好的相册图片制作缩略图(3幅)
        //遍历$z,为每个相册都制作缩略图
        $im = new \Think\Image();
        foreach($z as $k => $v){
            //./Public/Pics/2016-04-22/5719ce6a31c.jpg[原图]
            //./Public/Pics/2016-04-22/b_5719ce6a31c.jpg[大图]
            //./Public/Pics/2016-04-22/m_5719ce6a31c.jpg[中图]
            //./Public/Pics/2016-04-22/s_5719ce6a31c.jpg[小图]
            ////原图路径名
            $yuanname = $up->rootPath.$v['savepath'].$v['savename'];
            
            $im -> open($yuanname);//打开原图
            //3个缩略图同时制作，必须按照大、中、小的顺序制作
            $im -> thumb(800,800,6); //大图 缩略图
            $bigname = $up->rootPath.$v['savepath'].'b_'.$v['savename'];
            $im -> save($bigname);

            $im -> thumb(350,350,6); //中图 缩略图
            $midname = $up->rootPath.$v['savepath'].'m_'.$v['savename'];
            $im -> save($midname);

            $im -> thumb(50,50,6); //小图 缩略图
            $smaname = $up->rootPath.$v['savepath'].'s_'.$v['savename'];
            $im -> save($smaname);

            //把上传好的相册缩略图路径名维护到sp_goods_pics表中
            $arr = array(
                'goods_id'=>$goods_id,
                'pics_big'=>$bigname,
                'pics_mid'=>$midname,
                'pics_sma'=>$smaname,
            );
            D('GoodsPics')->add($arr);
        }
    }

    //商品修改
    function upd(){
        $goods_id = I('get.goods_id');
        $goods = new \Model\GoodsModel();
        if(IS_POST){
            //dump($_POST);
            //修改商品普通信息处理
            $shuju = $goods -> create();
            $shuju['upd_time'] = time();

            //富文本编辑器内容特殊处理
            $shuju['goods_introduce'] = \fanXSS($_POST['goods_introduce']);

            $this -> deal_logo($shuju); //实现商品logo图片处理
            $this -> deal_pics($shuju['goods_id']); //实现相册上传处理

            if($goods->save($shuju)){
                $this -> success('修改商品成功',U('showlist'),1);
            }else{
                $this -> error('修改商品失败',U('upd',array('goods_id'=>$goods_id)),1);
            }
        }else{
            $daohang = array(
                'first'=>'商品管理',
                'second'=>'修改商品',
                'third'=>'返回',
                'third_url'=>U('showlist'),
            );
            $this -> assign('daohang',$daohang);
            //根据$goods_id获得被修改商品的信息
            $info = $goods->find($goods_id);

            /****相册图片信息sp_goods_pics****/
            $picsinfo = D('GoodsPics')
                ->where(array('goods_id'=>$goods_id))
                ->select();
            $this -> assign('picsinfo',$picsinfo);
            /****相册图片信息****/

            /****获得“类型”并传递给模板****/
            $typeinfo = D('Type')->select();
            $this -> assign('typeinfo',$typeinfo);
            /****获得“类型”并传递给模板****/

            /****获得“第一级分类信息”并传递给模板****/
            $catinfoA = D('Category')
                ->where(array('cat_level'=>0))
                ->select();
            $this -> assign('catinfoA',$catinfoA);
            /****获得“第一级分类信息”并传递给模板****/

            /****获得商品的所有扩展分类信息****/
            $ext = D('GoodsCat')
                ->where(array('goods_id'=>$goods_id))
                ->field('group_concat(cat_id) as extids')
                ->find();
            //dump($ext);//array(1) {["extids"] => string(3) "5,6"}
            $extcatids = $ext['extids'];
            $this -> assign('extcatids',$extcatids);
            /****获得商品的所有扩展分类信息****/

            $this -> assign('info',$info);
            $this -> display();
        }
    }

    //删除单个的相册图片
    function delPics(){
        $pics_id = I('get.pics_id');
        //获得被删除的相册图片信息
        $picsinfo = D('GoodsPics')->find($pics_id);
        //unlink删除物理图片
        unlink($picsinfo['pics_big']);
        unlink($picsinfo['pics_mid']);
        unlink($picsinfo['pics_sma']);
        //delete删除sp_goods_pics的记录信息
        D('GoodsPics')->delete($pics_id);

        echo json_encode(array('flag'=>1));
    }
}
