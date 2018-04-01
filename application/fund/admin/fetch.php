<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/1
 * Time: 19:06
 */

namespace app\fund\admin;

use app\common\controller\Common;
use think\Request;

/**
 * cms 后台模块
 */
class Fetch extends Common
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        if (!IS_CLI) {
             exit;
        }
    }

    public function index()
    {
        echo 'success';
    }
}