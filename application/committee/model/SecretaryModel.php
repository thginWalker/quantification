<?php
//书记模块的模型
namespace app\secretary\model;

use think\Model;
use think\Db;

class SecretaryModel extends Model
{
    //设置当前模型对应的完整数据表名称
    protected $table = 'Admin';
    //查询
    public function retrieve($id){
            $user = Db::name('Admin');
            $data=$user->where('Id',$id)->select();
            return $data;
    }
    //修改
    public function modify(){
        $res = Db::table('Admin')->where('id',1)->update(['ad_number' => input('post.number'),'ad_name' => input('post.name'),'ad_sex' => input('post.sex'),'ad_email' => input('post.email')]) ;
        return $res;

    }
    //修改密码
        public function modifypass(){
        $res = Db::table('Admin')->where('id',1)->update(['ad_password' => input('post.password')]) ;
        return $res;

    }
    //添加
    public function add(){
        $user = new SecretaryModel;
        $user->data = input('post.');
        if($user->save()){
            return true;
        }else{
            return false;
        }
    }

}
