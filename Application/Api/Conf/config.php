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
        array('login', 'User/login', '', array('method' => 'post')),
        array('register$', 'User/register', '', array('method' => 'post')),
        array('verify-code/:tel$', 'User/getVerifyCode', '', array('method' => 'get')),
        array('user/:token/:tel$', 'User/getUserInfo', '', array('method' => 'get')),
        array('user$', 'User/modifyUserInfo', '', array('method' => 'put')),
        array('student-verify$', 'User/studentVerify', '', array('method' => 'post')),
        
        array('bus$', 'Bus/getBusInfo', '', array('method' => 'get')),
        array('bus/:id$', 'Bus/getBusInfo', '', array('method' => 'get')),
        array('bus$', 'Bus/updateBusLocation', '', array('method' => 'put')),
    )
);