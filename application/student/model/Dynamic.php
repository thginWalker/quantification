<?php
namespace app\student\model;

use think\Model;
use think\Db;


class Dynamic extends Model
{
    /*设置当前模型对于的完整数据表名称*/
    protected $table = 'dynamic';

    /**
     * 查找未审核信息
     */
    public function selectnotAu($classid)
    {

        $studentunion = Db::name('Dynamic');
        $data = $studentunion
                       ->where('classes_id','eq',$classid)
                       ->where('dy_judge','eq',0)
                       ->select();
        return $data;

    }









}
