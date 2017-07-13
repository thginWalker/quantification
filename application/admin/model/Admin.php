<?php
//修改专业的模型
namespace app\admin\model;

use think\Model;
use think\Db;


class Admin extends Model{
    /*设置当前模型对于的完整数据表名称*/
    protected $table = 'Admin';



    /**
     * 读取老师用户信息
     * @param  [type] $teacher_id [description]
     * @return [type]             [description]
     */
    public function selectAdmin($teacher_id)
    {

        $data = Db::name('Admin')
                       ->where('Id','eq',$teacher_id)
                       ->find();
        return $data;

    }

    /**
     * 修改老师用户信息
     * @param  [type] $teacher_id [description]
     * @param  [type] $number     [description]
     * @param  [type] $name       [description]
     * @param  [type] $sex        [description]
     * @param  [type] $email      [description]
     * @return [type]             [description]
     */
    public function modifyMessage($teacher_id,$number,$name,$sex,$email)
    {
      $data = Db::table('Admin')
                  ->where('Id','eq',$teacher_id)
                  ->update([
                    'ad_number' => $number,
                    'ad_name' => $name,
                    'ad_sex' => $sex,
                    'ad_email' => $email
                    ]) ;
        if ($data) {
          return true;
        }else{
          return false;
        }
    }

    /**
     * 查找老师密码
     * @param  [type] $teacher_id [description]
     * @return [type]             [description]
     */
    public function adminPwd($teacher_id)
    {
      $admin = Db::name('Admin');
            $data= $admin
              ->field('ad_password')
              ->where('Id','eq',$teacher_id)
              ->find();
            return $data;
    }


    /**
     * 修改老师密码
     * @param  [type] $classid [description]
     * @return [type]          [description]
     */
    public function modifyPwd($teacher_id,$password)
    {
      $admin =  Db::table('Admin');
        $data =  $admin
                        ->where('Id','eq',$teacher_id)
                        ->update([
                          'ad_password' => $password
                          ]) ;
        return $data;
    }







}
