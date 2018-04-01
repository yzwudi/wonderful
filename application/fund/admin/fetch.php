<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/1
 * Time: 19:06
 */

namespace app\fund\admin;

use app\common\controller\Common;

/**
 * cms 后台模块
 */
class Fetch extends Common
{
    public function index()
    {
        var_dump(IS_CLI) ;
    }
}