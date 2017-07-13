<?php
namespace app\student\model;

use think\Model;
use think\Db;


class Student extends Model
{
    /*设置当前模型对于的完整数据表名称*/
    protected $table = 'student';

    /**
     * 查找学生id
     * @param  [type] $number   [description]
     * @param  [type] $password [description]
     * @return [type]           [description]
     */
    public function selectStudentId($name)
    {
        $student = Db::name('Student');
        $data = $student
                ->where('nt_number',$name)
                ->find();
         $studentid = $data['Id'];
        if ($studentid) {
           return $studentid;
        } else {
            return false;
        }

    }

    //查找学生班级id
    public function StudentClassId($name)
    {
        $student = Db::name('Student');
        $data = $student
                ->where('nt_number',$name)
                ->find();
         $classid = $data['classes_id'];
        if ($classid) {
           return $classid;
        } else {
            return false;
        }
    }



        /**
     * 按条件进行查询所有
     * @param  [type] $page    [description]
     * @param  [type] $rows    [description]
     * @param  [type] $sort    [description]
     * @param  [type] $classid [description]
     * @return [type]          [description]
     */
    public function retrievestudent($page,$rows,$sort,$classid)
    {
        $start = ($page-1)*$rows;
        if ($sort) {

            $data = Db::name('Student')
                       ->where('classes_id','eq',$classid)
                       ->limit($start,$rows)//从第10行开始的25条数据
                       ->order($sort,'desc')//desc降序
                       ->select();
        } else {
            $data = Db::name('Student')
                       ->where('classes_id','eq',$classid)
                       ->limit($start,$rows)//从第10行开始的25条数据
                       ->order('nt_number','asc')//asc升序
                       ->select();
        }
        return $data;
    }

        /**
     * 查询条件记录条数
     * @param  [type] $classid [description]
     * @return [type]          [description]
     */
    public function countStudent($classid)
    {
        $data =  Db::name('Student')
                     ->where('classes_id','eq',$classid)
                     ->count();
        return $data;
    }


    /**
     * 读取学生用户信息
     * @param  [type] $teacher_id [description]
     * @return [type]             [description]
     */
    public function selectStudent($student_id)
    {

        $data = Db::name('Student')
                       ->where('Id','eq',$student_id)
                       ->find();
        return $data;

    }

    /**
     * 修改学生用户信息
     * @param  [type] $teacher_id [description]
     * @param  [type] $number     [description]
     * @param  [type] $name       [description]
     * @param  [type] $sex        [description]
     * @param  [type] $email      [description]
     * @return [type]             [description]
     */
    public function modifyMessage($student_id,$number,$name,$sex,$email)
    {

      $data = Db::table('Student')
                  ->where('Id','eq',$student_id)
                  ->update([
                    'nt_number' => $number,
                    'nt_name' => $name,
                    'nt_sex' => $sex,
                    'nt_email' => $email
                    ]) ;
        if ($data) {
          return true;
        }else{
          return false;
        }
    }

    /**
     * 查找学生密码
     * @param  [type] $teacher_id [description]
     * @return [type]             [description]
     */
    public function studentPwd($student_id)
    {
      $student = Db::table('Student');
            $data= $student
              ->field('nt_password')
              ->where('Id','eq',$student_id)
              ->find();
            return $data;
    }


    /**
     * 修改学生密码
     * @param  [type] $classid [description]
     * @return [type]          [description]
     */
    public function modifyPwd($student_id,$password)
    {
      $student =  Db::name('Student');

        $data =  $student
                        ->where('Id','eq',$student_id)
                        ->update([
                          'nt_password' => $password
                          ]) ;
        return $data;
    }




}
