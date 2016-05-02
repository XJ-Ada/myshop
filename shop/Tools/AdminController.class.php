<?php

//命名空间声明(类文件的所有上级目录,不包括项目目录shop)
namespace Tools;

//继承Controller有如下两种用法
//② "完全限定名称"方式访问类元素
//class AdminController extends \Think\Controller{

//① 空间“类元素”引入
use Think\Controller; 
class AdminController extends Controller{
    //构造方法
    function __construct(){
        //为了避免"覆盖"父类的构造方法，要先执行父类构造方法
        parent::__construct();

        //echo "I am AdminController";

        //判断用户是否越权访问
        $admin_id   = session('admin_id');
        $admin_name = session('admin_name');
        //正在访问的“控制器-操作方法”
        $nowAC = CONTROLLER_NAME.'-'.ACTION_NAME; //Role-distribute
        //判断用户是否处于登录状态
        if(!empty($admin_name)){

            //管理员对应角色的权限的“控制器-操作方法”字符串
            $roleAC = D('Manager')
                ->alias('m')
                ->join('left join sp_role r on m.role_id=r.role_id')
                ->where(array('m.mg_id'=>$admin_id))
                ->getField('r.role_auth_ac');
            //dump($nowAC);//string(15) "Role-distribute"
            //dump($roleAC);//string(28) "Goods-showlist,Order-tianjia"
            //echo D()->getLastSql();//查看上边执行的sql语句

            //默认允许访问权限
            $allowAC = "Manager-login,Manager-logout,Index-index,Index-left,Index-right,Index-center,Index-top,Index-down,Manager-verifyImg";

            //判断nowAC在roleAC里边是否存在
            //strpos(A,B)从A的左边判断子串B第一次出现的位置0 1 2..
            //           如果没有出现就直接返回false
            //越权访问判断
            //① 访问本身不存在的权限
            //② 访问的不是“默认”允许的权限
            //③ 不是超级管理员admin
            //以上①、②、③ “同时”满足，就是越权访问
            if(strpos($roleAC,$nowAC)===false && strpos($allowAC,$nowAC)===false && $admin_name!=='admin'){
                exit('没有权限访问！');
            }
        }else{
            //退出状态的用户可以访问的权限声明
            $logoutAllowAC = "Manager-login,Manager-verifyImg";

            if(strpos($logoutAllowAC,$nowAC)===false){
                //用户处于退出状态,使得"整个"页面都发生跳转(登录页)
                //$this -> redirect('Manager/login');
                //window.top 是整个页面的引用(非局部的frame)
                $js = <<<eof
                <script type="text/javascript">
                    window.top.location.href="/index.php/Admin/Manager/login";
                </script>
eof;
                echo $js;
            }
        }
    }
}
