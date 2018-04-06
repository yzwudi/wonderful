<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/4
 * Time: 21:43
 */

namespace app\fund\model;

use think\Model as ThinkModel;
use think\Db;

/**
 * 内容模型
 * @package app\cms\model
 */
class FundIndexInfo extends ThinkModel
{
    private $fund_index_info = null;

    public function __construct($data = [])
    {
        parent::__construct($data);
        if (!$this->fund_index_info) {
            $this->fund_index_info = Db::name('fund_index_info');
        }
    }


    public function add ($data)
    {
        return $this->fund_index_info->insertAll($data);
    }


    public function getData($field = [], $where = [], $sort = [], $limit = [])
    {
        $model = $this->fund_index_info;
        if ($field) {
            $model = $model->field($field);
        }
        if ($where) {
            $model = $model->where($where);
        }
        if ($where) {
            $model = $model->order($sort);
        }
        if ($limit) {
            $model = $model->limit($limit);
        }

        return $model->select();
    }
}