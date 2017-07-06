<?php
namespace app\student\model;

use think\Model;
use think\Db;


class studscoreinfo extends Model
{
    /*设置当前模型对于的完整数据表名称*/
    protected $table = 'studscoreinfo';

    /**
     * 查找学生的量化信息
     */
    public function perDetails($page,$rows,$studentid)
    {

        $start = ($page-1)*$rows;
        $studentunion = Db::name('studscoreinfo');
        $data = $studentunion
                       ->where('student_id','eq',$studentid)
                       ->limit($start,$rows)//从第10行开始的25条数据
                       ->order('fo_time','desc')//desc降序
                       ->select();
        return $data;

    }

    //查找学生的量化总数
    public function countperQuan($studentid)
    {
        $studentunion = Db::name('studscoreinfo');
        $count = $studentunion
                       ->where('student_id','eq',$studentid)
                       ->count();
        return $count;
    }


    //获取相应学生的量化成绩studscoreinfo//累计添加
    public function selectFraction($information)
    {

      $fo_fraction = [];
      foreach ($information as $key => $value) {

           $data = Db::table('Studscoreinfo')
                              ->field('student_id,fo_fraction')
                              ->where('student_id',$value)
                              ->select();

           //通过id查询进行分数相加
              $stu_fraction = 0;
            foreach ($data as $datakey => $datavalue) {
              $stu_fraction += $datavalue['fo_fraction'];

            }

            $fo_fraction[$key] = $stu_fraction;

      }
      return $fo_fraction;
    }



}
