<?php
/**
 * UserModel
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\model;


class User extends BaseModel
{
    protected $autoWriteTimestamp = true;

    /**
     * 检查用户名密码
     *
     * @param $ac
     * @param $se
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public static function check($ac, $se)
    {
        $user = self::where('user', '=', $ac)
            ->where('pwd', '=', pwd_encrypt($se))
            ->find();
        return $user;
    }
}