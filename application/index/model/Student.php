<?php
namespace app\index\model;

use think\Model;
use think\Db;
// use think\Request;

class Student extends Model
{
    //设置当前模型对于的完整数据表名称
    protected $table = 'student';

    //查找学生
    public function selectStudent($number,$password)
    {
        $student = Db::name('Student');
        $data = $student
                ->where('nt_number',$number)
                ->where('nt_password',$password)
                ->find();
        if ($data) {
           return true;
        } else {
            return false;
        }

    }



}
