<?php
namespace app\index\model;

use think\Model;
use think\Db;
use app\index\model\Student;

class Committee extends Model
{
    /*设置当前模型对于的完整数据表名称*/
    protected $table = 'committee';

    /**
     * 查找量化委员
     * @param  [type] $number   [description]
     * @param  [type] $password [description]
     * @return [type]           [description]
     */
    public function selectCommittee($number,$password)
    {//判断是否为量化委员并判断登录

        $student = Db::name('Student');
        $data = $student
                ->where('nt_number',$number)
                ->where('nt_password',$password)
                ->find();
        if ($data) {
            foreach ($data as $key => $value) {
                           $studentid = $data['Id'];
                           $classesid = $data['classes_id'];
            }//查找学生id和班级然后到量化委员查找是否有学生id
            $committee = Db::name('Committee');
            $result = $committee
                    ->where('student_id',$studentid)
                    ->where('classes_id',$classesid)
                    ->find();

            if ($result) {
                return true;
            }else{
                return false;
            }

        } else {
             return false;
        }

    }



}
