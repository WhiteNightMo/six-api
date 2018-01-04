<?php
/**
 * 验证月份格式
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\lib\validate;


class MonthFormat extends BaseValidate
{
    protected $rule = [
        'month' => 'require|isPositiveInteger|checkMonthValid'
    ];

    protected $message = [
        'month' => '日期格式不合法'
    ];

    /**
     * 检查月份是否合法
     *
     * @param $value
     * @return bool
     */
    protected function checkMonthValid($value)
    {
        $value .= '01';
        if (date('Ymd', strtotime($value)) == $value) {
            return true;
        }
        return false;
    }
}