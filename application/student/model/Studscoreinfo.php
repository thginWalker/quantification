<?php
//修改专业的模型
namespace app\admin\model;

use think\Model;
use think\Db;


class Studscoreinfo extends Model{
    //设置当前模型对应的完整数据表名称
    protected $table = 'Studscoreinfo';
/////////////////////////////////////////////////////////////////////////////////////
    //添加量化信息
    public function addStudscoreinfo($studentid,$time,$fraction,$reason,$remarks)
    {
      $data['student_id'] = $studentid;//此处获得student_id
      $data['fo_time'] = $time;
      $data['fo_fraction'] = $fraction;
      $data['fo_reason'] = $reason;
      $data['fo_remarks'] = $remarks;
       $Studscoreinfo = Db::table('Studscoreinfo');
       $result = $Studscoreinfo->insert($data);
       if ($result) {
           return $result;
       } else {
           return false;
       }
    }
//////、、、、、、、、、、、、、、、、、、、
    //修改量化信息
    public function updateStudscoreinfo($id,$studentid,$time,$fraction,$reason,$remarks)
    {
       $Studscoreinfo =  Db::table('Studscoreinfo');
       $data = $Studscoreinfo->where('Id', $id)
                            ->update([
                                'student_id' => $studentid,
                                'fo_time' => $time,
                                'fo_fraction' => $fraction,
                                'fo_reason' =>$reason,
                                'fo_remarks' => $remarks
                                ]);

       if ($data) {
            return true;
        } else {
            return false;
        }
    }
///////////////////////////////////////////////////////////////////////
    //删除量化信息
    public function deleteStudscoreinfo($ids)
    {
      $data = Studscoreinfo::destroy($ids);
        if ($data) {
            return true;
        } else {
            return false;
        }
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


    //通过学生id查找单个学生的详细量化原因
    public function fractionDetails($studentid)
    {
        $data = Db::table('Studscoreinfo')
                              ->where('student_id',$studentid)
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


    //通过学生id并通过量化表上周量化信息
    public function weeklyQuan($studentid)
    {
      //php获取上周开始时间戳
        $beginLastweek=mktime(0,0,0,date('m'),date('d')-date('w')+1-7,date('Y'));
      //php获取上周结束时间戳
        $endLastweek=mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y'));

      $weekData = [0,0,0,0,0,0,0];//存储每周成绩

      foreach ($studentid as $key => $value) {
        $data = Db::table('Studscoreinfo')
                              ->where('student_id',$studentid[$key])
                              ->select();

        if ($data) {
        ////////////////////////////////////////////////////////////////////////////////////////////////
        foreach ($data as $datakey => $datavalue) {
          //判断时间
          if ($datavalue['fo_time'] >$beginLastweek  &&  $datavalue['fo_time'] <$endLastweek) {//星期一-6
                    for ($i = 0; $i < 7; $i++) {
                          if (
                            $datavalue['fo_time']>mktime(0,0,0,date('m'),date('d')-date('w')-6+$i,date('Y'))
                            &&
                            $datavalue['fo_time']<mktime(0,0,0,date('m'),date('d')-date('w')-5+$i,date('Y'))
                            ) {
                            $weekData[$i] += $datavalue['fo_fraction'];
                          }
                    }

          }

        }
        ////////////////////////////////////////////////////////////////////////////////////////////////
        }

      }
return $weekData;

    }




///////////////////////////////////////////////////////////////////////////////////      //http://www.w3school.com.cn/php/func_date_mktime.asp
        //通过学生id并通过量化表上月量化信息
    public function monthlyQuan($studentid)
    {

$m = date('Y-m-d', mktime(0,0,0,date('m')-1,1,date('Y'))); //上个月的开始日期

$t = date('t',strtotime($m)); //上个月共多少天


    //上月刚开始的时间戳
    $beginLastmonthly = mktime(0,0,0,date('m')-1,1,date('Y'));
    //上月刚结束的时间戳
      $endThismonthly = mktime(0,0,0,date('m')-1,$t,date('Y'));

        $dataweek = [0,0,0,0];//记录一个月四个周的成绩
          foreach ($studentid as $key => $value) {
        $data = Db::table('Studscoreinfo')
                              ->where('student_id',$studentid[$key])
                              ->select();


          if ($data) {
            ///////////////////////////////////////////////////////////////////////////
                    foreach ($data as $datakey => $datavalue) {
          //判断时间
          if ($datavalue['fo_time'] >$beginLastmonthly  &&  $datavalue['fo_time'] <$endThismonthly) {//星期一-6
                    for ($i = 0; $i < 28; $i++) {

                          if (
                            $datavalue['fo_time']>mktime(0,0,0,date('m')-1,1,date('Y'))
                            &&
                            $datavalue['fo_time']<mktime(0,0,0,date('m')-1,8,date('Y'))
                            ) {
                            $dataweek[0] += $datavalue['fo_fraction'];
                          }elseif
                          (
                            $datavalue['fo_time']>mktime(0,0,0,date('m')-1,8,date('Y'))
                            &&
                            $datavalue['fo_time']<mktime(0,0,0,date('m')-1,15,date('Y'))
                          ){
                            $dataweek[1] += $datavalue['fo_fraction'];
                          }elseif
                          (
                            $datavalue['fo_time']>mktime(0,0,0,date('m')-1,15,date('Y'))
                            &&
                            $datavalue['fo_time']<mktime(0,0,0,date('m')-1,21,date('Y'))
                          ){
                            $dataweek[2] += $datavalue['fo_fraction'];
                          }elseif
                          (
                            $datavalue['fo_time']>mktime(0,0,0,date('m')-1,21,date('Y'))
                            &&
                            $datavalue['fo_time']<mktime(0,0,0,date('m')-1,28,date('Y'))
                          ){
                            $dataweek[3] += $datavalue['fo_fraction'];
                          }

                    }
          }

        }
            //////////////////////////////////////////////////////////////////////////
          }

      }


 return $dataweek;

  }





}
