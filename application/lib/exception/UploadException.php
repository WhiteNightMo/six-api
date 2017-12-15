<?php
/**
 * UploadException（上传失败）
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\lib\exception;


class UploadException extends BaseException
{
    public $code = 500;
    public $msg = '上传失败';
    public $errorCode = 10006;
}