<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/1
 * Time: 19:06
 */

namespace app\fund\admin;

use app\common\controller\Common;
use app\fund\model\FundIndexInfo;
use think\Db;
use think\Request;

/**
 * cms 后台模块
 */
class Fetch extends Common
{
    const HS300 = "0003001";
    const CYBZ  = "3990062";
    const SZZS  = '0000011';
    const SZCZ  = '3990012';
    const ZXBZ  = '3990052';
    const SZ50  = '0000161';
    const BGZS  = '0000031';
    const AGZS  = '0000021';

    public $index_map = [
        self::HS300 => '沪深300',
        self::CYBZ  => '创业板指',
        self::SZZS  => '上证指数',
        self::SZCZ  => '深证成指',
        self::ZXBZ  => '中小板指',
        self::SZ50  => '上证50',
        self::BGZS  => 'B股指数',
        self::AGZS  => 'A股指数',
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
        $macd_url_tpl = 'http://pdfm2.eastmoney.com/EM_UBG_PDTI_Fast/api/js?id=%s&TYPE=k&js=fsDataTeacma%s((x))&rtntype=5&extend=macd&isCR=false&check=kte&fsDataTeacma%s=fsDataTeacma%s';
        foreach ($this->index_map as $code => $name) {
            $micro_time = getMillisecond();
            $url = sprintf($url_tpl, $code, $micro_time, $micro_time, $micro_time);
            $macd_url = sprintf($macd_url_tpl, $code, $micro_time, $micro_time, $micro_time);
            $index_info = curl($url);
            $macd_info = curl($macd_url);
            $return = $this->formatCurlReturn($code, $name, $index_info, $macd_info);
        }

        echo 'success';
    }

    private function formatCurlReturn($code, $index_name, $data_index, $data_macd)
    {
        $data_index = preg_replace("/[a-zA-Z0-9]*[\(\)]/", '', $data_index);
        $data_index = json_decode($data_index, true)['data'];
        $data_macd = preg_replace("/[a-zA-Z0-9]*[\(\)]/", '', $data_macd);
        $data_macd = json_decode($data_macd, true)['data'];

        $mod_fund_index = new FundIndexInfo();
        $result = $mod_fund_index->getData(['date'], ['code'=>$code], ['date' => 'desc'], 1);
        if ($result) {
            $start_date = $result[0]['date'];
        } else {
            $start_date = '0000-00-00';
        }
        $result = [];
        foreach ($data_index as $val) {
            $val = explode(',', $val);
            if ($val[0] > $start_date) {
                $result[$val[0]]['index'] = $val[2];
                $result[$val[0]]['turn_volume'] = str_replace('亿', '', $val[6]);
                if (strpos($result[$val[0]]['turn_volume'], '万') !== false ) {
                    $result[$val[0]]['turn_volume'] = (int)$result[$val[0]]['turn_volume'] / 10000;
                }
                $result[$val[0]]['code'] = $code;
                $result[$val[0]]['index_name'] = $index_name;
                $result[$val[0]]['date'] = $val[0];
            }
        }
        foreach ($data_macd as $val) {
            $val = explode(',', $val);
            $date = array_shift($val);
            $val = json_decode(implode(',', $val), true);
            if ($date > $start_date) {
                $result[$date]['dif']  = $val[0];
                $result[$date]['dea']  = $val[1];
                $result[$date]['macd'] = $val[2];
            }

        }

        foreach (array_chunk($result, 300) as $value) {
            $result = $mod_fund_index->add($value);
        }
    }
}