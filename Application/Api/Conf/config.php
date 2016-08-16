<?php
return array(
    //'配置项'=>'配置值'
    'DB_TYPE' => 'mysql',           // 设置数据库类型
    'DB_HOST' => 'localhost',       // 设置主机
    'DB_NAME' => 'ego',             // 设置数据库名
    'DB_USER' => 'root',            // 设置用户名
    'DB_PWD' => 'root',             // 设置密码
    'DB_PORT' => '3306',            // 设置端口号
    'DB_PREFIX' => 'ego_',          // 设置表前缀
    'URL_CASE_INSENSITIVE' => true, // URL不区分大小写
    'URL_ROUTER_ON' => true,        // 是否开启URL路由
    'URL_ROUTE_RULES' => array(     // 路由规则
        // 获取验证码
        array('verify-code/:tel$', 'User/verifyCode', '', array('method' => 'get')),
        array('register$', 'User/register', '', array('method' => 'post')),
    )
);