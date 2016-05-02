<?php

namespace Model;
use Think\Model;

class CategoryModel extends Model{
    //insert完成数据添加的后续处理
    protected function _after_insert($data,$options){
        /*dump($data);
        array(11) {
            ....["cat_id"] => string(2) "28"
        }*/
        //完成sp_category表数据的path和level的制作及更新
        //1) path维护
        if($data['cat_pid']==0){
            //① 顶级分类path=new_id
            $path = $data['cat_id'];
        }else{
            //② 非顶级分类path = ppath-new_id
            //获得父级全路径
            $ppath = $this
                ->where(array('cat_id'=>$data['cat_pid']))
                ->getField('cat_path');
            $path = $ppath."-".$data['cat_id'];
        }
        //2) level维护
        //   算法：等于path里边'-'的个数
        $level = substr_count($path, '-');

        $arr = array(
            'cat_id' => $data['cat_id'],
            'cat_path' => $path,
            'cat_level' => $level,
        );
        $this -> save($arr);
    }
}
