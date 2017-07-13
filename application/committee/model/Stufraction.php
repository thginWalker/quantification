<?php
//修改专业的模型
namespace app\committee\model;

use think\Model;
use think\Db;
use think\request;
use think\Session;

class Stufraction extends Model{
    //设置当前模型对应的完整数据表名称
    protected $table = 'Studscoreinfo';
    //获取班级ID
    public function findclassid(){
        $number = Session::get('name');
        $student = Db::name('Student');
        $data = $student
                ->where('nt_number',$number)
                ->column('classes_id');
        return $data[0];
    }

    /**查询所有
    *$page分页页数
    *$rows分页的条数
     * [retrievemajor description]
     * @param  [type] $page [description]
     * @param  [type] $rows [description]
     * @return [type]       [description]
     */
    public function examinefraction($page,$rows){
        $class_id = $this->findclassid();
        $start = ($page-1)*$rows;
        $data = Db::name('Student')
                    ->where('classes_id',"$class_id")
                    ->limit($start,$rows)//从第10行开始的25条数据
                    ->select();
        //var_dump($data);exit;
        return $data;
    }
    /**
     * 查询指定班级
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function retrieveclasses($id){
         $data = Db::name('Classes')
                       ->where('Id',$id)
                       ->find();
       
            $id=$data["major_id"];
            $major=$this->retrievemajor($id);
            $data["major_id"] = $major["ma_majorname"];
        return $data;
    }
    /**
     * 查询全部班级
     * @return [type] [description]
     */
    public function retrieveclass(){
        $data = Db::name('Classes')
                       ->select();
        foreach ($data as $key => $value) {
            $id = $value["major_id"];
            $major = $this->retrievemajor($id);
            $data[$key]["major_id"]=$major["ma_majorname"];
        }
        return $data;
    }
    /**
     * 查询专业名称
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function retrievemajor($id){
        $data = Db::name('Major')
                       ->where('id',$id)
                       ->find();
        return $data;
    }
    /**
     *查询所有记录条数
     * @return [type] [description]
     */
    public function countfraction()
    {
           $data =  Db::name('Dynamic')
                     ->count();//
        return $data;
    }


     /**
      * 增加量化数据
      * @param [type] $studentunion_id [description]
      * @param [type] $classes_id      [description]
      * @param [type] $dy_name         [description]
      * @param [type] $dy_time         [description]
      * @param [type] $dy_reason       [description]
      * @param [type] $dy_fraction     [description]
      * @param [type] $dy_remarks      [description]
      */
    // public function addFraction($studentunion_id,$classes_id,$dy_name,$dy_time,$dy_reason,$dy_fraction,$dy_remarks)
    // {
    //     $data = new Fraction;
    //     $data ->studentunion_id = $studentunion_id;
    //     $data ->classes_id = $classes_id;
    //     $data ->dy_name = $dy_name;
    //     $data ->dy_time = $dy_time;
    //     $data ->dy_reason = $dy_reason;
    //     $data ->dy_fraction = $dy_fraction;   
    //     $data->dy_remarks = $dy_remarks;
    //     // $data->data = input('post.');
    //    $result = $data->save();
    //    return $result;
    // }
    
    public function addstufraction($id,$fo_time,$fo_reason,$fo_fraction,$fo_remarks)
    {
        $data = new Stufraction;
        $data ->student_id = $id;
        $data ->fo_time = $fo_time;
        $data ->fo_reason = $fo_reason;
        $data ->fo_fraction = $fo_fraction;
        $data ->fo_remarks = $fo_remarks;
       $result = $data->save();
       return $result;
    }


    /**
     * 删除量化数据
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deletefraction($id){
        $result = Fraction::destroy($id);
        return $result;
    }

}
