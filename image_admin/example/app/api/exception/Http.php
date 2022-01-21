<?php
namespace app\api\exception;

use think\exception\Handle;
use think\Response;
use Throwable;

/**
 * 应用异常处理类
 */
class Http extends Handle
{


    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param \think\Request   $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        // 添加自定义异常处理机制
        return jsonFail($e->getMessage(),config('code.exception_error'));
    }
}
