<?php
/**
 * 新增或者更新分类
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\lib\validate;


class CategoryCreateOrUpdate extends BaseValidate
{
    protected $rule = [
        'id' => 'isNotSet|isPositiveInteger',
        'name' => 'require|isNotEmpty|max:32'
    ];

    protected $message = [
        'id' => 'id不存在',
        'name' => '分类名必须且不能超过32个字符'
    ];
}