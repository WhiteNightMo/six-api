<?php
/**
 * CORS（cors跨域）
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\behavior;


class CORS
{
    public function appInit(&$params)
    {
        // 对所有请求的返回结果中添加header（允许跨域）
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: token, Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: POST,GET,PUT,DELETE');
        // 如果是options请求直接结束，不进行后续操作
        if (request()->isOptions()) {
            exit();
        }
    }
}