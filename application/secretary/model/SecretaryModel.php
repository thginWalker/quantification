<?php
//书记模块的模型
namespace app\secretary\model;

use think\Model;
use think\Db;

class SecretaryModel extends Model
{
    /**
     * 设置当前模型对应的完整数据表名称
     * @var string
     */
    protected $table = 'Admin';
    /**
     * 查询书记信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function retrieve($id){
            $user = Db::name('Admin');
            $data=$user->where('Id',$id)->select();
            return $data;
    }
    /**
     * 修改自己信息
     * @return [type] [description]
     */
    public function modify(){
        $res = Db::table('Admin')->where('id',1)->update(['ad_number' => input('post.number'),'ad_name' => input('post.name'),'ad_sex' => input('post.sex'),'ad_email' => input('post.email')]) ;
        return $res;

    }
    /**
     * 修改密码
     * @return [type] [description]
     */
        public function modifypass($password){
        $res = Db::table('Admin')->where('id',1)->update(['ad_password' => $password]) ;
        return $res;

    }
    // //添加
    // public function add(){
    //     $user = new SecretaryModel;
    //     $user->data = input('post.');
    //     if($user->save()){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }

}
