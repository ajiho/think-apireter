<?php

namespace ajiho\response;

use think\facade\Config;

class Response
{

    protected function ok($data = [], $code = 200, $msg = '', $httpStatus = 200)
    {
        $res = [
            Config::get('response.code_var') => $code,
            Config::get('response.msg_var') => $msg,
            Config::get('response.data_var') => $data
        ];
        return json($res, $httpStatus);
    }


    protected function fail($code = 500, $msg = '', $data = [], $httpStatus = 200)
    {
        $res = [
            Config::get('response.code_var') => $code,
            Config::get('response.msg_var') => $msg,
            Config::get('response.data_var') => $data
        ];
        return json($res, $httpStatus);
    }
}
