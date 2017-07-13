<?php
//修改班级的模型
namespace app\secretary\model;

use think\Model;
use think\Db;
use think\request;

class StudentModel extends Model{
    //设置当前模型对应的完整数据表名称
    protected $table = 'Student';


    /**查询所有
    *$page分页页数
    *$rows分页的条数
     * [retrievemajor description]
     * @param  [type] $page [description]
     * @param  [type] $rows [description]
     * @return [type]       [description]
     */
    public function retrievestudent($classes_id,$page,$rows)
    {
        $start = ($page-1)*$rows;
        $data = Db::name('Student')
                    ->where('classes_id',$classes_id)
                    ->limit($start,$rows)//从第10行开始的25条数据
                    ->select();
 
        return $data;
    }


    /**
     *查询所有记录条数
     * @return [type] [description]
     */
    public function countstudent()
    {
           $data =  Db::name('Student')
                     ->count();//
        return $data;
    }
    

     /**
      * 添加班级
      * @param [type] $cl_grade   [description]
      * @param [type] $cl_major   [description]
      * @param [type] $cl_classes [description]
      * @param [type] $cl_remarks [description]
      */
    public function addStudent($class_Id,$nt_number,$nt_name,$nt_sex,$nt_idnumber,$nt_email,$nt_remarks)
    {
        
        $data = new StudentModel;
        $data->classes_id = $class_Id;
        $data ->nt_number = $nt_number;
        $data->nt_name = $nt_name;
        $data->nt_sex = $nt_sex;
        $data->nt_idnumber = $nt_idnumber;
        $data->nt_email = $nt_email;
        $data->nt_remarks = $nt_remarks;

        // $data->data = input('post.');
       $result = $data->save();
       return $result;
    }
/**
 * 修改班级
 * @param  [type] $Id         [description]
 * @param  [type] $cl_grade   [description]
 * @param  [type] $cl_major   [description]
 * @param  [type] $cl_classes [description]
 * @param  [type] $cl_remarks [description]
 * @return [type]             [description]
 */
    public function editstudent($Id,$nt_number,$nt_name,$nt_sex,$nt_idnumber,$nt_email,$nt_remarks)
    {

       $classes =  Db::table('Student');
       $data = $classes->where('Id', $Id)
                            ->update([
                                'nt_number' => $nt_number,
                                'nt_name' => $nt_name,
                                'nt_sex' => $nt_sex,
                                'nt_idnumber' => $nt_idnumber,
                                'nt_email' => $nt_email,
                                'nt_remarks' => $nt_remarks,
                                ]);

       if ($data) {
            return true;
        } else {
            return false;
        }

    }
  

    /**
     * 删除班级
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deletestudent($id){
        $result = StudentModel::destroy($id);
        return $result;
    }

}
