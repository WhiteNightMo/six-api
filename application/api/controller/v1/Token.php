<?php
/**
 * Token（令牌）
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\controller\v1;


use app\api\service\Token as TokenService;
use app\lib\exception\ParameterException;

class Token
{
    /**
     * 验证token是否合法
     *
     * @param string $token
     * @return array
     * @throws ParameterException
     */
    public function verifyToken($token = '')
    {
        if (!$token) {
            throw new ParameterException([
                'msg' => 'token不允许为空'
            ]);
        }
        $valid = TokenService::verifyToken($token);
        return [
            'isValid' => $valid
        ];
    }
}