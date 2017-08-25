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
                    $major = $this->selectMajor($value['major_id'])['ma_abbreviation'];
                    $grade[$key]['class'] = "{$sub_cl_grade}级$major{$value['cl_classes']}班";
                    $grade[$key]['Id'] = $value['Id'];

                }
        return $grade;
    }
    public function selectMajor($major_id){
        $major = Db::name('Major');
        $data = $major->where('Id',$major_id)
                ->find();
        return $data;
    }

}
