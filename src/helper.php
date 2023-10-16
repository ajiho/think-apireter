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
    function api_response($code = 200, $msg = '', $data = [], $httpStatus = 200)
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
    function api_ok($data = [], $code = 200, $msg = '', $httpStatus = 200)
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
    function api_fail($msg = '', $code = 500, $data = [], $httpStatus = 200)
    {
        api_response($code, $msg, $data, $httpStatus);
    }
}

