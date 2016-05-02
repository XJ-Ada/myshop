<?php
namespace Admin\Controller;
//use Think\Controller;
use Tools\AdminController;
class AttributeController extends AdminController{
    //列表展示
    function showlist(){
        $daohang = array(
            'first'=>'属性管理',
            'second'=>'属性列表',
            'third'=>'添加',
            'third_url'=>U('tianjia'),
        );
        $this -> assign('daohang',$daohang);

        //获得并传递商品属性列表信息到模板
        $info = D('Attribute')
            ->alias('a')
            ->join('__TYPE__ t on a.type_id=t.type_id')
            ->field('a.*,t.type_name')
            ->select();
        $this -> assign('info',$info);

        /****获得全部的类型信息****/
        $typeinfo = D('Type')->select();
        $this -> assign('typeinfo',$typeinfo);
        /****获得全部的类型信息****/

        $this -> display();
    }
    function tianjia(){
        if(IS_POST){

            $Attribute = D('Attribute');
            $shuju = $Attribute -> create();
            if($Attribute->add($shuju)){
                $this -> success('添加属性成功',U('showlist'));
            }else{
                $this -> error('添加属性失败',U('tianjia'));
            }
        }else{
            $daohang = array(
                'first'=>'属性管理',
                'second'=>'添加属性',
                'third'=>'返回',
                'third_url'=>U('showlist'),
            );
            $this -> assign('daohang',$daohang);

            //获得“类型”并传递给模板
            $typeinfo = D('Type')->select();
            $this -> assign('typeinfo',$typeinfo);

            $this -> display();
        }
    }

    //根据typeid类型信息 获得对应的属性信息
    function getAttributeByType(){
        //接收get方式过来的typeid信息
        $typeid = I('get.typeid');

        //如果类型的值=0，则获取的属性信息不通过类型限制
        $cdt = array();
        if($typeid>0){
            $cdt['a.type_id']= $typeid;
        }

        //获得对应的属性信息
        $attrinfo = D('Attribute')
            ->alias('a')
            ->join('__TYPE__ t on a.type_id=t.type_id')
            ->field('a.*,t.type_name')
            ->where($cdt)
            ->select();
        //$attrinfo = array(
        //        0-》array(attr_id=>x,attr_name=>xx,attr_sel=>xx),
        //        1->array(attr_id=>x,attr_name=>xx,attr_sel=>xx),
        //        2->array(attr_id=>x,attr_name=>xx,attr_sel=>xx))
        echo json_encode($attrinfo); //[json,json,json]
        //[{"attr_id":"1","attr_name":"cpu","type_id":"2","attr_sel":"0","attr_write":"0","attr_vals":""},{"attr_id":"2","attr_name":"\u50cf\u7d20","type_id":"2","attr_sel":"0","attr_write":"0","attr_vals":""},{"attr_id":"3","attr_name":"\u989c\u8272","type_id":"2","attr_sel":"1","attr_write":"1","attr_vals":"\u767d\u8272,\u7eff\u8272,\u7ea2\u8272,\u9ed1\u8272"}]
    }

    //【添加商品】 根据typeid类型信息 获得对应的属性信息
   function getAttributeByType2(){
        //接收get方式过来的typeid信息
        $typeid = I('get.typeid');

        //如果类型的值=0，则获取的属性信息不通过类型限制
        $cdt = array();
        if($typeid>0){
            $cdt['a.type_id']= $typeid;
        }

        //获得对应的属性信息
        $attrinfo = D('Attribute')
            ->alias('a')
            ->join('__TYPE__ t on a.type_id=t.type_id')
            ->field('a.*,t.type_name')
            ->where($cdt)
            ->select();
        echo json_encode($attrinfo); //[json,json,json]
    }

    //【修改商品】 根据typeid类型信息 获得对应的属性信息
    function getAttributeByType3(){
        //接收get方式过来的typeid和goodsid信息
        $typeid = I('get.typeid');
        $goodsid = I('get.goodsid');

        //根据传递过来的“类型”、“商品”
        //判断是否存在属性信息
        //sp_goods_attr(goods_id,attr_id)-----sp_attrbute(attr_id,type_id)
        //判断当前的商品/类型是否存在对应的属性
        $attrinfo = D('GoodsAttr')
            ->alias('ga')
            ->join('__ATTRIBUTE__ a on ga.attr_id=a.attr_id')
            ->where(array('ga.goods_id'=>$goodsid,'a.type_id'=>$typeid))
            ->field('a.attr_id,a.attr_name,a.attr_sel,a.attr_vals,group_concat(ga.attr_value) attrvalues')
            ->group('a.attr_id')
            ->select();

        //通过"flag"表示当前属性信息的状态
        $info['flag'] = 0; //实体属性信息
        if(empty($attrinfo)){
            // 获得"空壳属性信息"
            $attrinfo = D('Attribute')
                ->where(array('type_id'=>$typeid))
                ->select();
            $info['flag'] = 1; //空壳属性信息
        }
        
        $info['data'] = $attrinfo;

        echo json_encode($info); //[json,json,json]
    }
}
