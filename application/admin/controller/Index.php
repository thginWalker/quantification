<?php
namespace app\admin\controller;

use think\Controller;
use think\Model;

use app\admin\Model\Student;
use app\admin\Model\Classes;
use app\admin\Model\Studscoreinfo;

use think\View;     //视图类
use think\Session;

class Index extends Controller
{
   public function index()
   {
     //先查找班主任管理班级
      $teacher_id =  session('teacher_id');
      $classes = model('Classes');
      $grade = $classes->manageClass($teacher_id);
       $view = new View();
       $view->assign('grade',$grade);
       return $view->fetch();
  }


////////////////////////////////////////////////////////////////////////班级人员管理
  //班级人员管理首页
   public function classStaff()
   {
       $classid = input('get.id');//得到班级的id
       $view = new View();
       $view->assign('classid',$classid);
      return $view->fetch('class_staff');
   }

   //班级人员管理详情
   public function classDetails()
   {

      $classid = input('get.classid');//查询班级字段
      $sort =  input('post.sort');//排序字段

      $page = isset($_POST['page'])?intval($_POST['page']):1;//默认页码
      $rows = isset($_POST['rows'])?intval($_POST['rows']):5;//默认行数

      $student = model('Student');
      $result = $student->retrievestudent($page,$rows,$sort,$classid);
      $result = json_encode($result);
      $total = $student->countStudent($classid);

      $result = substr($result, 0, -1);
      $result = '{"total" : '.$total.', "rows" : '.$result.']}';

      echo $result;

   }

    //添加班级人员信息
   public function addClass()
   {
        $number = input('post.number');
        $name = input('post.name');
        $sex = input('post.sex');
        $idnumber = input('post.idnumber');
        $remarks = input('post.remarks');
        $student = model('Student');
        $result = $student->addStudent($number,$name,$sex,$idnumber,$remarks);
        return $result;
   }

   //修改班级人员信息
   public function updateClass()
   {
        $Id = input('post.Id');
        $number = input('post.number');
        $name = input('post.name');
        $sex = input('post.sex');
        $idnumber = input('post.idnumber');
        $remarks = input('post.remarks');
        $student = model('Student');
        $result = $student->editStudent($Id,$number,$name,$sex,$idnumber,$remarks);
        return $result;
   }

    //删除班级人员信息
   public function deleteClass()
   {
       $ids = input('post.ids');
       $student = model('Student');
       $result = $student->deleteStudent($ids);
       if ($result) {
         echo $result;
       } else {
         echo 0;
       }

  }

/////////////////////////////////////////////////////////////////////////////量化委员管理
    //量化委员管理
    public function Committee()
    {

    return $this->fetch('committee');

   }

/////////////////////////////////////////////////////////////////////////////班级量化管理
   //班级量化管理首页
    public function classQuantification()
    {
       $classid = input('get.id');//得到班级的id
       $view = new View();
       $view->assign('classid',$classid);
      return $view->fetch('classquan');


   }

   //班级量化详情
   public function quanDetails()
   {
      //找到班级人员
      //然后找到班级量化
      //然后传送数据
      $classid = input('get.classid');//得到班级的id
      $sort =  input('post.sort');//排序字段
      if ($sort == 'fo_fraction') {//分数特殊排序
        $sortFo = $sort;
        $sort = 'nt_number';//设置默认值
      }
      $page = isset($_POST['page'])?intval($_POST['page']):1;//默认页码
      $rows = isset($_POST['rows'])?intval($_POST['rows']):5;//默认行数
      $student = model('Student');
      $result = $student->retrievestudent($page,$rows,$sort,$classid);
      $information = [];//存储学生信息
      $studentid = [];//作为学生id查询
      foreach ($result as $key => $value) {
        $information[$key]['Id'] = $value['Id'];//id
        $studentid[$key] = $value['Id'];//id
        $information[$key]['nt_name'] = $value['nt_name'];//姓名
        $information[$key]['nt_remarks'] = $value['nt_remarks'];//姓名
          }

      //根据id查找学生量化分数
      $studscoreinfo = model('Studscoreinfo');

       $fo_fraction = $studscoreinfo->selectFraction($studentid);

       foreach ($information as $key => $value) {
         $information[$key]['fo_fraction'] = $fo_fraction[$key];//分数
       }
       //根据分数进行排序
       if (isset($sortFo) && !empty($sortFo)  && $sortFo == 'fo_fraction') {

                 $s=count($information);

                  for ($i = 0; $i < $s; $i++) {
                      for ($j = 0; $j < $s - $i - 1; $j++) {
                          if ($information[$j]['fo_fraction'] < $information[$j + 1]['fo_fraction']) {
                              $temp = $information[$j];
                              $information[$j] = $information[$j + 1];
                              $information[$j + 1] = $temp;
                          }
                      }
                  }
       }
      $information = json_encode($information);
      $total = $student->countStudent($classid);

      $information = substr($information, 0, -1);
      $information = '{"total" : '.$total.', "rows" : '.$information.']}';

      echo $information;
      exit;
   }

   //学生量化详情
   public function studentDetails()
   {
      $studentid = input('get.studentid');
      //通过studscoreinfo查找单个学生的详细量化原因
      $studscoreinfo = model('Studscoreinfo');
       $studentDetails = $studscoreinfo->fractionDetails($studentid);
      //将信息html标签化
      $detailsHTML = $studscoreinfo->detailsHTML($studentDetails);
      echo $detailsHTML;

   }

   //添加班级量化管理//////////有问题
   public function addQuan()
   {

   }

   //修改班级量化管理////////有问题
   public function updateQuan()
   {

   }

    //删除班级量化管理
   public function deleteQuan()
   {

   }

/////////////////////////////////////////////////////////////////////////每周量化管理
   //每周量化管理
   public function weeklyQuantification()
   {
      $classid = input('get.id');//得到班级的id
      //通过班级id获取本班学生的每周量化管理
      $weekly = model('Studscoreinfo');//量化表
      $view = new View();
      $data = [];
      for ($i = 0; $i < 7; $i++) {
           $data[$i]['date'] = date("Y年m月d日",time()-24*60*60*$i);
           $week= date("w",time()-24*60*60*$i)-1;
           if ( $week ==-1) {
               $week =6;
           }
           $data[$i]['week'] = $week;

      }

      var_dump($data);
      exit;
      $view->assign('classid',$classid);
    return $view->fetch('weeklyquan');
    // echo "每周量化管理',";

   }










///////////////////////////////////////////////////////////////////每月量化管理
   //每月量化管理
   public function monthlyQuantification()
   {

    return $this->fetch('monthlyquan');
    // echo "每月量化管理',";

   }




    //返回json数据
    private function toJson($code = '200', $message = '数据正确', $data)
    {
        $pushdata = []; //定义新数组
        $pushdata['code'] = $code;
        $pushdata['message'] = $message;
        $pushdata['data'] = $data;
        return json_encode($pushdata, JSON_UNESCAPED_UNICODE); //返回正确汉字
    }

}