<?php

namespace App\Classes;

class Code
{
    //成功
    const SUCCESS = 200;
    //非法的请求
    const INVALID_REQUEST = 300;
    //参数错误
    const PARAMETER_ERROR = 400;
    //系统异常
    const SYSTEM_ERROR = 600;
    //无权操作(授权失败)
    const UNAUTHORIZED_ERROR = 401;

}