<?php
namespace app\gateway\controller;


use think\Controller;
use think\Model;



use think\View;     //视图类
use think\Session;

class Index extends Controller
{
    /**
     * 门户管理模块首页设置
     * @return [type] [description]
     */
   public function index()
   {
     echo "我是门户维修员";
  }



}

