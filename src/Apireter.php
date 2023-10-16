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
    public static function setField($codeField = 'code', $msgField = 'msg', $dataField = 'data')
    {
        static::$codeField = $codeField;
        static::$msgField = $msgField;
        static::$dataField = $dataField;
    }


    /**
     * 通用的响应
     * @param int $code  状态码
     * @param string $msg  响应信息
     * @param array $data  响应数据
     * @param int $httpStatus http状态码
     */
    public static function response($code = 200, $msg = '', $data = [], $httpStatus = 200)
    {
        \think\Response::create(json_encode([
            static::$codeField => $code,
            static::$msgField => empty($msg) ? static::getMsg($code) : $msg,
            static::$dataField => $data
        ], JSON_UNESCAPED_SLASHES + JSON_UNESCAPED_UNICODE))->header([
            'Content-Type' => 'application/json; charset=utf-8'
        ])->code($httpStatus)->send();
        die();
    }


    /**
     * 成功的快速响应方法
     * @param array $data 响应数据
     * @param int $code 状态码
     * @param string $msg  响应信息
     * @param int $httpStatus  http状态码
     */
    public static function ok($data = [], $code = 200, $msg = '', $httpStatus = 200)
    {
        static::response($code, $msg, $data, $httpStatus);
    }


    /**
     * 失败的快速响应方法
     * @param string $msg 错误信息
     * @param int $code 状态码
     * @param array $data  返回的数据
     * @param int $httpStatus http状态码
     */
    public static function fail($msg = '', $code = 500, $data = [], $httpStatus = 200)
    {
        static::response($code, $msg, $data, $httpStatus);
    }


    private static function getMsg($code)
    {
        $range = Lang::getLangSet();
        $filePath = app()->getAppPath() . 'lang/' . $range . '/status.php';
        if (file_exists($filePath)) {
            Lang::load($filePath, $range);
            //判断是否存在该多语言配置
            if (Lang::has($code)) {
                return Lang::get($code);
            }
        }
        return array_key_exists($code, Config::get('status')) ? Config::get('status')[$code] : '';
    }
}
