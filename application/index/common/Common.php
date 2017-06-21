<?php
namespace app\index\common;

use think\Controller;

class Common extends Controller
{

    //对每个方法进行判断
    //然后其他方法继承这个方法就好了
    public function _initialize(){
         if (!session::has('name') && !session::has('role')) {
             $this->error('对不起，您还没有登录!请先登录在进行操作','Index/index/login');
         }
    }

}
