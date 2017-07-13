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
        $studentDetails = [];
        foreach ($data as $key => $value) {
         // $studentDetails[$key]['fo_time'] = date("Y年m月d日",$value['fo_time']);////加分时间先不转化成日期格式，先排序
          $studentDetails[$key]['Id'] = $value['Id'];
          $studentDetails[$key]['student_id'] = $studentid;
          $studentDetails[$key]['fo_time'] = $value['fo_time'];
          $studentDetails[$key]['fo_fraction'] = $value['fo_fraction'];//加分分数
          $studentDetails[$key]['fo_reason'] = $value['fo_reason'];//加分原因
          $studentDetails[$key]['fo_remarks'] = $value['fo_remarks'];//加分备注

        }
        //需要根据加分时间排序
        $studentDetails = $this->SortArray($studentDetails,'fo_time');
        //将时间有时间戳转换成时间格式
        foreach ($studentDetails as $key => $value) {
          $studentDetails[$key]['fo_time'] = date("Y年m月d日",$value['fo_time']);
        }
        return $studentDetails;



    }


    //按照数组要求进行排序//按大到小
    public function SortArray($array,$field)
    {
        for ($i = 0; $i < count($array); $i++) {
                      for ($j = 0; $j < count($array) - $i - 1; $j++) {
                          if ($array[$j][$field] < $array[$j + 1][$field]) {
                              $temp = $array[$j];
                              $array[$j] = $array[$j + 1];
                              $array[$j + 1] = $temp;
                          }
                      }
       }
       return $array;
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
