<?php
/**
 * Token（令牌）
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\controller\v1;


use app\api\service\CmsToken;
use app\lib\exception\ParameterException;
use app\lib\exception\TokenException;
use app\lib\validate\CmsTokenGet;
use app\api\service\Token as TokenService;

class Token
{
    /**
     * 获取cms令牌
     *
     * @param $ac
     * @param $se
     * @return array
     */
    public function getCmsToken($ac, $se)
    {
        (new CmsTokenGet())->goCheck();

        $cms = new CmsToken();
        $token = $cms->get($ac, $se);
        return [
            'token' => $token
        ];
    }

    /**
     * 删除cms令牌
     *
     * @param $token
     * @throws TokenException
     */
    public function deleteCmsToken($token)
    {
        $valid = TokenService::verifyToken($token);
        if (!$valid) {
            throw new TokenException();
        } else {
            $cms = new CmsToken();
            $cms->delete($token);
        }
    }

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