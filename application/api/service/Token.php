<?php
/**
 * token业务基类
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\service;


use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    /**
     * 生成token
     *
     * @return string
     */
    public function generateToken()
    {
        // 32位随机字符串
        $randChars = get_rand_chars(32);
        // float时间戳
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        // salt加盐
        $salt = config('secure.token_salt');
        // 拼接后md5
        return md5($randChars . $timestamp . $salt);
    }

    /**
     * 获取token中的指定内容
     *
     * @param $key
     * @return mixed
     * @throws Exception
     */
    public static function getCurrentTokenVar($key)
    {
        // 规定token放在header头中
        $token = Request::instance()->header('token');
        // 从缓存中取出token的值
        $vars = cache($token);
        if (!$vars) {
            throw new TokenException();
        } else {
            // 文件存储默认是json字符串，如果使用redis则存的就是数组
            if (!is_array($vars)) {
                // 统一以数组类型处理
                $vars = json_decode($vars, true);
            }
            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            } else {
                throw new Exception('尝试获取的token变量不存在');
            }
        }
    }

    /**
     * 获取当前的uid
     *
     * @return mixed
     */
    public static function getCurrentUID()
    {
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }

    /**
     * 验证token是否存在
     *
     * @param $token
     * @return bool
     */
    public static function verifyToken($token)
    {
        return Cache::has($token);
    }
}