<?php
namespace app\student\controller;


use think\Controller;
use think\Model;

use app\student\Model\Student;
use app\student\Model\Studscoreinfo;

use think\View;     //视图类
use think\Session;

class Index extends Controller
{
    /**
     * 学生模块首页设置
     * @return [type] [description]
     */
   public function index()
   {
       $view = new View();
       return $view->fetch();
  }

  /**
   * 辅助找到学生id
   * @return [type] [description]
   */
  private function selectStudentId()
  {

        //先查找班主任管理班级
      $name =  session('name');//学生登录名字
      $student = model('Student');
      $studentid = $student->selectStudentId($name);
      return $studentid;
  }

    /**
   * 辅助找到学生班级id
   * @return [type] [description]
   */
  private function StudentClassId()
  {

      $name =  session('name');//学生登录名字
      $student = model('Student');
      $classid = $student->StudentClassId($name);
      return $classid;
  }

///////////////////////////////////个人量化首页////////////////////////////////////////////////

  public function quanPersonal()
  {

       $view = new View();
       return $view->fetch('personal');

  }

  //个人量化详情
  public function perDetails()
  {

      $page = isset($_POST['page'])?intval($_POST['page']):1;//默认页码
      $rows = isset($_POST['rows'])?intval($_POST['rows']):5;//默认行数

      $studentid = $this->selectStudentId();

      $studscoreinfo = model('Studscoreinfo');
      $result = $studscoreinfo->perDetails($page,$rows,$studentid);
      $result = json_encode($result);
      $total = $studscoreinfo->countperQuan($studentid);

      $result = substr($result, 0, -1);
      $result = '{"total" : '.$total.', "rows" : '.$result.']}';

      echo $result;
  }


///////////////////////////////////班级量化管理////////////////////////////////////////////////
  //班级量化首页
  public function quanClasses()
  {

       $view = new View();
       return $view->fetch('classquan');
  }

  //班级量化详情
  public function classDetails()
  {


      //找到班级人员
      //然后找到班级量化
      //然后传送数据
      $classid = $this->StudentClassId();
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
           $information = $studscoreinfo->SortArray($information,'fo_fraction');
       }
      $information = json_encode($information);
      $total = $student->countStudent($classid);

      $information = substr($information, 0, -1);
      $information = '{"total" : '.$total.', "rows" : '.$information.']}';

      echo $information;
      exit;

  }

///////////////////////////////////查看没审核首页////////////////////////////////////////////////
  //查看未审核首页
  public function notAudited()
  {

       $view = new View();
       return $view->fetch('not_audited');
  }

  //查看未审核详情
  public function notAuDetails()
  {
    $classid = $this->StudentClassId();
     $dynamic = model('Dynamic');
      $result = $dynamic->selectnotAu($classid);
      $result = json_encode($result);
      echo $result;
  }




///////////////////////////////////个人量化首页////////////////////////////////////////////////
  //更改信息
  public function changeInform()
  {

       $view = new View();
       return $view->fetch('change_inform');
  }



}

