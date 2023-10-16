<?php


use ajiho\Apireter;


if (!function_exists('api_response')) {
    /**
     * 通用的响应
     * @param int $code 状态码
     * @param string $msg 响应信息
     * @param array $data 响应数据
     * @param int $httpStatus http状态码
     */
    function api_response(int $code = 200, string $msg = '', array $data = [], int $httpStatus = 200)
    {
        Apireter::response($code, $msg, $data, $httpStatus);
    }
}




if (!function_exists('api_ok')) {

    /**
     * 成功的快速响应方法
     * @param array $data 响应数据
     * @param int $code 状态码
     * @param string $msg  响应信息
     * @param int $httpStatus  http状态码
     */
    function api_ok(array $data = [], int $code = 200, string $msg = '', int $httpStatus = 200)
    {
        api_response($code, $msg, $data, $httpStatus);
    }
}



if (!function_exists('api_fail')) {
    /**
     * 失败的快速响应方法
     * @param string $msg 错误信息
     * @param int $code 状态码
     * @param array $data  返回的数据
     * @param int $httpStatus http状态码
     */
    function api_fail(string $msg = '', int $code = 500, array $data = [], int $httpStatus = 200)
    {
        api_response($code, $msg, $data, $httpStatus);
    }
}

