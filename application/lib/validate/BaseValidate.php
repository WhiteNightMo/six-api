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
     * 验证id是否存在
     *
     * @param $value
     * @return bool
     */
    protected function isNotSet($value)
    {
        if (!isset($value)) {
            return false;
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

    /**
     * 检查url是否合法
     *
     * @param $url
     * @return bool|string
     */
    protected function checkUrlValid($url)
    {
        if (!preg_match('/(https?:\/\/)?[a-zA-Z0-9][-a-zA-Z0-9]{0,62}(\.[a-zA-Z0-9][-a-zA-Z0-9]{0,62})+\.?/', $url)) {
            return 'url不符合规范';
        }
        return true;
    }

    /**
     * 根据rule获取数据
     *
     * @param $arrays
     * @return array
     * @throws ParameterException
     */
    public function getDataByRule($arrays)
    {
        // 巧妙应用各验证器的$rule数组，只保存要验证的数据
        $newArray = [];
        foreach ($this->rule as $key => $value) {
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }
}