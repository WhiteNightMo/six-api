<?php
/**
 * 新增或者更新友链
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\lib\validate;


class LinkCreateOrUpdate extends BaseValidate
{
    protected $rule = [
        'id' => 'isNotSet|isPositiveInteger',
        'category_id' => 'require|isNotEmpty',
        'name' => 'require|isNotEmpty|max:32',
        'url' => 'require|isNotEmpty|checkUrlValid',
        'intro' => 'isNotSet'
    ];

    protected $message = [
        'id' => 'id不存在',
        'category_id' => '分类不能为空',
        'name' => '友链名必须且不能超过32个字符',
        'url' => 'url不符合规范',
        'intro' => '简介不存在'
    ];
}