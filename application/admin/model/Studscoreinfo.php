<?php
//修改专业的模型
namespace app\admin\model;

use think\Model;
use think\Db;


class Studscoreinfo extends Model{
    //设置当前模型对应的完整数据表名称
    protected $table = 'Studscoreinfo';

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


    //通过学生id查找单个学生的详细量化原因
    public function fractionDetails($studentid)
    {
        $data = Db::table('Studscoreinfo')
                              ->where('student_id',$studentid)
                              ->select();
        $studentDetails = [];
        foreach ($data as $key => $value) {
         // $studentDetails[$key]['fo_time'] = date("Y年m月d日",$value['fo_time']);////加分时间先不转化成日期格式，先排序
          $studentDetails[$key]['fo_time'] = $value['fo_time'];
          $studentDetails[$key]['fo_fraction'] = $value['fo_fraction'];//加分分数
          $studentDetails[$key]['fo_reason'] = $value['fo_reason'];//加分原因
          $studentDetails[$key]['fo_remarks'] = $value['fo_remarks'];//加分备注

        }//需要根据加分时间排序

        var_dump($studentDetails);
exit();

          return $studentDetails;
    }

    //将学生信息HTML标签化
    public function detailsHTML($studentDetails)
    {
      $HTMLstr = '<table class="dv-table" border="1" style="width:100%;padding:10px;background:#ccc">';

      foreach ($studentDetails as $key => $value) {
        $number = $key+1;
         $HTMLstr = $HTMLstr."
         <tr>
         <td align=\"center\"  colspan=\"4\">量化信息{$number}</td>
         </tr>
          <tr>
          <td class=\"dv-label\" width=\"60\">加分时间: </td>
          <td  width=\"80\" text-align=\"left\">{$value['fo_time']}</td>
          <td class=\"dv-label\" width=\"60\">加分分数:</td>
          <td  width=\"80\" text-align=\"left\">{$value['fo_fraction']}</td>
          </tr>
          <tr>
          <td class=\"dv-label\" width=\"60\">加分原因:</td>
          <td width=\"80\" text-align=\"left\">{$value['fo_reason']}</td>
          <td class=\"dv-label\">加分备注:</td>
          <td width=\"80\" text-align=\"left\">{$value['fo_remarks']}</td>
      </tr>";

      }
      $HTMLstr = $HTMLstr."</table>";
      return $HTMLstr;
    }








}
