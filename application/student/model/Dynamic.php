<?php
namespace app\student\model;

use think\Model;
use think\Db;


class Dynamic extends Model
{
    /*设置当前模型对于的完整数据表名称*/
    protected $table = 'dynamic';

    /**
     * 查找未审核信息
     */
    public function selectnotAu($classid)
    {

        $studentunion = Db::name('Dynamic');
        $data = $studentunion
                       ->where('classes_id','eq',$classid)
                       ->where('dy_judge','eq',0)
                       ->select();

        $studentDetails = [];
        foreach ($data as $key => $value) {
         // $studentDetails[$key]['fo_time'] = date("Y年m月d日",$value['fo_time']);////加分时间先不转化成日期格式，先排序
          $studentDetails[$key]['Id'] = $value['Id'];
          $studentDetails[$key]['dy_name'] = $value['dy_name'];//姓名
          $studentDetails[$key]['dy_time'] = $value['dy_time'];//加分时间
          $studentDetails[$key]['dy_reason'] = $value['dy_reason'];//加分原因
          $studentDetails[$key]['dy_fraction'] = $value['dy_fraction'];//加分分数
          $studentDetails[$key]['dy_remarks'] = $value['dy_remarks'];//加分备注

        }
        //需要根据加分时间排序
        $studentDetails = $this->SortArray($studentDetails,'dy_time');
        //将时间有时间戳转换成时间格式
        foreach ($studentDetails as $key => $value) {
          $studentDetails[$key]['dy_time'] = date("Y年m月d日",$value['dy_time']);
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







}
