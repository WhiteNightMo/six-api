<?php
/**
 * category异常
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code = 404;
    public $msg = '请求分类不存在';
    public $errorCode = 20000;
}