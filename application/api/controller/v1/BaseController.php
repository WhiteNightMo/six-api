<?php
/**
 * 控制器基类
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\controller\v1;


use app\api\service\Token;
use app\lib\enum\ScopeEnum;
use think\Controller;

class BaseController extends Controller
{
    /**
     * 检查CMS管理员权限
     */
    public function checkSuperScope()
    {
        Token::needScopeEnum(ScopeEnum::SUPER);
    }
}