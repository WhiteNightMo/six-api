<?php
/**
 * BaseModel
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\model;


use app\lib\exception\ParameterException;
use app\lib\validate\IDMustBePositiveInt;
use think\Model;

class BaseModel extends Model
{
    /**
     * 删除指定资源
     *
     * @param $id
     * @throws ParameterException
     */
    public static function destroyByID($id)
    {
        (new IDMustBePositiveInt())->goCheck();

        $count = self::destroy($id);
        if ($count == 0) {
            throw new ParameterException([
                'code' => 404,
                'msg' => '资源没有找到',
                'errorCode' => 100001
            ]);
        }
    }

    /**
     * 默认全局过滤方法 解码
     *
     * @param $value
     * @return string
     */
    public static function defaultFilterDecode($value)
    {
        return htmlspecialchars_decode($value);
    }
}