<?php
/**
 * CmsToken（CMS令牌）
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\controller\v1;

use app\api\service\CmsToken as CmsTokenService;
use app\api\service\Token as TokenService;
use app\api\service\Token;
use app\lib\exception\SuccessMessage;
use app\lib\exception\TokenException;
use app\lib\validate\CmsSecretUpdate;
use app\lib\validate\CmsTokenGet;

class CmsToken extends Token
{
    /**
     * 登录，获取cms令牌
     *
     * @param $ac
     * @param $se
     * @return array
     */
    public function getCmsToken($ac, $se)
    {
        (new CmsTokenGet())->goCheck();

        $cms = new CmsTokenService();
        $token = $cms->get($ac, $se);
        return [
            'token' => $token
        ];
    }

    /**
     * 修改密码
     *
     * @param $se
     * @param $newSe
     * @param $confirmSe
     * @return \think\response\Json
     */
    public function updateSecret($se, $newSe, $confirmSe)
    {
        (new CmsSecretUpdate())->goCheck();

        // 验证
        $uid = Token::getCurrentUID();
        $service = new CmsTokenService();
        $service->updateSecret($uid, $se, $newSe);
        return json(new SuccessMessage(), 200);
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
            $cms = new CmsTokenService();
            $cms->delete($token);
        }
    }
}