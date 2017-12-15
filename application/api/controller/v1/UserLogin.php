<?php
/**
 * UserLogin（用户登录日志）
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\controller\v1;

use app\api\model\UserLogin as UserLoginModel;
use app\lib\validate\PageParameter;

class UserLogin extends BaseController
{
    protected $beforeActionList = [
        'checkSuperScope' => ['only' => 'getLoginLogs'],
    ];

    /**
     * 获取登录日志
     *
     * @param int $page
     * @param int $size
     * @return array
     */
    public function getLoginLogs($page = 1, $size = 15)
    {
        (new PageParameter())->goCheck();

        // 分页获取登录日志
        $pagingLogs = UserLoginModel::getLoginLogs($page, $size);
        return $this->getPaginatorData($pagingLogs);
    }
}