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
    const HS300 = "0003001";
    const CYBZ = "3990062";

    public $index_map = [
        self::HS300 => '沪深300',
        self::CYBZ => '创业板指',
    ];

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        if (!IS_CLI and false) {
             exit;
        }
    }

    public function index()
    {
        $url_tpl = 'http://pdfm2.eastmoney.com/EM_UBG_PDTI_Fast/api/js?id=%s&TYPE=k&js=fsData%s((x))&rtntype=5&isCR=false&fsData%s=fsData%s';
        foreach ($this->index_map as $code => $name) {
            $micro_time = getMillisecond();
            $url = sprintf($url_tpl, $code, $micro_time, $micro_time, $micro_time);
            $return = curl($url);
            $return = $this->formatCurlReturn($return);
        }
    }

    private function formatCurlReturn($data)
    {
        $data = preg_replace("/[a-zA-Z0-9]*[\(\)]/", '', $data);
        $data = json_decode($data, true);
        jdump($data);exit;
        echo $data;exit;
    }
}