<?php
namespace app\index\controller;

use think\Controller;
use think\Model;
// 0学生
// 1超级管理员admin
// 2管理员admin
// 3量化委员committee
// 4学生会studentunion
// 5门户维护员gateway

use app\index\Model\Student;
use app\index\Model\Admin;
use app\index\Model\Committee;
use app\index\Model\Studentunion;
use app\index\Model\Gateway;

use think\View;     //视图类
use think\Session;

class Index extends Controller
{
   public function index()
   {
        /*判断是否有session值，如果有session再根据级别进行不同的跳转。
        如果没有session设置session*/
          if (!session::has('user_name') && !session::has('role')) {
              $view = new View();
              return $view->fetch('login');
              exit();
         }else{
           //判断选择类型不同，进行选择
            if (session("role") == 0) {//学生
              //进行相应的跳转
            } elseif (session("role") == 1) {//超级管理员

            } elseif (session("role") == 2) {//管理员

            } elseif (session("role") == 3) {//量化委员

            } elseif (session("role") == 4) {//学生会

            } elseif (session("role") == 5) {//门户维护员

            }else{
              return false;
            }
         }

  }


    //进行登录判断
    public function login()
    {
        $name = input('post.username');
        $password = input('post.password');
        $role = input('post.role');
        $check =  input('post.check');
        echo "name={$name},password={$password},$role={$role},check={$check}";
        echo "<hr/>";
        //验证码判断成功
        if(!captcha_check($check)){
          echo "验证码错误";
          exit();
        }else{
          echo "验证码成功";
        }

        //判断登录类型进行验证跳转
        if ($role == 0) {//学生
          //简化代码:PHP变量名、类名、函数名均可为变量
          //http://blog.csdn.net/ei__nino/article/details/7462014
                //判断是否登录成功
                // 0学生</o
                // 1超级管理员administrator
                // 2管理员admin
                // 3量化委员committee
                // 4学生会studentunion
                // 5门户维护员gateway
   //查找进行数据库验证
          // public function judgeModel($db,$model,$name,$password)
          // {
          //     $db = model($model);
          //     $selectModel = "select{$model}";
          //       $result = $db->$selectModel($name,$password);
          //       $this->judgeLogin($result);
          // }
          $this->judgeModel('student','Student',$name,$password);
        // exit();
                // $student = model('Student');
                // $result = $student->selectStudent($name,$password);
                // $this->judgeLogin($result);//判断是否登录成功

            } elseif ($role == 1) {//超级管理员

            $this->judgeAdmin($name,$password,$role);
                // $admin = model('Admin');
                // $result = $admin->selectAdmin($name,$password,$role);
                // $this->judgeLogin($result);//判断是否登录成功

            } elseif ($role == 2) {//管理员

              this->judgeAdmin($name,$password,$role);
               //  $admin = model('Admin');
               //  $result = $admin->selectAdmin($name,$password,$role);
               // $this->judgeLogin($result);

            } elseif ($role == 3) {//量化委员

               $this->judgeModel('committee','Committee',$name,$password);
               //  $committee = model('Committee');
               //  $result = $committee->selectCommittee($name,$password);
               // $this->judgeLogin($result);

            } elseif ($role == 4) {//学生会

                $this->judgeModel('studentunion','Studentunion',$name,$password);
                // $studentunion = model('Studentunion');
                // $result = $studentunion->selectStudentunion($name,$password);
                // $this->judgeLogin($result);

            } elseif ($role == 5) {//门户维护员

                $this->judgeModel('gateway','Gateway',$name,$password);
                // $gateway = model('Gateway');
                // $result = $gateway->selectGateway($name,$password);
                // $this->judgeLogin($result);

            }else{
              echo "非法登录";
              return false;
            }

            ///用户登录日志插件，记录IP端口及登录方式
            ///增加数据库log

    }

          //查找进行数据库验证
          public function judgeModel($db,$model,$name,$password)
          {

              $db = model($model);
              $selectModel = "select{$model}";
                $result = $db->$selectModel($name,$password);
                $this->judgeLogin($result);

          }

          //进行书记和班主任的数据库验证
          public function judgeAdmin($name,$password,$role)
          {

                $admin = model('Admin');
                $result = $admin->selectAdmin($name,$password,$role);
                $this->judgeLogin($result);//判断是否登录成功

          }

          //设置登录session
          public function setSession($name,$password)
          {
              //////////////////////////////////////////////////////
              ///测试代码，清空session
              //////////////////////////////////////
              // Session::clear();

                //登录成功设置session
                Session::set('name',$name);
                Session::set('role',$role);
                return true;
          }

          //判断session是否设置成功
          public function judgeSession()
          {

             if (Session::has('name') && Session::has('name')) {
                     echo "session设置成功";
                     return true;
             } else {
                      echo "session设置失败";
                      return false;
            }
          }

          //登录是否成功进行判断
          public function judgeLogin($result)
          {
              if ($result) {
                  echo "登录成功";
                  var_dump($result);
                 $this->judgeSession();//与session相关的操作
                } else {
                  echo "登录失败";
                }
          }



}
