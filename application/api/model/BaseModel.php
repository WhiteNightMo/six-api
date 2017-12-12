<?php
/**
 * BaseModel
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\model;


use think\Model;

class BaseModel extends Model
{
    /**
     * 密码加密
     *
     * @param $pwd
     * @return string
     */
    public static function pwdEncrypt($pwd)
    {
        if (empty($pwd)) {
            $pwd = config('secure.default_pwd');
        }
        $hash = $pwd . config('secure.pwd_salt');
        $chars = md5(hash('sha256', $hash));
        return $chars;
    }
}