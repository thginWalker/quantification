<?php
//量化委员模块控制器
namespace app\committee\controller;

use \think\Controller;
use \think\Model;
use \think\Response;

use  app\committee\model\committeeModel;

use think\View;     //视图类
use think\Session;

class Index extends Controller{

   /**
    * 首页
    * @return [type] [description]
    */
    public function index(){
        $class_id = request()->param();
        $this->assign('class_id',$class_id);
        return $this->fetch('index');
    }

    /**
     * 显示分数设置
     * @return [type] [description]
     */
    public function fraction(){
        $fraction = model('Fraction');
        $classes = $fraction->retrieveclass();
        foreach ($classes as $key => $value) {
            $class[$key]['text'] = "{$value['cl_grade']}级{$value['major_id']}{$value['cl_classes']}班";
            $class[$key]['value'] = $value['Id'];
        }
        $this->assign('class',$class);
        return $this->fetch('fraction');

    }
    /**
     * 分数分页传值
     * @return [type] [description]
     */
    public function fractionmessage(){
        $page = isset($_POST['page'])?intval($_POST['page']):1;//默认页码
        $rows = isset($_POST['rows'])?intval($_POST['rows']):5;//默认行数
        $class = model('Stufraction');
        $class_id = $class->findclassid();
        $fraction = model('Fraction');
        $result = $fraction->retrievefraction($page,$rows,$class_id);
        $result = json_encode($result);
        $total = $fraction->countfraction();
        $result = substr($result, 0, -1);
        $result = '{"total" : '.$total.', "rows" : '.$result.']}';
     //var_dump($result);exit();
    echo $result;

    }
    
   public function stufraction(){
     return $this->fetch('stufraction');
   }

    /**
     * 删除量化数据
     * @return [type] [description]
     */
    public function deletefraction(){

         $ids = input('post.ids');
        $major = model('Fraction');
       $result = $major->deletefraction($ids);
       if ($result) {
         return $result;
       } else {
         return 0;
       }
    }  
    public function student(){
        $page = isset($_POST['page'])?intval($_POST['page']):1;//默认页码
        $rows = isset($_POST['rows'])?intval($_POST['rows']):5;//默认行数
        $fraction = model('Stufraction');
        $result = $fraction->examinefraction($page,$rows);
        $result = json_encode($result);
        $total = $fraction->countfraction();
        $result = substr($result, 0, -1);
        $result = '{"total" : '.$total.', "rows" : '.$result.']}';
     //var_dump($result);exit();
    echo $result;

    }
    public function editstufraction()
   {    
        $id =  input('post.Id');
        $fo_time = input('post.fo_time');
        $fo_reason = input('post.fo_reason');
        $fo_fraction = input('post.fo_fraction');
        $fo_time = strtotime($fo_time);
        $fo_remarks = input('post.fo_remarks');; 
        $stufraction = model('Stufraction');
         $result = $stufraction->addstufraction($id,$fo_time,$fo_reason,$fo_fraction,$fo_remarks);
        if ($result) {
             echo "操作成功";
           } else {
             echo "操作失败";
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
