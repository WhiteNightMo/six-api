<?php
/**
 * article异常
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\lib\exception;


class ArticleException extends BaseException
{
    public $code = 404;
    public $msg = '请求文章不存在';
    public $errorCode = 30000;
}