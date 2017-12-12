<?php
/**
 * cms获取token
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\lib\validate;


class CmsTokenGet extends BaseValidate
{
    protected $rule = [
        'ac' => 'require|isNotEmpty',
        'se' => 'require|isNotEmpty',
    ];

    protected $message = [
        'ac' => '账号不能为空',
        'se' => '密码不能为空'
    ];
}