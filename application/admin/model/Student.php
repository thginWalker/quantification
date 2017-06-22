<?php
//修改专业的模型
namespace app\admin\model;

use think\Model;
use think\Db;
// use think\request;

class Student extends Model{
    //设置当前模型对应的完整数据表名称
    protected $table = 'Student';



    //按条件进行查询所有
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

    //为修改量化委员选择所有学生
    public function retrievecomBobox($classid)
    {
      $data =  Db::name('Student')
                     ->field('Id,nt_number,nt_name')
                     ->where('classes_id','eq',$classid)
                     ->select();
      $result = [];
      foreach ($data as $key => $value) {
        $result[$key]['value'] = $value['Id'];
        $result[$key]['text'] = "{$value['nt_name']}({$value['nt_number']})";
      }
       return $result;
    }

    //查询条件记录学生selectStudent($page,$rows,$sort,$classid,$classid)
    public function selectStudent($classid)
    {
       $data =  Db::name('Student')
                     ->where('classes_id','eq',$classid)
                     ->select();
       return $data;
    }

    //查询条件记录条数
    public function countStudent($classid)
    {
        $data =  Db::name('Student')
                     ->where('classes_id','eq',$classid)
                     ->count();
        return $data;
    }

    //查询某条记录
    public function queryClassses($id)
    {
        $Student = Db::name('Student');
        $data = $Student
                    ->where('Id',$id)
                    ->find();//多条件查询，可以改善
        return $data;
    }



    //查询学生信息
    public function queryStudent($id){
        $data = Student::get($id);
        return $data;
    }

     //添加学生信息
    public function addStudent($number,$name,$sex,$idnumber,$remarks)
    {
      $data['nt_number'] = $number;
      $data['nt_name'] = $name;
      $data['nt_password'] = md5(123456);//默认密码
      $data['nt_sex'] = $sex;
      $data['nt_idnumber'] = $idnumber;
      $data['nt_remarks'] = $remarks;
       $student = Db::table('Student');
       $result = $student->insert($data);
       if ($result) {
           return $result;
       } else {
           return false;
       }
    }

    //修改学生信息
    public function editStudent($Id,$number,$name,$sex,$idnumber,$remarks)
    {


       $student =  Db::table('Student');
       $data = $student->where('Id', $Id)
                            ->update([
                                'nt_number' => $number,
                                'nt_name' => $name,
                                'nt_sex' => $sex,
                                'nt_idnumber' =>$idnumber,
                                'nt_remarks' => $remarks
                                ]);

       if ($data) {
            return true;
        } else {
            return false;
        }

    }


    //删除学生信息
    public function deleteStudent($ids)
    {
        $data = Student::destroy($ids);
        if ($data) {
            return true;
        } else {
            return false;
        }

    }






}
