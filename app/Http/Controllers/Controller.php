<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use EllipseSynergie\ApiResponse\Contracts\Response;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * 返回逻辑错误
     * @param $message
     * @param $errorCode
     * @param array $data
     * @return mixed
     */
    public function errorResponse($message, $errorCode, $data = [])
    {
        return $this->response->withArray([
            'code' => $errorCode,
            'message' => $message,
            'data' => $data
        ],[],JSON_UNESCAPED_UNICODE);
    }

    /**
     * 返回成功信息及内容
     * @param array $data
     * @param string $message
     * @return mixed
     */
    public function successResponse(array $data = [], $message = 'OK')
    {
        return $this->response->withArray([
            'code' => 200,
            'message' => $message,
            'data' => $data
        ],[],JSON_UNESCAPED_UNICODE);
    }

}
