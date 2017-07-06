<?php
namespace app\index\model;

use think\Model;
use think\Db;
// use think\Request;

class Gateway extends Model
{
    /*设置当前模型对于的完整数据表名称*/
    protected $table = 'gateway';

    /**
     * 查找门户管理员
     * @param  [type] $number   [description]
     * @param  [type] $password [description]
     * @return [type]           [description]
     */
    public function selectGateway($number,$password)
    {
        $gateway = Db::name('Gateway');
        $data = $gateway
                ->where('ga_number',$number)
                ->where('ga_password',$password)
                ->find();
        if ($data) {
           return true;
        } else {
            return false;
        }

    }



}
