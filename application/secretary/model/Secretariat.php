<?php
//秘书处模块的模型
namespace app\secretary\model;

use think\Model;
use think\Db;

class Secretariat extends Model
{
    /**
     * 设置当前模型对应的完整数据表名称
     * @var string
     */
    protected $table = 'Studentunion';
    /**
     * 查询秘书处信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function retrieve(){
            $user = Db::name('Studentunion');
            $data=$user->where('on_distinguish',1)->find();
            return $data;
    }
    /**
     * 修改秘书处信息
     * @return [type] [description]
     */
    public function modify(){
        $res = Db::table('Studentunion')->where('on_distinguish',1)->update(['on_number' => input('post.number'),'on_email' => input('post.email')]) ;
        return $res;

    }
}
