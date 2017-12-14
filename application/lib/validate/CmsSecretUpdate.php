<?php
/**
 * cms更新密码
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\lib\validate;


class CmsSecretUpdate extends BaseValidate
{
    protected $rule = [
        'se' => 'require|isNotEmpty',
        'newSe' => 'require|isNotEmpty|checkSecretValid',
        'confirmSe' => 'require|isNotEmpty'
    ];

    protected $message = [
        'se' => '旧密码不能为空',
        'newSe' => '新密码不符合规范',
        'confirmSe' => '确认密码不能为空',
    ];
}