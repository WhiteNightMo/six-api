<?php
/**
 * 文档注释
 *
 * @author xiaomo<xiaomo@etlinker.com>
 * @copyright Copyright(C)2016 Wuhu Yichuan Network Technology Corporation Ltd. All rights reserved.
 */

namespace app\api\model;


class UserLogin extends BaseModel
{
    protected $type = [
        'login_time' => 'timestamp'
    ];

    /**
     * 获取登录日志
     *
     * @param int $page
     * @param int $size
     * @return \think\Paginator
     * @throws \think\Exception
     */
    public static function getLoginLogs($page = 1, $size = 15)
    {
        return self::order('login_time', 'desc')
            ->paginate($size, false, ['page' => $page]);
    }
}