## think-apireter

用于thinkphp6.0.+前后端分离开发、或ajax请求时快速响应统一的数据格式

## 特性

- 支持修改响应字段的名称(code,msg,data)
- 支持配置文件统一管理status状态码
- 真正的json返回
- 在任意地方调用直接返回到客户端
- 无需return、更简短的输出
- 支持多语言(针对msg信息)
- 成功和失败的快速响应方法

## 安装

```
composer require ajiho/think-apireter
```

## 配置文件

安装完成后会在`config`目录下生成`status.php`用于统一管理状态码


```php
<?php

return [
    200 => '请求成功',
    500 => '请求错误',

    // 定义其它的业务状态码
    // 20000 => "用户名已经被注册",
    // 20001 => "验证码不正确",
];

```

## 使用


### 基本使用

```php
use ajiho\Apireter;

public function save()
{
    //接受参数
    $params = input();

    //表单验证
    try {
        validate([
            'username|用户名' => 'require',
            'password|密码' => 'require'
        ])->check($params);
    
    } catch (\think\exception\ValidateException $e) {
        //快速响应错误
        Apireter::fail($e->getMessage());
        //或者助手函数
        api_fail($e->getMessage());
    }
    
    //执行检测用户入库前是否已经存在，假设这里用户已经存在
    Apireter::response(40001);
    //或者助手函数
    api_response(40001);
    //此时您就需要去配置文件status.php配置对应的错误信息
    /*    return [
            200 => '请求成功',
            500 => '请求错误',
        
            // 定义其它的业务状态码
            // 40001 => "用户名已经被注册",
        ];*/
    
    
    
    //快速成功响应数据
    $info = User::create($params, true);
    $user = User::find($info['id']);
    Apireter::ok($user);
    //或者助手函数
    api_ok($user);
    
}
```


- ok、fail方法底层都是基于response方法,只是参数顺序改变了而已，这样方便我们调用。
- 所有的方法的msg参数如果填了，哪怕你在status.php配置了对应的状态码的信息，也会被覆盖。


### 多语言

PS:如果您没有一点多语言基础可以先看官方文档多语言的基本使用

需要开启多语言的中间件(如果是多应用需要两个地方都开启,否则无效)

你想新增一个英文的语言包,您需要复制一份`status.php`配置文件到以下目录



```
// 单应用模式
app/lang/en-us/status.php


// 多应用模式
app/应用/lang/en-us/status.php
```

```php
<?php

return [
    200 => 'success',
    500 => 'error',

    // 定义其它的业务状态码
    // 20000 => "User has been registered",
    // 20001 => "Verification code error",
];

```



### 更改响应字段名称


单次生效

```php
\ajiho\Apireter::setField('status', 'message', 'result')
\ajiho\Apireter::fail('文件上传错误');

//返回结果
{
    "status": 500,
    "message": "文件上传错误",
    "result": []
}
```

全局生效和应用生效您可以创建中间件,然后设置即可。

