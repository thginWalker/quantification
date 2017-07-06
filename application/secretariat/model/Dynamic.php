<?php

namespace app\secretariat\model;

use think\Model;
use think\Db;


class Dynamic extends Model
{
    /*设置当前模型对于的完整数据表名称*/
    protected $table = 'Dynamic';

        // 按条件进行查询所有
    public function retrieveDynamic($page,$rows,$sort)
    {

          $start = ($page-1)*$rows;
        if ($sort) {

            $data = Db::name('Dynamic')
                       ->where('dy_judge',0)
                       ->limit($start,$rows)//从第10行开始的25条数据
                       ->order($sort,'desc')//desc降序
                       ->select();
        } else {
            $data = Db::name('Dynamic')
                        ->where('dy_judge',0)
                       ->limit($start,$rows)//从第10行开始的25条数据
                       ->order('dy_time','desc')//asc升序
                       ->select();
        }

                    return $data;
    }

    //统计查询数据条数
    public function countDynamic()
    {
        $dynamic = Db::name('Dynamic');
        $data = $dynamic
                    ->count();//多
                    return $data;
    }

    //量化通过操作
    public function quanAudited($Id)
    {
        $dynamic = Db::name('Dynamic');
            $data = $dynamic->where('Id', $Id)
                            ->update([
                                'dy_judge' => 1,//量化通过为1
                                ]);
       if ($data) {
            return true;
        } else {
            return false;
        }
    }


    //量化否决操作
    public function quanAuditveto($Id)
    {
         $dynamic = Db::name('Dynamic');
            $data = $dynamic->where('Id', $Id)
                            ->update([
                                'dy_judge' => 2,//量化不通过为2
                                ]);
       if ($data) {
            return true;
        } else {
            return false;
        }
    }



}
