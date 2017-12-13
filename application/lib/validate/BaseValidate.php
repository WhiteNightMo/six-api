<?php
/**
 * 基础验证器
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\lib\validate;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    /**
     * 统一验证方法
     *
     * @return bool
     * @throws ParameterException
     */
    public function goCheck()
    {
        // 获取所有参数
        $params = Request::instance()->param();
        // 参数验证
        $result = $this->batch()->check($params);
        // 结果分析
        if (!$result) {
            throw new ParameterException([
                'msg' => $this->error
            ]);
        }
        return true;
    }

    /**
     * 验证id是否是正整数
     *
     * @param $value
     * @return bool
     */
    protected function isPositiveInteger($value)
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 参数不能为空
     *
     * @param $value
     * @return bool
     */
    public function isNotEmpty($value)
    {
        if (empty($value)) {
            return false;
        }
        return true;
    }

    /**
     * 检查密码是否合法
     *
     * @param $se
     * @return bool|string
     */
    protected function checkSecretValid($se)
    {
        if (!preg_match('/^[A-Za-z0-9]{6,16}$/', $se)) {
            return '新密码不符合规范，密码由6-16位数字和大小写字母组成';
        }
        return true;
    }
}