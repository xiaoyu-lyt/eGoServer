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
        // SystemImagesController
        // 获取LaunchImage
        array('image/launch-image$', 'SystemImages/getLaunchImage', '', array('method' => 'get')),
        array('image/banner-images$', 'SystemImages/getBannerImages', '', array('method' => 'get')),
        
        // UserController
        // 登录验证
        array('login', 'User/login', '', array('method' => 'post')),
        // 注册
        array('register$', 'User/register', '', array('method' => 'post')),
        // 获取验证码
        array('verify-code/:receiver$', 'User/getVerifyCode', '', array('method' => 'get')),
        array('verify-code/:receiver/:type$', 'User/getVerifyCode', '', array('method' => 'get')),
        // 获取用户信息
        array('user/:token/:tel$', 'User/getUserInfo', '', array('method' => 'get')),
        // 修改用户信息
        array('user$', 'User/setUserInfo', '', array('method' => 'put')),
        // 学生身份认证
        array('student-verify$', 'User/studentVerify', '', array('method' => 'post')),
        
        // BusController
        // 获取所有小白信息
        array('bus$', 'Bus/getBusInfo', '', array('method' => 'get')),
        // 获取单辆小白信息
        array('bus/:id$', 'Bus/getBusInfo', '', array('method' => 'get')),
        // 更新小白位置信息
        array('bus$', 'Bus/updateBusLocation', '', array('method' => 'put')),
        
        // BuildingController
        // 获取所有建筑信息
        array('building$', 'Building/getBuildingLocation', '', array('method' => 'get')),
        // 获取单个建筑信息
        array('building/:id$', 'Building/getBuildingLocation', '', array('method' => 'get')),
    )
);