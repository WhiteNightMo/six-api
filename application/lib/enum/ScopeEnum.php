<?php
/**
 * 权限数值枚举
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\lib\enum;


class ScopeEnum
{
    // 不同身份的权限数值

    // 注册用户
    const USER = 16;
    // 管理员
    const SUPER = 32;

    // 不同数值对应的身份
    const CONFIG = [
        self::USER => '注册用户',
        self::SUPER => '管理员'
    ];
}