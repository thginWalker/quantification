<?php
//修改专业的模型
namespace app\studentunion\model;

use think\Model;
use think\Db;
use think\request;
use think\Session;

class Fraction extends Model{
    //设置当前模型对应的完整数据表名称
    protected $table = 'Dynamic';


    /**查询所有
    *$page分页页数
    *$rows分页的条数
     * [retrievemajor description]
     * @param  [type] $page [description]
     * @param  [type] $rows [description]
     * @return [type]       [description]
     */
    public function retrievefraction($page,$rows,$sort){
        $start = ($page-1)*$rows;
        $data = Db::name('Dynamic')
                    ->where('dy_judge',0)
                    ->order($sort,'desc')
                    ->limit($start,$rows)//从第10行开始的25条数据
                    ->select();
        foreach ($data as $key => $value) {
            $id=$value["classes_id"];
            $class = $this->retrieveclasses($id);
            $data[$key]["classes_name"] = $class["cl_grade"]."级".$class["major_id"].$class["cl_classes"]."班";
            $data[$key]["dy_time"]=date("Y年m月d日",$value["dy_time"]);
        }
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
    public function addFraction($classes_id,$dy_name,$dy_time,$dy_reason,$dy_fraction,$dy_remarks)
    {
        $studentunion_id = $this->findid();
        $data = new Fraction;
        $data ->studentunion_id = $studentunion_id;
        $data ->classes_id = $classes_id;
        $data ->dy_name = $dy_name;
        $data ->dy_time = $dy_time;
        $data ->dy_reason = $dy_reason;
        $data ->dy_fraction = $dy_fraction;   
        $data->dy_remarks = $dy_remarks;
        // $data->data = input('post.');
       $result = $data->save();
       return $result;
    }
    /**
     * 修改量化数据
     * @param  [type] $id              [description]
     * @param  [type] $studentunion_id [description]
     * @param  [type] $classes_id      [description]
     * @param  [type] $dy_name         [description]
     * @param  [type] $dy_time         [description]
     * @param  [type] $dy_reason       [description]
     * @param  [type] $dy_fraction     [description]
     * @param  [type] $dy_remarks      [description]
     * @return [type]                  [description]
     */
    public function editfraction($id,$classes_id,$dy_name,$dy_time,$dy_reason,$dy_fraction,$dy_remarks){
       $studentunion_id = $this->findid();
       $major =  Db::table('Dynamic');
       $data = $major->where('Id', $id)
                            ->update([
                                'studentunion_id' => $studentunion_id,
                                'classes_id' => $classes_id,
                                'dy_name' => $dy_name,
                                'dy_time' => $dy_time,
                                'dy_reason' => $dy_reason,
                                'dy_fraction' => $dy_fraction,
                                'dy_remarks' => $dy_remarks,
                                ]);

       if ($data) {
            return true;
        } else {
            return false;
        }

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
    public function findid(){
        $number = Session::get('name');
        $user = Db::name('Studentunion');
        $data=$user->where('on_number',$number)->column('Id');
        return $data[0];
    }
}
