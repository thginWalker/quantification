<?php
namespace app\admin\controller;

use app\common\Common;

use app\admin\Model\Student;
use app\admin\Model\Classes;
use app\admin\Model\Studscoreinfo;
use app\admin\Model\Admin;

use think\View;     //视图类
use think\Session;

class Index extends Common
{
    /**
     * 教师模块首页设置
     * @return [type] [description]
     */
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


//////////////////////////////////////////班级人员管理//////////////////////////////////////////
  /**
   * 班级人员管理首页
   * @return [type] [description]
   */
   public function classStaff()
   {
       $classid = input('get.id');//得到班级的id
       $view = new View();
       $view->assign('classid',$classid);
      return $view->fetch('class_staff');
   }

   /**
    * 班级人员管理详情
    * @return [type] [description]
    */
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

    /**
     * 添加班级人员信息
     */
   public function addClass()
   {
        $number = input('post.number');
        $name = input('post.name');
        $sex = input('post.sex');
        $idnumber = input('post.idnumber');
        $remarks = input('post.remarks');
        $student = model('Student');
        $result = $student->addStudent($number,$name,$sex,$idnumber,$remarks);
        $result = $this->toJson($code = '200', $message = '数据正确', $student);
        return $result;
   }

   /**
    * 修改班级人员信息
    * @return [type] [description]
    */
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
        $result = $this->toJson($code = '200', $message = '数据正确', $student);
        return $result;

   }

    /**
     * 删除班级人员信息
     * @return [type] [description]
     */
   public function deleteClass()
   {
       $ids = input('post.ids');
       $student = model('Student');
       $result = $student->deleteStudent($ids);
       if ($result) {
         $result = $this->toJson($code = '200', $message = '数据正确', $student);
        return $result;
       } else {
         echo 0;
       }

  }

//////////////////////////////////////////量化委员管理//////////////////////////////////////////
    /**
     * 量化委员管理
     */
    public function Committee()
    {
     $classid = input('get.id');//得到班级的id
     $view = new View();
     $view->assign('classid',$classid);
    return $view->fetch('committee');

   }

   /**
    * 量化委员详情
    * @return [type] [description]
    */
   public function commDetails()
   {
        $classid = input('post.classid');//得到班级的id
        // 通过班级id找到改班级的量化委员学生id
      $committee = model('Committee');
      $studentid = $committee->selectCommittee($classid);
      //通过学生id找到学生信息
      $student = model('Student');
      $result = $student->queryStudent($studentid);
      $result = $this->toJson($code = '200', $message = '数据正确', $result);
      echo $result;
   }

   /**
    * 量化委员列表
    * @return [type] [description]
    */
   public function comBobox()
   {
       $classid = input('get.classid');//得到班级的id
       $student = model('Student');
       $result = $student->retrievecomBobox($classid);
      $result = json_encode($result);
      echo $result;
   }

   /**
    * 修改量化委员
    * @return [type] [description]
    */
   public function updatecomm()
   {
      $classid = input('post.classid');
      $student_id = input('post.student_id');
      $Committee = model('Committee');
       $result = $Committee->updateCommittee($classid,$student_id);
       $data = $this->toJson('200',  '数据正确', $result);
      echo $data;
   }

//////////////////////////////////////////班级量化管理//////////////////////////////////////////
   /**
    * 班级量化管理首页
    * @return [type] [description]
    */
    public function classQuantification()
    {
       $classid = input('get.id');//得到班级的id
       $view = new View();
       $view->assign('classid',$classid);
      return $view->fetch('classquan');


   }

   /**
    * 班级量化详情
    * @return [type] [description]
    */
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
           $information = $studscoreinfo->SortArray($information,'fo_fraction');
       }
      $information = json_encode($information);
      $total = $student->countStudent($classid);

      $information = substr($information, 0, -1);
      $information = '{"total" : '.$total.', "rows" : '.$information.']}';

      echo $information;
      exit;
   }

   /**
    * 学生量化详情
    * @return [type] [description]
    */
   public function studentDetails()
   {
      $studentid = input('get.studentid');
      //通过studscoreinfo查找单个学生的详细量化原因
      $studscoreinfo = model('Studscoreinfo');
      $studentDetails = $studscoreinfo->fractionDetails($studentid);
      // $data = $this->toJson('200',  '数据正确', $studentDetails);
       $data = json_encode($studentDetails);
      echo $data;
   }



   /**
    * 添加量化信息
    */
   public function addQuan()
   {
        $studentid = input('post.studentid');
        $time = input('post.time');
        $fraction = input('post.fraction');
        $reason = input('post.reason');
        $remarks = input('post.remarks');
        $studscoreinfo = model('Studscoreinfo');
        $result = $studscoreinfo->addStudscoreinfo($studentid,strtotime($time),$fraction,$reason,$remarks);
        $data = $this->toJson('200',  '数据正确', $result);
        echo $data;
   }

   /**
    * 修改量化信息
    * @return [type] [description]
    */
   public function updateQuan()
   {
        $id = input('post.Id');
        $studentid  = input('post.studentid');
        $time = input('post.time');
        $fraction = input('post.fraction');
        $reason = input('post.reason');
        $remarks = input('post.remarks');
        $studscoreinfo = model('Studscoreinfo');
        $result = $studscoreinfo->updateStudscoreinfo($id,$studentid,strtotime($time),$fraction,$reason,$remarks);
        $data = $this->toJson('200',  '数据正确', $result);
        echo $data;
      //echo "修改班级量化管理";
   }

    /**
     * 删除量化信息
     * @return [type] [description]
     */
   public function deleteQuan()
   {
    $ids = input('post.ids');
    $studscoreinfo = model('Studscoreinfo');
    $result = $studscoreinfo->deleteStudscoreinfo($ids);
    $data = $this->toJson('200',  '数据正确', $result);
    echo $data;
   }

//////////////////////////////////////////上周量化管理//////////////////////////////////////////
   /**
    * 上周量化管理
    * @return [type] [description]
    */
   public function weeklyQuantification()
   {

       $classid = input('get.id');//得到班级的id
       $view = new View();
       $view->assign('classid',$classid);
      return $view->fetch('weeklyquan');

   }

  /**
   * 上周量化详情
   * @return [type] [description]
   */
   public function weeklyDetails()
   {
      ////////////////////////////////////////////////////////////////////////////
      $classid = input('post.classid');//得到班级的id
      //通过班级id获取本班学生的每周量化管理
      $student = model('Student');//量化表
      $data = $student->selectStudent($classid);
      $studentid = [];// 存储学生id
      foreach ($data as $key => $value) {
        $studentid[$key] = $value['Id'];
      }

       $studscoreinfo = model('Studscoreinfo');//量化表
      $result = $studscoreinfo->weeklyQuan($studentid);
      $result = json_encode($result);
      echo $result;

   }



//////////////////////////////////////////上月量化管理//////////////////////////////////////////
   /**
    * 上月量化管理
    * @return [type] [description]
    */
   public function monthlyQuantification()
   {

       $classid = input('get.id');//得到班级的id
       $view = new View();
       $view->assign('classid',$classid);
      return $view->fetch('monthlyquan');

   }


   /**
    * 上月量化详情
    * @return [type] [description]
    */
   public function monthlyDetails()
   {
      $classid = input('post.classid');//得到班级的id
      //通过班级id获取本班学生的每周量化管理
      $student = model('Student');//量化表
      $data = $student->selectStudent($classid);
      $studentid = [];// 存储学生id
      foreach ($data as $key => $value) {
        $studentid[$key] = $value['Id'];
      }

       $studscoreinfo = model('Studscoreinfo');//量化表
      $result = $studscoreinfo->monthlyQuan($studentid);
      $result = json_encode($result);
      echo $result;


   }

//////////////////////////////////////////个人信息管理//////////////////////////////////////////
   /**
    * 修改信息首页
    * @return [type] [description]
    */
   public function modifyInfo()
   {
       //先查找班主任个人信息
      $teacher_id =  session('teacher_id');
      $admin = model('Admin');
      $info = $admin->selectAdmin($teacher_id);
      $view = new View();
      $view->assign('info',$info);
      return $view->fetch('self');
   }

   /**
    * 修改老师信息
    * @return [type] [description]
    */
   public function reviseMessage()
   {
      $teacher_id =  session('teacher_id');
      $number = input('post.number');
      $name = input('post.name');
      $sex = input('post.sex');
      $email = input('post.email');
      $admin = model("Admin");
      $result = $admin->modifyMessage($teacher_id,$number,$name,$sex,$email);
       if($result){
       $this->success('修改成功','Admin/Index/modifyInfo');
      }else{
        $this->error('修改失败','Admin/Index/modifyInfo');
      }
   }

   /**
    * 修改密码首页
    * @return [type] [description]
    */
   public function modifyPass()
   {
       $view = new View();
       // $view->assign('classid',$classid);
      return $view->fetch('password');
   }

   /**
    * 修改密码信息
    */

   public function revisePwd()
   {

      $teacher_id = session('teacher_id');
      $oldpassword =  input('post.oldpassword');
      $password =  md5(input('post.password'));
       $admin = model("Admin");
       $data = $admin->adminPwd($teacher_id);
            if( md5($oldpassword) == $data['ad_password'])
            {
                $result = $admin->modifyPwd($teacher_id,$password);
                if($result){
                     $this->success('修改成功','Admin/Index/modifyPass');
                }else{
                    $this->error('修改失败','Admin/Index/modifyPass');
                }
            }else{
                $this->error('原密码错误','Admin/Index/modifyPass');

            }
   }


    /**
     * 返回json数据
     * @param  string $code    [description]
     * @param  string $message [description]
     * @param  [type] $data    [description]
     * @return [type]          [description]
     */
    private function toJson($code = '200', $message = '数据正确', $data)
    {
        $pushdata = []; //定义新数组
        $pushdata['code'] = $code;
        $pushdata['message'] = $message;
        $pushdata['data'] = $data;
        return json_encode($pushdata, JSON_UNESCAPED_UNICODE); //返回正确汉字
    }

}

