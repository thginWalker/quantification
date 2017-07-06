<?php
//修改专业的模型
namespace app\admin\model;

use think\Model;
use think\Db;


class Classes extends Model
{
    /*设置当前模型对于的完整数据表名称*/
    protected $table = 'Classes';

    /**
     * 查找班主任管理班级
     * @param  [type] $teacher_id [description]
     * @return [type]             [description]
     */
    public function manageClass($teacher_id)
    {
        $classes = Db::name('Classes');
        $data = $classes
                    ->where('admin_id',$teacher_id)
                    ->select();//多条件查询，可以改善

        $grade = [];

               foreach($data as $key=>$value){
                $sub_cl_grade = substr($value['cl_grade'], 2, 2);
                    $grade[$key]['class'] = "{$sub_cl_grade}级{$value['cl_abbreviation']}{$value['cl_classes']}班";
                    $grade[$key]['Id'] = $value['Id'];

                }
        return $grade;
    }

}
