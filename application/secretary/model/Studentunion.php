<?php
//修改学生会的模型
namespace app\secretary\model;

use think\Model;
use think\Db;
use think\request;

class Studentunion extends Model{
    //设置当前模型对应的完整数据表名称
    protected $table = 'Studentunion';


    /**查询所有
    *$page分页页数
    *$rows分页的条数
     * [retrievemajor description]
     * @param  [type] $page [description]
     * @param  [type] $rows [description]
     * @return [type]       [description]
     */
    public function retrieveStudentunion($page,$rows,$sort)
    {
        $start = ($page-1)*$rows;
        $data = Db::name('Studentunion')
                        ->where('on_distinguish',0)
                        ->order($sort,'desc')
                        ->limit($start,$rows)//从第10行开始的25条数据
                        ->select();
        return $data;
    }

    /**
     *查询所有记录条数
     * @return [type] [description]
     */
    public function countstudentunion()
    {
           $data =  Db::name('Studentunion')
                        ->where('on_distinguish',0)
                        ->count();//
        return $data;
    }


     /**
      * 添加学生会
      * @param [type] $majorname [description]
      * @param [type] $remarks   [description]
      */
    public function addstudentunion($on_department,$on_number,$on_email,$on_remarks)
    {
        $data = new Studentunion;
        $data ->on_department = $on_department;
        $data ->on_number = $on_number;
        $data->on_email = $on_email;
        $data->on_distinguish = 0;
        $data->on_remarks = $on_remarks;
       $result = $data->save();
       return $result;
    }
/**
 * 修改学生会
 * @param  [type] $Id        [description]
 * @param  [type] $majorname [description]
 * @param  [type] $remarks   [description]
 * @return [type]            [description]
 */
    public function editstudentunion($Id,$on_department,$on_number,$on_email,$on_remarks)
    {


       $major =  Db::table('Studentunion');
       $data = $major->where('Id', $Id)
                            ->update([
                                'on_department' => $on_department,
                                'on_number' => $on_number,
                                'on_email' => $on_email,
                                'on_remarks' => $on_remarks,                               
                                ]);


       if ($data) {
            return true;
        } else {
            return false;
        }

    }


    /**
     * 删除学生会
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deletetstudentunion($id){
        $result = Studentunion::destroy($id);
        return $result;
    }

}
