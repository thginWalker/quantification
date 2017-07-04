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
    /**
     * 判断是否有session值,有跳转，没有设置
     * @return [type] [description]
     */
   public function index()
   {

          if (!session::has('name') && !session::has('role')) {
              $view = new View();
              return $view->fetch('login');
              exit();
         }else{

              $this->judgeJump();
         }

  }

    /**
     * 进行登录判断
     * @return [type] [description]
     */
    public function login()
    {
        $name = input('post.username');
        $password = md5(input('post.password'));
        $role = input('post.role');
        $check =  input('post.check');

        if(!captcha_check($check)){ //验证码判断成功
          $this->error("验证码错误");
          exit();
        }
        //判断登录类型进行验证跳转
        if ($role == 0) {//学生

          $this->judgeModel('student','Student',$name,$password,0);

            } elseif ($role == 1 || $role == 2) {//超级管理员

            $this->judgeAdmin($name,$password,$role);

            } elseif ($role == 3) {//量化委员

  //            $this->judgeModel('student','Student',$name,$password,1);
               $this->judgeModel('committee','Committee',$name,$password,3);

            } elseif ($role == 4) {//学生会

                $this->judgeModel('studentunion','Studentunion',$name,$password,4);

            } elseif ($role == 5) {//门户维护员

                $this->judgeModel('gateway','Gateway',$name,$password,5);

            }else{

                $this->error("非法登录");
              return false;

            }

            ///用户登录日志插件，记录IP端口及登录方式
            ///增加数据库log

    }

          /**
           * 查找进行数据库验证
           * @param  [type] $db       [description]
           * @param  [type] $model    [description]
           * @param  [type] $name     [description]
           * @param  [type] $password [description]
           * @param  [type] $role     [description]
           * @return [type]           [description]
           */
          public function judgeModel($db,$model,$name,$password,$role)
          {

              $db = model($model);
              $selectModel = "select{$model}";
              $result = $db->$selectModel($name,$password);
              $judge = $this->judgeLogin($result,$name,$role);

          }

          /**
           * 书记和班主任的登录验证
           * @param  [type] $name     [description]
           * @param  [type] $password [description]
           * @param  [type] $role     [description]
           * @return [type]           [description]
           */
          public function judgeAdmin($name,$password,$role)
          {

                $admin = model('Admin');
                $result = $admin->selectAdmin($name,$password,$role);
                $this->judgeLogin($result,$name,$role);//判断是否登录成功

          }

          /**
           * 清除默认session值，即退出
           * @return [type] [description]
           */
          public function clearSession()
          {
            Session::clear();
          }

          /**
           * 设置登录session
           * @param [type] $name [description]
           * @param [type] $role [description]
           */
          public function setSession($name,$role)
          {

                //登录成功设置session
                Session::set('name',$name);
                Session::set('role',$role);
                return true;
          }

          /**
           * 判断session是否设置成功
           * @return [type] [description]
           */
          public function judgeSession()
          {
               if (Session::has('name') && Session::has('role')) {
                       return true;
               } else {
                       return false;
              }
          }

          /**
           * 登录是否成功进行判断
           * @param  [type] $result [description]
           * @param  [type] $name   [description]
           * @param  [type] $role   [description]
           * @return [type]         [description]
           */
          public function judgeLogin($result,$name,$role)
          {
              if ($result) {
                $this->setSession($name,$role);//设置session
                $this->judgeSession();//判断是否设置session
                $this->judgeJump();//进行相应跳转

                } else {

                  $this->error("账号或密码错误!");
                }
          }

          /**
           * 判断session是否存在进行跳转
           * @return [type] [description]
           */
          public function judgeJump()
          {
                  if (session("role") == 0) {//学生
                      $this->success('登录成功', 'Student/Index/index');
                    } elseif (session("role") == 1) {//超级管理员
                      $this->success('登录成功', 'Secretary/Index/index');
                    } elseif (session("role") == 2) {//管理员
                       $this->success('登录成功', 'Admin/Index/index');
                    } elseif (session("role") == 3) {//量化委员
                        $this->success('登录成功', 'Committee/Index/index');
                    } elseif (session("role") == 4) {//学生会
                      // echo "4";
                    } elseif (session("role") == 5) {//门户维护员
                        //
                    }else{
                      return false;
                    }
          }

}