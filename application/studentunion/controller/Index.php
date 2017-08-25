<?php
//学生会模块控制器
namespace app\studentunion\controller;

use \app\common\Common;
use \think\Controller;
use \think\Model;
use \think\Response;

use  app\studentunion\model\studentunionModel;

use think\View;     //视图类
use think\Session;

class Index extends Common{

   /**
    * 首页
    * @return [type] [description]
    */
    public function index(){
         return $this->fetch('index');
    }

    /**
     * 修改自己信息
     * @return [type] [description]
     */
    public function revise(){
        $message = model("studentunion");
        $data = $message->retrieve(1);
        $this->assign("message",$data);
         return $this->fetch('self');

    }

    /**
     * 接收修改自己信息
     * @return [type] [description]
     */
    public function revisemessage(){
        $message = model("studentunion");
        $res = $message->modify();
         if($res){
         $this->success('修改成功','index/revise');
        }else{
          $this->error('修改失败','index/revise');
        }
    }
    /**
     * 修改密码
     * @return [type] [description]
     */
    public function modifypassword(){
        $message = model("studentunion");
        $data = $message->retrieve();
        $this->assign("message",$data);
         return $this->fetch('password');
    }
    /**
     * 接收修改密码
     * @return [type] [description]
     */
    public function revisepassworld(){

            $message = model("studentunion");
            $data = $message->retrieve();
            $pwd = $data[0]['on_password'];
            $oldpassword = input('post.oldpassword');
            $oldpassword = md5($oldpassword);
            if( $oldpassword == $pwd){
                $password = input('post.password');
                $password = md5($password);
                $res = $message->modifypass($password);
                if($res){
                     $this->success('修改成功','modifypassword');
                }else{
                    $this->error('修改失败','modifypassword');
                }
            }else{
                $this->error('原密码错误','modifypassword');
            }

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
        $sort =  input('post.sort');
        $page = isset($_POST['page'])?intval($_POST['page']):1;//默认页码
        $rows = isset($_POST['rows'])?intval($_POST['rows']):5;//默认行数
        $fraction = model('Fraction');
        $result = $fraction->retrievefraction($page,$rows,$sort);
        $result = json_encode($result);
        $total = $fraction->countfraction();
        $result = substr($result, 0, -1);
        $result = '{"total" : '.$total.', "rows" : '.$result.']}';
     //var_dump($result);exit();
    echo $result;

    }
    /**
     * 添加量化数据
     * @return [type] [description]
     */
   public function addfraction()
   {
        $classes_id = input('post.classes_name');
        $dy_name = input('post.dy_name');
        $dy_time = input('post.dy_time');
        $dy_time = strtotime($dy_time);
        $dy_reason = input('post.dy_reason');
        $dy_fraction = input('post.dy_fraction');
        $dy_remarks = input('post.dy_remarks');        
        $major = model('Fraction');
          $result = $major->addFraction($classes_id,$dy_name,$dy_time,$dy_reason,$dy_fraction,$dy_remarks);
        if ($result) {
             echo "操作成功";
           } else {
             echo "操作失败";
           }

   }
    /**
     * 修改量化数据
     * @return [type] [description]
     */
   public function editfraction()
   {    
        $id =  input('post.Id');
        $dy_name = input('post.dy_name');
        $classes_name = input('post.classes_name');
        $sign = is_numeric($classes_name);
        if($sign){
            $classes_id = $classes_name;
        }else{
            $classes_id = input('post.classes_id');
        }
        $dy_time = input('post.dy_time');
        $dy_time = strtotime($dy_time);
        $dy_reason = input('post.dy_reason');
        $dy_fraction = input('post.dy_fraction');
        $dy_remarks = input('post.dy_remarks'); 
        $fraction = model('Fraction');
         $result = $fraction->editFraction($id,$classes_id,$dy_name,$dy_time,$dy_reason,$dy_fraction,$dy_remarks);
        if ($result) {
             echo "操作成功";
           } else {
             echo "操作失败";
           }

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
    //显示修改分数
    public function examine(){
        $fraction = model('Fraction');
        $classes = $fraction->retrieveclass();
        foreach ($classes as $key => $value) {
            $class[$key]['text'] = "{$value['cl_grade']}级{$value['major_id']}{$value['cl_classes']}班";
            $class[$key]['value'] = $value['Id'];
        }
        $this->assign('class',$class);
         return $this->fetch('examine');
    }
    //显示分页信息及分数信息
    public function examinefraction(){
        $sort =  input('post.sort');
        $page = isset($_POST['page'])?intval($_POST['page']):1;//默认页码
        $rows = isset($_POST['rows'])?intval($_POST['rows']):5;//默认行数
        $examine = model('Examine');
        $result = $examine->examinefraction($page,$rows,$sort);
        $result = json_encode($result);
        $total = $examine->countfraction();
        $result = substr($result, 0, -1);
        $result = '{"total" : '.$total.', "rows" : '.$result.']}';
     //var_dump($result);exit();
    echo $result;

    }
    //联系我们
      public function contact(){
        return $this->fetch();
    }
    public function signout(){
        var_dump("expression");
       $this->redirect('Index/Index/clearSession');
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
