<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/1
 * Time: 13:06
 */

return [
    // 模块名[必填]
    'name'        => 'fund',
    // 模块标题[必填]
    'title'       => '基金工具',
    // 模块唯一标识[必填]，格式：模块名.开发者标识.module
    'identifier'  => 'fund.admin.module',
    // 开发者[必填]
    'author'      => 'Administrator',
    // 版本[必填],格式采用三段式：主版本号.次版本号.修订版本号
    'version'     => '1.0.0',
    // 模块描述[必填]
    'description' => '基金工具',

    // 参数配置
    'config' => [
        ['radio', 'need_check', '是否需要审核', '发布文章时是否需要审核才能发布', ['1' => '是', '0' => '否'], 1],
        ['radio', 'comment_status', '是否开启评论', '是否开启文章评论功能', ['1' => '是', '0' => '否'], 1]
    ]
];