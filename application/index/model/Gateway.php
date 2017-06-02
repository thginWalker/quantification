<?php
namespace app\index\model;

use think\Model;
use think\Db;
// use think\Request;

class Gateway extends Model
{
    //设置当前模型对于的完整数据表名称
    protected $table = 'gateway';

    //查找门户管理员
    public function selectGateway($number,$password)
    {
        $gateway = Db::name('Gateway');
        $data = $gateway
                ->where('number',$number)
                ->where('password',$password)
                ->find();
        if ($data) {
           return true;
        } else {
            return false;
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
