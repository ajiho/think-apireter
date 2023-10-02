<?php

namespace ajiho\response;

use think\facade\Config;
use think\facade\Lang;


class Response
{

    /**
     * 通用的响应
     * @param int $code 业务状态码
     * @param string $msg 响应消息
     * @param array $data 返回数据
     * @param int $httpStatus http状态码
     * @return \think\Response
     */
    public static function response($code = 200, $msg = '', $data = [], $httpStatus = 200)
    {
        $res = [
            Config::get('response.code_var') => $code,
            Config::get('response.msg_var') => empty($msg) ? static::getMsg($code) : $msg,
            Config::get('response.data_var') => $data
        ];
        $res = json_encode($res, JSON_UNESCAPED_SLASHES + JSON_UNESCAPED_UNICODE);
        $header = [
            'Content-Type' => 'application/json; charset=utf-8'
        ];
        return \think\Response::create($res)->header($header)->code($httpStatus);
    }


    /**
     * 成功的响应
     * @param $data array 返回的数据
     * @param $code int 业务状态码
     * @param $msg string 返回消息
     * @param $httpStatus int http状态码
     * @return \think\Response
     */
    public static function ok($data = [], $code = 200, $msg = '', $httpStatus = 200)
    {
        return static::response($code, $msg, $data, $httpStatus);
    }


    /**
     * 失败的响应
     * @param $code int 业务状态码
     * @param $msg string 返回消息
     * @param $data array 返回的数据
     * @param $httpStatus int http状态码
     * @return \think\Response
     */
    public static function failCode($code = 500, $msg = '', $data = [], $httpStatus = 200)
    {
        return static::response($code, $msg, $data, $httpStatus);
    }


    public static function failMsg($msg = '',$code = 500,  $data = [], $httpStatus = 200)
    {
        return static::response($code, $msg, $data, $httpStatus);
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
