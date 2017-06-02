<?php
namespace app\index\model;

use think\Model;
use think\Db;
// use think\Request;

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
                     ->where('number',$number)
                    ->where('password',$password)
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
                ->where('number',$number)
                ->where('password',$password)
                ->where('Id','<>',1)
                ->find();//需指明id不能为1
            if ($data) {
               return true;
            } else {
                return false;
            }
        }
    }

    // public function addAdmin(){
    //     //实例化model类
    //     $admin = new Admin;
    //     //向变量里赋值arrau表单值
    //     $admin->data = input('post.');
    //     $username = input('post.username');
    //     $password = input('post.password');

    //     //插入数据
    //     if ($admin->save()) {
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }

}
