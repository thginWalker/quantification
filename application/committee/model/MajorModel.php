<?php
//修改专业的模型
namespace app\secretary\model;

use think\Model;
use think\Db;
use think\request;

class MajorModel extends Model{
    //设置当前模型对应的完整数据表名称
    protected $table = 'Major';


    /**查询所有
    *$page分页页数
    *$rows分页的条数
     * [retrievemajor description]
     * @param  [type] $page [description]
     * @param  [type] $rows [description]
     * @return [type]       [description]
     */
    public function retrievemajor($page,$rows)
    {
        $start = ($page-1)*$rows;
        $data = Db::name('Major')
                       ->limit($start,$rows)//从第10行开始的25条数据
                       ->select();
        return $data;
    }


    /**
     *查询所有记录条数
     * @return [type] [description]
     */
    public function countmajor()
    {
           $data =  Db::name('Major')
                     ->count();//
        return $data;
    }


     /**
      * 添加专业
      * @param [type] $majorname [description]
      * @param [type] $remarks   [description]
      */
    public function addMajor($majorname,$abbreviation,$remarks)
    {
        $data = new MajorModel;
        $data ->ma_majorname = $majorname;
        $data ->ma_abbreviation = $abbreviation;
        $data->ma_remarks = $remarks;
        // $data->data = input('post.');
       $result = $data->save();
       return $result;
    }
/**
 * 修改专业
 * @param  [type] $Id        [description]
 * @param  [type] $majorname [description]
 * @param  [type] $remarks   [description]
 * @return [type]            [description]
 */
    public function editmajor($Id,$majorname,$abbreviation,$remarks)
    {


       $major =  Db::table('Major');
       $data = $major->where('Id', $Id)
                            ->update([
                                'ma_majorname' => $majorname,
                                'ma_abbreviation' => $abbreviation,
                                'ma_remarks' => $remarks,

                                ]);


       if ($data) {
            return true;
        } else {
            return false;
        }

    }


    /**
     * 删除专业
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deletetmajor($id){
        $result = Majormodel::destroy($id);
        return $result;
    }

}
