<?php

namespace Model;
use Think\Model;

class AuthModel extends Model{
    // 插入成功后的回调方法
    //在以下方法里边实现auth_path和auth_level的"制作"和"更新""
    protected function _after_insert($data,$options) {
        /*dump($data);
        array(5) {
          ["auth_name"] => string(12) "商品品牌"
          ["auth_pid"] => int(101)
          ["auth_c"] => string(5) "Brand"
          ["auth_a"] => string(8) "showlist"
          ["auth_id"] => string(3) "113"
        }
        dump($options);
        array(2) {
          ["table"] => string(7) "sp_auth"
          ["model"] => string(4) "Auth"
        }
        */
        //1) 维护auth_path
        //① 顶级：path====本身记录的主键id值
        if($data['auth_pid']==0){
            $path = $data['auth_id'];
        }else{
        //② 非顶级：path====父级全路径-本身主键id值
            //获得父级全路径
            $ppath = $this
                ->where(array('auth_id'=>$data['auth_pid']))
                ->getField('auth_path');
            $path = $ppath.'-'.$data['auth_id'];
        }
        //2) 维护等级
        //等级====全路径里边'-'的个数
        $level = substr_count($path,'-');//计算$path里边出现'-'的个数

        //把path和level给更新到数据记录里边
        $arr = array(
            'auth_id'=>$data['auth_id'],
            'auth_path'=>$path,
            'auth_level'=>$level,
        );
        $this -> save($arr);
    }
}
