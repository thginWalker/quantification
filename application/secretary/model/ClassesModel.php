<?php
//修改班级的模型
namespace app\secretary\model;

use think\Model;
use think\Db;
use think\request;

class ClassesModel extends Model{
    //设置当前模型对应的完整数据表名称
    protected $table = 'Classes';


    /**查询所有
    *$page分页页数
    *$rows分页的条数
     * [retrievemajor description]
     * @param  [type] $page [description]
     * @param  [type] $rows [description]
     * @return [type]       [description]
     */
    public function retrieveclasses($page,$rows,$sort)
    {
        $start = ($page-1)*$rows;
        $data = Db::name('Classes')
                    ->order($sort,'desc')
                    ->limit($start,$rows)//从第10行开始的25条数据
                    ->select();
         foreach ($data as $key => $value) {
            $ids=$value["major_id"];
            $mm=$this->retrievemajor($ids);
            $data[$key]["major_name"]=$mm;
        }
        return $data;
    }
    /**
     * 查询专业名称
     * @param  [type] $major_id [description]
     * @return [type]           [description]
     */
    public function retrievemajor($major_id){
                $data = Db::name('Major')
                            ->where('Id',$major_id)
                            ->find();
                return $data["ma_majorname"];

    }

    /**
     *查询所有记录条数
     * @return [type] [description]
     */
    public function countclasses()
    {
           $data =  Db::name('Classes')
                     ->count();//
        return $data;
    }
    /**
     * 查询班级
     * @return [type] [description]
     */
    public function querymajor(){
             $major = Db::name('Major');
            $data = $major->select();
            return $data;
    }
        /**
         * 查询班主任
         * @return [type] [description]
         */
        public function queryheadmaster(){
             $major = Db::name('Admin');
            $data = $major->where('ad_distinguish',1)->select();
            return $data;
    }



     /**
      * 添加班级
      * @param [type] $cl_grade   [description]
      * @param [type] $major_id   [description]
      * @param [type] $cl_classes [description]
      * @param [type] $cl_remarks [description]
      */
    public function addClasses($cl_grade,$major_id,$cl_classes,$cl_headmaster,$cl_remarks)
    {
        $m = $this->retrieveheadmaster($cl_headmaster);
        $data = new ClassesModel;
        $data ->cl_grade = $cl_grade;
        $data->major_id = $major_id;
        $data->cl_classes = $cl_classes;
        $data->admin_id = $cl_headmaster;
        $data->cl_headmaster = $m;
        $data->cl_remarks = $cl_remarks;

        // $data->data = input('post.');
       $result = $data->save();
       return $result;
    }
/**
 * 修改班级
 * @param  [type] $Id         [description]
 * @param  [type] $cl_grade   [description]
 * @param  [type] $major_id   [description]
 * @param  [type] $cl_classes [description]
 * @param  [type] $cl_remarks [description]
 * @return [type]             [description]
 */
    public function editclasses($Id,$cl_grade,$major_id,$cl_classes,$cl_headmaster,$cl_remarks)
    {

       $m = $this->retrieveheadmaster($cl_headmaster);
       $classes =  Db::table('Classes');
       $data = $classes->where('Id', $Id)
                            ->update([
                                'cl_grade' => $cl_grade,
                                'major_id' => $major_id,
                                'cl_classes' => $cl_classes,
                                'admin_id' => $cl_headmaster,
                                'cl_headmaster' => $m,
                                'cl_remarks' => $cl_remarks,
                                ]);

       if ($data) {
            return $m;
        } else {
            return false;
        }

    }
    /**
     * 获取班主任信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function retrieveheadmaster($id){
        $user = Db::name('Admin');
        $data=$user->where('Id',$id)->find();
        $str = $data["ad_number"]."(".$data["ad_name"].")";
        return $str;
    }

    /**
     * 删除班级
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deletetclass($id){
        $result = ClassesModel::destroy($id);
        return $result;
    }

}
