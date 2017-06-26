<?php
//修改班主任的模型
namespace app\secretary\model;

use think\Model;
use think\Db;
use think\request;

class HeadmasterModel extends Model{
    //设置当前模型对应的完整数据表名称
    protected $table = 'Admin';


    /**查询所有
    *$page分页页数
    *$rows分页的条数
     * [retrievemajor description]
     * @param  [type] $page [description]
     * @param  [type] $rows [description]
     * @return [type]       [description]
     */
    public function retrieveheadmaster($page,$rows)
    {
        $start = ($page-1)*$rows;
        $data = Db::name('Admin')->where('ad_distinguish',1)
                       ->limit($start,$rows)//从第10行开始的25条数据
                       ->select();
        return $data;
    }


    /**
     *查询所有记录条数
     * @return [type] [description]
     */
    public function countheadmaster()
    {
           $data =  Db::name('Admin')->where('ad_distinguish',1)
                     ->count();//
        return $data;
    }




    /**
     * 添加班主任
     * @param  [type] $ad_number  [description]
     * @param  [type] $ad_name    [description]
     * @param  [type] $ad_sex     [description]
     * @param  [type] $ad_email   [description]
     * @param  [type] $ad_remarks [description]
     * @return [type]             [description]
     */
    public function addheadmaster($ad_number,$ad_name,$ad_sex,$ad_email,$ad_remarks)
    {
        $data = new HeadmasterModel;
        $data ->ad_number = $ad_number;
        $data->ad_name = $ad_name;
        $data->ad_sex = $ad_sex;
        $data->ad_email = $ad_email;
        $data->ad_distinguish = '1';
        $data->ad_remarks = $ad_remarks;

        // $data->data = input('post.');
       $result = $data->save();
       return $result;
    }
/**
 * 修改班主任
 * @param  [type] $Id         [description]
 * @param  [type] $ad_number  [description]
 * @param  [type] $ad_name    [description]
 * @param  [type] $ad_sex     [description]
 * @param  [type] $ad_email   [description]
 * @param  [type] $ad_remarks [description]
 * @return [type]             [description]
 */
    public function editheadmaster($Id,$ad_number,$ad_name,$ad_sex,$ad_email,$ad_remarks)
    {


       $classes =  Db::table('Admin');
       $data = $classes->where('Id', $Id)
                            ->update([
                                'ad_number' => $ad_number,
                                'ad_name' => $ad_name,
                                'ad_sex' => $ad_sex,
                                'ad_email' => $ad_email,
                                'ad_remarks' => $ad_remarks,

                                ]);

       if ($data) {
            return true;
        } else {
            return false;
        }

    }


    /**
     * 删除班主任
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteheadmaster($id){
        $result = HeadmasterModel::destroy($id);
        return $result;
    }

}
