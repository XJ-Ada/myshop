<?php

namespace Model;
use Think\Model;

class RoleModel extends Model{
    //完成role_auth_ac的制作
    //重写父类方法_before_update()
    protected function _before_update(&$data,$options) {
        /*dump($data);
        array(1) {
          ["role_auth_ids"] => string(15) "101,106,102,109"
        }
        */
        //制作role_auth_ac
        //查询被分配权限的相关信息(包括控制器auth_c/操作方法auth_a)
        $authinfo = D('Auth')->select($data['role_auth_ids']);
        $tmp = array();
        foreach($authinfo as $k => $v){
            if(!empty($v['auth_c']) && !empty($v['auth_a'])){
                //拼装控制器操作方法的单元
                $tmp[] = $v['auth_c']."-".$v['auth_a'];
            }
        }
        $tmp_s = implode(',',$tmp);
        //dump($tmp_s);//string(27) "Goods-tianjia,Order-tianjia"
        $data['role_auth_ac'] = $tmp_s;
    }
}
