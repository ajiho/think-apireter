## think-apireter

用于thinkphp6.0.+前后端分离开发、或ajax请求时快速响应统一的数据格式

## 特性

- 支持修改响应字段的名称(code,msg,data)
- 真正的json返回
- 在任意地方调用直接返回到客户端
- 无需return、更简短的输出
- 成功和失败的快速响应方法

## 安装

```
composer require ajiho/think-apireter
```




## 使用


总共有三个方法,下面是具体的参数和默认值

```php
/**
 * 参数的类型和说明
 * @param int $code 状态码
 * @param string $msg 响应信息
 * @param mixed $data 响应数据
 * @param int $httpStatus http状态码
 */

\ajiho\Apireter::response(int $code = 200, string $msg = 'success', $data = [], int $httpStatus = 200)
\ajiho\Apireter::ok($data = [], int $code = 200, string $msg = 'success', int $httpStatus = 200)
//失败的快速响应方法,错误信息是必填的。
\ajiho\Apireter::fail(string $msg, int $code = 500, $data = [], int $httpStatus = 200)

//分别对应三个更便捷简短的助手函数,参数相同。
api_response();
api_ok();
api_fail();
```

`ok`、`fail`方法底层都是基于`response`方法,只是参数顺序改变了而已，这样更方便我们调用。

### 简单示例

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
    
   
    //快速成功响应数据
    $info = User::create($params, true);
    $user = User::find($info['id']);
    Apireter::ok($user);
    //或者助手函数
    api_ok($user);
    
}
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

全局生效和应用生效您可以创建对应的中间件,然后设置即可。



### 其它建议

如果你喜欢把所有的状态码都放在一个配置文件里进行管理,你可以在项目里新建文件`config/status.php`

```php
/**
 * 该文件存放业务状态码相关的配置
 */

return [
    "success" => 1,
    "error" => 0,
    "not_login" => -1,
    "user_is_registered" => -2,
    "invalid_token" => -3,
];
```

然后在代码中如下调用这些状态码
```php
api_response(config('status.invalid_token'),'token解析失败,请重新登录');


//响应结果
{
    "code": -3,
    "msg": "token解析失败,请重新登录",
    "data": []
}
```

当然了，这都只是个人建议，直接在控制器方法中直接返回错误信息更简单方便

```php
api_fail('token解析失败,请重新登录',403);

//响应结果
{
    "code": 403,
    "msg": "token解析失败,请重新登录",
    "data": []
}
```



