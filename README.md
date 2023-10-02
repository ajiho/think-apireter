# think-response

为 thinkphp6.0.+ API 项目提供了一个规范统一的响应数据格式。

# 特性

- 支持多语言
- 支持自定义字段
- 支持直接抛异常,方便喜欢AOP思想处理响应的开发人员

# 安装

```
composer require ajiho/think-response
```

# 配置文件

安装完成后会在`config`目录下生成两个配置文件`response.php`、`status.php`

`response.php`

```php
<?php

/**
 * 该文件主要用于配置think-response包的一些设置
 * 假如你想让你输出字段变成 status message result  可以在下面进行更改
 */

return [
    // 响应code变量
    'code_var' => 'code',
    // 响应msg变量
    'msg_var' => 'msg',
    //响应data变量
    'data_var' => 'data',
];

```

`status.php`

```php
<?php

/**
 * 该文件存放业务状态码相关的配置,可以用来进行多语言适配
 */

return [
    200 => '请求成功',
    500 => '请求错误',

    // 定义其它的业务状态码
    // 20000 => "用户名已经被注册",
    // 20001 => "验证码不正确",
];

```

# 使用

```php
use ajiho\response\Response;

public function index()
{
    $users = User::all();

    return Response::ok($users);
}
```

## 多语言

PS:如果您没有一点多语言基础可以先看官方文档多语言的基本使用

需要开启多语言的中间件(如果是多应用需要两个地方都开启,否则无效)

比如此时,你想给状态码配置文件`status.php`新增一个英文的语言包

需要新建`status.php`

```
// 单应用模式
app/lang/en-us/status.php

// 多应用模式
app/应用/lang/en-us/status.php
```

```php
<?php

/**
 * 该文件存放业务状态码相关的配置,可以用来进行多语言适配
 */

return [
    200 => 'success',
    500 => 'error',

    // 定义其它的业务状态码
    // 20000 => "User has been registered",
    // 20001 => "Verification code error",
];

```

## 抛异常

todo
