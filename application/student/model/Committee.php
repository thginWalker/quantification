<?php
//修改专业的模型
namespace app\admin\model;

use think\Model;
use think\Db;
// use think\request;

class Committee extends Model{
    //设置当前模型对应的完整数据表名称
    protected $table = 'Committee';


    //通过班级id找到量化委员学生id并返回信息
    public function selectCommittee($classid){
        $committee =  Db::table('Committee');
        $data = $committee
                            ->where('classes_id', $classid)
                            ->find();
        $studentid = $data['student_id'];
        return $studentid;

    }

    //修改量化委员
    public function updateCommittee($classid,$student_id)
    {

        $committee =  Db::table('Committee');
       $data = $committee->where('classes_id', $classid)
                            ->update([
                                'student_id' => $student_id,
                                ]);

       if ($data) {
            return true;
        } else {
            return false;
        }
    }











}
