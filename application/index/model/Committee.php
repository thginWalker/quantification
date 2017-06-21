<?php
namespace app\index\model;

use think\Model;
use think\Db;
// use think\Request;

class Committee extends Model
{
    //设置当前模型对于的完整数据表名称
    protected $table = 'committee';

    //查找量化委员
    public function selectCommittee($number,$password)
    {
        $committee = Db::name('Committee');
        $data = $committee
                ->where('co_number',$number)
                ->where('co_password',$password)
                ->find();
        if ($data) {
           return true;
        } else {
            return false;
        }

    }



}
