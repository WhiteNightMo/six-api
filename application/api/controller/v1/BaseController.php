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

    /**
     * 获取分页数据
     *
     * @param $paging \think\Paginator
     * @return array
     */
    public function getPaginatorData($paging)
    {
        if ($paging->isEmpty()) {
            return [
                'data' => [],
                'current_page' => $paging->currentPage()
            ];
        }

        // 返回数据
        $data = $paging->toArray();
        return [
            'data' => $data,
            'current_page' => $paging->currentPage(),
            'page_html' => $paging->render()
        ];

    }
}