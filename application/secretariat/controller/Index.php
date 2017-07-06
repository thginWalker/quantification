<?php
namespace app\secretariat\controller;


use think\Controller;
use think\Model;

use app\secretariat\Model\Dynamic;

use think\View;     //视图类
use think\Session;

class Index extends Controller
{
    /**
     * 秘书处模块首页设置
     * @return [type] [description]
     */
   public function index()
   {
     //先查找班主任管理班级
      $name =  session('name');//秘书处登录名字
       $view = new View();
       $view->assign('secretariat',$name);//传去秘书处名字
       return $view->fetch();
  }

  //量化详细内容
  public function quanDetails()
  {
      $sort =  input('post.sort');//排序字段

      $page = isset($_POST['page'])?intval($_POST['page']):1;//默认页码
      $rows = isset($_POST['rows'])?intval($_POST['rows']):5;//默认行数

      $dynamic = model('Dynamic');

      $result = $dynamic->retrieveDynamic($page,$rows,$sort);

      $result = json_encode($result);
      $total = $dynamic->countDynamic();

      $result = substr($result, 0, -1);
      $result = '{"total" : '.$total.', "rows" : '.$result.']}';

      echo $result;
  }

  //审核量化
  public function Auditquan()
  {
       $view = new View();
       return $view->fetch();
  }

  //量化通过
  public function Audited()
  {
     $Id = input('post.Id');
     $dynamic = model('Dynamic');
      $result = $dynamic->quanAudited($Id);//返回判断性
      echo $result;
  }

  //量化否决
  public function Auditveto()
  {
     $Id = input('post.Id');
     $dynamic = model('Dynamic');
    $result = $dynamic->quanAuditveto($Id);//返回判断性
    echo $result;
  }

  //修改密码
  public function Modifypwd()
  {
        $view = new View();
       return $view->fetch();
  }


}

