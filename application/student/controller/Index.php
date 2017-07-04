<?php
namespace app\student\controller;

use think\Controller;
use think\Model;

// use app\admin\Model\Student;
// use app\admin\Model\Classes;
// use app\admin\Model\Studscoreinfo;

use think\View;     //视图类
use think\Session;

class Index extends Controller
{
   public function index()
   {
     echo "我是学生";
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

