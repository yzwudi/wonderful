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
        $order = $this->getOrder();
        $map = $this->getMap();
        $data_list = Db::name('fund_test')->where($map)->order($order)->select();

        foreach ($data_list as &$value) {
            $value['icon'] = '';
        }
        $btn_access = [
            'title' => '查看详情',
            'icon'  => 'fa fa-fw fa-key',
            'href'  => url('detail', ['id' => '__id__'])
        ];


        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table', 'danger')
            ->addTimeFilter('create_time') // 添加时间段筛选
            ->addOrder('text,username') // 添加排序
            ->addFilter('username') // 添加筛选
            ->hideCheckbox()
            ->setPageTitle('基金列表')
            ->addColumns([
                ['__INDEX__', 'ID'],
            ])
            ->addColumn('username', '用户名')
            ->addColumn('status', '状态', 'status')
            ->addColumn('text', '内容', 'text.edit')
            ->addColumn('icon', '图标', 'icon',  'fa fa-fw fa-star-o')
            ->addColumn('create_time', '创建时间')
            ->addColumn('right_button', '操作', 'btn')
            ->addRightButton('edit', [], true)
            ->addRightButton('custom', $btn_access, true) // 添加授权按钮
            ->addRightButton('disable')
            ->setPageTips('这是页面提示信息')
            ->setRowList($data_list)
            ->setTableName('fund_test')
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