<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 河源市卓锐科技有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

// 为方便系统核心升级，二次开发中需要用到的公共函数请写在这个文件，不要去修改common.php文件

function jdump($arr)
{
    echo json_encode($arr, JSON_UNESCAPED_UNICODE);
}

function croot3($num)
{
    $guess=$num/3;
    while(abs($guess*$guess*$guess-$num)>=0.0000000001)
    {
        $guess=($num/$guess/$guess+2*$guess)/3;
    }
    return $guess;
}