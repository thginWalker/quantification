<?php
namespace app\index\model;

use think\Model;
use think\Db;


class Studentunion extends Model
{
    /*设置当前模型对于的完整数据表名称*/
    protected $table = 'studentunionnt';

    /**
     * 查找学生的量化信息
     * @param  [type] $number   [description]
     * @param  [type] $password [description]
     * @return [type]           [description]
     */
    public function perDetails($page,$rows,$stuentid)
    {
        $studentunion = Db::name('Studentunion');
        $data = $studentunion
                ->where('on_number',$number)
                ->where('on_password',$password)
                ->select();


    }



}




