<?php
namespace app\index\model;

use think\Model;
use think\Db;
// use think\Request;

class Studentunion extends Model
{
    /*设置当前模型对于的完整数据表名称*/
    protected $table = 'studentunionnt';

    /**
     * 查找学生会和秘书处登录
     * @param  [type] $number   [description]
     * @param  [type] $password [description]
     * @return [type]           [description]
     */
    public function selectStudentunion($number,$password)
    {

      $studentunion = Db::name('Studentunion');
        // 先判断学生会为不为秘书处
           $secretariat = $studentunion
                     ->where('on_number',$number)
                    ->where('on_password',$password)
                    ->where('Id','eq',1)
                    ->find();//多条件查询，可以改善
               if ($secretariat) {
                    $role = 6;
                   return $role;//登录成功
               }
        //如何不为秘书处然后在判断是不是其他学生会
            $union = $studentunion
                ->where('on_number',$number)
                ->where('on_password',$password)
                ->where('Id','<>',1)
                ->find();//需指明id不能为1
            if ($union) {
                    $role = 4;
                   return $role;//登录成功
            }

            return false;

        }



}
