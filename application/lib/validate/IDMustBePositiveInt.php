<?php
/**
 * id必须是正整数
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\lib\validate;


class IDMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger'
    ];

    protected $message = [
        'id' => 'id必须是正整数'
    ];
}