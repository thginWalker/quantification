<?php

namespace app\secretariat\model;

use think\Model;
use think\Db;


class Studentunion extends Model
{
    /*设置当前模型对于的完整数据表名称*/
    protected $table = 'Studentunion';

      /**
     * 读取秘书处用户信息
     * @param  [type] $teacher_id [description]
     * @return [type]             [description]
     */
    public function selectSecretariat()
    {

        $data = Db::name('Studentunion')
                       ->where('Id','eq',1)
                       ->find();
        return $data;

    }

    /**
     * 修改秘书处用户信息
     * @param  [type] $teacher_id [description]
     * @param  [type] $number     [description]
     * @param  [type] $name       [description]
     * @param  [type] $sex        [description]
     * @param  [type] $email      [description]
     * @return [type]             [description]
     */
    public function modifyMessage($number,$name,$email)
    {

      $data = Db::table('Studentunion')
                  ->where('Id','eq',1)
                  ->update([
                    'on_department' => $number,
                    'on_number' => $name,
                    'on_email' => $email
                    ]) ;
        if ($data) {
          return true;
        }else{
          return false;
        }
    }

    /**
     * 查找秘书处密码
     * @param  [type] $teacher_id [description]
     * @return [type]             [description]
     */
    public function studentPwd()
    {
        var_dump('23333');
        exit();
      $studentunion = Db::table('$Studentunion');
            $data= $studentunion
              ->field('on_password')
              ->where('Id','eq',1)
              ->find();
            return $data;
    }


    /**
     * 修改秘书处密码
     * @param  [type] $classid [description]
     * @return [type]          [description]
     */
    public function modifyPwd($password)
    {
      $studentunion =  Db::name('Studentunion');

        $data =  $studentunion
                        ->where('Id','eq',1)
                        ->update([
                          'on_password' => $password
                          ]) ;
        return $data;
    }




}
