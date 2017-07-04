<?php
//书记模块控制器
namespace app\committee\controller;

use \think\Controller;
use \think\Model;


use think\View;     //视图类
use think\Session;

class Index extends Controller{

   /**
    * 首页
    * @return [type] [description]
    */
    public function index()
    {

        echo "我是量化委员下面的模块，谢谢";
        exit;
         return $this->fetch('index');
    }



}
