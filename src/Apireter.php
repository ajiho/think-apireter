<?php

namespace ajiho;

use think\facade\Config;
use think\facade\Lang;


class Apireter
{


    // 响应code字段
    public static $codeField = 'code';

    // 响应msg字段
    public static $msgField = 'msg';

    //响应data字段
    public static $dataField = 'data';


    /**
     * 设定code、msg、data的响应字段名称
     * @param string $codeField
     * @param string $msgField
     * @param string $dataField
     * @return void
     */
    public static function setField(string $codeField = 'code', string $msgField = 'msg', string $dataField = 'data')
    {
        static::$codeField = $codeField;
        static::$msgField = $msgField;
        static::$dataField = $dataField;
    }


    /**
     * 通用的响应
     * @param int $code 状态码
     * @param string $msg 响应信息
     * @param mixed $data 响应数据
     * @param int $httpStatus http状态码
     */
    public static function response(int $code = 200, string $msg = 'success', $data = [], int $httpStatus = 200)
    {
        \think\Response::create(json_encode([
            static::$codeField => $code,
            static::$msgField => $msg,
            static::$dataField => $data
        ], JSON_UNESCAPED_SLASHES + JSON_UNESCAPED_UNICODE))->header([
            'Content-Type' => 'application/json; charset=utf-8'
        ])->code($httpStatus)->send();
        die();
    }


    /**
     * 成功的快速响应方法
     * @param mixed $data 响应数据
     * @param int $code 状态码
     * @param string $msg 响应信息
     * @param int $httpStatus http状态码
     */
    public static function ok($data = [], int $code = 200, string $msg = 'success', int $httpStatus = 200)
    {
        static::response($code, $msg, $data, $httpStatus);
    }


    /**
     * 失败的快速响应方法
     * @param string $msg 错误信息
     * @param int $code 状态码
     * @param mixed $data 返回的数据
     * @param int $httpStatus http状态码
     */
    public static function fail(string $msg, int $code = 500, $data = [], int $httpStatus = 200)
    {
        static::response($code, $msg, $data, $httpStatus);
    }


}
