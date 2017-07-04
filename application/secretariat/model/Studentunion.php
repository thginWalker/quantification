<?php
namespace app\index\model;

use think\Model;
use think\Db;
// use think\Request;

class Studentunion extends Model
{
    /*设置当前模型对于的完整数据表名称*/
    protected $table = 'studentunionnt';

    /**
     * 查找学生
     * @param  [type] $number   [description]
     * @param  [type] $password [description]
     * @return [type]           [description]
     */
    public function selectStudentunion($number,$password)
    {
        $studentunion = Db::name('Studentunion');
        $data = $studentunion
                ->where('on_number',$number)
                ->where('on_password',$password)
                ->find();
        if ($data) {
           return true;
        } else {
            return false;
        }

    }



}
