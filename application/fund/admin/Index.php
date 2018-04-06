<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/1
 * Time: 13:44
 */

namespace app\fund\admin;

use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use think\Db;

/**
 * 仪表盘控制器
 * @package app\cms\admin
 */
class Index extends Admin
{
    // 文章列表
    public function index()
    {
        // 读取用户数据
        $data_list = Db::name('fund_index_info')->order(['date' => 'desc'])->paginate();

// 使用ZBuilder构建数据表格
        return ZBuilder::make('table')
//            ->addOrder('id,username') // 添加排序
//            ->addFilter('id,username') // 添加筛选
            ->addColumns([
                ['__INDEX__', 'ID'],
            ])
            ->addColumn('index_name', '指数名称')
            ->addColumn('code', 'code')
            ->addColumn('date', '日期')
//            ->addColumn('mobile', '手机号')
            ->addColumn('create_time', '创建时间')
            ->setRowList($data_list) // 设置表格数据
            ->fetch();
    }

    // 文章设置
    public function config()
    {
        // 调用moduleConfig()方法即可，或者使用函数module_config()
        return $this->moduleConfig();
    }

    public function detail()
    {
        // 调用moduleConfig()方法即可，或者使用函数module_config()
        return $this->moduleConfig();
    }
}