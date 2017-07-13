<?php
//部门模块的模型
namespace app\Studentunion\model;

use think\Model;
use think\Db;
use think\Session;


class Studentunion extends Model
{
    /**
     * 设置当前模型对应的完整数据表名称
     * @var string
     */
    protected $table = 'Studentunion';
    /**
     * 查询部门信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function retrieve(){
            $id = $this->findid();
            $user = Db::name('Studentunion');
            $data=$user->where('Id',$id)->select();
            return $data;
    }
    /**
     * 修改自己信息
     * @return [type] [description]
     */
    public function modify(){
        $id = $this->findid();
        $res = Db::table('Studentunion')->where('id',$id)->update(['on_department' => input('post.name'),'on_email' => input('post.email')]) ;
        return $res;

    }
    /**
     * 修改密码
     * @return [type] [description]
     */
        public function modifypass($password){
        $id = $this->findid();
        $res = Db::table('Studentunion')->where('id',$id)->update(['on_password' => $password]) ;
        return $res;

    }
    public function findid(){
        $number = Session::get('name');
        $user = Db::name('Studentunion');
        $data=$user->where('on_number',$number)->column('Id');
        return $data[0];
    }
}
