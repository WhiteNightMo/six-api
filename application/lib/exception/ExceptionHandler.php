<?php
/**
 * 全局异常处理类
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\lib\exception;


use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    // 异常需要返回的数据
    private $code;
    private $msg;
    private $errorCode;

    public function render(\Exception $e)
    {
        if ($e instanceof BaseException) {
            // 自定义的异常，返回异常信息
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        } else {
            // 服务器异常
            if (config('app_debug')) {
                return parent::render($e);
            } else {
                $this->code = 500;
                $this->msg = '服务器内部错误';
                $this->errorCode = 999;
                // 记录日志
                $this->recordErrorLog($e);
            }
        }

        // 封装异常并返回
        $request = Request::instance();
        $result = [
            'msg' => $this->msg,
            'errorCode' => $this->errorCode,
            'request_url' => $request->url()
        ];
        return json($result, $this->code);
    }

    /**
     * 记录错误日志
     *
     * @param \Exception $e
     */
    private function recordErrorLog(\Exception $e)
    {
        Log::init([
            'type' => 'File',
            'path' => LOG_PATH,
            'level' => ['error']    // 只记录error以上的错误
        ]);
        Log::record($e->getMessage(), 'error');
    }
}