<?php
/**
 * 参数异常
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = 10000;
}