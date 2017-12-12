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
}