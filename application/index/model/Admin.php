<?php
namespace app\index\model;

use think\Model;
use think\Db;
use think\Session;

class Admin extends Model
{
    //设置当前模型对于的完整数据表名称
    protected $table = 'admin';

    //判断书记和班主任登录
    public  function selectAdmin($number,$password,$role)
    {

        $admin = Db::name('Admin');
        if ($role== 1) {/// role为1时为超级管理员
           $data = $admin
                     ->where('ad_number',$number)
                    ->where('ad_password',$password)
                    ->where('Id','eq',1)
                    ->find();//多条件查询，可以改善
               if ($data) {
                   return true;//登录成功
               } else {
                   return false;
               }

        } elseif ($role == 2) {//,2管理员班主任
            $admin = Db::name('Admin');
            $data = $admin
                ->where('ad_number',$number)
                ->where('ad_password',$password)
                ->where('Id','<>',1)
                ->find();//需指明id不能为1
            if ($data) {
          Session::set('teacher_id',$data['Id']);//设置session，方便使用
               return true;
            } else {
                return false;
            }
        }
    }



}
